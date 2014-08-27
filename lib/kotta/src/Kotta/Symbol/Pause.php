<?php

namespace Kotta\Symbol;

class Pause implements Symbol {

    protected $value;
    protected $isContinued;

    public function __construct($value, $isContinued = false)
    {
        $this->value = $value;
        $this->isContinued = $isContinued;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getName()
    {
        return 'pause';
    }

    public function isContinued()
    {
        return $this->isContinued;
    }

} 