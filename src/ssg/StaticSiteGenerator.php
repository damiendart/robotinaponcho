<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator;

use StaticSiteGenerator\Steps\AddStarRatingsMarkup;
use StaticSiteGenerator\Steps\GenerateUrlPaths;
use StaticSiteGenerator\Steps\MinifyHtml;
use StaticSiteGenerator\Steps\ProcessFrontMatter;
use StaticSiteGenerator\Steps\ProcessMarkdown;
use StaticSiteGenerator\Steps\ProcessTwig;
use StaticSiteGenerator\Steps\WriteFiles;
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

        $markdownConverter = (new MarkdownConverterFactory())->make();

        $this->pipeline = new Pipeline(
            new ProcessFrontMatter(new Parser()),
            new GenerateUrlPaths(),
            new ProcessMarkdown($markdownConverter),
            new ProcessTwig(
                new TwigEnvironmentFactory(
                    $markdownConverter,
                    new SiteMetadata(),
                    $this->getData(),
                ),
                $this->inputDirectory,
            ),
            new AddStarRatingsMarkup(),
            new MinifyHtml(),
            new WriteFiles($outputDirectory),
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
            static function (\SplFileInfo $current) {
                return !str_starts_with($current->getFilename(), '.')
                    && !str_starts_with($current->getFilename(), '_');
            },
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

    /**
     * @return array{'log': LogEntry[]}
     */
    private function getData(): array
    {
        /** @var array{array{'content': string, 'published_at': string}} $log */
        $log = (new Parser())->parseFile(
            join(
                DIRECTORY_SEPARATOR,
                [$this->inputDirectory, '_data', 'log.yml'],
            ),
        );

        return [
            'log' => array_map(
                static function (array $entry): LogEntry {
                    $publishedAt = \DateTimeImmutable::createFromFormat(
                        \DateTimeInterface::ATOM,
                        $entry['published_at'],
                    );

                    \assert($publishedAt instanceof \DateTimeImmutable);

                    return new LogEntry($publishedAt, $entry['content']);
                },
                $log,
            ),
        ];
    }
}
