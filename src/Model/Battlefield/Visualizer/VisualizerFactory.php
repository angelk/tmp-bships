<?php

namespace Model\Battlefield\Visualizer;

use Model\Battlefield\Battlefield;
use Model\Battlefield\Point\PointInterface;

/**
 * Description of VisualizerFactory
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class VisualizerFactory
{
    /**
     * Save last shot for specific battlefield
     * @var Array
     */
    private $lastShots = [];
    
    /**
     * Create visualizer based on battlefield
     * @param Battlefield $battlefield
     * @return VisualizerInterface
     */
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
    
    /**
     * Store last shoot info.
     * Used to create visualizerChaet for cheat shots.
     * @param Battlefield $battlefield
     * @param PointInterface $shoot
     */
    public function setLastShot(Battlefield $battlefield, PointInterface $shoot)
    {
        $battlefieldId = \spl_object_hash($battlefield);
        $this->lastShots[$battlefieldId] = $shoot;
    }
}
