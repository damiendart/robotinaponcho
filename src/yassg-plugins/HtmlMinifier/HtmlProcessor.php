<?php

/*
 * Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\HtmlMinifier;

use voku\helper\HtmlMin;
use Yassg\Files\InputFileInterface;
use Yassg\Files\WriteFile;
use Yassg\Processors\ProcessorInterface;

class HtmlProcessor implements ProcessorInterface
{
    private HtmlMin $minifier;

    public function __construct(HtmlMin $minifier)
    {
        $this->minifier = $minifier;
    }

    public function canProcess(InputFileInterface $file): bool
    {
        return str_ends_with($file->getRelativePathname(), 'html');
    }

    public function process(InputFileInterface $inputFile): WriteFile
    {
        return new WriteFile(
            $this->minify($inputFile->getContent()),
            $inputFile->getRelativePathname(),
        );
    }

    private function minify(string $input): string
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
        $output = $this->minifier->minify($input);
        $output = preg_replace(
            "/({$elementRegexGroup})>\\s</",
            '$1><',
            $output,
        );
        $output = preg_replace(
            "#>\\s<(/?({$elementRegexGroup}))#",
            '><$1',
            $output,
        );

        return preg_replace_callback(
            '/(&#[0-9]+;)/',
            function ($match): string {
                return mb_convert_encoding(
                    $match[1],
                    'UTF-8',
                    'HTML-ENTITIES',
                );
            },
            $output,
        );
    }
}
