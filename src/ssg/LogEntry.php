<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator;

/** @psalm-api */
final readonly class LogEntry
{
    public function __construct(
        public \DateTimeImmutable $publishedAt,
        public string $content,
    ) {}
}
