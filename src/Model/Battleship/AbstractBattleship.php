<?php

namespace Model\Battleship;

/**
 * Description of Battleship
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
abstract class AbstractBattleship implements BattleshipInterface
{
    /**
     * battleship size. E.g. Destroyer(size=4) need 4 points to be plces.
     * @var int
     */
    protected $size;
    
    /**
     * @inheritdoc
     */
    public function getSize()
    {
        return $this->size;
    }
}
