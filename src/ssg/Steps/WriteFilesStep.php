<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\InputFile;

final class WriteFilesStep extends AbstractStep
{
    private int $fileCount;

    public function __construct(
        private readonly string $outputDirectory,
    ) {
        $this->fileCount = 0;
    }

    public function run(InputFile ...$inputFiles): array
    {
        $inputFiles = parent::run(...$inputFiles);

        echo $this->fileCount . ' files written' . PHP_EOL;

        return $inputFiles;
    }

    protected function process(InputFile $inputFile): InputFile
    {
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

        ++$this->fileCount;

        return $inputFile;
    }
}
