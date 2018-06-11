<?php

namespace Gpekz\NotifierBundle\Mailer;

use Gpekz\NotifierBundle\Exception\MailerException;
use Gpekz\NotifierBundle\Message\Message;

/**
 * DirectMailer.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
class DirectMailer implements MailerInterface
{
    public const TYPE = 'direct';
    private const TIME_FOR_NEXT_EMAIL = 72000;

    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Message $message, string $type): void
    {
        $swiftMessage = (new \Swift_Message())
            ->setFrom($message->getFrom(), $message->getName())
            ->setTo($message->getRecipients())
            ->setSubject($message->getSubject())
            ->setBody($message->getBody())
            ->setContentType($message->getType())
        ;

        if (!empty($message->getCc())) {
            $swiftMessage->setCc($message->getCc());
        }

        if (!empty($message->getBcc())) {
            $swiftMessage->setBcc($message->getBcc());
        }

        if (!empty($message->getReply())) {
            $swiftMessage->setReplyTo($message->getReply());
        }

        foreach ($message->getAttachments() as $attachment) {
            $swiftMessage->attach(\Swift_Attachment::fromPath($attachment));
        }

        try {
            $this->mailer->getTransport()->start();
            $this->mailer->send($swiftMessage);
            $this->mailer->getTransport()->stop();
        } catch (\Exception $exception) {
            throw new MailerException($exception->getMessage());
        }

        \usleep(self::TIME_FOR_NEXT_EMAIL);
    }

    public function supports(string $type): bool
    {
        return self::TYPE === $type;
    }
}
