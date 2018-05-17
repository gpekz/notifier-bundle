<?php

namespace Gpekz\NotifierBundle\Mailer;

use Gpekz\NotifierBundle\Exception\MailerException;

/**
 * Mailer.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
class Mailer implements MailerInterface
{
    private const TIME_FOR_NEXT_EMAIL = 72000;

    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(string $from, string $name, array $recipients, string $subject, string $body, string $type = 'text/html', array $cc = [], array $bcc = [], array $reply = [], array $attachments = []): void
    {
        $message = (new \Swift_Message())
            ->setFrom($from, $name)
            ->setTo($recipients)
            ->setSubject($subject)
            ->setBody($body)
            ->setContentType($type)
        ;

        if (!empty($cc)) {
            $message->setCc($cc);
        }

        if (!empty($bcc)) {
            $message->setBcc($bcc);
        }

        if (!empty($reply)) {
            $message->setReplyTo($reply);
        }

        foreach ($attachments as $attachment) {
            $message->attach(\Swift_Attachment::fromPath($attachment));
        }

        try {
            $this->mailer->getTransport()->start();
            $this->mailer->send($message);
            $this->mailer->getTransport()->stop();
        } catch (\Exception $exception) {
            throw new MailerException($exception->getMessage());
        }

        \usleep(self::TIME_FOR_NEXT_EMAIL);
    }
}
