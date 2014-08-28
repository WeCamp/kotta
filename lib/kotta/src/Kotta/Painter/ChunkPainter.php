<?php

namespace Kotta\Painter;

use Kotta\Bar;
use Kotta\Chunk;
use Kotta\Symbol\Converter;
use Kotta\Symbol\Symbol;

class ChunkPainter
{
    protected $canvas;
    protected $chunk;
    protected $symbolPainter;

    protected $clefOffset = array('x' => 60, 'y' => 56);
    protected $tempoOffset = 125;
    protected $notesOffset = 200;

    public function __construct(Chunk $chunk, SymbolPainter $symbolPainter, Converter $converter)
    {
        $this->chunk         = $chunk;
        $this->converter     = $converter;
        $this->symbolPainter = $symbolPainter;
        $this->canvas        = $this->createCanvas();

//        $this->symbolPainter->paint($this->canvas, $chunk->getClef(), $this->clefOffset);
        $this->paintclef(Symbol::CLEF_F);
    }

    public function paint()
    {
        $offset = $this->notesOffset;

        foreach ($this->chunk->getBars() as $bar) {
            $offset = $this->drawBar($this->canvas, $bar, $offset);
        }

        return $this->canvas;
    }

    public function drawBar($canvas, Bar $bar, $offset)
    {
        foreach ($bar->getSymbols() as $symbol) {
            $offset += 35;
            $this->symbolPainter->paint($canvas, $symbol, $offset);
        }
        return $offset;
    }

    protected function createCanvas()
    {
        $canvas = imagecreatetruecolor(1400, 168);
        imagealphablending($canvas, true);
        imagesavealpha($canvas, true);

        $trans_colour = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefill($canvas, 0, 0, $trans_colour);

        $black = imagecolorallocate($canvas, 0, 0, 0);

        for ($i = 56; $i <= 112; $i += 14) {
            imageline($canvas, 0, $i, 1400, $i, $black);
        }

        return $canvas;
    }

    protected function paintclef($clef)
    {
        $imageToDraw = $this->converter->toImage($clef);
        imagecopy($this->canvas, $imageToDraw, $this->clefOffset['x'], $this->clefOffset['y'], 0, 0, imagesx($imageToDraw), imagesy($imageToDraw));
    }

}
