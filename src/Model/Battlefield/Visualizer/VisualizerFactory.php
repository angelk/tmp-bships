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
//        return new VisualizerCheat($battlefield);
        return new Visualizer($battlefield);
    }
}
