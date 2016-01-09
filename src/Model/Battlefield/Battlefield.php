<?php

namespace Model\Battlefield;

use Model\Battlefield\Placer;
use Model\Battleship\BattleshipInterface;

/**
 * Description of Battlefield
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Battlefield
{
    private $field = [];
    /**
     *
     * @var Placer[]
     */
    private $palcers = [];
    private $shots = [];
    
    /**
     *
     * @param int $sizeW Field width in sqares
     * @param int $sizeH Field height in sqares
     */
    public function __construct($sizeW, $sizeH)
    {
        for ($i = 0; $i < $sizeW; $i++) {
            $this->field[] = array_fill(0, $sizeH, null);
        }
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
        $this->palcers[] = $placer;
    }
    
    public function getValidPlaces(BattleshipInterface $battleship)
    {
        $potentialPlacements = [];
        $battleshipSize = $battleship->getSize();
        foreach ($this->field as $yKey => $y) {
            foreach ($y as $xKey => $x) {
                $horizontalValidation = true;
                for ($i = 0; $i < $battleshipSize; $i++) {
                    $tmpPoint = new Point($xKey + $i, $yKey);
                    if (!$this->isPointValid($tmpPoint)) {
                        $horizontalValidation = false;
                        break;
                    }
                }
                if ($horizontalValidation) {
                    $potentialPlacements[]  = new Placer(
                        $battleship,
                        new Point($xKey, $yKey),
                        new Point($xKey + $battleshipSize -1, $yKey)
                    );
                }
                
                $verticalValidation = true;
                for ($i = 0; $i < $battleshipSize; $i++) {
                    $tmpPoint = new Point($xKey, $yKey + $i);
                    if (!$this->isPointValid($tmpPoint)) {
                        $verticalValidation = false;
                        break;
                    }
                }
                if ($verticalValidation) {
                    $potentialPlacements[]  = new Placer(
                        $battleship,
                        new Point($xKey, $yKey),
                        new Point($xKey, $yKey + $battleshipSize -1)
                    );
                }
            }
        }
        
        return $potentialPlacements;
    }
    
    public function isPointValid(Point $point)
    {
        $pointX = $point->getX();
        $fieldSizeX = count($this->field) -1;
        if ($fieldSizeX < $pointX) {
            return false;
        }
        
        $pointY = $point->getY();
        $fieldSizeY = count($this->field[0]) -1;
        if ($fieldSizeY < $pointY) {
            return false;
        }
        
        return true;
    }
    
    public function isPointFree(Point $point)
    {
        foreach ($this->palcers as $placer) {
            $xInersection = ($placer->getStartPoint()->getX() <= $point->getX() && $placer->getEndPoint()->getX() >= $point->getX());
            $yIntersection = ($placer->getStartPoint()->getY() <= $point->getY() && $placer->getEndPoint()->getY() >= $point->getY());
            
            if ($xInersection && $yIntersection) {
                return false;
            }
        }
        
        return true;
    }
}
