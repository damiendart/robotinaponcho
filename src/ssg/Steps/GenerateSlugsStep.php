<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\Inputfile;

final class GenerateSlugsStep extends AbstractStep
{
    /** @var string[] */
    private const DOCUMENT_EXTENSIONS = ['html', 'htm', 'php', 'md'];

    /** @var string[] */
    private const INDEX_DOCUMENT_FILENAMES = ['index'];

    /** @var string[] */
    private const TEMPLATE_EXTENSIONS = ['twig'];

    protected function process(Inputfile $inputFile): Inputfile
    {
        return $inputFile->withAdditionalMetadata(
            ['slug' => $this->slugify($inputFile->outputPath)],
        );
    }

    private function slugify(string $input): string
    {
        foreach (self::TEMPLATE_EXTENSIONS as $extension) {
            if (str_ends_with($input, ".{$extension}")) {
                $input = mb_strcut($input, 0, -5);

                break;
            }
        }

        error_clear_last();

        $input = preg_replace(
            '/(.' . join('|.', self::DOCUMENT_EXTENSIONS) . ')+$/',
            '',
            $input,
        );

        if (PREG_NO_ERROR !== preg_last_error() || null === $input) {
            throw new \RuntimeException(preg_last_error_msg());
        }

        foreach (self::INDEX_DOCUMENT_FILENAMES as $filename) {
            if (str_ends_with($input, "/{$filename}") || $filename === $input) {
                $input = mb_strcut($input, 0, -\strlen($filename));

                break;
            }
        }

        return ltrim($input, '/');
    }
}
