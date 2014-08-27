<?php

namespace Kotta\Parser;

use Kotta\ValueObjects\MidiFile;
use Kotta\ValueObjects\Track;
use Tmont\Midi\Parsing\FileParser as MidiParser;
use Tmont\Midi\TrackHeader;
use Tmont\Midi\Event\TrackNameEvent;

class Parser extends MidiParser {
    protected $currentTrack = 0;

    protected $tracks = null;

    public function getTracks()
    {
        if (!$this->tracks)
        {
            $this->parseTracks();
        }

        return $this->tracks;
    }

    public function parseTracks()
    {
        $midiFile = new MidiFile();
        $findName = true;

        do {
            $result = $this->parse();
            if ($result instanceof TrackHeader) {
                if (!$findName)
                {
                    $midiFile->addTrack(new Track('Unknown'));
                }
                $foundName = false;
            }
            elseif ($result instanceof TrackNameEvent) {
                $foundName = true;
                $midiFile->addTrack(new Track($result->getData()[2]));
            }
        } while ($result);

        $this->tracks = $midiFile;
    }
}