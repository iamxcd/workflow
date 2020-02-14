<?php

namespace Songbai\Workflow;

class Meta
{
    private $name;
    private $label;
    private $other;

    public function __construct($name = null, $label = null, $other = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->other = $other;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getOther()
    {
        return $this->other;
    }
}
