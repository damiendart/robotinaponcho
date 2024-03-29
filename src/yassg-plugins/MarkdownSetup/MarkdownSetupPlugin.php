<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace App\Yassg\Plugins\MarkdownSetup;

use League\CommonMark\ConverterInterface;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;
use Psr\Container\ContainerInterface;
use Yassg\Plugins\PluginInterface;

class MarkdownSetupPlugin implements PluginInterface
{
    public function getContainerDefinitions(): array
    {
        return [
            ConverterInterface::class => function (ContainerInterface $c): ConverterInterface {
                /** @var Environment $environment */
                $environment = $c->get(Environment::class);

                return new MarkdownConverter($environment);
            },
            Environment::class => function (ContainerInterface $c): Environment {
                /** @var CommonMarkCoreExtension $commonMarkCoreExtension */
                $commonMarkCoreExtension = $c->get(
                    CommonMarkCoreExtension::class,
                );

                /** @var DescriptionListExtension $descriptionListExtension */
                $descriptionListExtension = $c->get(
                    DescriptionListExtension::class,
                );

                $environment = new Environment();

                /** @var SmartPunctExtension $smartPunctuationExtension */
                $smartPunctuationExtension = $c->get(SmartPunctExtension::class);

                /** @var TableExtension $tableExtension */
                $tableExtension = $c->get(TableExtension::class);

                return $environment
                    ->addExtension($commonMarkCoreExtension)
                    ->addExtension($descriptionListExtension)
                    ->addExtension($smartPunctuationExtension)
                    ->addExtension($tableExtension);
            },
        ];
    }
}
