<?php
namespace Test\Decorator;

use Decorator\Main;
use PHPUnit\Framework\TestCase;

class GausianImageTest extends TestCase
{
    public function testCreateImage()
    {
        $image = new Image("./image.png");
        $gaussianImage = new GaussianImage($image);
        $this->assertInstenceOf(Image::class,$gaussianImage);
        $gdImage = $gaussianImage->createImage();
        $this->assertInstenceOf(GdImage::class, $gdImage);
    }
}