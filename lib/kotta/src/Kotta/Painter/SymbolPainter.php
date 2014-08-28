<?php

namespace Kotta\Painter;

use Kotta\Symbol\Converter;
use Tmont\Midi\Util\Note;

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
        imagecopy($canvas, $imageToDraw, $offset, $symbol->getCenterPoint()['y'], 0, 0, imagesx($imageToDraw), imagesy($imageToDraw));
    }

}