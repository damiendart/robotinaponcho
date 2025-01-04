<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\ValueObjects;

/** @psalm-api */
final readonly class GitMetadata
{
    public function __construct(
        public string $path,
        public \DateTimeImmutable $createdAt = new \DateTimeImmutable(),
        public \DateTimeImmutable $updatedAt = new \DateTimeImmutable(),
        public string $createdHash = '0000000000000000000000000000000000000000',
        public string $updatedHash = '0000000000000000000000000000000000000000',
    ) {}
}
