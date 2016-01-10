<?php

namespace Model\Battlefield\Point;

/**
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
interface PointInterface
{

    public function getX();

    public function getY();

    public function isSameAs(Point $point);
}
