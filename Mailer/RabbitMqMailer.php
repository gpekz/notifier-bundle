<?php

namespace Gpekz\NotifierBundle\Mailer;

use Gpekz\NotifierBundle\Message\Message;

/**
 * RabbitMqMailer.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
class RabbitMqMailer implements MailerInterface
{
    public const TYPE = 'rabbitmq';

    private $producer;

    public function __construct($producer)
    {
        $this->producer = $producer;
    }

    public function send(Message $message, string $type): void
    {
        // ...

        // $this->producer->publish();
    }

    public function supports(string $type): bool
    {
        return self::TYPE === $type;
    }
}
