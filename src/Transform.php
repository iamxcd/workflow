<?php

namespace Songbai\Workflow;

class Transform
{
    private $name = '';
    private $froms = [];
    private $to = '';
    private $meta;

    public function __construct(string $name, $froms, string $to, Meta $meta)
    {
        $this->name = $name;
        $this->froms = (array) $froms;
        $this->to = $to;
        $this->meta = $meta;
    }

    public function getName(): string
    {
        return  $this->name;
    }

    public function getTo(): string
    {
        return  $this->to;
    }

    public function getFroms(): array
    {
        return  $this->froms;
    }
    public function getMeta(): Meta
    {
        return $this->meta;
    }
}
