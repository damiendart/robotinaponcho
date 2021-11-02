<?php

// Copyright (C) 2021 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

use ToolboxSass\Helpers\PHPCSFixerHelper;

return (new PhpCsFixer\Config())
    ->setRules(PHPCSFixerHelper::getHouseRules('8.0'))
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->notPath('node_modules')
            ->notPath('protected' . DIRECTORY_SEPARATOR . 'vendor')
            ->notPath('public')
            ->in(__DIR__)
            ->name('*.php')
            ->name('cron-*')
            ->name('*.twig')
    );
