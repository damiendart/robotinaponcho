<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\Inputfile;

final class GenerateSlugsStep implements StepInterface
{
    /** @var string[] */
    private array $documentExtensions = ['html', 'htm', 'php', 'md'];

    /** @var string[] */
    private array $indexDocumentFilenames = ['index'];

    /** @var string[] */
    private array $templateExtensions = ['twig'];

    public function run(Inputfile ...$inputFiles): array
    {
        foreach ($inputFiles as $key => $inputFile) {
            $inputFiles[$key] = $inputFile->withAdditionalMetadata(
                ['slug' => $this->slugify($inputFile->outputPath)],
            );
        }

        return $inputFiles;
    }

    private function slugify(string $input): string
    {
        foreach ($this->templateExtensions as $extension) {
            if (str_ends_with($input, ".{$extension}")) {
                $input = mb_strcut($input, 0, -5);

                break;
            }
        }

        error_clear_last();

        $input = preg_replace(
            '/(.' . join('|.', $this->documentExtensions) . ')+$/',
            '',
            $input,
        );

        if (PREG_NO_ERROR !== preg_last_error() || null === $input) {
            throw new \RuntimeException(preg_last_error_msg());
        }

        foreach ($this->indexDocumentFilenames as $filename) {
            if (str_ends_with($input, "/{$filename}") || $filename === $input) {
                $input = mb_strcut($input, 0, -\strlen($filename));

                break;
            }
        }

        return ltrim($input, '/');
    }
}
