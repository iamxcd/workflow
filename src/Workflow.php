<?php

namespace Songbai\Workflow;

class Workflow
{
    private $definition;
    private $marking;

    public function __construct(Definition $definition, Marking $marking)
    {
        $this->definition = $definition;
        $this->marking = $marking;
    }

    public function can(object $object, string $transformName): bool
    {
        $place = $this->marking->getMarking($object);

        foreach ($this->definition->getTransitions() as $transform) {
            if ($transform->getName() != $transformName) {
                continue;
            }

            /**
             * 当前place 不在froms中
             */
            if (!in_array($place, $transform->getFroms())) {
                return false;
            }

            # place
            return true;
        }
        return false;
    }

    /**
     * 应用
     */
    public function apply(object $object, string $transformName, array $context = [])
    {
        if (!$this->can($object, $transformName)) {
            throw new \Exception("不能设置:" . $transformName);
        }
        $transform = $this->definition->getTransition($transformName);
        $this->marking->setMarking($object, $transform->getTo());
    }

    /**
     * 下一步 有哪些
     */
    public function next(object $object)
    {
        $next = [];
        $place = $this->marking->getMarking($object);
        foreach ($this->definition->getTransitions() as $transform) {
            if (in_array($place, $transform->getFroms())) {
                $next[] = $transform;
            }
        }
        return $next;
    }
}
