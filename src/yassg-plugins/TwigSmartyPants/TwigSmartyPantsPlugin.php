<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace App\Yassg\Plugins\TwigSmartyPants;

use function DI\decorate;

use Michelf\SmartyPantsTypographer;
use Twig\Environment;
use Twig\TwigFilter;
use Yassg\Events\EventDispatcher;
use Yassg\Events\TwigEnvironmentCreatedEvent;
use Yassg\Plugins\PluginInterface;

class TwigSmartyPantsPlugin implements PluginInterface
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
                'smartypants',
                [SmartyPantsTypographer::class, 'defaultTransform'],
                ['is_safe' => ['html']],
            ),
        );
    }
}
