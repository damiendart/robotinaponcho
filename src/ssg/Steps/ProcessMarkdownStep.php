<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use League\CommonMark\ConverterInterface;
use StaticSiteGenerator\InputFile;
use StaticSiteGenerator\Support\MarkdownConverterFactory;

final class ProcessMarkdownStep extends AbstractStep
{
    private ConverterInterface $converter;

    public function __construct(MarkdownConverterFactory $factory)
    {
        $this->converter = $factory->make();
    }

    protected function process(InputFile $inputFile): InputFile
    {
        if (! str_ends_with($inputFile->outputPath, 'md')) {
            return $inputFile;
        }

        $inputFile = $this->extractTitle($inputFile);

        return $inputFile
            ->withContent($this->processContent($inputFile->getContent()))
            ->withOutputPath($this->processOutputPath($inputFile->outputPath));
    }

    private function extractTitle(InputFile $inputFile): InputFile
    {
        if (
            1 === preg_match("/(.*)\n=+/", $content = $inputFile->getContent(), $headings)
            && false === \array_key_exists('title', $inputFile->metadata)
        ) {
            return $inputFile
                ->withContent(
                    // Errors are converted into exceptions by the
                    // custom error handler, so "preg_replace" will
                    // always return a string.
                    (string) preg_replace(
                        "/{$headings[1]}\n=+\n/",
                        '',
                        $content,
                    ),
                )
                ->withAdditionalMetadata(['title' => $headings[1]]);
        }

        return $inputFile;
    }

    private function processContent(string $content): string
    {
        return $this->converter->convert($content)->getContent();
    }

    private function processOutputPath(string $pathname): string
    {
        error_clear_last();

        $pathname = preg_replace(
            '/' . pathinfo($pathname, PATHINFO_EXTENSION) . '$/i',
            'html',
            $pathname,
        );

        if (PREG_NO_ERROR !== preg_last_error() || null === $pathname) {
            throw new \RuntimeException(preg_last_error_msg());
        }

        return $pathname;
    }
}
