<?php

namespace Songbai\Workflow;


/**
 * 创建工作流定义
 */
class DefinitionBuilder
{

    private $places = [];
    private $transitions = [];
    private $initialPlace = '';
    private $placeMeta = [];

    public function addPlace(string $place): DefinitionBuilder
    {
        if (!$this->places) {
            $this->initialPlace = $place;
        }

        $this->places[$place] = $place;

        return $this;
    }
    public function addPlaceMeta(Meta $placeMeta): DefinitionBuilder
    {
        $this->placeMeta[$placeMeta->getName()] = $placeMeta;

        return $this;
    }

    public function addPlaces(array $places): DefinitionBuilder
    {
        foreach ($places as $place) {
            $this->addPlace($place);
        }

        return $this;
    }

    public function addTransition(Transform $transition): DefinitionBuilder
    {
        $this->transitions[] = $transition;

        return $this;
    }

    private function setInitialPlace($place = null)
    {
        if (!$place) {
            return;
        }
        $this->initialPlace = $place;
    }

    public function build(): Definition
    {
        return new Definition($this->places, $this->transitions, $this->initialPlace, $this->placeMeta);
    }
}
