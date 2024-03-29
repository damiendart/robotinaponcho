<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace App\Yassg\Plugins\GitMetadata;

readonly class GitMetadata
{
    public function __construct(
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
        public ?string $createdHash,
        public ?string $updatedHash,
    ) {}
}
