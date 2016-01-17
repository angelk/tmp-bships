<?php

namespace Model\Battleship;

/**
 * Battleship
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
