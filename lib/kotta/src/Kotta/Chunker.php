<?php

namespace Kotta;

use Kotta\Symbol\Note;
use Kotta\Symbol\Pause;

class Chunker {

    public function chunk(array $symbols)
    {
        $bars = $this->createBars($symbols);
        $chunks = $this->createChunks($bars);
        return $chunks;
    }

    protected function createBars($symbols)
    {
        $i = 0;
        $countOfSymbols = count($symbols);
        $maxValueSum = 4;
        $currentValueSum = 0;

        $currentBar = array();
        $bars = array();

        while($i < $countOfSymbols)
        {
            $currentNote = $symbols[$i];
            $currentNoteValue = $currentNote->getValue();
            $continued = false;
            while($currentNoteValue > 0) {
                if($currentValueSum + $currentNoteValue <= $maxValueSum) {
                    $currentValueSum += $currentNoteValue;
                    $newNote = $this->buildFromSymbolWithValue($currentNote, $currentNoteValue, $continued);
                    $currentNoteValue = 0;
                    $continued = false;
                    $currentBar[] = $newNote;
                } else {
                    $newValue = $maxValueSum - $currentValueSum;
                    $newNote = $this->buildFromSymbolWithValue($currentNote, $newValue, $continued);
                    $currentNoteValue -= $newValue;
                    $continued = true;
                    $currentValueSum = 0;
                    $currentBar[] = $newNote;
                    $bars[] = new Bar($currentBar);
                    $currentBar = array();
                }
                if($currentValueSum == $maxValueSum) {
                    $currentValueSum = 0;
                    $bars[] = new Bar($currentBar);
                    $currentBar = array();
                }
            }
            $i++;
        }

        return $bars;
    }

    protected function createChunks($bars)
    {
        $chunks = array();
        $currentChunk = array();

        $maxSymbolsPerChunk = 30;
        $currentSymbolSum = 0;

        foreach($bars as $bar) {

            $symbolsCount = count($bar->getSymbols());
            if($currentSymbolSum + $symbolsCount <= $maxSymbolsPerChunk) {
                $currentSymbolSum += $symbolsCount;
                $currentChunk[] = $bar;
            } else {
                $chunks[] = new Chunk($currentChunk);
                $currentSymbolSum = 0;
                $currentChunk = array();
            }
        }

        if(count($currentChunk)) {
            $chunks[] = new Chunk($currentChunk);
        }

        return $chunks;
    }

    private function buildFromSymbolWithValue($symbol, $value, $isContinued)
    {
        if($symbol->getName() == 'pause') {
            return new Pause($value, $isContinued);
        } else {
            return new Note($value, $symbol->getName(), $isContinued);
        }
    }

} 