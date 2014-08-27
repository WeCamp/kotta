<?php

Namespace Kotta\Symbol;

class SymbolPainter {

    function paint( Resource $canvas, Symbol $symbol, $offset ) {
        $imageToDraw = SymbolConverter::SymbolToImage($symbol);

        // draw the image on the canvas

        if ($symbol->isContinued()) {
            $continueImage = SymbolConverter::ConnectorImage($symbol);

            // draw the image in the canvas
        }

        return $canvas;
    }

}