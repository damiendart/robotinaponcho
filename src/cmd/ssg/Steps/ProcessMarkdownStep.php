<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use League\CommonMark\ConverterInterface;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;
use StaticSiteGenerator\Inputfile;

final readonly class ProcessMarkdownStep implements StepInterface
{
    private ConverterInterface $converter;

    public function __construct()
    {
        $environment = new Environment();

        $environment
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new DescriptionListExtension())
            ->addExtension(new SmartPunctExtension())
            ->addExtension(new TableExtension());

        $this->converter = new MarkdownConverter($environment);
    }

    public function run(Inputfile ...$inputFiles): array
    {
        foreach ($inputFiles as $key => $inputFile) {
            if (! str_ends_with($inputFile->outputPath, 'md')) {
                continue;
            }

            $inputFiles[$key] = $inputFile
                ->withContent($this->processContent($inputFile->getContent()))
                ->withOutputPath($this->processRelativePathname($inputFile->outputPath));
        }

        return $inputFiles;
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
