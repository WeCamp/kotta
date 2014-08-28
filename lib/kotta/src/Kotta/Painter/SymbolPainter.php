<?php

namespace Kotta\Painter;

use Kotta\Symbol\Converter;

class SymbolPainter
{

    /**
     * @param resource PNG image $canvas
     * @param \Kotta\painter\Symbol $symbol
     * @param int $offset
     */
    function paint($canvas, Symbol $symbol, $offset)
    {
        $imageToDraw = $symbol->getImageResource();
        imagecopy($canvas, $imageToDraw, $offset, 20, 0, 0, imagesx($imageToDraw), imagesy($imageToDraw));
    }

}