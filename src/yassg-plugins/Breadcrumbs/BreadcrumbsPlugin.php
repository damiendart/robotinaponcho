<?php

/*
 * Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\Breadcrumbs;

use function DI\decorate;

use Psr\Container\ContainerInterface;
use Yassg\Events\EventDispatcher;
use Yassg\Events\PreSiteBuildEvent;
use Yassg\Files\InputFileCollection;
use Yassg\Files\InputFileInterface;
use Yassg\Plugins\PluginInterface;

final class BreadcrumbsPlugin implements PluginInterface
{
    public function getContainerDefinitions(): array
    {
        return [
            EventDispatcher::class => decorate(
                function (EventDispatcher $previous, ContainerInterface $c) {
                    $previous->addEventListener(
                        PreSiteBuildEvent::class,
                        function (PreSiteBuildEvent $event): void {
                            $this->addBreadcrumbs($event->getInputFiles());
                        },
                    );

                    return $previous;
                },
            ),
        ];
    }

    private function addBreadcrumbs(InputFileCollection $inputFiles): void
    {
        /** @var InputFileInterface $inputFile */
        foreach ($inputFiles as $inputFile) {
            $slugComponents = preg_split(
                '/(?<=\/)(?!$)/',
                $inputFile->getMetadata()['slug'],
            );

            if (PREG_NO_ERROR !== preg_last_error()) {
                throw new \RuntimeException(preg_last_error_msg());
            }

            array_unshift($slugComponents, '');
            // For this implementation, we don't need the last
            // breadcrumb (the page the user is currently on).
            array_pop($slugComponents);

            /** @var Breadcrumb[] $breadcrumbs */
            $breadcrumbs = array_reduce(
                $slugComponents,
                function (array $carry, string $slugComponent) use ($inputFiles) {
                    /** @var ?Breadcrumb $previousBreadcrumb */
                    $previousBreadcrumb = end($carry) ?: null;
                    $slug = $previousBreadcrumb?->getSlug() . $slugComponent;

                    /** @var InputFileInterface $inputFile */
                    foreach ($inputFiles as $inputFile) {
                        if ($inputFile->getMetadata()['slug'] === $slug) {
                            $carry[] = new Breadcrumb(
                                $inputFile->getMetadata()['sitemapTitle']
                                ?? $inputFile->getMetadata()['title']
                                ?? $slug,
                                $slug,
                            );

                            break;
                        }
                    }

                    return $carry;
                },
                [],
            );

            $inputFile->mergeMetadata(
                ['breadcrumbs' => $breadcrumbs],
            );
        }
    }
}
