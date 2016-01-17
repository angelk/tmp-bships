<?php

namespace EventDispatcher;

/**
 * EventDispatcher
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class EventDispatcher implements EventDispacherInterface
{
    protected $listeners = [];
   
    /**
     * @inheritdoc
     */
    public function dispatch(Event $event)
    {
        if (isset($this->listeners[$event->getName()])) {
            foreach ($this->listeners[$event->getName()] as $listener) {
                call_user_func($listener, $event);
            }
        }
    }
    
    public function addListener($eventName, $listener)
    {
        $this->listeners[$eventName][] = $listener;
    }
    
    /**
     * @inheritdoc
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $method) {
            $this->addListener($eventName, [$subscriber, $method]);
        }
    }
}
