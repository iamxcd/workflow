# 工作流模块
    
# 关键字
    位置 place
    转换 transform
    守卫 Guard
# 守卫事件
    目前就下面三个
    'transition.转换名.' + 'can' or 'apply.before' or 'apply.before'

    $guard->addGuard('to_pay', 'can', function (object $obj, $transform) {
        return true;
    });

# 流程图
    graphviz 下载 https://graphviz.gitlab.io/download/

    $grap = new GraphvizDumper();
    file_put_contents('tmp.dot', $grap->dump($def->build()));
    dot -Tpng -o tmp.png tmp.dot

![image](https://raw.githubusercontent.com/xiansongbai/workflow/master/example/tmp.png)

# 参考
    https://github.com/symfony/workflow