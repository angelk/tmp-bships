<?php

namespace Model\Battlefield\Point;

/**
 * Description of PointFactory
 *
 * @author po_taka
 */
class PointFactory
{
    public function createPoint($data)
    {
        if ($data === 'show') {
            return new CheatPoint();
        }
        
        return new NamedPoint($data);
    }
}
