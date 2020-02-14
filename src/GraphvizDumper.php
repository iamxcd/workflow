<?php

namespace Songbai\Workflow;

class GraphvizDumper
{
    protected static $defaultOptions = [
        'graph' => ['ratio' => 'compress', 'rankdir' => 'LR'],
        'node' => ['fontsize' => 9, 'fontname' => 'SimSun', 'color' => '#333333', 'fillcolor' => 'lightblue', 'fixedsize' => 'false', 'width' => 1],
        'edge' => ['fontsize' => 9, 'fontname' => 'SimSun', 'color' => '#333333', 'arrowhead' => 'normal', 'arrowsize' => 0.5],
    ];

    public function dump(Definition $definition)
    {
        $places = $this->findPlaces($definition);
        $transitions = $this->findTransitions($definition);
        $edges = $this->findEdges($definition);

        return $this->startDot(self::$defaultOptions)
            . $this->addPlaces($places)
            . $this->addTransitions($transitions)
            . $this->addEdges($edges)
            . $this->endDot();
    }

    protected function findPlaces(Definition $definition): array
    {
        $places = [];

        foreach ($definition->getPlace() as $place) {
            $attributes = [];
            if (array_key_exists($place, $definition->getPlaceMetas())) {
                $attributes['style'] = 'filled';
            }

            $label = $definition->getPlaceMeta($place)->getLabel();
            if (null !== $label) {
                $attributes['name'] = $label;
            }
            $places[$place] = [
                'attributes' => $attributes,
            ];
        }

        return $places;
    }

    protected function findTransitions(Definition $definition): array
    {
        $transitions = [];

        foreach ($definition->getTransitions() as $transition) {
            $attributes = ['shape' => 'box', 'regular' => true];
            $name = $transition->getMeta()->getLabel() ?? $transition->getName();

            $transitions[] = [
                'attributes' => $attributes,
                'name' => $name,
            ];
        }

        return $transitions;
    }

    protected function addPlaces(array $places): string
    {
        $code = '';

        foreach ($places as $id => $place) {
            if (isset($place['attributes']['name'])) {
                $placeName = $place['attributes']['name'];
                unset($place['attributes']['name']);
            } else {
                $placeName = $id;
            }

            $code .= sprintf("  place_%s [label=\"%s\", shape=circle%s];\n", $this->dotize($id), $this->escape($placeName), $this->addAttributes($place['attributes']));
        }

        return $code;
    }

    protected function addTransitions(array $transitions): string
    {
        $code = '';

        foreach ($transitions as $i => $place) {
            $code .= sprintf("  transition_%s [label=\"%s\",%s];\n", $this->dotize($i), $this->escape($place['name']), $this->addAttributes($place['attributes']));
        }

        return $code;
    }

    protected function findEdges(Definition $definition): array
    {
        $dotEdges = [];
        $i = 0;
        foreach ($definition->getTransitions() as $transition) {
            $transitionName =  $transition->getName();
            foreach ($transition->getFroms() as $from) {
                $dotEdges[] = [
                    'from' => $from,
                    'to' => $transitionName,
                    'direction' => 'from',
                    'transition_number' => $i,
                ];
            }
            $dotEdges[] = [
                'from' => $transitionName,
                'to' => $transition->getTo(),
                'direction' => 'to',
                'transition_number' => $i,
            ];
            $i++;
        }

        var_dump($dotEdges);
        return $dotEdges;
    }

    protected function addEdges(array $edges): string
    {
        $code = '';

        foreach ($edges as $edge) {
            if ('from' === $edge['direction']) {
                $code .= sprintf(
                    "  place_%s -> transition_%s [style=\"solid\"];\n",
                    $this->dotize($edge['from']),
                    $this->dotize($edge['transition_number'])
                );
            } else {
                $code .= sprintf(
                    "  transition_%s -> place_%s [style=\"solid\"];\n",
                    $this->dotize($edge['transition_number']),
                    $this->dotize($edge['to'])
                );
            }
        }

        return $code;
    }

    protected function startDot(array $options): string
    {
        return sprintf(
            "digraph workflow {\n  %s\n  node [%s];\n  edge [%s];\n\n",
            $this->addOptions($options['graph']),
            $this->addOptions($options['node']),
            $this->addOptions($options['edge'])
        );
    }

    protected function endDot(): string
    {
        return "}\n";
    }

    protected function dotize(string $id): string
    {
        return hash('sha1', $id);
    }

    protected function escape($value): string
    {
        return \is_bool($value) ? ($value ? '1' : '0') : addslashes($value);
    }

    protected function addAttributes(array $attributes): string
    {
        $code = [];

        foreach ($attributes as $k => $v) {
            $code[] = sprintf('%s="%s"', $k, $this->escape($v));
        }

        return $code ? ' ' . implode(' ', $code) : '';
    }

    private function addOptions(array $options): string
    {
        $code = [];

        foreach ($options as $k => $v) {
            $code[] = sprintf('%s="%s"', $k, $v);
        }

        return implode(' ', $code);
    }
}
