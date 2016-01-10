<?php

namespace Test\PhpUnit\Battlefield\Tests\Battlefield;

use Model\Battlefield\Battlefield;
use Model\Battlefield\Point\Point;

/**
 * Description of BattleField
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class BattleFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testIsPointValid()
    {
        $battleField = new Battlefield(10, 10);
        $validTests = [
            [0,0],
            [2,3],
            [9,9],
        ];
        
        $invalidTests = [
            [0,11],
            [10,10],
            [9,10],
            [10,9],
        ];
        
        foreach ($validTests as $pointCoord) {
            $point = new Point($pointCoord[0], $pointCoord[1]);
            $this->assertTrue($battleField->isPointValid($point), "Test failed for {$pointCoord[0]}, {$pointCoord[1]}");
        }
        
        foreach ($invalidTests as $pointCoord) {
            $point = new Point($pointCoord[0], $pointCoord[1]);
            $this->assertFalse($battleField->isPointValid($point), "Test failed for {$pointCoord[0]}, {$pointCoord[1]}");
        }
        
    }
    
    public function testShootOnInvalidPoint()
    {
        $this->setExpectedException(\Model\Battlefield\Exception\HumanReadableException::class);
        $battlefield = new Battlefield(3, 3);
        $shot = new Point(4, 5);
        $battlefield->shoot($shot);
    }
    
    public function testShotOnValidPoint()
    {
        $battlefield = new Battlefield(3, 3);
        $shot = new Point(2, 2);
        $battlefield->shoot($shot);
    }
}
