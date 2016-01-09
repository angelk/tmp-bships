<?php

namespace Model\Battleship;

/**
 * Description of Destroyer
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Destroyer extends AbstractBattleship
{
    public function __construct()
    {
        $this->size = 4;
    }
}
