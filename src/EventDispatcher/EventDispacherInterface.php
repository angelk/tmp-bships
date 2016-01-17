<?php

namespace EventDispatcher;

/**
 *
 * @author po_taka
 */
interface EventDispacherInterface
{
    /**
     * Dispatch event
     * @param Event $event
     */
    public function dispatch(Event $event);
    
    /**
     * Add subscriber
     * @param EventSubscriberInterface $subscriber
     */
    public function addSubscriber(EventSubscriberInterface $subscriber);
}
