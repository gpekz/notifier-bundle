<?php

namespace Gpekz\NotifierBundle\Event;

use Gpekz\NotifierBundle\Notifier\NotifierInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * NotifierEvent.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
class NotifierEvent extends Event
{
    private $notifier;
    private $options;

    public function __construct(NotifierInterface $notifier, array $options = [])
    {
        $this->notifier = $notifier;
        $this->options = $options;
    }

    public function getNotifier(): NotifierInterface
    {
        return $this->notifier;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
