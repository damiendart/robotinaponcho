<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\SitemapEntries;

use function DI\decorate;

use Psr\Container\ContainerInterface;
use Yassg\Configuration\Configuration;
use Yassg\Events\EventDispatcher;
use Yassg\Events\PreSiteBuildEvent;
use Yassg\Files\InputFileInterface;
use Yassg\Plugins\PluginInterface;

class SitemapEntriesPlugin implements PluginInterface
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
                            $entries = [
                                new SitemapEntry(
                                    'crap/colouring-pages-a4.pdf',
                                    'crap/colouring-pages-a4.pdf',
                                ),
                                new SitemapEntry(
                                    'crap/colouring-pages-us.pdf',
                                    'crap/colouring-pages-us.pdf',
                                ),
                            ];

                            /** @var InputFileInterface $inputFile */
                            foreach ($event->getInputFiles() as $inputFile) {
                                $slug = $inputFile->getMetadata()['slug'];

                                if (
                                    'robots.txt' === $slug
                                    || 'sitemap.xml' === $slug
                                    || str_starts_with($slug, 'google')
                                    || str_ends_with($slug, '.atom')
                                ) {
                                    continue;
                                }

                                $entries[] = new SitemapEntry(
                                    $inputFile->getMetadata()['sitemapTitle']
                                        ?? $inputFile->getMetadata()['title']
                                        ?? $slug,
                                    $slug,
                                );
                            }

                            $configuration->mergeMetadata(
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
