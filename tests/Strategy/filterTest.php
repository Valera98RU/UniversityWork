<?php
namespace Test\Strategy;

use Strategy\Main;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    public function testApplyFilter()
    {
        $image = new Image($path);
        $filter = new Filter( $image );
        $image->setFilter($filter);
        $imageAfterFilter = $image->getImagerAftterfilter();
        $this->assertInstenceOf(GdImage::class,$imageAfterFilter);
    }
}