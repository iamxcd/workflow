<?php

require  '../vendor/autoload.php';

$config = require  'config.php';

use Songbai\Workflow\DefinitionBuilder;
use Songbai\Workflow\GraphvizDumper;
use Songbai\Workflow\Guard;
use Songbai\Workflow\Marking;
use Songbai\Workflow\Meta;
use Songbai\Workflow\Transform;
use Songbai\Workflow\Workflow;

$def = new DefinitionBuilder();

$places = array_keys($config['places']);
$def->addPlaces($places);
foreach ($config['places'] as $k => $v) {
    $def->addPlaceMeta(new Meta($k, $v['label']));
}
foreach ($config['transitions'] as  $key => $val) {
    $def->addTransition(new Transform($key, $val['from'], $val['to'], new Meta($key, $val['meta']['label'])));
}

$guard = new Guard();

$guard->addGuard('to_pay', 'can', function (object $obj, $transform) {
    return true;
});

$wf = new Workflow($def->build(), new Marking($config['marking_property'], $places), $guard);

$order = new class
{
    public function getStatus()
    {
        return 'created';
    }

    public function setStatus($status)
    {
        echo '设置状态:' . $status;
    }
};

// $grap = new GraphvizDumper();
// file_put_contents('tmp.dot', $grap->dump($def->build()));

// if ($wf->can($order, 'to_pay')) {
//     $wf->apply($order, 'to_pay');
// } else {
//     echo "执行 to_pay 失败";
// }

// 下一步 有哪些
foreach ($wf->next($order) as $step) {
    echo  $step->getName() . ' ' . $step->getMeta()->getLabel() . PHP_EOL;
}
