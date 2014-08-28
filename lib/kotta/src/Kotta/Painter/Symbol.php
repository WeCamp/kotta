<?php

namespace Kotta\Painter;

class Symbol
{
    protected $name;
    protected $imageName;
    protected $imageResource;

    protected $centerPoint_x;
    protected $centerPoint_y;

    public function __construct($name, $imageName, $imageResource, array $centerPoint)
    {
        /* Validation */
        if (!is_string($name)) {
            throw new \RuntimeException('Name should be a string');
        }
        if (!is_string($imageName)) {
            throw new \RuntimeException('ImageName should be a string');
        }
        if (!is_resource($imageResource)) {
            throw new \RuntimeException('ImageResource should be an instance of Resource');
        }

        if (!array_key_exists('x',$centerPoint) || !array_key_exists('x',$centerPoint)) {
            throw new \RuntimeException('CenterPoint should contain x or y key');
        }

        $this->name          = $name;
        $this->imageName     = $imageName;
        $this->imageResource = $imageResource;

        $this->centerPoint_x = (int) $centerPoint['x'];
        $this->centerPoint_y = (int) $centerPoint['y'];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getImageName()
    {
        return $this->imageName;
    }

    public function getImageResource()
    {
        return $this->imageResource;
    }

    public function getCenterPoint()
    {
        return array(
            'x' => $this->centerPoint_x,
            'y' => $this->centerPoint_y
        );
    }
} 