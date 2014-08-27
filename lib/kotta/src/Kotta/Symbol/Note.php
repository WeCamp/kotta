<?php

namespace Kotta\Symbol;

class Note implements Symbol
{
    protected $value;
    protected $name;
    protected $isContinued;

    public function __construct($value, $name, $isContinued = false)
    {
        $this->value = $value;
        $this->name = $name;
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

} 