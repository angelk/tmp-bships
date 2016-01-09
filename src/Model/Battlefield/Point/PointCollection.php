<?php

namespace Model\Battlefield\Point;

use Model\Battlefield\Point;

/**
 * Description of PointCollection
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class PointCollection
{
    /**
     *
     * @var Point[]
     */
    private $points;
    
    public function __construct($points = array())
    {
        foreach ($points as $point) {
            $this->addPoint($point);
        }
    }
    
    public function addPoint(Point $point)
    {
        $this->points[] = $point;
    }
    
    public function getPointByCoordinates($x, $y)
    {
        foreach ($this->points as $point) {
            if ($point->getX() == $x && $point->getY() == $y) {
                return $point;
            }
        }
        
        return null;
    }
}
