<?php

namespace Gpekz\NotifierBundle;

use Gpekz\NotifierBundle\DependencyInjection\Compiler\NotifierCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * GpekzNotifierBundle.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
class GpekzNotifierBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new NotifierCompilerPass());
    }
}
