<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"H:\wj\study\thinkphp5\rbac\public/../application/index\view\index\index.html";i:1539704925;s:61:"H:\wj\study\thinkphp5\rbac\application\index\view\layout.html";i:1542299776;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RBAC</title>
    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/bootstrap/css/app.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="/static/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<!--导航条-->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="/">RBAC</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">首页</a></li>
            </ul>
            <?php if(isset($currentuser)): ?>
            <p class="navbar-text navbar-right">Hi,<?php echo $currentuser['name']; ?></p>
            <?php endif; ?>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<!--菜单栏和内容区域-->
<div class="container-fluid">
    <div class="col-sm-2 col-md-2 col-lg-2 sidebar">
        <ul class="nav nav-sidebar">
            <li>权限演示页面</li>
            <li><a href="<?php echo url('test/page1'); ?>">测试一</a></li>
            <li><a href="<?php echo url('test/page2'); ?>">测试二</a></li>
            <li><a href="<?php echo url('test/page3'); ?>">测试三</a></li>
            <li><a href="<?php echo url('test/page4'); ?>">测试四</a></li>
            <li><a href="<?php echo url('test/page5'); ?>">测试五</a></li>
            <li>系统设置</li>
            <li><a href="<?php echo url('user/index'); ?>">用户管理</a></li>
            <li><a href="<?php echo url('role/index'); ?>">角色管理</a></li>
            <li><a href="<?php echo url('access/index'); ?>">权限管理</a></li>
        </ul>
    </div>
    <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 col-lg-10 col-lg-offset-2">
        <div>
    <h1>RBAC</h1>
    <p>基于角色的访问控制（Role-Based Access Control）作为传统访问控制（自主访问，强制访问）的有前景的代替受到广泛的关注。在RBAC中，权限与角色相关联，用户通过成为适当角色的成员而得到这些角色的权限。这就极大地简化了权限的管理。在一个组织中，角色是为了完成各种工作而创造，用户则依据它的责任和资格来被指派相应的角色，用户可以很容易地从一个角色被指派到另一个角色。角色可依新的需求和系统的合并而赋予新的权限，而权限也可根据需要而从某角色中回收。角色与角色的关系可以建立起来以囊括更广泛的客观情况</p>
    <p>项目源码地址：<a href="https://github.com/apiee/rbac" >https://github.com/apiee/rbac</a></p>
</div>
        <footer>
            <p class="pull-left">@baicai</p>
            <p class="pull-right">Power By baicai</p>
        </footer>
    </div>
</div>


</body>
</html>