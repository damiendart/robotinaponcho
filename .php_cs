<?php

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
