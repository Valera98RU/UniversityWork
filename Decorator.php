<?php

namespace Decorator\Main;


use GdImage;

define('NEGATIVE_FILTER', 'Negative');
define('MEAN_REMOVAL', 'MeanRemoval');
define('GAUSSIAN', 'Gaussian');

interface IFilter
{
    public function ApplyFilter(GdImage &$image): void;
}

class BaseFilterDecorator implements IFilter
{
    private IFilter $filter;

    public function __construct(IFilter $filter)
    {
        $this->filter = $filter;
    }

    public function ApplyFilter(GdImage &$image): void
    {
        $this->filter->ApplyFilter($image);
    }
}

class Negative implements IFilter
{
    public function ApplyFilter(GdImage &$image): void
    {
        imagefilter($image, IMG_FILTER_NEGATE, [IMG_FILTER_PIXELATE => 512]);
    }
}

class MeanRemoval implements IFilter
{
    public function ApplyFilter(GdImage &$image): void
    {
        imagefilter($image, IMG_FILTER_MEAN_REMOVAL, [IMG_FILTER_PIXELATE => 512]);
    }
}

class Gaussian implements IFilter
{
    public function ApplyFilter(GdImage &$image): void
    {
        imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR, [IMG_FILTER_PIXELATE => 512]);
    }
}

class Nothing implements IFilter
{
    public function ApplyFilter(GdImage &$image): void
    {

    }
}

class NegativeDecorator extends BaseFilterDecorator
{
    public function ApplyFilter(GdImage &$image): void
    {
        parent::ApplyFilter($image);
        $filter = new Negative();
        $filter->ApplyFilter($image);
    }
}

class MeanRemovalDecorator extends BaseFilterDecorator
{
    public function ApplyFilter(GdImage &$image): void
    {
        parent::ApplyFilter($image);
        $filter = new MeanRemoval();
        $filter->ApplyFilter($image);
    }
}

class GaussianDecorator extends BaseFilterDecorator
{
    public function ApplyFilter(GdImage &$image): void
    {
        parent::ApplyFilter($image);
        $filter = new Gaussian();
        $filter->ApplyFilter($image);
    }
}


class main
{
    public function do(string $path, array $filters)
    {
        $images = ImageCreateFromJPEG($path);
        $filter = new Nothing();
        if (in_array(NEGATIVE_FILTER, $filters)) {
            $filter = new NegativeDecorator($filter);
        }
        if (in_array(MEAN_REMOVAL, $filters)) {
            $filter = new MeanRemovalDecorator($filter);
        }
        if (in_array(GAUSSIAN, $filters)) {
            $filter = new GaussianDecorator($filter);
        }
        $filter->ApplyFilter($images);
    }
}
