<?php

namespace Kotta\Painter;

use Kotta\Bar;
use Kotta\Chunk;
use Kotta\Symbol\Converter;
use Kotta\Symbol\Note;

class ChunkPainter
{
    protected $canvas;
    protected $chunk;
    protected $symbolPainter;
    protected $linecolor;

    protected $clefOffset = 65;
    protected $tempoOffset = 100;
    protected $notesOffset = 130;

    public function __construct(Chunk $chunk, SymbolPainter $symbolPainter, Converter $converter)
    {
        $this->chunk         = $chunk;
        $this->converter     = $converter;
        $this->symbolPainter = $symbolPainter;
        $this->canvas        = $this->createCanvas();

        $painterSymbol = $this->converter->toSymbol($chunk->getClef());
        $this->symbolPainter->paint($this->canvas, $painterSymbol, $this->clefOffset);

        $this->linecolor = imagecolorallocate($this->canvas, 0, 0, 0);
    }

    public function paint()
    {
        $offset = $this->notesOffset;

        foreach ($this->chunk->getBars() as $bar) {
            $offset = $this->paintBar($this->canvas, $bar, $offset);
        }

        return $this->canvas;
    }

    public function paintBar($canvas, Bar $bar, $offset)
    {
        foreach ($bar->getSymbols() as $symbol) {
            $offset += 35;

            $painterSymbol = $this->converter->toSymbol($symbol);
            $this->symbolPainter->paint($canvas, $painterSymbol, $offset);
        }
        $offset = $this->paintBarEnd($offset);
        return $offset;
    }

    protected function createCanvas()
    {
        $canvas = imagecreatetruecolor(1400, 168);
        imagealphablending($canvas, true);
        imagesavealpha($canvas, true);

        $trans_colour = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefill($canvas, 0, 0, $trans_colour);

        for ($i = 56; $i <= 112; $i += 14) {
            imageline($canvas, 0, $i, 1400, $i, $this->linecolor);
        }

        return $canvas;
    }

    protected function paintclef($clef)
    {
        $symbol      = $this->converter->toSymbol($clef);
        $imageToDraw = $symbol->getImageResource();

        imagecopy(
            $this->canvas,
            $imageToDraw,
            $this->clefOffset['x'],
            $this->clefOffset['y'],
            0,
            0,
            imagesx($imageToDraw),
            imagesy($imageToDraw)
        );
    }

    protected function paintBarEnd($offset)
    {
        imageline($this->canvas, $offset, 56, $offset, 112, $this->linecolor);

        return $offset;

    }

}
