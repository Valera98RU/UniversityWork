<?php
namespace Test\Decorator;

use Decorator\Main;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testGetImage()
    {
        $image = new Image("./image.png");
        $gdImage = $image->getImage();

        $this->assertInstenceOf(GdImage::class,$gdImage);
    }
    public function testGetPath()
    {
        $image = new Image("./image.png");
        $path = $image->getPath();
        $this->assertEquels("./image.png");
    }
}