<?php

namespace Songbai\Workflow;

use Closure;

class Guard
{
    private $guards = [];

    public  function addGuard(string $transformName, string $eventName, Closure $event): Guard
    {
        $this->guards['transform.' . $transformName . '.' . $eventName] = $event;
        return $this;
    }

    public function has($name): bool
    {
        return array_key_exists($name, $this->guards);
    }

    public function get($name): Closure
    {
        if (!$this->has($name)) {
            throw new \Exception('guard 不存在:' . $name);
        }

        return $this->guards[$name];
    }
}
