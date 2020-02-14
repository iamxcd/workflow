# 工作流模块

# 特性 ?
    1 先定义流程,以及步骤
    2 使用者 只关心 下一步该做什么
    
# 关键字
    位置 place
    转换 transform
    守卫 Guard

# 流程图
    graphviz 下载 https://graphviz.gitlab.io/download/

    $grap = new GraphvizDumper();
    file_put_contents('tmp.dot', $grap->dump($def->build()));
    dot -Tpng -o tmp.png tmp.dot

![image](https://raw.githubusercontent.com/xiansongbai/workflow/master/example/tmp.png)

# 参考
    https://github.com/symfony/workflow