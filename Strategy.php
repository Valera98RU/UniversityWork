<?php

namespace Strategy\Main;

use GdImage;

define('NEGATIVE_FILTER','Negative');
define('MEAN_REMOVAL','MeanRemoval');
define('GAUSSIAN','Gaussian');

/**
 * Фильтров
 */
interface IFilter{
    /**
     * Применить фильтр
     */
    public static function ApplyFilter(GdImage &$image):void;
}
/**
 * Фильтр негатива
 */
class Negative implements IFilter {

    public static function ApplyFilter(GdImage &$image):void
    {
        imagefilter($image,IMG_FILTER_NEGATE,[IMG_FILTER_PIXELATE=>512]);
    }
}
/**
 * Фильтр эффекта эскиза
 */
class MeanRemoval implements IFilter {

    public static function ApplyFilter(GdImage &$image):void
    {
        imagefilter($image,IMG_FILTER_MEAN_REMOVAL,[IMG_FILTER_PIXELATE=>512]);
    }
}
/**
 * Фильтр размытия по гаусу
 */
class Gaussian implements IFilter{
    public static function ApplyFilter(GdImage &$image):void
    {
        imagefilter($image,IMG_FILTER_GAUSSIAN_BLUR,[IMG_FILTER_PIXELATE=>512]);
    }
}

/**
 * Исполняемый код
 */
class main{

    /**
     * @param string $path Путь до изображения
     * @param string $filter Название фильтра
     */
    public function do(string $path, string $filter){
        //Создаём объект изображения
        $images = ImageCreateFromJPEG($path);
        //Применяем фильтр  изображению
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

