<?php

namespace Model\Battlefield\Point;

use Model\Battlefield\Exception\HumanReadableException;

/**
 * Create point with names like "A1", "b2"
 *
 * @author po_taka
 */
class NamedPoint extends Point
{
    /**
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $matches = [];
        if (!preg_match('/^(?<name>[a-z]{1})(?<number>[0-9]+)$/im', $name, $matches)) {
            throw new HumanReadableException("Format for point is 'A1'");
        }
        
        $name = $matches['name'];
        $nameLower = strtolower($name);
        $number = (int) $matches['number'];
        $numberCoordinate = $number - 1;
        
        $aCode = ord('a');
        $nameCode = ord($nameLower);
        
        $nameCoordinate = $nameCode - $aCode;
        
        $this->x = $numberCoordinate;
        $this->y = $nameCoordinate;
    }
}
