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
        foreach ($this as $pointKey => $point) {
            if ($point->getX() == $x && $point->getY() == $y) {
                return $point;
            }
        }
        
        return null;
    }
    
    /**
     * Check if there is point with given coordinates
     * @param Point $existingPoint
     */
    public function hasPoint(PointInterface $pointToCheck)
    {
        $existingPoint = $this->getPointByCoordinates($pointToCheck->getX(), $pointToCheck->getY());
        if ($existingPoint) {
            return true;
        }
        
        return false;
    }
    
    public function getLastPoint($real = true)
    {
        end($this->points);
        while (current($this->points)) {
            if (!$real || !current($this->points) instanceof CheatPointInterface) {
                break;
            }
            prev($this->points);
        }
        
        return current($this->points);
    }
    
    public function current()
    {
        if (!isset($this->points[$this->iteratorPosition])) {
            return null;
        }
        
        return $this->points[$this->iteratorPosition];
    }

    public function key()
    {
        return $this->iteratorPosition;
    }

    public function next()
    {
        do {
            $this->iteratorPosition++;
            error_log("checking {$this->iteratorPosition}, valid: " . ($this->valid() ? '1' : '0') ." ");
            error_log(" " . ($this->current() instanceof CheatPointInterface ? 'instance' : 'not intance') . " ");
            error_log("current class " . get_class($this->current()) . " \n");
        } while (!(!$this->valid() || !$this->current() instanceof CheatPointInterface));
        // @TODO fix code above!!!
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
        $countOfNonCheatingPoitns = 0;
        foreach ($this->points as $point) {
            if (!$point instanceof CheatPoint) {
                $countOfNonCheatingPoitns++;
            }
        }
        return $countOfNonCheatingPoitns;
    }
}
