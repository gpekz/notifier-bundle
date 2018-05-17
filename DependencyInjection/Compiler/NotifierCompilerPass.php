<?php

namespace Gpekz\NotifierBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NotifierCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $ids = $container->findTaggedServiceIds('gpekz.notifier');

        foreach ($ids as $id => $tags) {
            if ($container->hasParameter('gpekz_notifier.default.from_email')) {
                $container->getDefinition($id)->setArgument('$from', $container->getParameter('gpekz_notifier.default.from_email'));
            }

            if ($container->hasParameter('gpekz_notifier.default.from_name')) {
                $container->getDefinition($id)->setArgument('$name', $container->getParameter('gpekz_notifier.default.from_name'));
            }

            if ($container->hasParameter('gpekz_notifier.default.reply_to')) {
                $container->getDefinition($id)->setArgument('$reply', $container->getParameter('gpekz_notifier.default.reply_to'));
            }
        }
    }
}