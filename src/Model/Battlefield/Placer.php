<?php

namespace Model\Battlefield;

use Model\Battleship\BattleshipInterface;
use Model\Battlefield\Point;

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
    
    public function __construct(BattleshipInterface $battleship, Point $start, Point $end)
    {
        $this->battleship = $battleship;
        $this->startPoint = $start;
        $this->endPoint = $end;
    }
    
    public function getBattleship()
    {
        return $this->battleship;
    }

    /**
     * @return Point
     */
    public function getStartPoint()
    {
        return $this->startPoint;
    }

    /**
     * @return Point
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }
}
