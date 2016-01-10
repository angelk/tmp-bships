<?php

namespace Model\Battlefield\Point;

/**
 * Description of NamedPoint
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
            throw new \Model\Battlefield\Exception\HumanReadableException("Foramt for point should be like A1");
        }
        
        $name = $matches['name'];
        $nameLower = strtolower($name);
        $number = (int) $matches['number'];
        $numberCoordinate = $number - 1;
        
        $aCode = ord('a');
        $zCode = ord('z');
        $nameCode = ord($nameLower);
        
        if ($nameCode > $zCode || $nameCode < $aCode) {
            throw new \Model\Battlefield\Exception\HumanReadableException("First letter of point must be betwee 'a' and 'z'");
        }
        
        $nameCoordinate = $nameCode - $aCode;
        
        $this->x = $numberCoordinate;
        $this->y = $nameCoordinate;
    }
}
