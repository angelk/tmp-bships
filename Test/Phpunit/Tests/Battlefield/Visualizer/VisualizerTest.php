<?php

namespace Test\PhpUnit\Battlefield\Visualizer;

use Model\Battlefield\Visualizer\Visualizer;
use Model\Battlefield\Battlefield;
use Model\Battlefield\Placer;
use Model\Battlefield\Point\Point;

/**
 * Description of VisualizerTest
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class VisualizerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBattlefield()
    {
        $battlefield = new Battlefield(10, 10);
        $visualizer = new Visualizer($battlefield);
        $this->assertSame($battlefield, $visualizer->getBattlefield());
    }
    
    public function testGetLastShotStatusWithoutShoots()
    {
        $battlefield = new Battlefield(10, 10);
        $visualizer = new Visualizer($battlefield);
        $this->assertNull($visualizer->getLastShotStatus());
    }
    
    public function testGetLastShotStatusSink()
    {
        $battlefield = new Battlefield(10, 10);
        $visualizer = new Visualizer($battlefield);
        
        $placer = new Placer(
            new \Model\Battleship\Destroyer(),
            new Point(0, 0),
            new Point(3, 0)
        );
        
        $battlefield->addBattleship($placer);
        
        $battlefield->shoot(new Point(1, 1));
        $this->assertSame('miss', $visualizer->getLastShotStatus());
        
        $battlefield->shoot(new Point(0, 0));
        $this->assertSame('hit', $visualizer->getLastShotStatus());
        
        $battlefield->shoot(new Point(1, 0));
        $battlefield->shoot(new Point(2, 0));
        $battlefield->shoot(new Point(3, 0));
        
        $this->assertSame('sunk', $visualizer->getLastShotStatus());
        
    }
}
