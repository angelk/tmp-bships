<?php

namespace Model\Battlefield;

use Model\Battlefield\Placer;
use Model\Battlefield\Point\PointCollection;
use Model\Battleship\BattleshipInterface;

/**
 * Description of Battlefield
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Battlefield
{
    private $fieldWidth;
    private $fieldHeight;
    
    /**
     *
     * @var Placer[]
     */
    private $placers = [];
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
    
    protected function getFieldMaximumHeightIndex()
    {
        return $this->fieldHeight -1;
    }
    
    protected function getFieldMaximumWidthIndex()
    {
        return $this->fieldWidth -1;
    }
    
    public function shoot(Point $shot)
    {
        $this->shots[] = $shot;
    }
    
    public function getShots()
    {
        return $this->shots;
    }

    /**
     * @param Placer $placer
     */
    public function addBattleShip(Placer $placer)
    {
        // user should not be able to add bships if there are shots!
        $this->placers[] = $placer;
    }
    
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
                        if (!$this->isPointValid($pointToCheck)) {
                            $horizontalValidation = false;
                        }
                    }
                    
                    if ($verticalValidation) {
                        $pointToCheck = new Point($xIndex, $yIndex + $i);
                        if (!$this->isPointValid($pointToCheck)) {
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
    
    public function isPointValid(Point $point)
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
    
    public function isPointFree(Point $point)
    {
        if (!$this->isPointValid($point)) {
            // should I throw exception ?
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
}
