<?php

namespace Kotta\Symbol;

interface Symbol
{
    public function getName();
    public function getValue();
    public function isContinued();
}