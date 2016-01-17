<?php

namespace Event\Model\Battlefield;

/**
 * Used to hook drurin shoot event
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class ShootEvent extends \EventDispatcher\Event
{
    private $battlefield;
    private $shoot;
    
    public function __construct($name, $battlefield, $shoot)
    {
        parent::__construct($name);
        $this->battlefield = $battlefield;
        $this->shoot = $shoot;
    }
    
    public function getBattlefield()
    {
        return $this->battlefield;
    }

    public function getShoot()
    {
        return $this->shoot;
    }
}
