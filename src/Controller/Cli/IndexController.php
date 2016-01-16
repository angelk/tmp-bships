<?php

namespace Controller\Cli;

/**
 * Description of IndexController
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class IndexController extends \Controller\AbstractController
{
    public function homeAction()
    {
        $battlefieldFactory = new \Model\Battlefield\BattlefieldFactory();
        $battlefield = $battlefieldFactory->createBattleField(
            [
                new \Model\Battleship\Battleship(),
                new \Model\Battleship\Destroyer(),
                new \Model\Battleship\Destroyer(),
            ]
        );
        
        $battlefield->setEventDispacher($this->getEventDispacher());
        
        while (true) {
            $visualizer = $this->getVisualizerFactory()->create($battlefield);
            echo PHP_EOL . $visualizer->getFieldOutput(). PHP_EOL;
            $shot = null;
            $pointFactory = new \Model\Battlefield\Point\PointFactory();
            while ($shot === null) {
                echo "Enter point coordinates: ";
                $coordinates = trim(fgets(STDIN));
                try {
                    $shot = $pointFactory->createPoint($coordinates);
                } catch (\Exception $e) {
                    echo "Error. ". $e->getMessage() . PHP_EOL;
                }
            }
            $battlefield->shoot($shot);
        }
            
        return [];
    }
}
