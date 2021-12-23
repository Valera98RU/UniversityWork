<?php
namespace Test\Decorator;

use Decorator\Main;
use PHPUnit\Framework\TestCase;

class NegativeImageTest extends TestCase
{
    public function testCreateImage()
    {
        $image = new Image("./image.png");
        $negativeImage = new NegativeImage($image);
        $this->assertInstenceOf(Image::class,$negativeImage);
        $gdImage = $negativeImage->createImage();
        $this->assertInstenceOf(GdImage::class, $gdImage);
    }
}