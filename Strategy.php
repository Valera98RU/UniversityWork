<?php

namespace Strategy\Main;

use GdImage;

define('NEGATIVE_FILTER','Negative');
define('MEAN_REMOVAL','MeanRemoval');
define('GAUSSIAN','Gaussian');

interface IFilter{

    public static function ApplyFilter(GdImage &$image):void;
}

class Negative implements IFilter {

    public static function ApplyFilter(GdImage &$image):void
    {
        imagefilter($image,IMG_FILTER_NEGATE,[IMG_FILTER_PIXELATE=>512]);
    }
}
class MeanRemoval implements IFilter {

    public static function ApplyFilter(GdImage &$image):void
    {
        imagefilter($image,IMG_FILTER_MEAN_REMOVAL,[IMG_FILTER_PIXELATE=>512]);
    }
}
class Gaussian implements IFilter{
    public static function ApplyFilter(GdImage &$image):void
    {
        imagefilter($image,IMG_FILTER_GAUSSIAN_BLUR,[IMG_FILTER_PIXELATE=>512]);
    }
}


class main{

    public function do(string $path, string $filter){
        $images = ImageCreateFromJPEG($path);
        switch ($filter){
            case NEGATIVE_FILTER:
                Negative::ApplyFilter($images);
                break;
            case MEAN_REMOVAL:
                Gaussian::ApplyFilter($images);
                break;
            case GAUSSIAN:
                MeanRemoval::ApplyFilter($images);
                break;
        }
    }
}

