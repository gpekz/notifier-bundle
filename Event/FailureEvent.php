<?php

namespace Gpekz\NotifierBundle\Event;

use Gpekz\NotifierBundle\Exception\MailerException;
use Gpekz\NotifierBundle\Notifier\NotifierInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * FailureEvent.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
class FailureEvent extends Event
{
    private $notifier;
    private $exception;
    private $options;

    public function __construct(NotifierInterface $notifier, MailerException $exception, array $options = [])
    {
        $this->notifier = $notifier;
        $this->exception = $exception;
        $this->options = $options;
    }

    public function getNotifier(): NotifierInterface
    {
        return $this->notifier;
    }

    public function getException(): MailerException
    {
        return $this->exception;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
