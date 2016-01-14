<?php

namespace EventDispatcher;

/**
 * Description of Event
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Event
{
    private $name;
    private $target;
    
    public function __construct($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getTarget()
    {
        return $this->target;
    }
}
