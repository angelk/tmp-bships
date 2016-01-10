<?php

namespace Model\Battlefield\Visualizer;

use Model\Battlefield\Battlefield;

/**
 * Description of VisualizerFactory
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class VisualizerFactory
{
    public function create(Battlefield $battlefield)
    {
        $lastShot = $battlefield->getShots()
                                    ->getLastPoint(false);
        
        if (!$lastShot) {
            return new Visualizer($battlefield);
        }
        
        if ($lastShot instanceof \Model\Battlefield\Point\CheatPointInterface) {
            return new VisualizerCheat($battlefield);
        }
        
        return new Visualizer($battlefield);
    }
}
