<?php

namespace Model\Battleship;

/**
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
interface BattleshipInterface
{
    /**
     * Get point needed to place battleship
     * @return int
     */
    public function getSize();
}
