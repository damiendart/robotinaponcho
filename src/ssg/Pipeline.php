<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator;

use StaticSiteGenerator\Steps\StepInterface;

final readonly class Pipeline implements StepInterface
{
    /** @var StepInterface[] */
    private array $steps;

    public function __construct(StepInterface ...$steps)
    {
        $this->steps = $steps;
    }

    public function run(InputFile ...$inputFiles): array
    {
        foreach ($this->steps as $step) {
            $inputFiles = $step->run(...$inputFiles);
        }

        return $inputFiles;
    }
}
