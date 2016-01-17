<?php

namespace EventDispatcher;

/**
 *
 * @author po_taka
 */
interface EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents();
}
