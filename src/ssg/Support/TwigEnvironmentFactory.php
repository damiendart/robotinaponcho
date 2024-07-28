<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Support;

use Michelf\SmartyPantsTypographer;
use StaticSiteGenerator\ValueObjects\SiteMetadata;
use Twig\Environment;
use Twig\Loader\LoaderInterface;
use Twig\TwigFilter;

final readonly class TwigEnvironmentFactory
{
    public function __construct(
        private MarkdownConverterFactory $markdownConverterFactory,
        private SiteMetadata $siteMetadata,
    ) {}

    public function make(LoaderInterface $loader): Environment
    {
        $environment = new Environment(
            $loader,
            ['strict_variables' => true],
        );

        $environment->addFilter(new TwigFilter('dedent', 'StaticSiteGenerator\dedent'));

        $environment->addFilter(
            new TwigFilter(
                'markdown',
                function (string $string): string {
                    $converter = $this->markdownConverterFactory->make();

                    return $converter
                        ->convert($string)
                        ->getContent();
                },
                ['is_safe' => ['html']],
            ),
        );

        $environment->addFilter(
            new TwigFilter(
                'smartypants',
                [SmartyPantsTypographer::class, 'defaultTransform'],
                ['is_safe' => ['html']],
            ),
        );

        $environment->addFilter(
            new TwigFilter(
                'widont',
                static function (?string $string): string {
                    $string ??= '';

                    if (str_word_count($string) < 4) {
                        return $string;
                    }

                    if (
                        mb_strlen(
                            join(
                                ' ',
                                \array_slice(
                                    explode(' ', $string),
                                    -2,
                                ),
                            ),
                        ) > 14
                    ) {
                        return $string;
                    }

                    return preg_replace(
                        '/\s+(\S+)$/',
                        '&#160;$1',
                        rtrim($string),
                    );
                },
                ['is_safe' => ['html']],
            ),
        );

        $environment->addGlobal('site', $this->siteMetadata->metadata);

        return $environment;
    }
}
