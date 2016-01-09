<?php

namespace Test\PhpUnit\Battlefield\Tests\Battlefield;

use Model\Battlefield\Battlefield;
use Model\Battleship\Battleship;
use Model\Battlefield\Point;

class BattlefieldValidPlacesTest extends \PHPUnit_Framework_TestCase
{
    public function testPlacer()
    {
        $field = new Battlefield(6, 6);
        $battleship = new Battleship();
        $validPlaces = $field->getValidPlaces($battleship);
        
        $expectedResults = [];
        
        for ($i = 0; $i < 6; $i++) {
            $expectedResults[] = [
                'start' => new Point(0, $i),
                'end' => new Point(4, $i),
            ];
            
            $expectedResults[] = [
                'start' => new Point(1, $i),
                'end' => new Point(5, $i),
            ];
            
            $expectedResults[] = [
                'start' => new Point($i, 0),
                'end' => new Point($i, 4),
            ];
            
            $expectedResults[] = [
                'start' => new Point($i, 1),
                'end' => new Point($i, 5),
            ];
        }
        
        $this->assertEquals(24, count($validPlaces));
        
        foreach ($expectedResults as $expectedValidPlaces) {
            $valid = false;
            foreach ($validPlaces as $validPlace) {
                if ($expectedValidPlaces['start']->isSameAs($validPlace->getStartPoint())
                        && $expectedValidPlaces['end']->isSameAs($validPlace->getEndPoint())) {
                    $valid = true;
                    break;
                }
            }
            
            if (!$valid) {
                $errorMsg = "Expected result not found: [{$validPlace->getStartPoint()->getX()},{$validPlace->getStartPoint()->getY()}";
                $errorMsg .= ";{$validPlace->getEndPoint()->getX()},{$validPlace->getEndPoint()->getY()}]";
                $this->assertTrue($valid, $errorMsg);
            }
        }
        
    }
}
