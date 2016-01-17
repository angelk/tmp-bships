<?php

namespace Model\Battlefield\Visualizer;

/**
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
interface VisualizerInterface
{
    /**
     * Return string representation of battlefield
     * @return string
     */
    public function getFieldOutput();

    /**
     * Get last shot status - miss, hit, etc
     */
    public function getLastShotStatus();
}
