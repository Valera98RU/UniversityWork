<?php
namespace Test\Decorator;

use Decorator\Main;
use PHPUnit\Framework\TestCase;

class JPEGImageTest extends TestCase
{
    public function testCreateImage()
    {
        $image = new JPEGImage("./image.jpg");
        $this->assertInstenceOf(Image::class,$image);
        $gdImage = $image->createImage();
        $this->assertInstenceOf(GdImage::class, $gdImage);
    }
}