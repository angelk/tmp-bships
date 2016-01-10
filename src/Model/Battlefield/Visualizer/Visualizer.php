<?php

namespace Model\Battlefield\Visualizer;

use Model\Battlefield\Battlefield;

/**
 * Description of Visualizer
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Visualizer implements VisualizerInterface
{
    private $battlefield;

    protected $beforeStart;
    protected $beforeNewRow;
    protected $afterNewRow;
    protected $beforeNewField;
    protected $afterNewfield;
    protected $beforeEnd;
    
    
    public function __construct(Battlefield $battlefield)
    {
        $this->battlefield = $battlefield;
    }
    
    public function getBattlefield()
    {
        return $this->battlefield;
    }

    public function getBeforeStart()
    {
        return $this->beforeStart;
    }
    
    public function getBeforeNewRow()
    {
        return $this->beforeNewRow;
    }
    
    public function setBeforeNewRow($beforeNewRow)
    {
        $this->beforeNewRow = $beforeNewRow;
    }

    public function getAfterNewRow()
    {
        return $this->afterNewRow;
    }
    
    public function setAfterNewRow($afterNewRow)
    {
        $this->afterNewRow = $afterNewRow;
    }

    public function getBeforeNewField()
    {
        return $this->beforeNewField;
    }
    
    public function setBeforeNewField($beforeNewField)
    {
        $this->beforeNewField = $beforeNewField;
    }

    public function getAfterNewfield()
    {
        return $this->afterNewfield;
    }
    
    public function setAfterNewfield($afterNewfield)
    {
        $this->afterNewfield = $afterNewfield;
    }

    public function getBeforeEnd()
    {
        return $this->beforeEnd;
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
        
        $output = $this->beforeStart;
        $output .= $this->getHeaderRowOutput();
        
        for ($y = 0; $y <= $battlefieldMaxHeightIndex; $y ++) {
            $output .= $this->beforeNewRow;
            $output .= $this->getRowIndexOutput($y);
            for ($x = 0; $x <= $battlefieldMaxWidthIndex; $x++) {
                $output .= $this->beforeNewField;
                $pointToVisualize = new \Model\Battlefield\Point($x, $y);
                $pointStatus = $this->battlefield->getPointStatus($pointToVisualize);
                $output .= $this->pointStatusToOutputValue($pointStatus);
                $output .= $this->afterNewfield;
            }
            $output .= $this->afterNewRow;
        }
        
        return $output;
    }
    
    public function getRowIndexOutput($rowIndex)
    {
        $output = $this->beforeNewField;
        $output .= $rowIndex;
        $output .= $this->afterNewfield;
        return $output;
    }
    
    public function getHeaderRowOutput()
    {
        $output = $this->beforeNewRow;
        $battlefieldMaxWidthIndex = $this->battlefield->getFieldMaximumWidthIndex();
        
        $output .= $this->beforeNewField;
        $output .= '&nbsp;';
        $output .= $this->afterNewfield;
        
        for ($x = 0; $x <= $battlefieldMaxWidthIndex; $x++) {
            $output .= $this->beforeNewField;
            $output .= $x;
            $output .= $this->afterNewfield;
        }
        $output .= $this->afterNewRow;
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
            // @TODO check for sink
            if (false) {
                
            } else {
                return 'hit';
            }
        }
        return '@TODO';
    }
}
