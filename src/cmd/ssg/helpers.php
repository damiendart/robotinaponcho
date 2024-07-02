<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator;

/**
 * Removes extraneous leading whitespace from multi-line strings.
 *
 * Single-line strings will simply have any leading whitespace removed.
 */
function dedent(string $input): string
{
    $lines = explode("\n", $input);
    $nonEmptyLines = array_filter(
        explode("\n", $input),
        static fn (string $line): bool => '' !== $line,
    );

    if (\count($nonEmptyLines) < 1) {
        return $input;
    }

    $shortestLeadingWhitespaceCount = min(
        array_map(
            static function ($line): int {
                if (1 === preg_match('/^[ \t]+/', $line, $matches)) {
                    return \strlen($matches[0]);
                }

                return 0;
            },
            $nonEmptyLines,
        ),
    );

    return join(
        "\n",
        array_map(
            static fn ($line): string => substr($line, $shortestLeadingWhitespaceCount),
            $lines,
        ),
    );
}
