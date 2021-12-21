<?php
namespace Decorator\Main;

/**
 * Библиотека работы с фото файлами
 */
use GdImage;

/**
 * Глобальные константы с названием фото фильтров
 */
define('NEGATIVE_FILTER', 'Negative');
define('MEAN_REMOVAL', 'MeanRemoval');
define('GAUSSIAN', 'Gaussian');

abstract class Image
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getImage():GdImage
    {
        return $this->iamge;
    }
    public function getPath():string
    {
        return $this->path;
    }

    abstract public function createImage():GdImage;

}

class JPEGImage extends Image{
    public function createImage():GdImage
    {
        return imagecreatefromjpeg($this->path);
    }
}

class PNGImage extends Image{
    public function createImage():GdImage
    {
        return imagecreatefrompng($this->path);
    }
}

class ImageDecorator extends Image
{
    protected Image $image;
    public function __construct(Image $image)
    {
        parent::__construct($image->getPath());
        $this->image = $image;
    }
    public function createImage():GdImage
    {
        return $this->image->createImage();
    }
}

class NegativeImage extends ImageDecorator
{
    public function __construct(Image $image)
    {
        parent::__construct($path,$image);
    }
    public function createImage():GdImage
    {
        return imagefilter($this->image->createImage(),IMG_FILTER_NEGATE);
    }

}

class GaussianImage extends ImageDecorator
{
    public function __construct(Image $image)
    {
        parent::__construct($path,$image);
    }
    public function createImage():GdImage
    {
        return imagefilter($this->image->createImage(),IMG_FILTER_GAUSSIAN_BLUR);
    }
}

/**
 * Выполяемый код
 */
class main
{
    
    public function do(string $path, string $filter, string $imageType = "JPEG"):GdImage
    {       
        $image = null;
        switch($imageType)
        {
            case 'JPEG':
                $image = new JPEGImage($path);
                break;
            case 'PNG':
                $image = new PNGImage($path);
                break;
        }
        switch($filter)
        {
            case 'Negative':
                $image = new NegativeImage( $image );
                break;
            case 'Gausian':
                $image  = new GaussianImage($image);
                break;

        }
        return $iamge->createImage();
    }
}
