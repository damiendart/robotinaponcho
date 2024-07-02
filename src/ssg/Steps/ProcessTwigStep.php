<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;
use Michelf\SmartyPantsTypographer;

use function StaticSiteGenerator\dedent;

use StaticSiteGenerator\Inputfile;
use StaticSiteGenerator\ValueObjects\SiteMetadata;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use Twig\TwigFilter;

final readonly class ProcessTwigStep implements StepInterface
{
    private LoaderInterface $filesystemLoader;

    public function __construct(
        string $inputDirectory,
        private SiteMetadata $globalMetadata,
    ) {
        $this->filesystemLoader = new FilesystemLoader();

        $this->filesystemLoader->addPath($inputDirectory);
    }

    public function run(Inputfile ...$inputFiles): array
    {
        foreach ($inputFiles as $key => $inputFile) {
            if (
                !(
                    str_ends_with($inputFile->outputPath, 'twig')
                    || \array_key_exists('twigTemplate', $inputFile->metadata)
                )
            ) {
                continue;
            }

            $chainLoader = new ChainLoader();

            $chainLoader->addLoader(
                new ArrayLoader([$inputFile->outputPath => $inputFile->getContent()]),
            );
            $chainLoader->addLoader($this->filesystemLoader);

            $environment = $this->createEnvironment($chainLoader);
            $data = array_merge(
                $this->globalMetadata->metadata,
                $inputFile->metadata,
            );

            if (\array_key_exists('twigTemplate', $inputFile->metadata)) {
                $template = $inputFile->metadata['twigTemplate'];
                $data['renderedMarkdown'] = $inputFile->getContent();
            } else {
                $template = $inputFile->outputPath;
            }

            $inputFiles[$key] = $inputFile
                ->withContent($environment->render($template, $data))
                ->withOutputPath($this->processRelativePathname($inputFile->outputPath));
        }

        return $inputFiles;
    }

    private function processRelativePathname(string $pathname): string
    {
        error_clear_last();

        $pathname = preg_replace('/.twig$/i', '', $pathname);

        if (PREG_NO_ERROR !== preg_last_error() || null === $pathname) {
            throw new \RuntimeException(preg_last_error_msg());
        }

        return $pathname;
    }

    private function createEnvironment(LoaderInterface $loader): Environment
    {
        $environment = new Environment(
            $loader,
            ['strict_variables' => true],
        );

        $environment->addFilter(
            new TwigFilter(
                'dedent',
                static function (string $string): string {
                    return dedent($string);
                },
            ),
        );

        $environment->addFilter(
            new TwigFilter(
                'markdown',
                static function (string $string): string {
                    $environment = new \League\CommonMark\Environment\Environment();
                    $environment
                        ->addExtension(new CommonMarkCoreExtension())
                        ->addExtension(new DescriptionListExtension())
                        ->addExtension(new SmartPunctExtension())
                        ->addExtension(new TableExtension());

                    $converter = new MarkdownConverter($environment);

                    return $converter
                        ->convert($string)
                        ->getContent();
                },
                ['is_safe' => ['html']],
            ),
        );

        $environment->addFilter(
            new TwigFilter(
                'smartypants',
                [SmartyPantsTypographer::class, 'defaultTransform'],
                ['is_safe' => ['html']],
            ),
        );

        $environment->addFilter(
            new TwigFilter(
                'widont',
                static function (?string $string): string {
                    $string ??= '';

                    if (str_word_count($string) < 4) {
                        return $string;
                    }

                    if (
                        mb_strlen(
                            join(
                                ' ',
                                \array_slice(
                                    explode(' ', $string),
                                    -2,
                                ),
                            ),
                        ) > 14
                    ) {
                        return $string;
                    }

                    return preg_replace(
                        '/\s+(\S+)$/',
                        '&#160;$1',
                        rtrim($string),
                    );
                },
                ['is_safe' => ['html']],
            ),
        );

        return $environment;
    }
}
