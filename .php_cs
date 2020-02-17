<?php
// Copyright (C) 2020 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sortAlgorithm' => 'alpha'],
        'no_unused_imports' => true,
    ])
    ->setFinder(
        Symfony\Component\Finder\Finder::create()
            ->notPath('protected' . DIRECTORY_SEPARATOR . 'vendor')
            ->in(__DIR__)
            ->name('*.php')
            ->name('cron-*')
            ->name('*.twig')
        );
