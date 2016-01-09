<?php

namespace Test\PhpUnit\Battlefield\Tests\Battlefield;

use Model\Battlefield\Battlefield;
use Model\Battleship\Battleship;
use Model\Battlefield\Point;
use Model\Battlefield\Placer;

/**
 * Description of BattleshipFreePointTest
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class BattleshipFreePointTest extends \PHPUnit_Framework_TestCase
{
    public function testBattleShipFreePoint()
    {
        $field = new Battlefield(10, 10);
        $battleShip = new Battleship();
        $placer = new Placer(
            $battleShip,
            new Point(0, 0),
            new Point(0, 4)
        );
        $field->addBattleShip($placer);
        
        $validPoints = [
            new Point(5, 0),
            new Point(6, 0),
        ];
        
        $invalidPoints = [
            new Point(0, 0),
            new Point(0, 1),
            new Point(0, 2),
            new Point(0, 3),
            new Point(0, 4),
        ];
        
        foreach ($validPoints as $validPoint) {
            $this->assertTrue($field->isPointFree($validPoint));
        }
        
        foreach ($invalidPoints as $invalidPoint) {
            $this->assertFalse(
                $field->isPointFree($invalidPoint),
                "Point [{$invalidPoint->getX()}, {$invalidPoint->getY()}] should be invalid"
            );
        }
    }
}
