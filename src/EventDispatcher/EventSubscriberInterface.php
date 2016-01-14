<?php

namespace EventDispatcher;

/**
 *
 * @author potaka
 */
interface EventSubscriberInterface
{
    public static function getSubscribedEvents();
}
