<?php

namespace Songbai\Workflow;

/**
 * 定义工作流
 */
class Definition
{
    private $places = [];
    private $transitions = [];
    private $initialPlace = '';
    private $placeMeta = [];

    public function __construct($places, $transitions, $initialPlace, $placeMeta)
    {
        $this->places = $places;
        $this->placeMeta = $placeMeta;

        if (!in_array($initialPlace, $this->places)) {
            throw new \Exception('place 不存在');
        }
        $this->initialPlace = $initialPlace;

        foreach ($transitions as $transition) {
            if (!in_array($transition->getTo(), $this->places)) {
                throw new \Exception('未定义' . $transition->getTo());
            }
            foreach ($transition->getFroms() as $from) {
                if (!in_array($from, $this->places)) {
                    throw new \Exception('未定义' . $from);
                }
            }
            $this->transitions[$transition->getName()] = $transition;
        }
    }

    public function getTransitions()
    {
        return $this->transitions;
    }

    public function getTransition($transitionName)
    {
        if (!array_key_exists($transitionName, $this->transitions)) {
            throw new \Exception("transition 不存在:" . $transitionName);
        }
        return $this->transitions[$transitionName];
    }

    public function getPlaceMeta(string $placeName): Meta
    {
        if (array_key_exists($placeName, $this->placeMeta)) {
            return $this->placeMeta[$placeName];
        }
        return new Meta();
    }

    public function getPlaceMetas(): array
    {
        return $this->placeMeta;
    }

    public function getPlace(): array
    {
        return $this->places;
    }
}
