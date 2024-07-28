<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\Inputfile;
use StaticSiteGenerator\Support\TwigEnvironmentFactory;
use StaticSiteGenerator\ValueObjects\SiteMetadata;
use Twig\Loader\ArrayLoader;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

final readonly class ProcessTwigStep implements StepInterface
{
    private LoaderInterface $filesystemLoader;

    public function __construct(
        string $inputDirectory,
        private SiteMetadata $globalMetadata,
        private TwigEnvironmentFactory $twigEnvironmentFactory,
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

            $context = $inputFile->metadata;
            $environment = $this->twigEnvironmentFactory->make($chainLoader);

            if (\array_key_exists('twigTemplate', $inputFile->metadata)) {
                $template = $inputFile->metadata['twigTemplate'];
                $context['renderedMarkdown'] = $inputFile->getContent();
            } else {
                $template = $inputFile->outputPath;
            }

            $inputFiles[$key] = $inputFile
                ->withContent($environment->render($template, $context))
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
}
