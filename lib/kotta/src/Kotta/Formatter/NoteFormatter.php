<?php

namespace Kotta\Formatter;

use Kotta\Symbol\Note;
use Kotta\Symbol\Pause;
use Tmont\Midi\Delta;
use Tmont\Midi\Event;
use Tmont\Midi\FileHeader;
use Tmont\Midi\Reporting\Formatter;

class NoteFormatter extends Formatter
{
    protected $stream = array();
    protected $lastDeltaTicks;
    protected $playingNote;
    protected $timeDivision;
    protected $key;
    protected $track;

    public function __construct($track)
    {
        $this->track = $track;
    }

    public function formatFileHeader(FileHeader $fileHeader)
    {
        $data = $fileHeader->getData();
        $this->timeDivision = $data[2];
    }

    public function formatEvent(Event $event)
    {
        $data = $event->getData();

        if($data[0] != $this->track)
            return;

        switch ($event->getType()) {
            case Event\EventType::NOTE_ON:
                list(, $noteNumber, $velocity) = $data;
                if($velocity) {
                    $this->playingNote = $noteNumber;
                } else {
                    $this->pushNote($this->playingNote, $this->lastDeltaTicks);
                    $this->playingNote = false;
                }
                break;
            case Event\EventType::NOTE_OFF:
                $this->pushNote($this->playingNote, $this->lastDeltaTicks);
                break;
            case Event\EventType::META:
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

    protected function pushPause($ticks)
    {
        $value = $this->ticksToValue($ticks);

        if($value == 0)
            return;

        $pause = new Pause($value);

        $this->pushCommand($pause);
    }

    protected function ticksToValue($ticks)
    {
        $value = round($ticks / $this->timeDivision, 1);

        return $value;
    }

    protected function pushCommand($command)
    {
        $this->stream[] = $command;
    }

}