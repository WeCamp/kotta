<?php

namespace Service;

use \Illuminate\Support\Facades\Facade;

class ConversionFacade extends Facade {

    protected static function getFacadeAccessor() { return 'Service\ConversionService'; }

}
