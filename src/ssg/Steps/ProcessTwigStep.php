<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\InputFile;
use StaticSiteGenerator\Support\TwigEnvironmentFactory;
use StaticSiteGenerator\ValueObjects\InputFileCollection;
use Twig\Loader\ArrayLoader;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

final class ProcessTwigStep extends AbstractStep
{
    private InputFileCollection $collection;
    private LoaderInterface $filesystemLoader;

    public function __construct(
        private readonly TwigEnvironmentFactory $twigEnvironmentFactory,
        string $inputDirectory,
    ) {
        $this->filesystemLoader = new FilesystemLoader();

        $this->filesystemLoader->addPath($inputDirectory);
    }

    public function run(InputFile ...$inputFiles): array
    {
        $this->collection = new InputFileCollection(...$inputFiles);

        return parent::run(...$inputFiles);
    }

    protected function process(InputFile $inputFile): InputFile
    {
        if (
            !(
                str_ends_with($inputFile->outputPath, 'twig')
                || \array_key_exists('twigTemplate', $inputFile->metadata)
            )
        ) {
            return $inputFile;
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

        $context['inputFiles'] = $this->collection;

        return $inputFile
            ->withContent($environment->render($template, $context))
            ->withOutputPath($this->processRelativePathname($inputFile->outputPath));
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
