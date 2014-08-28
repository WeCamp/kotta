<?php

namespace Service;

use Kotta\Parser\Parser;

class ConversionService
{
    public function getTracks($file)
    {
        //create a new file parser
        $parser = new Parser();
        $file = \Config::get('app.uploader.location') . '/' . $file;

        $parser->load($file);
        $midi = $parser->parseToMidiClass();

        return $midi->getTrackNames();
    }
}