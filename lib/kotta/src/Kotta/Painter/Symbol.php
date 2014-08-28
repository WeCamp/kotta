<?php

namespace Kotta\Painter;

use Kotta\Symbol\Converter;
use Kotta\Symbol\Symbol as SymbolInterface;

class Symbol
{

    protected $converter;

    public function __construct(Converter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @param resource PNG image $canvas
     * @param \Kotta\Painter\Symbol|\Kotta\Symbol\Symbol $symbol
     * @param int $offset
     */
    function paint($canvas, SymbolInterface $symbol, $offset)
    {
        $imageToDraw = $this->converter->toImage($symbol);
        imagecopy($canvas, $imageToDraw, 0, 0, 0, 0, imagesx($imageToDraw), imagesy($imageToDraw));
    }

}