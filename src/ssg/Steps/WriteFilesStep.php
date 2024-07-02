<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\Inputfile;

final readonly class WriteFilesStep implements StepInterface
{
    public function __construct(
        private string $outputDirectory,
    ) {}

    public function run(Inputfile ...$inputFiles): array
    {
        $fileCount = 0;

        foreach ($inputFiles as $inputFile) {
            $outputPath = join(
                DIRECTORY_SEPARATOR,
                [$this->outputDirectory, $inputFile->outputPath],
            );

            if (! is_dir(\dirname($outputPath))) {
                mkdir(\dirname($outputPath), 0777, true);
            }

            if ($inputFile->hasModifiedContent()) {
                file_put_contents($outputPath, $inputFile->getContent());
            } else {
                copy($inputFile->source, $outputPath);
            }

            ++$fileCount;
        }

        echo "{$fileCount} files written" . PHP_EOL;

        return $inputFiles;
    }
}
