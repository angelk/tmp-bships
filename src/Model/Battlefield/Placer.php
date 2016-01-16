<?php

namespace Model\Battlefield;

use Model\Battleship\BattleshipInterface;
use Model\Battlefield\Point\PointInterface;

/**
 * Description of Placer
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Placer
{
    private $battleship;
    private $startPoint;
    private $endPoint;
    
    public function __construct(BattleshipInterface $battleship, PointInterface $start, PointInterface $end)
    {
        /*
         * @TODO
         * placer should allow ony
         * ---->
         * OR
         * | 
         * |
         * |
         * \/
         * 
         * But not <-----
         */
        $this->battleship = $battleship;
        $this->startPoint = $start;
        $this->endPoint = $end;
    }
    
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
    
    public function getPoints()
    {
        $startX = $this->getStartPoint()->getX();
        $startY = $this->getStartPoint()->getY();
        $endX = $this->getEndPoint()->getX();
        $endY = $this->getEndPoint()->getY();
        /*
         * Horizontal placement
         */
        
        $return = [];
        if ($startY == $endY) {
            for ($i = $startX; $i <= $endX; $i++) {
                $return[] = new Point\Point($i, $startY);
            }
        } else {
            for ($i = $startY; $i <= $endY; $i++) {
                $return[] = new Point\Point($startX, $i);
            }
        }
        
        return $return;
    }
}
