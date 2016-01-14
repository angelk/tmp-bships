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
    private $lastShots = [
        
    ];
    
    public function create(Battlefield $battlefield)
    {
        $battlefieldId = spl_object_hash($battlefield);
        $lastShot = isset($this->lastShots[$battlefieldId]) ? $this->lastShots[$battlefieldId] : null;
        
        if (!$lastShot) {
            return new Visualizer($battlefield);
        }
        
        if ($lastShot instanceof \Model\Battlefield\Point\CheatPointInterface) {
            return new VisualizerCheat($battlefield);
        }
        
        return new Visualizer($battlefield);
    }
    
    public function setLastShot(Battlefield $battlefield, \Model\Battlefield\Point\PointInterface $shoot)
    {
        $battlefieldId = \spl_object_hash($battlefield);
        $this->lastShots[$battlefieldId] = $shoot;
    }
}
