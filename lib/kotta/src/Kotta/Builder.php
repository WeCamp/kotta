<?php

namespace Kotta;

use Kotta\Formatter\NoteFormatter;
use Kotta\Painter\ChunkPainter;
use Kotta\Painter\SymbolPainter;
use Kotta\Symbol\Converter;
use Tmont\Midi\Parsing\FileParser;
use Tmont\Midi\Reporting\Printer;

class Builder
{
    public function generateImages($fileLocation, $trackNumber)
    {
        $parser = new FileParser();
        $parser->load($fileLocation);

        $formatter = new NoteFormatter($trackNumber);

        $printer = new Printer($formatter, $parser);
        $printer->printAll();

        $stream = $formatter->getStream();

        $chunker = new Chunker();
        $chunks  = $chunker->chunk($stream);

        $chunkImages = array();
        foreach ($chunks as $chunk) {
            $chunkImages[] = $this->paint($chunk);
        }

        return $chunkImages;
    }

    protected function paint(Chunk $chunk)
    {
        $symbolConverter = new Converter( base_path('lib/kotta/assets/symbols') );
        $symbolPainter = new SymbolPainter($symbolConverter);

        $chunkPainter = new ChunkPainter($chunk, $symbolPainter, $symbolConverter);
        $png          = $chunkPainter->paint();

        return $png;
    }
} 