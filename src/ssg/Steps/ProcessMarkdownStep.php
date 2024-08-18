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

        return $inputFile
            ->withContent($this->processContent($inputFile->getContent()))
            ->withOutputPath($this->processRelativePathname($inputFile->outputPath));
    }

    private function processContent(string $content): string
    {
        return $this->converter->convert($content)->getContent();
    }

    private function processRelativePathname(string $pathname): string
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
