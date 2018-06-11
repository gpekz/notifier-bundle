<?php

namespace Gpekz\NotifierBundle\DependencyInjection;

use Gpekz\NotifierBundle\Mailer\MailerInterface;
use Gpekz\NotifierBundle\Notifier\NotifierInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * GpekzNotifierExtension.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
class GpekzNotifierExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->registerForAutoconfiguration(NotifierInterface::class)->addTag('gpekz.notifier');
        $container->registerForAutoconfiguration(MailerInterface::class)->addTag('gpekz.mailer');

        if (isset($config['default'])) {
            if (isset($config['default']['from_email'])) {
                $container->setParameter('gpekz_notifier.default.from_email', $config['default']['from_email']);
            }

            if (isset($config['default']['from_name'])) {
                $container->setParameter('gpekz_notifier.default.from_name', $config['default']['from_name']);
            }

            if (isset($config['default']['reply_to'])) {
                $container->setParameter('gpekz_notifier.default.reply_to', $config['default']['reply_to']);
            }
        }
    }
}
