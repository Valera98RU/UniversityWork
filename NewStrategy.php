<?php

namespace Strategy\Main;

use GdImage;

define('NEGATIVE_FILTER','Negative');
define('MEAN_REMOVAL','MeanRemoval');
define('GAUSSIAN','Gaussian');

class Filter{    
    protected $filterType = 0;
    protected $filterParams = [];

    public function applyFilter(GdImage $image):GdImage
    {
        return   imagefilter(
            $image,
            $this->filterType,
            $this->filterParams
        );
    } 
}

class Image
{
    private $image;
    private $filter;

    public function __construct(string $path)
    {
        $this->image = imagecreatefromjpeg($path);
    }

    public function setFilter(Filter $filter):void
    {
        $this->filter = $filter;
    }

    public function getImagerAftterfilter():GdImage
    {
        return $this->filter->applyFilter($this->image);
    }
}

class NegativeFilter extends Filter
{
    protected $filterType = IMG_FILTER_NEGATE;
    protected $filterParams = [IMG_FILTER_PIXELATE => 512];    
}
class MeanRemovalFilter extends Filter
{
    protected $filterType = IMG_FILTER_MEAN_REMOVAL;
    protected $filterParams = [IMG_FILTER_PIXELATE => 512];    
}
class GaussianFilter extends Filter
{
    protected $filterType = IMG_FILTER_GAUSSIAN_BLUR;
    protected $filterParams = [IMG_FILTER_PIXELATE => 512];    
}

/**
 * Выполяемый код
 */
class main
{
    
    public function do(string $path, string $filter):GdImage
    {
        if(!file_exists($path)){
            throw new \Exception("File not found");
        }

        $image = new Image($path);

        switch($filter)
        {
            case NEGATIVE_FILTER:
                $image->setFilter(new NegativeImage());
                break;
            case MEAN_REMOVAL:
                $image->setFilter(new MeanRemovalImage());
                break;
            case GAUSSIAN:
                $image->setFilter(new GaussianImage());
                break;
            default:
                throw new \Exception("Filter not found");
                break;
        }

        return $image->getImagerAftterfilter();
        
    }
}
