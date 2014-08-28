<?php

namespace Kotta\Painter;


class Chunk
{
    protected $image;
    protected $chunk;
    protected $symbolPainter;

    public function __construct(Chunk $chunk, Symbol $symbolPainter)
    {
        $this->chunk = $chunk;
        $this->symbolPainter = $symbolPainter;

        $png = imagecreatetruecolor(1400, 166);
        imagealphablending($png, true);
        imagesavealpha($png, true);

        $this->image = $png;
    }

    public function paint()
    {
        foreach ($chunk->getBars() as $bar) {
            $this->drawBar($this->image, $bar);
        }
    }

    public function drawBar($image, Bar $bar)
    {
        foreach ($bar->getSymbols() as $symbol) {
            $this->symbolPainter->paint($image, $bar, $offset);
        }
    }

}
