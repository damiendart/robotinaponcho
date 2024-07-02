<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator;

use StaticSiteGenerator\Steps\GenerateCollectionsStep;
use StaticSiteGenerator\Steps\GenerateSitemapEntriesStep;
use StaticSiteGenerator\Steps\GenerateSlugsStep;
use StaticSiteGenerator\Steps\MinifyHtmlStep;
use StaticSiteGenerator\Steps\ProcessFrontMatterStep;
use StaticSiteGenerator\Steps\ProcessMarkdownStep;
use StaticSiteGenerator\Steps\ProcessTwigStep;
use StaticSiteGenerator\Steps\WriteFilesStep;
use StaticSiteGenerator\ValueObjects\SiteMetadata;

final readonly class StaticSiteGenerator
{
    private Pipeline $pipeline;

    public function __construct(
        private string $inputDirectory,
        private string $outputDirectory,
    ) {
        $releaseTimestamp = getenv('RELEASE_TIMESTAMP') ?: (new \DateTimeImmutable())->format('YmdHis');

        $siteMetadata = new SiteMetadata(
            [
                'author' => 'Damien Dart',
                'authorEmail' => 'damiendart@pobox.com',
                'metaTwitterAuthor' => '@damiendart',
                'metaTwitterSite' => '@damiendart',
                'metaOpengraphImage' => "https://www.robotinaponcho.net/assets/opengraph.{$releaseTimestamp}.png",
                'releaseTimestamp' => $releaseTimestamp,
                'urlBase' => 'https://www.robotinaponcho.net/',
            ],
        );

        $this->pipeline = new Pipeline(
            new ProcessFrontMatterStep(),
            new GenerateSlugsStep(),
            new GenerateCollectionsStep($siteMetadata),
            new GenerateSitemapEntriesStep($siteMetadata),
            new ProcessMarkdownStep(),
            new ProcessTwigStep($this->inputDirectory, $siteMetadata),
            new MinifyHtmlStep(),
            new WriteFilesStep($this->outputDirectory),
        );
    }

    public function run(): int
    {
        $this->pipeline->run(...$this->getInputFiles());

        return 0;
    }

    private function getInputFiles(): array
    {
        $files = new \RecursiveCallbackFilterIterator(
            new \RecursiveDirectoryIterator(
                $this->inputDirectory,
                \FilesystemIterator::CURRENT_AS_FILEINFO
                    | \FilesystemIterator::SKIP_DOTS
                    | \FilesystemIterator::UNIX_PATHS,
            ),
            static fn (\SplFileInfo $current) => !str_starts_with($current->getFilename(), '.'),
        );
        $inputDirectory = realpath($this->inputDirectory);
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
