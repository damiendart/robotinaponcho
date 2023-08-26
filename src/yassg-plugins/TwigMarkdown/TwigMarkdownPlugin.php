<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Robotinaponcho\Yassg\Plugins\TwigMarkdown;

use function DI\decorate;

use League\CommonMark\ConverterInterface;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\TwigFilter;

use function Yassg\dedent;

use Yassg\Events\EventDispatcher;
use Yassg\Events\TwigEnvironmentCreatedEvent;
use Yassg\Plugins\PluginInterface;

class TwigMarkdownPlugin implements PluginInterface
{
    public function getContainerDefinitions(): array
    {
        return [
            EventDispatcher::class => decorate(
                function (EventDispatcher $previous, ContainerInterface $c): EventDispatcher {
                    /** @var ConverterInterface $markdownConverter */
                    $markdownConverter = $c->get(ConverterInterface::class);

                    return $previous->addEventListener(
                        TwigEnvironmentCreatedEvent::class,
                        function (TwigEnvironmentCreatedEvent $event) use ($markdownConverter): void {
                            $this->updateEnvironment(
                                $event->getEnvironment(),
                                $markdownConverter,
                            );
                        },
                    );
                },
            ),
        ];
    }

    private function updateEnvironment(
        Environment $environment,
        ConverterInterface $markdownConverter,
    ): void {
        $environment->addFilter(
            new TwigFilter(
                'dedent',
                function (string $string): string {
                    return dedent($string);
                },
            ),
        );

        $environment->addFilter(
            new TwigFilter(
                'markdown',
                function (string $string) use ($markdownConverter): string {
                    return $markdownConverter
                        ->convert($string)
                        ->getContent();
                },
                ['is_safe' => ['html']],
            ),
        );
    }
}
