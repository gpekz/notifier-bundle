<?php

namespace Gpekz\NotifierBundle\Mailer;

use Gpekz\NotifierBundle\Exception\MailerException;
use Gpekz\NotifierBundle\Message\Message;

/**
 * Mailer.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
class Mailer implements MailerInterface
{
    private $mailers = [];
    private $cache = [];

    public function __construct(iterable $mailers = [])
    {
        foreach ($mailers as $mailer) {
            if (!$mailer instanceof MailerInterface) {
                throw new \InvalidArgumentException(\sprintf('The mailer %s must implement interface', get_class($mailer), MailerInterface::class));
            }

            if (!in_array($mailer, $this->mailers)) {
                $this->mailers[] = $mailer;
            }
        }
    }

    public function send(Message $message, string $type): void
    {
        $this->getMailer($type)->send($message, $type);
    }

    public function supports(string $type): bool
    {
        try {
            $this->getMailer($type);
        } catch (MailerException $exception) {
            return false;
        }

        return true;
    }

    public function getMailer(string $type): MailerInterface
    {
        if (isset($this->cache[$type])) {
            return $this->cache[$type];
        }

        foreach ($this->mailers as $mailer) {
            if ($mailer->supports($type)) {
                $this->cache[$type] = $mailer;

                return $mailer;
            }
        }

        throw new MailerException(\sprintf('No mailer found for type %s', $type));
    }
}
