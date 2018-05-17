<?php

namespace Gpekz\NotifierBundle\Notifier;

/**
 * NotifierInterface.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
interface NotifierInterface
{
    public function notify(string $method, array $options = []): void;
}
