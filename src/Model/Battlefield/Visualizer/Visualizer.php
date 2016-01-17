<?php

namespace Model\Battlefield\Visualizer;

use Model\Battlefield\Battlefield;
use Model\Battlefield\Point\Point;

/**
 * Description of Visualizer
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Visualizer implements VisualizerInterface
{
    private $battlefield;

    public function __construct(Battlefield $battlefield)
    {
        $this->battlefield = $battlefield;
    }
    
    public function getBattlefield()
    {
        return $this->battlefield;
    }

    protected function pointStatusToOutputValue($pointStatus)
    {
        switch ($pointStatus) {
            case Battlefield::POINT_STATUS_NO_SHOT:
                $return = '.';
                break;
            case Battlefield::POINT_STATUS_SHIP_HIT:
                $return = 'x';
                break;
            case Battlefield::POINT_STATUS_SHIP_NOT_HIT:
                $return = '.';
                break;
            case Battlefield::POINT_STATUS_SHOT:
                $return = '-';
                break;
            default:
                throw new \Model\Exception\Exception("Unknown status {$pointStatus}");
        }
        
        return $return;
    }
    
    public function getFieldOutput()
    {
        /*
         * Maybe I don't need cli and html visualizers.
         * <pre> will do the work
         */
        $battlefieldMaxWidthIndex = $this->battlefield->getFieldMaximumWidthIndex();
        $battlefieldMaxHeightIndex = $this->battlefield->getFieldMaximumHeightIndex();
        
        $output = $this->getHeaderRowOutput();
        $output .= PHP_EOL;
        
        for ($y = 0; $y <= $battlefieldMaxHeightIndex; $y ++) {
            $output .= $this->getRowIndexOutput($y);
            for ($x = 0; $x <= $battlefieldMaxWidthIndex; $x++) {
                $pointToVisualize = new Point($x, $y);
                $pointStatus = $this->battlefield->getPointStatus($pointToVisualize);
                $output .= $this->pointStatusToOutputValue($pointStatus) . ' ';
            }
            $output .= PHP_EOL;
        }
        
        return $output;
    }
    
    public function getRowIndexOutput($rowIndex)
    {
        $output = chr($rowIndex + 65) . ' ';
        return $output;
    }
    
    public function getHeaderRowOutput()
    {
        $battlefieldMaxWidthIndex = $this->battlefield->getFieldMaximumWidthIndex();
        
        $output = '  ';
        
        for ($x = 0; $x <= $battlefieldMaxWidthIndex; $x++) {
            $output .= ($x + 1) . ' ';
        }
        return $output;
    }
    
    public function getLastShotStatus()
    {
        $lastShot = $this->battlefield
                                ->getShots()
                                    ->getLastPoint();
        
        if (!$lastShot) {
            return null;
        }
        
        if ($this->battlefield->isPointFree($lastShot)) {
            return 'miss';
        } else {
            $sink = false;
            foreach ($this->battlefield->getPlacers() as $placer) {
                $placerPoints = $placer->getPoints();
                if ($placerPoints->hasPoint($lastShot)) {
                    $sinking = true;
                    foreach ($placerPoints as $battleshipPoint) {
                        if (Battlefield::POINT_STATUS_SHIP_HIT !== $this->battlefield->getPointStatus($battleshipPoint)) {
                            $sinking = false;
                            break;
                        }
                    }
                    
                    if ($sinking) {
                        $sink = true;
                    }
                    break;
                }
            }
            if ($sink) {
                return 'sunk';
            } else {
                return 'hit';
            }
        }
    }
}
