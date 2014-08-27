<?php

namespace Kotta\ValueObjects;

class MidiFile
{
    protected $tracks;

    protected $channel;

    public function addTrack(Track $track)
    {
        $this->tracks[] = $track;
    }
} 