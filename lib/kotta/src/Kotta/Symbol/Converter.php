<?php

namespace Kotta\Symbol;

use Kotta\Painter\Symbol;

class Converter
{
    const CLEF_WIDTH   = 45;
    const NOTE_WIDTH   = 35;
    const NOTE_PADDING = 5;
    const TIE_WIDTH    = 29;

    protected $resourcePath;

    protected $symbolMap = array(
        'clef_c'     => array(
            'image'       => 'clef_c.png',
            'centerPoint' => array(
                'x' => 0,
                'y' => 0
            )
        ),
        'clef_f'     => array(
            'image'       => 'clef_f.png',
            'centerPoint' => array(
                'x' => 0,
                'y' => 0
            )
        ),
        'clef_g'     => array(
            'image'       => 'clef_g.png',
            'centerPoint' => array(
                'x' => 25,
                'y' => 50
            )
        ),
        'dot'        => array(
            'image'       => 'dot.png',
            'centerPoint' => array(
                'x' => 0,
                'y' => 0
            )
        ),
        'flat'       => array(
            'image'       => 'flat.png',
            'centerPoint' => array(
                'x' => 0,
                'y' => 0
            )
        ),
        'natural'    => array(
            'image'       => 'natural.png',
            'centerPoint' => array(
                'x' => 1,
                'y' => 27
            )
        ),
        'sharp'      => array(
            'image'       => 'sharp.png',
            'centerPoint' => array(
                'x' => 18,
                'y' => 27
            )
        ),
        'tie'        => array(
            'image'       => 'tie.png',
            'centerPoint' => array(
                'x' => 15,
                'y' => 6
            )
        ),
        'note_1'     => array(
            'image'       => 'note_full.png',
            'centerPoint' => array(
                'x' => 12,
                'y' => 45
            )
        ),
        'note_1_2'   => array(
            'image'       => 'note_half.png',
            'centerPoint' => array(
                'x' => 11,
                'y' => 45
            )
        ),
        'note_1_4'   => array(
            'image'       => 'note_quarter.png',
            'centerPoint' => array(
                'x' => 11,
                'y' => 45
            )
        ),
        'note_1_8'   => array(
            'image'       => 'note_eighth.png',
            'centerPoint' => array(
                'x' => 11,
                'y' => 45
            )
        ),
        'note_1_16'  => array(
            'image'       => 'note_sixteenth.png',
            'centerPoint' => array(
                'x' => 11,
                'y' => 45
            )
        ),
        'note_1_32'  => array(
            'image'       => 'note_thirtysecond.png',
            'centerPoint' => array(
                'x' => 11,
                'y' => 45
            )
        ),
        'pause_1'    => array(
            'image'       => 'rest_full.png',
            'centerPoint' => array(
                'x' => 0,
                'y' => 0
            )
        ),
        'pause_1_2'  => array(
            'image'       => 'rest_half.png',
            'centerPoint' => array(
                'x' => 0,
                'y' => 0
            )
        ),
        'pause_1_4'  => array(
            'image'       => 'rest_quarter.png',
            'centerPoint' => array(
                'x' => 18,
                'y' => 26
            )
        ),
        'pause_1_8'  => array(
            'image'       => 'rest_eighth.png',
            'centerPoint' => array(
                'x' => 0,
                'y' => 0
            )
        ),
        'pause_1_16' => array(
            'image'       => 'rest_sixteenth.png',
            'centerPoint' => array(
                'x' => 0,
                'y' => 0
            )
        ),
        'pause_1_32' => array(
            'image'       => 'rest_thirtysecond.png',
            'centerPoint' => array(
                'x' => 0,
                'y' => 0
            )
        ),
        'pause_1_64' => array(
            'image'       => 'rest_sixtyfourth.png',
            'centerPoint' => array(
                'x' => 0,
                'y' => 0
            )
        ),
    );

    public function __construct($resourcePath)
    {
        $this->resourcePath = $resourcePath;
    }

    /**
     * @param $symbol
     *
     * @return resource
     * @throws \InvalidArgumentException
     *
     * @deprecated
     */
    public function toImage($symbolName)
    {
        $symbolName = (string)$symbolName;
        if (!array_key_exists($symbolName, $this->symbolMap)) {
            throw new \InvalidArgumentException('The symbol ' . $symbolName . ' does not exist in the image list.');
        }

        $filename      = $this->symbolMap[$symbolName]['image'];
        $imageResource = imagecreatefrompng($this->resourcePath . DIRECTORY_SEPARATOR . $filename);
        imagealphablending($imageResource, true);
        imagesavealpha($imageResource, true);

        return $imageResource;
    }


    /**
     * Get symbol
     *
     * @param string $symbolName Name of the symbol
     *
     * @throws \InvalidArgumentException
     *
     * @return Symbol
     */
    public function toSymbol($symbolName)
    {
        $symbolName = (string)$symbolName;
        if (!array_key_exists($symbolName, $this->symbolMap)) {
            throw new \InvalidArgumentException('The symbol ' . $symbolName . ' does not exist in the image list.');
        }

        $symbol      = $this->symbolMap[$symbolName];
        $imageResource = imagecreatefrompng($this->resourcePath . DIRECTORY_SEPARATOR . $symbol['image']);
        imagealphablending($imageResource, true);
        imagesavealpha($imageResource, true);

        return new Symbol($symbolName, $symbol['image'], $imageResource, $symbol['centerPoint']);
    }

}