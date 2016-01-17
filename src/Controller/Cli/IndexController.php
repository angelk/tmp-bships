<?php

namespace Controller\Cli;

use Model\Battlefield\BattlefieldFactory;
use Model\Battlefield\Battlefield;

/**
 * IndexController
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class IndexController extends \Controller\AbstractController
{
    public function homeAction()
    {
        $battlefieldFactory = new BattlefieldFactory();
        $battlefield = $battlefieldFactory->createDefaultBattlefield();
        $battlefield->setEventDispacher($this->getEventDispacher());
        
        $newGame = true;
        
        while (true) {
            $this->playGame($battlefield);
            echo "Game completed in {$battlefield->getShots()->count()} shots" . PHP_EOL;
            
            $newGame = null;
            while (!in_array($newGame, ['y', 'n'])) {
                echo "New game(y/n): ";
                $newGame = trim(fgets(STDIN));
            }
            
            if ($newGame === 'n') {
                break;
            }
        };
        
        return 0;
    }
        
    /**
     * Force user to complete the game
     * @param Battlefield $battlefield
     */
    protected function playGame(Battlefield $battlefield)
    {
        while ($battlefield->isThereNonSunkBattleship()) {
            echo PHP_EOL . PHP_EOL;
            $visualizer = $this->getVisualizerFactory()->create($battlefield);
            if (($lastShotStatus = $visualizer->getLastShotStatus())) {
                echo $lastShotStatus . PHP_EOL;
            }
            echo PHP_EOL . $visualizer->getFieldOutput(). PHP_EOL;
            $this->shoot($battlefield);
        }
    }
    
    /**
     * Force user to enter valid point
     * @param Battlefield $battlefield
     * @return \Model\Battlefield\Point\PointInterface
     */
    protected function shoot(Battlefield $battlefield)
    {
        $pointFactory = new \Model\Battlefield\Point\PointFactory();
        $shot = null;
        while ($shot === null) {
            echo "Enter point coordinates: ";
            $coordinates = trim(fgets(STDIN));
            try {
                $shot = $pointFactory->createPoint($coordinates);
                $battlefield->shoot($shot);
            } catch (\Model\Battlefield\Exception\HumanReadableException $e) {
                echo "Error. ". $e->getMessage() . PHP_EOL;
                $shot = null;
            }
        }
        
        return $shot;
    }
}
