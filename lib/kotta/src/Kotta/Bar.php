<?php

namespace Kotta;

class Bar {

    protected $symbols = array();

    public function __construct($symbols)
    {
        $this->symbols = $symbols;
    }

    public function getSymbols()
    {
        return $this->symbols;
    }

}