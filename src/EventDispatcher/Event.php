<?php

namespace EventDispatcher;

/**
 * Event
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Event
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $target;
   
    /**
     * @param string $name Event name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return type
     */
    public function getTarget()
    {
        return $this->target;
    }
}
