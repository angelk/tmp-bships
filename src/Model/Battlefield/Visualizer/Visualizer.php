<?php

namespace Model\Battlefield\Visualizer;

use Model\Battlefield\Battlefield;

/**
 * Description of Visualizer
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Visualizer
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

        
    private function pointStatusToOutputValue($pointStatus)
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
    
    public function getOutput()
    {
        $output = $this->beforeStart;
        $battlefieldMaxWidthIndex = $this->battlefield->getFieldMaximumWidthIndex();
        $battlefieldMaxHeightIndex = $this->battlefield->getFieldMaximumHeightIndex();
        for ($y = 0; $y <= $battlefieldMaxHeightIndex; $y ++) {
            $output .= $this->beforeNewRow;
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
}
