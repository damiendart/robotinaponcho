<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\InputFile;
use StaticSiteGenerator\InputFileCollection;
use StaticSiteGenerator\TwigEnvironmentFactory;
use Twig\Loader\ArrayLoader;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

final class ProcessTwig extends AbstractStep
{
    /** @psalm-suppress PropertyNotSetInConstructor */
    private InputFileCollection $inputFiles;
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
        $this->inputFiles = new InputFileCollection(...$inputFiles);

        return parent::run(...$inputFiles);
    }

    protected function processFile(InputFile $inputFile): InputFile
    {
        if (false === $this->shouldProcess($inputFile)) {
            return $inputFile;
        }

        $chainLoader = new ChainLoader();

        $chainLoader->addLoader(
            new ArrayLoader([$inputFile->outputPath => $inputFile->getContent()]),
        );
        $chainLoader->addLoader($this->filesystemLoader);

        $context = $inputFile->metadata;
        $environment = $this->twigEnvironmentFactory->make($chainLoader);

        if (
            \array_key_exists('template', $inputFile->metadata)
            && \is_string($inputFile->metadata['template'])
        ) {
            $template = $inputFile->metadata['template'];
            $context['content'] = $inputFile->getContent();
        } else {
            $template = $inputFile->outputPath;
        }

        $context['inputFiles'] = $this->inputFiles;

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

    private function shouldProcess(InputFile $inputFile): bool
    {
        if (str_ends_with($inputFile->outputPath, 'twig')) {
            return true;
        }

        if (
            \array_key_exists('template', $inputFile->metadata)
            && \is_string($inputFile->metadata['template'])
            && str_ends_with($inputFile->metadata['template'], 'twig')
        ) {
            return true;
        }

        return false;
    }
}
