<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace StaticSiteGenerator\Steps;

use StaticSiteGenerator\Inputfile;
use StaticSiteGenerator\ValueObjects\GitMetadata;
use Symfony\Component\Yaml\Parser;

final readonly class ProcessFrontMatterStep implements StepInterface
{
    private const FRONT_MATTER_REGEXES = [
        '/{#---(.*)---#}/s',
        '/<!---(.*)--->/s',
    ];

    public function __construct(
        private Parser $yamlParser,
    ) {}

    public function run(Inputfile ...$inputFiles): array
    {
        foreach ($inputFiles as $key => $inputFile) {
            foreach (self::FRONT_MATTER_REGEXES as $regex) {
                if (
                    1 === preg_match($regex, $inputFile->getContent(), $matches)
                    && '' !== trim($matches[1])
                ) {
                    $content = str_replace($matches[0], '', $inputFile->getContent());
                    /** @var array{array-key, mixed} $metadata */
                    $metadata = $this->yamlParser->parse($matches[1]);

                    if (\array_key_exists('git', $metadata)) {
                        $git = explode(' ', trim($metadata['git'], '$'));

                        if (5 !== \count($git)) {
                            $metadata['git'] = new GitMetadata();
                        } else {
                            $metadata['git'] = new GitMetadata(
                                \DateTimeImmutable::createFromFormat('U', $git[2]),
                                \DateTimeImmutable::createFromFormat('U', $git[4]),
                                $git[1],
                                $git[3],
                            );
                        }
                    }

                    if (1 === preg_match("/(.*)\n=+/", $content, $headings)) {
                        $content = preg_replace("/{$headings[1]}\n=+\n/", '', $content);
                        $metadata['title'] = $headings[1];
                    }

                    $inputFiles[$key] = $inputFile
                        ->withAdditionalMetadata($metadata)
                        ->withContent($content);

                    break;
                }
            }
        }

        return $inputFiles;
    }
}
