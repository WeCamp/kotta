<?php

namespace Kotta\Formatter;

use Kotta\Symbol\Note;
use Kotta\Symbol\Pause;
use Tmont\Midi\Chunk;
use Tmont\Midi\Delta;
use Tmont\Midi\Event;
use Tmont\Midi\FileHeader;
use Tmont\Midi\Reporting\Formatter;
use Tmont\Midi\Util\Key;

class NoteFormatter extends Formatter
{
    protected $stream = array();
    protected $lastDeltaTicks;
    protected $playingNote;
    protected $timeDivision;
    protected $key;

    public function formatFileHeader(FileHeader $fileHeader)
    {
        $data = $fileHeader->getData();
        $this->timeDivision = $data[2];
    }

    public function formatEvent(Event $event)
    {
        $data = $event->getData();

        switch ($event->getType()) {
            case 144: // Note event
                list(, $noteNumber, $velocity) = $data;
                if($velocity) {
                    $this->playingNote = $noteNumber;
                } else {
                    $this->pushNote($this->playingNote, $this->lastDeltaTicks);
                    $this->playingNote = false;
                }
                break;
            case 255:
                switch($event->getSubtype()) {
                    case 89:
                        break;
                }
        }

    }

    public function formatDelta(Delta $delta)
    {
        $data = $delta->getData();
        $this->lastDeltaTicks = $data[0];
        if(!$this->playingNote) {
            $this->pushPause($this->lastDeltaTicks);
        }
    }

    public function getStream()
    {
        return $this->stream;
    }

    protected function pushNote($noteNumber, $ticks)
    {
        $value = $this->ticksToValue($ticks);

        $note = new Note($value, \Tmont\Midi\Util\Note::getNoteName($noteNumber));

        $this->pushCommand($note);
    }

    protected function ticksToValue($ticks)
    {
        $value = round($ticks / $this->timeDivision, 1);

        return $value;
    }

    protected function pushPause($ticks)
    {
        $value = $this->ticksToValue($ticks);

        if($value == 0)
            return;

        $pause = new Pause($value);

        $this->pushCommand($pause);

    }

    protected function pushCommand($command)
    {
        $this->stream[] = $command;
    }

}