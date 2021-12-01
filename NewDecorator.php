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

class Image
{
    private $iamge;

    public function __construct(string $path)
    {
        $this->iamge = $this->createImage($path);
    }

    public function getImage():GdImage
    {
        return $this->iamge;
    }

    abstract private function createImage(string $path):GdImage;

}
class JPEGImage extends Image{
    private function createImage(string $path):GdImage
    {
        return imagecreatefromjpeg($path);
    }
}
class PNGImage extends Image{
    private function createImage(string $path):GdImage
    {
        return imagecreatefrompng($path);
    }
}

class BaseFilter
{
    private Image $image;
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function applyFilter():GdImage
    {
        return   imagefilter(
                $this->image->getImage(),
                $this->getFilterType(),
                $this->getFilterParams()
            );
    }
    private function getFilterType():int;
    private function getFilterParams():array;    
}

class NegativeImage extends BaseFilter
{
    private function getFilterType():int
    {
        return IMG_FILTER_NEGATE;
    }
    private function getFilterParams():array
    {
        return [IMG_FILTER_PIXELATE => 512];
    }
}
class MeanRemovalImage extends BaseFilter
{
    private function getFilterType():int
    {
        return IMG_FILTER_MEAN_REMOVAL;
    }
    private function getFilterParams():array
    {
        return [IMG_FILTER_PIXELATE => 512];
    }
}
class GaussianImage extends BaseFilter
{
    private function getFilterType():int
    {
        return IMG_FILTER_GAUSSIAN_BLUR;
    }
    private function getFilterParams():array
    {
        return [IMG_FILTER_PIXELATE => 512];
    }
}


/**
 * Выполяемый код
 */
class main
{
    
    public function do(string $path, string $filter, string $imageType = "JPEG"):GdImage
    {
        if(!file_exists($path)){
            throw new \Exception("File not found");
        }

        switch($imageType)
        {
            case "JPEG":
                $image = new JPEGImage($path);
                break;
            case "PNG":
                $image = new PNGImage($path);
                break;
            default:
                throw new \Exception("Image type not found");
                break;
        }

        switch($filter)
        {
            case NEGATIVE_FILTER:
                $filter = new NegativeImage($image);
                break;
            case MEAN_REMOVAL:
                $filter = new MeanRemovalImage($image);
                break;
            case GAUSSIAN:
                $filter = new GaussianImage($image);
                break;
            default:
                throw new \Exception("Filter not found");
                break;
        }

        return $filter->applyFilter();
        
    }
}
