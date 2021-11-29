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

/**
 * Интерфейс фото фильтров
 */
interface IFilter
{
    /**
     * Применяет фильтр к изображению
     */
    public function ApplyFilter(GdImage &$image): void;
}
/**
 * Базовый декоратов фильтров
 */
class BaseFilterDecorator implements IFilter
{
    protected IFilter $filter;

    public function __construct(IFilter $filter)
    {
        $this->filter = new BaseFilter();
    }

    public abstract function ApplyFilter(GdImage &$image);    
}

/**
 * Базой фильтр
 */
class BaseFilter implements IFilter
{
    private string $filterType = "";
    private array $param = null;


    public function setFilterType(string $type):void
    {
        $this->$filterType = $type;
    }
    public function setFilterParams(array $param):void
    {
        $this->$param = $param;
    }
    public function ApplyFilter(GdImage &$image):variant_mod
    {
        if($filterType === "")
        {
            throw new Excption("Тип фильтра не задан");
        }        
        imagefilter($image, $filterType, $param);
    }
}



/**
 * Фичего не делает
 */
class Nothing implements IFilter
{
    public function ApplyFilter(GdImage &$image): void
    {
        //ничего не делаем
    }
}
/**
 * Декоратов негативного фильтра
 */
class NegativeDecorator extends BaseFilterDecorator
{
    public function ApplyFilter(GdImage &$image): void
    {               
        //настраиваем  фильтр негатива     
        $this->filter->setFilterType(IMG_FILTER_NEGATE);
        $this->filter->setFilterParams([IMG_FILTER_PIXELATE => 512]);
        //применяем фильтр из библиотеки с статическими настройками
        $this->filter->ApplyFilter($image);
       
    }
}
/**
 * Декоратор фильтра для достижения эффекта эскиза
 */
class MeanRemovalDecorator extends BaseFilterDecorator
{
    public function ApplyFilter(GdImage &$image): void
    {     
        //Настраиваем фильтр эффекта эскиза
        $this->$filter->setFilterType(IMG_FILTER_MEAN_REMOVAL);
        $this->filter->setFilterParams([IMG_FILTER_PIXELATE => 512]);
        //применяем фильтр из библиотеки с статическими настройками
        $this->filter->ApplyFilter($image);
    }
}
/**
 * Декоратор фильтра размытия по гаусу
 */
class GaussianDecorator extends BaseFilterDecorator
{
    public function ApplyFilter(GdImage &$image): void
    {     
        //Настраиваем фильтр размытия по гаусу
        $this->filter->setFilterType(IMG_FILTER_GAUSSIAN_BLUR);
        $this->filter->setFilterParams([IMG_FILTER_PIXELATE => 512]);
        //применяем фильтр из библиотеки с статическими настройками
        $this->filter->ApplyFilter($image);
    }
}

/**
 * Выполяемый код
 */
class main
{
    public function do(string $path, array $filters)
    {
        //Инициализируем объект фотографии
        $images = ImageCreateFromJPEG($path);
        //Иннициализируем фильтр по умолчанию
        $filter = new Nothing();
        if (in_array(NEGATIVE_FILTER, $filters)) {
            //если передан фильтр негатива то переинициализируем фильтр
            $filter = new NegativeDecorator();
        }
        if (in_array(MEAN_REMOVAL, $filters)) {
            // если передан фильтр эффекта эскиза то переинициализируем фильтр
            $filter = new MeanRemovalDecorator();
        }
        if (in_array(GAUSSIAN, $filters)) {
             // если передан фильтр разытия по гаусу то переинициализируем фильтр
            $filter = new GaussianDecorator();
        }
        //применяем фильтр
        $filter->ApplyFilter($images);
    }
}
