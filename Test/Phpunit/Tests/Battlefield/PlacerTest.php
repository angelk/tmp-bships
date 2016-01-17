<?php

namespace Test\PhpUnit\Battlefield\Tests\Battlefield;

use Model\Battlefield\Placer;
use Model\Battlefield\Point\Point;
use Model\Battleship\Destroyer;


/**
 * Description of PlacerTest
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class PlacerTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidPlacer()
    {
        $this->setExpectedException(\Model\Battlefield\Exception\Exception::class);
        
        new Placer(
            new Destroyer(),
            new Point(0, 0),
            new Point(2, 0)
        );
    }
    
    public function testPointMissMatch()
    {
        $this->setExpectedException(\Model\Battlefield\Exception\Exception::class);
        
        new Placer(
            new Destroyer(),
            new Point(3, 0),
            new Point(0, 0)
        );
    }
}
