<?php
namespace Test\Decorator;

use Decorator\Main;
use PHPUnit\Framework\TestCase;

class PNGImageTest extends TestCase
{
    public function testCreateImage()
    {
        $image = new PNGImage("./image.png");
        $this->assertInstenceOf(Image::class,$image);
        $gdImage = $image->createImage();
        $this->assertInstenceOf(PNGImage::class, $gdImage);
    }
}