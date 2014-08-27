<?php

namespace Kotta\Parser;

use Kotta\ValueObjects\MidiFile;
use Kotta\ValueObjects\Track;
use Kotta\ValueObjects\Bags\TrackBag;
use Tmont\Midi\Delta;
use Tmont\Midi\Event\EndOfTrackEvent;
use Tmont\Midi\Parsing\FileParser as MidiParser;
use Tmont\Midi\TrackHeader;
use Tmont\Midi\Event\TrackNameEvent;

class Parser extends MidiParser {
    protected $currentTrack = 0;

    protected $tracks = null;

    public function parseToMidiClass()
    {
        $midiFile = new MidiFile();
        $trackBag = new TrackBag();
        $track = null;
        do {
            $result = $this->parse();

            if ($result instanceof TrackHeader) {
                $track = new Track();
                $track->setSize($result->getData()[0]);
            }

            if ($result instanceof TrackNameEvent) {
                $track->setName($result->getData()[2]);
            }

            if ($result instanceof Delta) {
                $track->addTickCount($result->getData()[0]);
            }

            if ($result instanceof EndOfTrackEvent) {
                if ($track->getTicks()) {
                    $trackBag->add($track);
                } else {
                    // todo: If the track has a name, it should be a comment. Add the comments to the MidiFile
                }
            }
        } while ($result);
        $midiFile->setTracks($trackBag);

        return $midiFile;
    }
}