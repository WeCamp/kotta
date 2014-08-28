<?php

namespace Service;

use Kotta\Parser\Parser;

class ConversionService
{
    public function getTracks($file)
    {
        //create a new file parser
        $parser = new Parser();
        $parser->load($file);
        $midi = $parser->parseToMidiClass();

        return $this->cleanTracks($midi->getTrackNames());
    }

    public function cleanTracks($tracks)
    {
        foreach ($tracks as $key => $track)
        {
            if ($track == '')
            {
                $tracks[$key] = 'Track ' . ($key + 1);
            }
        }

        return $tracks;
    }

    public function getSearchResult($result)
    {
        $midiFile = \MidiFile::find($result);
        if ($midiFile)
        {
            \Session::put('fileName', $midiFile->name);
            $path = \Config::get('app.uploader.location') . '/searchFiles/search-midi-' . $result . '.mid';
            if (!\File::exists($path))
            {
                \File::put($path, file_get_contents(\Config::get('app.midiLibraryUrl') . $midiFile->url));
            }

            return $path;
        }

        return false;
    }

    public function getFilePath($file)
    {
        if (is_numeric($file))
        {
            $file = $this->getSearchResult($file);
            if (!$file)
            {
                return \Redirect::route('index')->withErrors('validation.uploader.searchResultError');
            }
        }
        else
        {
            $file = \Config::get('app.uploader.location') . '/' . $file;
        }

        return $file;
    }

    public function addConversion($file, $fileName, $track, $trackName)
    {
        $conversion = array(
            'user_id' => \Auth::user()->id,
            'file' => $file,
            'fileName' => $fileName,
            'track' => $track,
            'trackName' => $trackName,
        );

        if (\Conversion::create($conversion))
        {
            return true;
        }

        return false;
    }
}