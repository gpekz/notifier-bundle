<?php

namespace Gpekz\NotifierBundle\Notifier;

use Gpekz\NotifierBundle\Event\Events;
use Gpekz\NotifierBundle\Event\FailureEvent;
use Gpekz\NotifierBundle\Event\NotifierEvent;
use Gpekz\NotifierBundle\Exception\MailerException;
use Gpekz\NotifierBundle\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Templating\EngineInterface;

/**
 * AbstractNotifier.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
abstract class AbstractNotifier implements NotifierInterface
{
    private $mailer;
    private $templating;
    private $dispatcher;
    private $from;
    private $name;
    private $reply;

    public function __construct(MailerInterface $mailer, EngineInterface $templating, EventDispatcherInterface $dispatcher, ?string $from = null, ?string $name = null, array $reply = [])
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->dispatcher = $dispatcher;
        $this->from = $from;
        $this->name = $name;
        $this->reply = $reply;
    }

    public function notify(string $method, array $options = []): void
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $resolvedOptions = $resolver->resolve($options);

        $body = $this->getBody($resolvedOptions);
        $from = $this->getFrom();
        $name = $this->getName();
        $recipients = $this->getRecipients($resolvedOptions);
        $subject = $this->getSubject($resolvedOptions);
        $type = $this->getContentType();
        $cc = $this->getCc($resolvedOptions);
        $bcc = $this->getBcc($resolvedOptions);
        $reply = $this->getReplyTo($resolvedOptions);
        $attachments = $this->getAttachments($resolvedOptions);

        $this->dispatcher->dispatch(Events::PRE_SEND, new NotifierEvent($this, $resolvedOptions));

        try {
            $this->mailer->send($from, $name, $recipients, $subject, $body, $type, $cc, $bcc, $reply, $attachments);
        } catch (MailerException $exception) {
            $this->dispatcher->dispatch(Events::FAILURE, new FailureEvent($this, $exception, $resolvedOptions));

            return;
        }

        $this->dispatcher->dispatch(Events::POST_SEND, new NotifierEvent($this, $resolvedOptions));
    }

    protected function getBody(array $options = []): string
    {
        $template = $this->getTemplatePath($options);

        if (false === $this->templating->exists($template)) {
            throw new FileNotFoundException(sprintf('The template %s does not exists', $template));
        }

        $data = $this->getTemplateData($options);

        return $this->templating->render($template, $data);
    }

    protected function getFrom(): string
    {
        if (null === $this->from) {
            throw new \LogicException(sprintf('You must provide a from for the notifier "%"', get_class($this)));
        }

        return $this->from;
    }

    protected function getName(): string
    {
        if (null === $this->name) {
            throw new \LogicException(sprintf('You must provide a name for the notifier "%"', get_class($this)));
        }

        return $this->name;
    }

    protected function getContentType(): string
    {
        return 'text/html';
    }

    protected function getTemplateData(array $options = []): array
    {
        return $options;
    }

    protected function getCc(array $options = []): array
    {
        return [];
    }

    protected function getBcc(array $options = []): array
    {
        return [];
    }

    protected function getReplyTo(array $options = []): array
    {
        return $this->reply;
    }

    protected function getAttachments(array $options = []): array
    {
        return [];
    }

    abstract protected function configureOptions(OptionsResolver $resolver): void;

    abstract protected function getTemplatePath(array $options = []): string;

    abstract protected function getRecipients(array $options = []): array;

    abstract protected function getSubject(array $options = []): string;
}
