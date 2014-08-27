<?php

namespace Kotta\Formatter;

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

    public function formatFileHeader(FileHeader $fileHeader)
    {
        $data = $fileHeader->getData();
        $this->timeDivision = $data[2];
        echo "Set time division {$this->timeDivision} \n";
    }

    public function formatEvent(Event $event)
    {

        $data = $event->getData();

        switch ($event->getType()) {
            case 144: // Note event
                list(, $noteNumber, $velocity) = $data;
                if ($velocity) {
                    $this->playingNote = $noteNumber;
                } else {
                    $this->pushNote($this->playingNote, $this->lastDeltaTicks);
                    $this->playingNote = false;
                }
                break;
        }

    }

    protected function pushNote($note, $ticks)
    {
        $value = $this->ticksToValue($ticks);
        echo "Play note $note for $value\n";
    }

    protected function ticksToValue($ticks)
    {
        $value = round($ticks / $this->timeDivision);

        return $value;
    }

    public function formatDelta(Delta $delta)
    {
        $data = $delta->getData();
        $this->lastDeltaTicks = $data[0];
        //echo $this->lastDelta.PHP_EOL;
        if (!$this->playingNote) {
            echo "Wait " . $this->lastDeltaTicks . "\n";
        }
    }

    protected function pushPause($ticks)
    {
        $value = $this->ticksToValue($ticks);
        echo "Pause for $value\n";
    }

}