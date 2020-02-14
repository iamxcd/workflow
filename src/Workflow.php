<?php

namespace Songbai\Workflow;

class Workflow
{
    private $definition;
    private $guard;
    private $marking;

    public function __construct(Definition $definition, Marking $marking, Guard $guard)
    {
        $this->definition = $definition;
        $this->marking = $marking;
        $this->guard = $guard;
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
            $guardName = 'transform.' . $transform->getName() . '.can';
            if ($this->guard->has($guardName)) {
                $callback = $this->guard->get($guardName);
                return (bool) $callback($object, $transform);
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

        $guardName = 'transform.' . $transform->getName() . '.apply.before';
        if ($this->guard->has($guardName)) {
            $callback = $this->guard->get($guardName);
            $callback($object, $transform);
        }

        $this->marking->setMarking($object, $transform->getTo());

        $guardName = 'transform.' . $transform->getName() . '.apply.after';
        if ($this->guard->has($guardName)) {
            $callback = $this->guard->get($guardName);
            $callback($object, $transform);
        }
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
