<?php

namespace Model\Battlefield\Visualizer;

use Model\Battlefield\Battlefield;

/**
 * Used to visualize cheat shot
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class VisualizerCheat extends Visualizer
{
    protected function pointStatusToOutputValue($pointStatus)
    {
        switch ($pointStatus) {
            case Battlefield::POINT_STATUS_NO_SHOT:
                $return = ' ';
                break;
            case Battlefield::POINT_STATUS_SHIP_HIT:
                $return = ' ';
                break;
            case Battlefield::POINT_STATUS_SHIP_NOT_HIT:
                $return = 'X';
                break;
            case Battlefield::POINT_STATUS_SHOT:
                $return = ' ';
                break;
            default:
                throw new \Model\Exception\Exception("Unknown status {$pointStatus}");
        }
        
        return $return;
    }
}
