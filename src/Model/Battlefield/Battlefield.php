<?php

namespace Model\Battlefield;

use Model\Battlefield\Point\PointInterface;
use Model\Battlefield\Point\CheatPointInterface;
use Model\Battlefield\Point\Point;
use Model\Battlefield\Placer;
use Model\Battlefield\Point\PointCollection;
use Model\Battleship\BattleshipInterface;
use EventDispatcher\EventDispacherInterface;

/**
 * Description of Battlefield
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Battlefield
{
    const POINT_STATUS_NO_SHOT = 0;
    const POINT_STATUS_SHOT = 1;
    const POINT_STATUS_SHIP_NOT_HIT = 2;
    const POINT_STATUS_SHIP_HIT = 3;
    
    private $fieldWidth;
    private $fieldHeight;
    
    /**
     *
     * @var EventDispacherInterface|Null
     */
    private $eventDispacher;
    
    /**
     *
     * @var Placer[]
     */
    private $placers = [];
    /**
     *
     * @var PointCollection
     */
    private $shots = [];
    
    /**
     *
     * @param int $sizeW Field width in sqares
     * @param int $sizeH Field height in sqares
     */
    public function __construct($sizeW, $sizeH)
    {
        $this->fieldWidth = $sizeW;
        $this->fieldHeight = $sizeH;
        
        $this->shots = new PointCollection();
    }

    /**
     * @param EventDispacherInterface $eventDispacher
     */
    public function setEventDispacher(EventDispacherInterface $eventDispacher)
    {
        $this->eventDispacher = $eventDispacher;
    }
    
    /**
     * @return Placer[]
     */
    public function getPlacers()
    {
        return $this->placers;
    }

    /**
     * If dispatch is set, then dispatch event
     * @param \EventDispatcher\Event $event
     * @return boolean
     */
    protected function dispatch($event)
    {
        if (!$this->eventDispacher) {
            return false;
        }
        
        $this->eventDispacher->dispatch($event);
    }
    
    /**
     * maximum height index. Start form zero
     * @return int
     */
    public function getFieldMaximumHeightIndex()
    {
        return $this->fieldHeight -1;
    }
    
    /**
     * maximum width index. Start form zero
     * @return type
     */
    public function getFieldMaximumWidthIndex()
    {
        return $this->fieldWidth -1;
    }
    
    /**
     * Add point to shoot
     * @param PointInterface $shot
     * @return self
     */
    public function shoot(PointInterface $shot)
    {
        $event = new \Event\Model\Battlefield\ShootEvent('beforeShoot', $this, $shot);
        $this->dispatch($event);
        
        if ($shot instanceof CheatPointInterface) {
            return $this;
        }
        
        if (!$this->isPointValid($shot)) {
            throw new Exception\HumanReadableException("Invlid point");
        }
        $this->shots->addPoint($shot);
        $afterShootEvent = new \Event\Model\Battlefield\ShootEvent('afterShoot', $this, $shot);
        $this->dispatch($afterShootEvent);
        
        return $this;
    }
    
    /**
     * @return PointCollection
     */
    public function getShots()
    {
        return $this->shots;
    }

    /**
     * Place new battleship on the field
     * @param Placer $placer
     */
    public function addBattleship(Placer $placer)
    {
        if ($this->shots->count()) {
            throw new Exception\Exception("Can\'t add placers. There are shoots!");
        }
        $this->placers[] = $placer;
    }
    
    /**
     * Get available placers for battleship
     * @param BattleshipInterface $battleship
     * @return Placer[]
     */
    public function getValidPlaces(BattleshipInterface $battleship)
    {
        $potentialPlacements = [];
        $battleshipSize = $battleship->getSize();
        for ($yIndex = 0; $yIndex < $this->fieldHeight; $yIndex++) {
            for ($xIndex = 0; $xIndex < $this->fieldWidth; $xIndex++) {
                $horizontalValidation = true;
                $verticalValidation = true;
                for ($i = 0; $i < $battleshipSize; $i++) {
                    if ($horizontalValidation) {
                        $pointToCheck = new Point($xIndex + $i, $yIndex);
                        if (!$this->isPointFree($pointToCheck)) {
                            $horizontalValidation = false;
                        }
                    }
                    
                    if ($verticalValidation) {
                        $pointToCheck = new Point($xIndex, $yIndex + $i);
                        if (!$this->isPointFree($pointToCheck)) {
                            $verticalValidation = false;
                        }
                    }
                    
                    if (!$horizontalValidation && !$verticalValidation) {
                        break;
                    }
                }
                
                if ($verticalValidation) {
                    $potentialPlacements[]  = new Placer(
                        $battleship,
                        new Point($xIndex, $yIndex),
                        new Point($xIndex, $yIndex + $battleshipSize -1)
                    );
                }

                if ($horizontalValidation) {
                    $potentialPlacements[]  = new Placer(
                        $battleship,
                        new Point($xIndex, $yIndex),
                        new Point($xIndex + $battleshipSize -1, $yIndex)
                    );
                }
            }
        }
        
        return $potentialPlacements;
    }
    
    /**
     * Check if point is valid for battlefield
     * @param PointInterface $point
     * @return boolean
     */
    public function isPointValid(PointInterface $point)
    {
        $pointX = $point->getX();
        if ($this->getFieldMaximumWidthIndex() < $pointX) {
            return false;
        }
        
        $pointY = $point->getY();
        if ($this->getFieldMaximumHeightIndex() < $pointY) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Check if point already have palced battleship
     * @param PointInterface $point
     * @return boolean
     */
    public function isPointFree(PointInterface $point)
    {
        if (!$this->isPointValid($point)) {
            return false;
        }
        
        foreach ($this->placers as $placer) {
            $xInersection = ($placer->getStartPoint()->getX() <= $point->getX() && $placer->getEndPoint()->getX() >= $point->getX());
            $yIntersection = ($placer->getStartPoint()->getY() <= $point->getY() && $placer->getEndPoint()->getY() >= $point->getY());
            
            if ($xInersection && $yIntersection) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Get point status - miss, no shot, hit ... etc
     * @param PointInterface $point
     * @return int
     */
    public function getPointStatus(PointInterface $point)
    {
        if (!$this->isPointValid($point)) {
            throw new Exception\Exception("Can't get status of invalid point");
        }
        
        $isThereShot = $this->shots->hasPoint($point);
        $isThereShip = !$this->isPointFree($point);
        
        if ($isThereShot) {
            if ($isThereShip) {
                return self::POINT_STATUS_SHIP_HIT;
            }
            
            return self::POINT_STATUS_SHOT;
        }
        
        if ($isThereShip) {
            return self::POINT_STATUS_SHIP_NOT_HIT;
        }
        
        return self::POINT_STATUS_NO_SHOT;
    }
    
    /**
     * Used to check if game should end
     * @return boolean
     */
    public function isThereNonSunkBattleship()
    {
        foreach ($this->placers as $placer) {
            foreach ($placer->getPoints() as $placerPoint) {
                if (!$this->shots->hasPoint($placerPoint)) {
                    return true;
                }
            }
        }
        
        return false;
    }
}
