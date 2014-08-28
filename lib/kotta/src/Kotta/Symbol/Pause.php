<?php

namespace Kotta\Symbol;

class Pause implements Symbol
{

    protected $value;
    protected $isContinued;

    protected $name = 'pause';
    protected $type = 'pause';

    public function __construct($value, $isContinued = false)
    {
        $this->value       = $value;
        $this->isContinued = $isContinued;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isContinued()
    {
        return $this->isContinued;
    }

    public function __toString()
    {
        // do some magic to return the Symbol::CONST based on this length and type
        return constant(SYMBOL::$this->type . '_' . '1_8');
    }

} 