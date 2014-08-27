<?php

namespace Kotta\ValueObjects;

use Kotta\ValueObjects\Bags\TrackBag;

class MidiFile
{
    protected $tracks;

    protected $channel;

    protected $trackBag;

    public function __construct()
    {
        $this->trackBag = new TrackBag();
    }

    public function setTracks(TrackBag $tracks)
    {
        $this->trackBag = $tracks;
    }

    public function getTrackNames()
    {
        $trackNames = array();
        foreach ($this->trackBag as $track)
        {
            $trackNames[] = $track->getName();
        }

        return $trackNames;
    }

    public function getTracks()
    {
        return $this->trackBag;
    }
} 