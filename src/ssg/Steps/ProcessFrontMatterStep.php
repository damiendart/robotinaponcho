<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\InputFile;
use StaticSiteGenerator\ValueObjects\GitMetadata;
use Symfony\Component\Yaml\Parser;

final class ProcessFrontMatterStep extends AbstractStep
{
    private const FRONT_MATTER_REGEXES = [
        '/{#---(.*)---#}/s',
        '/<!---(.*)--->/s',
    ];

    public function __construct(
        private readonly Parser $yamlParser,
    ) {}

    protected function process(InputFile $inputFile): InputFile
    {
        foreach (self::FRONT_MATTER_REGEXES as $regex) {
            if (
                1 === preg_match($regex, $inputFile->getContent(), $matches)
                && '' !== trim($matches[1])
            ) {
                $content = str_replace($matches[0], '', $inputFile->getContent());

                /** @var mixed[] $metadata */
                $metadata = $this->yamlParser->parse($matches[1]) ?? [];

                if (\array_key_exists('git', $metadata)) {
                    $metadata['git'] = $this->parseGitMetadataKeyword($metadata['git']);
                }

                return $inputFile
                    ->withAdditionalMetadata($metadata)
                    ->withContent($content);
            }
        }

        return $inputFile;
    }

    private function parseGitMetadataKeyword(string $keyword): GitMetadata
    {
        $parts = explode(' ', trim($keyword, '$'));

        if (5 !== \count($parts)) {
            throw new \RuntimeException('Unable to parse expanded "Metadata" keyword');
        }

        return new GitMetadata(
            new \DateTimeImmutable('@' . $parts[2]),
            new \DateTimeImmutable('@' . $parts[4]),
            $parts[1],
            $parts[3],
        );
    }
}
