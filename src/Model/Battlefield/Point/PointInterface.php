<?php

namespace Model\Battlefield\Point;

/**
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
interface PointInterface
{

    /**
     * Get x-axis
     * @return int
     */
    public function getX();

    /**
     * get y-axis
     * @return int
     */
    public function getY();

    /**
     * Check if two points are identical
     * @param PointInterface $point
     */
    public function isSameAs(PointInterface $point);
}
