<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator;

use StaticSiteGenerator\Steps\AddStarRatingsMarkupStep;
use StaticSiteGenerator\Steps\GenerateUrlPathsStep;
use StaticSiteGenerator\Steps\MinifyHtmlStep;
use StaticSiteGenerator\Steps\ProcessFrontMatterStep;
use StaticSiteGenerator\Steps\ProcessMarkdownStep;
use StaticSiteGenerator\Steps\ProcessTwigStep;
use StaticSiteGenerator\Steps\WriteFilesStep;
use StaticSiteGenerator\Support\MarkdownConverterFactory;
use StaticSiteGenerator\Support\TwigEnvironmentFactory;
use StaticSiteGenerator\ValueObjects\SiteMetadata;
use Symfony\Component\Yaml\Parser;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run;

final readonly class StaticSiteGenerator
{
    private Pipeline $pipeline;

    public function __construct(
        private string $inputDirectory,
        string $outputDirectory,
    ) {
        $whoops = new Run();

        $whoops->pushHandler(new PlainTextHandler());
        $whoops->register();

        $this->pipeline = new Pipeline(
            new ProcessFrontMatterStep(new Parser()),
            new GenerateUrlPathsStep(),
            new ProcessMarkdownStep(new MarkdownConverterFactory()),
            new ProcessTwigStep(
                new TwigEnvironmentFactory(new SiteMetadata()),
                $this->inputDirectory,
            ),
            new AddStarRatingsMarkupStep(),
            new MinifyHtmlStep(),
            new WriteFilesStep($outputDirectory),
        );
    }

    public function run(): int
    {
        $this->pipeline->run(...$this->getInputFiles());

        return 0;
    }

    /** @return InputFile[] */
    private function getInputFiles(): array
    {
        /** @psalm-suppress InvalidArgument */
        $files = new \RecursiveCallbackFilterIterator(
            new \RecursiveDirectoryIterator(
                $this->inputDirectory,
                \FilesystemIterator::CURRENT_AS_FILEINFO
                    | \FilesystemIterator::SKIP_DOTS
                    | \FilesystemIterator::UNIX_PATHS,
            ),
            static fn (\SplFileInfo $current) => !str_starts_with($current->getFilename(), '.'),
        );
        $inputDirectory = (string) realpath($this->inputDirectory);
        $inputFiles = [];

        /** @var \SplFileInfo $file */
        foreach (new \RecursiveIteratorIterator($files) as $file) {
            $inputFiles[] = new InputFile(
                $file->getRealPath(),
                substr($file->getRealPath(), \strlen($inputDirectory) + 1),
            );
        }

        return $inputFiles;
    }
}
