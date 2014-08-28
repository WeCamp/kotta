<?php

namespace Kotta;

use Kotta\Symbol\Symbol;

class Chunk {

    protected $bars = array();

    public function __construct($bars)
    {
        $this->bars = $bars;
    }

    public function getBars()
    {
        return $this->bars;
    }

    public function getClef()
    {
        return Symbol::CLEF_G;
    }

}