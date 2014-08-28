<?php

namespace Kotta;

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

}