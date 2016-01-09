<?php

namespace Model\Battleship;

/**
 * Description of Battleship
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Battleship extends AbstractBattleship
{
    public function __construct()
    {
        $this->size = 5;
    }
}
