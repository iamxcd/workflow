<?php

namespace Songbai\Workflow;

class Marking
{
    private $property;
    private $places;
    public function __construct(string $property = 'marking', array $places)
    {
        $this->property = $property;
        $this->places = $places;
    }

    public function getMarking(object $object)
    {
        $action = 'get' . ucfirst($this->property);

        if (!method_exists($object, $action)) {
            throw new \Exception("设置marking 方法不存在");
        }
        $marking = $object->{$action}();

        /**
         * 不存在 则取第一个
         */
        if (!in_array($marking, $this->places)) {
            return $this->places[0];
        }
        return $marking;
    }

    public function setMarking(object $object, $place)
    {
        if (!in_array($place, $this->places)) {
            throw new \Exception("place 不存在 " . $place);
        }
        $action = 'set' . ucfirst($this->property);
        if (!method_exists($object, $action)) {
            throw new \Exception("设置marking的方法不存在");
        }
        
        return $object->{$action}($place);
    }
}
