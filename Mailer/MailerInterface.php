<?php

namespace Gpekz\NotifierBundle\Mailer;

use Gpekz\NotifierBundle\Exception\MailerException;
use Gpekz\NotifierBundle\Message\Message;

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
    public function send(Message $message, string $type): void;

    public function supports(string $type): bool;
}
