<?php

namespace Model\Battlefield\Point;

use Model\Battlefield\Point;

/**
 * Description of PointCollection
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class PointCollection implements \Iterator
{
    private $iteratorPosition = 0;
    
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

    public function current()
    {
        return $this->points[$this->iteratorPosition];
    }

    public function key()
    {
        return $this->iteratorPosition;
    }

    public function next()
    {
        $this->iteratorPosition++;
    }

    public function rewind()
    {
        $this->iteratorPosition = 0;
    }

    public function valid()
    {
        return isset($this->points[$this->iteratorPosition]);
    }
}
