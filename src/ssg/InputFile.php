<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator;

final readonly class InputFile
{
    private ?string $modifiedContent;

    /** @param mixed[] $metadata */
    public function __construct(
        public string $source,
        public string $outputPath,
        public array $metadata = [],
        ?string $content = null,
    ) {
        $this->modifiedContent = $content;
    }

    public function hasModifiedContent(): bool
    {
        return null !== $this->modifiedContent;
    }

    public function getContent(): string
    {
        return $this->modifiedContent ?? $this->getOriginalContent();
    }

    private function getOriginalContent(): string
    {
        $content = file_get_contents($this->source);

        // Errors are converted into exceptions by the custom error
        // handler, so "file_get_contents" will always return a string.
        \assert(\is_string($content));

        return $content;
    }

    /** @param mixed[] $metadata */
    public function withAdditionalMetadata(array $metadata): self
    {
        return $this->withMetadata(
            array_merge($this->metadata, $metadata),
        );
    }

    public function withContent(string $content): self
    {
        return new self(
            $this->source,
            $this->outputPath,
            $this->metadata,
            $content,
        );
    }

    public function withOutputPath(string $outputPath): self
    {
        return new self(
            $this->source,
            $outputPath,
            $this->metadata,
            $this->hasModifiedContent() ? $this->getContent() : null,
        );
    }

    /** @param mixed[] $metadata */
    public function withMetadata(array $metadata): self
    {
        return new self(
            $this->source,
            $this->outputPath,
            $metadata,
            $this->hasModifiedContent() ? $this->getContent() : null,
        );
    }
}
