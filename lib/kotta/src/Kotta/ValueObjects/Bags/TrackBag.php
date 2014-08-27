<?php

namespace Kotta\ValueObjects\Bags;

use Kotta\Bags\Track;

class TrackBag implements Iterator
{
    private $position = 0;
    private $array = array();  

    public function __construct(array $tracks = array()) {
        foreach ($tracks as $track)
        {
            if ($track instanceof Track)
            {
                $this->addTrack($track);
            }
            else
            {
                throw new \Exception("Tracks must be an instance of Kotta\Bags\Track, " . get_class($track) . " provided");
            }
        }
        $this->position = 0;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function current() {
        return $this->array[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function valid() {
        return isset($this->array[$this->position]);
    }

    public function addTrack(Track $track)
    {
        if (!in_array($track, $this->array)
        {
            $this->array[] = $track;
        }
    }
} 