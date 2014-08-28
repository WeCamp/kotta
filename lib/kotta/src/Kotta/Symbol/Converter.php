<?php

namespace Kotta\Symbol;

class Converter
{

    const CLEF_WIDTH   = 45;
    const NOTE_WIDTH   = 35;
    const NOTE_PADDING = 5;
    const TIE_WIDTH    = 29;

    protected $resourcePath;

    protected $imageMap = array(
        'clef_c'     => 'clef_c.png',
        'clef_f'     => 'clef_f.png',
        'clef_g'     => 'clef_g_copy.png',
        'dot'        => 'dot.png',
        'flat'       => 'flat.png',
        'natural'    => 'natural.png',
        'sharp'      => 'sharp.png',
        'tie'        => 'tie.png',
        'note_1'     => 'note_full.png',
        'note_1_2'   => 'note_half.png',
        'note_1_4'   => 'note_quarter.png',
        'note_1_8'   => 'note_eighth.png',
        'note_1_16'  => 'note_sixteenth.png',
        'note_1_32'  => 'note_thirtysecond.png',
        'pause_1'    => 'rest_full.png',
        'pause_1_2'  => 'rest_half.png',
        'pause_1_4'  => 'rest_quarter.png',
        'pause_1_8'  => 'rest_eighth.png',
        'pause_1_16' => 'rest_sixteenth.png',
        'pause_1_32' => 'rest_thirtysecond.png',
        'pause_1_64' => 'rest_sixtyfourth.png',
    );

    public function __construct($resourcePath)
    {
        $this->resourcePath = $resourcePath;
    }

    public function toImage($symbol)
    {
        $symbol = (string) $symbol;
        if (!array_key_exists($symbol, $this->imageMap)) {
            throw new \InvalidArgumentException('The symbol ' . $symbol . ' does not exist in the image list.');
        }

        $filename      = $this->imageMap[$symbol];
        $imageResource = imagecreatefrompng($this->resourcePath . DIRECTORY_SEPARATOR . $filename);
        imagealphablending($imageResource, true);
        imagesavealpha($imageResource, true);

        return $imageResource;
    }

}