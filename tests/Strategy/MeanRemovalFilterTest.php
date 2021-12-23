<?php
namespace Test\Strategy;

use Strategy\Main;
use PHPUnit\Framework\TestCase;

class MeanRemovalTest extends TestCase
{
    public function testApplyFilter()
    {
        $image = new Image($path);
        $meanRemoval = new MeanRemoval( $image );
        $this->assertInstenceOf(Filter::class,$meanRemoval);
        $image->setFilter($meanRemoval);
        $imageAfterFilter = $image->getImagerAftterfilter();
        $this->assertInstenceOf(GdImage::class,$imageAfterFilter);
    }
}