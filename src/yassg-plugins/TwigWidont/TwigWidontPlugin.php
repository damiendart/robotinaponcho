<?php

/*
 * Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\TwigWidont;

use function DI\decorate;

use Twig\Environment;
use Twig\TwigFilter;
use Yassg\Events\EventDispatcher;
use Yassg\Events\TwigEnvironmentCreatedEvent;
use Yassg\Plugins\PluginInterface;

class TwigWidontPlugin implements PluginInterface
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
                'widont',
                function (?string $string): string {
                    $string ??= '';

                    if (str_word_count($string) < 4) {
                        return $string;
                    }

                    if (
                        mb_strlen(
                            join(
                                ' ',
                                \array_slice(
                                    explode(' ', $string),
                                    -2,
                                ),
                            ),
                        ) > 14
                    ) {
                        return $string;
                    }

                    return preg_replace(
                        '/\s+(\S+)$/',
                        '&#160;$1',
                        rtrim($string),
                    );
                },
                ['is_safe' => ['html']],
            ),
        );
    }
}
