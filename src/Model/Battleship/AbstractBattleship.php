<?php

namespace Model\Battleship;

/**
 * Description of Battleship
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
abstract class AbstractBattleship implements BattleshipInterface
{
    protected $size;
    
    public function getSize()
    {
        return $this->size;
    }
}
