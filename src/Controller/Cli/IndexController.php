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
        $battlefield = $battlefieldFactory->createDefaultBattlefield();
        
        $battlefield->setEventDispacher($this->getEventDispacher());
        
        while ($battlefield->isThereNonSinkedBattleship()) {
            $visualizer = $this->getVisualizerFactory()->create($battlefield);
            if (($lastShotStatus = $visualizer->getLastShotStatus())) {
                echo $lastShotStatus . PHP_EOL;
            }
            echo PHP_EOL . $visualizer->getFieldOutput(). PHP_EOL;
            $shot = null;
            $pointFactory = new \Model\Battlefield\Point\PointFactory();
            while ($shot === null) {
                echo "Enter point coordinates: ";
                $coordinates = trim(fgets(STDIN));
                try {
                    $shot = $pointFactory->createPoint($coordinates);
                    $battlefield->shoot($shot);
                } catch (\Exception $e) {
                    echo "Error. ". $e->getMessage() . PHP_EOL;
                }
            }
        }
        
        echo "Game completed in " . $battlefield->getShots()->count() . ' shots' . PHP_EOL;
        return [];
    }
}
