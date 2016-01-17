<?php

namespace Model\Battlefield;

/**
 * Description of BattlefieldFactory
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class BattlefieldFactory
{
    /**
     * Create battlefield with specific size.
     * Randomly place given battleships
     * @param array $battleships battleships to place
     * @param int $sizeX Field x size
     * @param int $sizeY Field y size
     * @return \Model\Battlefield\Battlefield
     */
    public function createBattlefield(array $battleships = [], $sizeX = 10, $sizeY = 10)
    {
        $battlefield = new Battlefield($sizeX, $sizeY);
        foreach ($battleships as $battleship) {
            $validPlacers = $battlefield->getValidPlaces($battleship);
            $randomPlacerKey = array_rand($validPlacers);
            $randomPlacer = $validPlacers[$randomPlacerKey];
            $battlefield->addBattleship($randomPlacer);
        }
        
        return $battlefield;
    }

    /**
     * Create Battlefield[10x10] with one battleship and two destroyers
     * @return type
     */
    public function createDefaultBattlefield()
    {
        $battlefield = $this->createBattleField(
            [
                new \Model\Battleship\Battleship(),
                new \Model\Battleship\Destroyer(),
                new \Model\Battleship\Destroyer(),
            ]
        );
        
        return $battlefield;
    }
}
