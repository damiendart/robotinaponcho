<?php

/*
 * Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\TwigPrettyRatings;

use function DI\decorate;

use Twig\Environment;
use Twig\TwigFilter;
use Yassg\Events\EventDispatcher;
use Yassg\Events\TwigEnvironmentCreatedEvent;
use Yassg\Plugins\PluginInterface;

class TwigPrettyRatingsPlugin implements PluginInterface
{
    public function getContainerDefinitions(): array
    {
        return [
            EventDispatcher::class => decorate(
                function (EventDispatcher $previous): EventDispatcher {
                    return $previous->addEventListener(
                        TwigEnvironmentCreatedEvent::class,
                        function (TwigEnvironmentCreatedEvent $event): void {
                            $this->updateEnvironment($event->getEnvironment());
                        },
                    );
                },
            ),
        ];
    }

    private function updateEnvironment(Environment $environment): void
    {
        $environment->addFilter(
            new TwigFilter(
                'prettyratings',
                function (?string $string): string {
                    $string ??= '';

                    return preg_replace(
                        '/\((★{1,5})\)/u',
                        '<span class="pill"><span class="visually-hidden">(</span>$1<span class="visually-hidden">)</span></span>',
                        rtrim($string),
                    );
                },
                ['is_safe' => ['html']],
            ),
        );
    }
}
