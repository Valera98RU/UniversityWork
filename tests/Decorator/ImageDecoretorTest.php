<?php
namespace Test\Decorator;

use Decorator\Main;
use PHPUnit\Framework\TestCase;

class ImageDecoratorTest extends TestCase
{
    public function testCreateImage()
    {
        $image = new Image("./image.png");
        $imageDecorator = new ImageDecorator($image);
        $this->assertInstenceOf(Image::class,$imageDecorator);
        $gdImage = $imageDecorator->createImage();
        $this->assertInstenceOf(GdImage::class, $gdImage);
    }
}