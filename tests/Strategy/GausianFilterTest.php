<?php
namespace Test\Strategy;

use Strategy\Main;
use PHPUnit\Framework\TestCase;

class GaussianFilterTest extends TestCase
{
    public function testApplyFilter()
    {
        $image = new Image($path);
        $gaussianFilter = new GaussianFilter( $image );
        $this->assertInstenceOf(Filter::class,$gaussianFilter);
        $image->setFilter($gaussianFilter);
        $imageAfterFilter = $image->getImagerAftterfilter();
        $this->assertInstenceOf(GdImage::class,$imageAfterFilter);
    }
}