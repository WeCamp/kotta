<?php

class IndexController extends Controller
{
    public function __construct(\Service\ConversionService $conversionService)
    {

    }

    public function getIndex()
    {
        return View::make('index.index');
    }

}
