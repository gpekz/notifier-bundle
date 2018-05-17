<?php

namespace Gpekz\NotifierBundle\Event;

/**
 * Events.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
class Events
{
    public const PRE_SEND = 'notifier.pre_send';
    public const POST_SEND = 'notifier.post_send';
    public const FAILURE = 'notifier.failure';
}
