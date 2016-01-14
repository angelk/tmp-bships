<?php

namespace EventDispatcher;

/**
 * Description of EventDispatcher
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class EventDispatcher implements EventDispacherInterface
{
    protected $listeners = [];
    
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
    
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $method) {
            $this->addListener($eventName, [$subscriber, $method]);
        }
    }
}
