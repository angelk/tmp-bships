<?php

namespace Test\PhpUnit\Battlefield\Tests\Battlefield\Point;

use Model\Battlefield\Point\NamedPoint;

/**
 * Description of NamePointTest
 *
 * @author po_taka
 */
class NamePointTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidConstructor()
    {
        $pointsToTest = [
            '$3',
            '\\3',
            '13',
            '3a',
            'a',
            ')',
            'ee3',
        ];
        
        foreach ($pointsToTest as $pointName) {
            try {
                $point = new NamedPoint($pointName);
                throw new \Exception("{$pointName} should rise exception");
            } catch (\Model\Exception\Exception $e) {
                // it's ok, exception should be thrown
            }
        }
    }
    
    public function testValidPointsConstructor()
    {
        $pointsToTest = [
            [
                'name' => 'a1',
                'x' => 0,
                'y' => 0,
            ],
            [
                'name' => 'c4',
                'x' => 3,
                'y' => 2,
            ]
        ];
        
        foreach ($pointsToTest as $pointData) {
            $point = new NamedPoint($pointData['name']);
            $this->assertSame($pointData['x'], $point->getX());
            $this->assertSame($pointData['y'], $point->getY());
        }
    }
}
