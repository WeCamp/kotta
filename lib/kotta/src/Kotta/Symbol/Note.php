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

    public function __toString()
    {
        // do some magic to return the Symbol::CONST based on this length and type
        return SYMBOL::NOTE_1_8;
    }

} 