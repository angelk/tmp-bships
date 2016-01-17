<?php

namespace Model\Battlefield\Point;

/**
 * Description of CheatPoint
 *
 * @author po_taka
 */
class CheatPoint implements PointInterface, CheatPointInterface
{

    public function getX()
    {
        throw new \Model\Exception\Exception("Method not allowed");
    }

    public function getY()
    {
        throw new \Model\Exception\Exception("Method not allowed");
    }

    public function isSameAs(PointInterface $point)
    {
        throw new \Model\Exception\Exception("Method not allowed");
    }
}
