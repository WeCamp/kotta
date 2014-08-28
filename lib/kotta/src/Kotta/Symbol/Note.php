<?php

namespace Kotta\Symbol;

class Note implements Symbol
{
    protected $value;
    protected $name;
    protected $isContinued;
    protected $type = 'NOTE';

    public function __construct($value, $name, $isContinued = false)
    {
        $this->value       = $value;
        $this->name        = $name;
        $this->isContinued = $isContinued;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isContinued()
    {
        return $this->isContinued;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * The default is a random note because we dont know what to do with it..
     * @return string
     */
    public function __toString()
    {
        switch($this->getValue()) {
            case 4: return Symbol::NOTE_1;
            case 2: return Symbol::NOTE_1_2;
            case 1: return Symbol::NOTE_1_4;
            case 0.5: return Symbol::NOTE_1_8;
            case 0.25: return Symbol::NOTE_1_16;
            default:
                return Symbol::NOTE_1_4;
        }
    }

} 