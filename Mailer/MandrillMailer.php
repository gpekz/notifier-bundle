<?php

namespace Gpekz\NotifierBundle\Mailer;

use Gpekz\NotifierBundle\Message\Message;

/**
 * MandrillMailer.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
class MandrillMailer implements MailerInterface
{
    public const TYPE = 'mandrill';

    private $mandrill;

    public function __construct(\Mandrill $mandrill)
    {
        $this->mandrill = $mandrill;
    }

    public function send(Message $message, string $type): void
    {
        // ...

        // $this->mandrill->messages->send();
    }

    public function supports(string $type): bool
    {
        return self::TYPE === $type;
    }
}
