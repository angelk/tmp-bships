<?php

namespace Model\Battlefield;

/**
 * Description of BattlefieldFactory
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class BattlefieldFactory
{
    public function createBattleField(array $battleships = [], $sizeX = 10, $sizeY = 10)
    {
        $battlefield = new Battlefield($sizeX, $sizeY);
        foreach ($battleships as $battleship) {
            $validPlacers = $battlefield->getValidPlaces($battleship);
            $randomPlacerKey = array_rand($validPlacers);
            $randomPlacer = $validPlacers[$randomPlacerKey];
            $battlefield->addBattleShip($randomPlacer);
        }
        
        return $battlefield;
    }
}
