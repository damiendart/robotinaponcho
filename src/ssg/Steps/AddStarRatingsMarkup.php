<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\InputFile;

final class AddStarRatingsMarkup extends AbstractStep
{
    protected function processFile(InputFile $inputFile): InputFile
    {
        if (! str_ends_with($inputFile->outputPath, 'html')) {
            return $inputFile;
        }

        return $inputFile->withContent(
            $this->processContent($inputFile->getContent()),
        );
    }

    private function processContent(string $content): string
    {
        // Errors are converted into exceptions by the custom error
        // handler, so "preg_replace_callback" will always return a
        // string in this instance.
        return (string) preg_replace_callback(
            '/(★☆☆☆☆|★★☆☆☆|★★★☆☆|★★★★☆|★★★★★)/',
            static function ($matches): string {
                /** @var int<1, 5> $stars */
                $stars = mb_strlen(rtrim($matches[0], '☆'));

                $rating = ['one', 'two', 'three', 'four', 'five'][$stars - 1];

                return "<span class=\"star-rating star-rating--{$rating}\"><span class=\"u-visually-hidden\">"
                    . ucfirst($rating)
                    . ' out of five</span></span>';
            },
            $content,
        );
    }
}
