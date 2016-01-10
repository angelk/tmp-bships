<?php

namespace Test\PhpUnit\Battlefield\Tests\Battlefield\Point;

use Model\Battlefield\Point\Point;
use Model\Battlefield\Point\PointCollection;

/**
 * Description of PointTest
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class PointCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $points = [
            new Point(1,2),
            new Point(2,2),
        ];
        
        $pointCollection = new PointCollection($points);
        
        $actualPoints = [];
        foreach ($pointCollection as $point) {
            $actualPoints[] = $point;
        }
        
        $this->assertSame($points, $actualPoints);
    }
    
    public function testGetPointbyCoordinates()
    {
        $point = new Point(6,7);
        $pointCollection = new PointCollection([$point]);
        
        $actialPoint = $pointCollection->getPointByCoordinates(6, 7);
        $this->assertSame($point, $actialPoint);
        
        $this->assertNull($pointCollection->getPointByCoordinates(2, 2));
    }
    
    public function testHasPoint()
    {
        $point = new Point(6, 7);
        $pointCollection = new PointCollection([$point]);
        
        $this->assertTrue($pointCollection->hasPoint($point));
        $this->asserttrue(
            $pointCollection->hasPoint(
                new Point(6, 7)
            )
        );
        
        $this->assertfalse(
            $pointCollection->hasPoint(
                new Point(2, 2)
            )
        );
    }
    
    public function testKey()
    {
        $point = new Point(6, 7);
        $secontPoint = new Point(2,2);
        $pointCollection = new PointCollection(
            [
                $point,
                $secontPoint,
            ]
        );
        
        $this->assertEquals(0, $pointCollection->key());
        $pointCollection->next();
        $this->assertEquals(1, $pointCollection->key());
    }
}
