<?php

// Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\SiteMapEntries;

use function DI\decorate;
use Psr\Container\ContainerInterface;
use Yassg\Configuration\Configuration;
use Yassg\Events\EventDispatcher;
use Yassg\Events\PreSiteBuildEvent;
use Yassg\Files\InputFileInterface;
use Yassg\Plugins\PluginInterface;

class SiteMapEntries implements PluginInterface
{
    public function getContainerDefinitions(): array
    {
        return [
            EventDispatcher::class => decorate(
                function (EventDispatcher $previous, ContainerInterface $c) {
                    /** @var Configuration $configuration */
                    $configuration = $c->get(Configuration::class);

                    $previous->addEventListener(
                        PreSiteBuildEvent::class,
                        function (PreSiteBuildEvent $event) use ($configuration): void {
                            $baseUrl = $configuration->getMetadata()['urlBase'];

                            /** @var array<string> $entries */
                            $entries = [
                                "{$baseUrl}crap/colouring-pages-a4.pdf",
                                "{$baseUrl}crap/colouring-pages-us.pdf",
                            ];

                            /** @var InputFileInterface $inputFile */
                            foreach ($event->getInputFiles() as $inputFile) {
                                $slug = $inputFile->getMetadata()['slug'];

                                if (
                                    'robots.txt' === $slug
                                    || str_starts_with($slug, 'google')
                                    || str_ends_with($slug, '.atom')
                                ) {
                                    continue;
                                }

                                $entries[] = "{$baseUrl}{$slug}";
                            }

                            $configuration->setMetadata(
                                ['sitemapEntries' => $entries],
                            );
                        },
                    );

                    return $previous;
                },
            ),
        ];
    }
}
