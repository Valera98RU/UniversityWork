<?php
namespace Test\Strategy;

use Strategy\Main;
use PHPUnit\Framework\TestCase;

class NegativeFilterTest extends TestCase
{
    public function testApplyFilter()
    {
        $image = new Image($path);
        $negativeFilter = new NegativeFilter( $image );
        $this->assertInstenceOf(Filter::class,$negativeFilter);
        $image->setFilter($negativeFilter);
        $imageAfterFilter = $image->getImagerAftterfilter();
        $this->assertInstenceOf(GdImage::class,$imageAfterFilter);
    }
}