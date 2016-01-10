<?php

namespace Model\Battlefield\Point;

/**
 * Description of Point
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Point implements PointInterface
{
    protected $x;
    protected $y;
    
    public function __construct($x, $y)
    {
        foreach (func_get_args() as $arg) {
            if (!is_int($arg)) {
                throw new \Exception("{$arg} should be 'int'");
            }
        }
        
        $this->x = $x;
        $this->y = $y;
    }
    
    public function getX()
    {
        return $this->x;
    }

    public function getY()
    {
        return $this->y;
    }
    
    public function isSameAs(Point $point)
    {
        if ($point->getX() === $this->getX() && $point->getY() === $this->getY()) {
            return true;
        }
        
        return false;
    }
}
