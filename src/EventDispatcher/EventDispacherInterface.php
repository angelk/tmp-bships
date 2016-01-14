<?php

namespace EventDispatcher;

/**
 *
 * @author potaka
 */
interface EventDispacherInterface
{
    public function dispatch(Event $event);
    public function addSubscriber(EventSubscriberInterface $subscriber);
}
