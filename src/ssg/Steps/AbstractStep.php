<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\InputFile;

abstract class AbstractStep implements StepInterface
{
    /**
     * @return InputFile[]
     *
     * @throws \Exception
     */
    public function run(InputFile ...$inputFiles): array
    {
        /** @var InputFile[] $output */
        $output = [];

        foreach ($inputFiles as $inputFile) {
            try {
                $processed = $this->process($inputFile);

                $output = $this->collect(
                    ...$output,
                    ...(\is_array($processed) ? $processed : [$processed]),
                );
            } catch (\Throwable $throwable) {
                throw new \RuntimeException(
                    \sprintf('Unable to process "%s"', $inputFile->source),
                    previous: $throwable,
                );
            }
        }

        return $output;
    }

    /** @return InputFile|InputFile[] */
    abstract protected function process(InputFile $inputFile): array|InputFile;

    /**
     * @return InputFile[]
     */
    private function collect(InputFile ...$inputFiles): array
    {
        return $inputFiles;
    }
}
