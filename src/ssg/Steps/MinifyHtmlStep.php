<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\Inputfile;
use voku\helper\HtmlMin;

final readonly class MinifyHtmlStep implements StepInterface
{
    private HtmlMin $minifier;

    public function __construct()
    {
        $this->minifier = (new HtmlMin())
            // HTMLMin adds superfluous whitespace when removing
            // unnecessary closing tags. For more information,
            // see <https://github.com/voku/HtmlMin/issues/59>.
            ->doRemoveOmittedHtmlTags(false)
            ->doMakeSameDomainsLinksRelative(['www.robotinaponcho.net']);
    }

    public function run(Inputfile ...$inputFiles): array
    {
        foreach ($inputFiles as $key => $inputFile) {
            if (! str_ends_with($inputFile->outputPath, 'html')) {
                continue;
            }

            $inputFiles[$key] = $inputFile
                ->withContent($this->processContent($inputFile->getContent()));
        }

        return $inputFiles;
    }

    private function processContent(string $content): string
    {
        $elementRegexGroup = join(
            '|',
            [
                'address',
                'article',
                'aside',
                'blockquote',
                'body',
                'canvas',
                'dd',
                'div',
                'dl',
                'dt',
                'fieldset',
                'figcaption',
                'figure',
                'footer',
                'form',
                'h1',
                'h2',
                'h3',
                'h4',
                'h5',
                'h6',
                'head',
                'header',
                'hr',
                'li',
                'main',
                'nav',
                'noscript',
                'ol',
                'p',
                'pre',
                'section',
                'table',
                'tfoot',
                'ul',
                'video',
            ],
        );

        $content = $this->minifier->minify($content);

        // HTMLMin adds superfluous whitespace between block elements.
        $content = preg_replace(
            "/({$elementRegexGroup})>\\s</",
            '$1><',
            $content,
        );
        $content = preg_replace(
            "#>\\s<(/?({$elementRegexGroup}))#",
            '><$1',
            $content,
        );

        if ($this->minifier->isDoMakeSameDomainsLinksRelative()) {
            // Add the scheme and domain name back to canonical link
            // URLs to prevent any future shenanigans (if the site gets
            // mirrored, for example).
            $content = preg_replace(
                '/<link href=(\S+) rel=canonical>/',
                '<link href=https://www.robotinaponcho.net$1 rel=canonical>',
                $content,
            );
        }

        return preg_replace_callback(
            '/(&#\d+;)/',
            static function ($match): string {
                return mb_convert_encoding(
                    $match[1],
                    'UTF-8',
                    'HTML-ENTITIES',
                );
            },
            $content,
        );
    }
}
