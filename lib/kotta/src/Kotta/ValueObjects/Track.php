<?php

namespace Kotta\ValueObjects;

class Track
{
    protected $size;

    protected $name;

    protected $ticks = 0;

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    public function addTickCount($ticks)
    {
        $this->ticks += $ticks;
    }

    /**
     * @return int
     */
    public function getTicks()
    {
        return $this->ticks;
    }
}