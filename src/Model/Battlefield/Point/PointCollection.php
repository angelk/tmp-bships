<?php

namespace Model\Battlefield\Point;

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
     * @var PointInterface[]
     */
    private $points = [];
    
    public function __construct($points = array())
    {
        foreach ($points as $point) {
            $this->addPoint($point);
        }
    }
    
    public function addPoint(PointInterface $point)
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
    
    /**
     * Check if there is point with given coordinates
     * @param Point $point
     */
    public function hasPoint(PointInterface $point)
    {
        $point = $this->getPointByCoordinates($point->getX(), $point->getY());
        if ($point) {
            return true;
        }
        
        return false;
    }
    
    public function getLastPoint()
    {
        end($this->points);
        return current($this->points);
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
    
    public function count()
    {
        return count($this->points);
    }
}
