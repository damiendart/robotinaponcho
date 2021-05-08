<?php

// Copyright (C) 2020 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

return PhpCsFixer\Config::create()
    ->setRules([
        '@PhpCsFixer' => true,
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'ordered_imports' => ['sortAlgorithm' => 'alpha'],
        'no_unused_imports' => true,
    ])
    ->setFinder(
        Symfony\Component\Finder\Finder::create()
            ->notPath('node_modules')
            ->notPath('protected' . DIRECTORY_SEPARATOR . 'vendor')
            ->notPath('public')
            ->in(__DIR__)
            ->name('*.php')
            ->name('cron-*')
            ->name('*.twig')
    );
