<?php
namespace Test\Decorator;

use Decorator\Main;
use PHPUnit\Framework\TestCase;

class DecoratorImageTest extends TestCase
{
    public function testCreateImage()
    {
        $image = new Image("./image.png");
        $gaussianImage = new GaussianImage($image);
        $this->assertInstenceOf(Image::class,$gaussianImage);
        $gdImage = $gaussianImage->createImage();
        $this->assertInstenceOf(GdImage::class, $gdImage);

        $JPEGImage = new JPEGImage("./image.jpg");
        $NegativeJPEGImage = new NegativeImage($JPEGImage);
        $this->assertInstenceOf(Image::class,$NegativeJPEGImage);
        $gdImage = $NegativeJPEGImage->createImage();
        $this->assertInstenceOf(GdImage::class, $gdImage);

        $PNGImage = new PNGImage("./image.png");
        $GausianPNGImage = new GaussianImage($PNGImage);
        $this->assertInstenceOf(Image::class,$GausianPNGImage);
        $gdImage = $GausianPNGImage->createImage();
        $this->assertInstenceOf(GdImage::class, $gdImage);
    }
}