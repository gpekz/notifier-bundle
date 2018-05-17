<?php

namespace Gpekz\NotifierBundle\Mailer;

use Gpekz\NotifierBundle\Exception\MailerException;

/**
 * MailerInterface.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
interface MailerInterface
{
    /**
     * @throws MailerException
     */
    public function send(string $from, string $name, array $recipients, string $subject, string $body, string $type = 'text/html', array $cc = [], array $bcc = [], array $reply = [], array $attachments = []): void;
}
