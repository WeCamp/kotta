<?php

namespace Kotta\Symbol;

interface Symbol
{
    const CLEF_C = 'CLEF_C';
    const CLEF_F = 'clef_f';
    const CLEF_G = 'clef_g';

    const DOT     = 'dot';
    const FLAT    = 'flat';
    const NATURAL = 'natural';
    const SHARP   = 'sharp';
    const TIE     = 'tie';

    const NOTE_1    = 'note_1';
    const NOTE_1_2  = 'note_1_2';
    const NOTE_1_4  = 'note_1_4';
    const NOTE_1_8  = 'note_1_8';
    const NOTE_1_16 = 'note_1_16';
    const NOTE_1_32 = 'note_1_32';

    const PAUSE_1    = 'rest_1';
    const PAUSE_1_4  = 'rest_1_4';
    const PAUSE_1_8  = 'rest_1_8';
    const PAUSE_1_16 = 'rest_1_16';
    const PAUSE_1_32 = 'rest_1_32';
    const PAUSE_1_64 = 'rest_1_64';

    public function getName();

    public function getValue();

    public function isContinued();

    public function __toString();
}