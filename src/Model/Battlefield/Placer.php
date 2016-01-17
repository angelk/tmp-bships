<?php

namespace Model\Battlefield;

use Model\Battleship\BattleshipInterface;
use Model\Battlefield\Point\PointInterface;

/**
 * Used to add battleship to battlefield
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Placer
{
    /**
     * @var BattleshipInterface
     */
    private $battleship;
    /**
     * @var PointInterface
     */
    private $startPoint;
    /**
     * @var PointInterface
     */
    private $endPoint;
    
    /**
     * @param BattleshipInterface $battleship
     * @param PointInterface $start
     * @param PointInterface $end
     */
    public function __construct(BattleshipInterface $battleship, PointInterface $start, PointInterface $end)
    {
        /*
         * placer should allow ony
         * ---->
         * OR
         * | 
         * |
         * \/
         * 
         * But not <-----
         */
        
        if ($start->getX() > $end->getX() || $start->getY() > $end->getY()) {
            throw new Exception\Exception("Points missmatch");
        }
        
        $this->battleship = $battleship;
        $this->startPoint = $start;
        $this->endPoint = $end;
        
        if ($this->getPoints()->count() !== $battleship->getSize()) {
            throw new Exception\Exception('Can\'t fit battleship in placer');
        }
    }
    
    /**
     * @return BattleshipInterface
     */
    public function getBattleship()
    {
        return $this->battleship;
    }

    /**
     * @return PointInterface
     */
    public function getStartPoint()
    {
        return $this->startPoint;
    }

    /**
     * @return PointInterface
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }
    
    /**
     * Get all point used by palcer.
     *
     * Placer with points [0.0] : [0.2]
     * have points [0.0], [0.1], [0.2]
     * @return \Model\Battlefield\Point\PointCollection
     */
    public function getPoints()
    {
        $startX = $this->getStartPoint()->getX();
        $startY = $this->getStartPoint()->getY();
        $endX = $this->getEndPoint()->getX();
        $endY = $this->getEndPoint()->getY();
        /*
         * Horizontal placement
         */
        
        $return = new Point\PointCollection();
        if ($startY == $endY) {
            for ($i = $startX; $i <= $endX; $i++) {
                $return->addPoint(new Point\Point($i, $startY));
            }
        } else {
            for ($i = $startY; $i <= $endY; $i++) {
                $return->addPoint(new Point\Point($startX, $i));
            }
        }
        
        return $return;
    }
}
