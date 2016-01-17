<?php

namespace Model\Battlefield\Point;

use Exception\Exception;

/**
 * Create poits with coordinates, e.g. [0,1]
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Point implements PointInterface
{
    protected $x;
    protected $y;
    
    /**
     * @param int $x
     * @param int $y
     * @throws \Exception
     */
    public function __construct($x, $y)
    {
        foreach (func_get_args() as $arg) {
            if (!is_int($arg)) {
                throw new Exception("{$arg} should be 'int'");
            }
        }
        
        $this->x = $x;
        $this->y = $y;
    }
    
    /**
     * @inheritdoc
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @inheritdoc
     */
    public function getY()
    {
        return $this->y;
    }
    
    /**
     * @inheritdoc
     */
    public function isSameAs(PointInterface $point)
    {
        if ($point->getX() === $this->getX() && $point->getY() === $this->getY()) {
            return true;
        }
        
        return false;
    }
}
