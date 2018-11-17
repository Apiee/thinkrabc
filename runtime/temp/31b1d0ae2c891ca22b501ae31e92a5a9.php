<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:73:"H:\wj\study\thinkphp5\rbac\public/../application/index\view\role\set.html";i:1542284802;s:61:"H:\wj\study\thinkphp5\rbac\application\index\view\layout.html";i:1542299776;}*/ ?>
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
        <div class="row">
    <div class="col-xs-9 col-sm-9 col-md-9  col-lg-9">
        <h5>新增角色</h5>
    </div>
</div>
<hr/>
<div class="row">
    <div class="form-horizontal role_set_wrap" role="form">
        <div class="form-group">
            <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">角色</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <input type="text" class="form-control" name="name" placeholder="请输入角色" value="<?php echo !empty($info)?$info['name']:''; ?>">
            </div>
        </div>
        <div class="col-xs-6 col-xs-offset-2 col-sm-6 col-sm-offset-2 col-md-6  col-md-offset-2 col-lg-6 col-sm-lg-2 ">
            <input type="hidden" name="id" value="<?php echo !empty($info)?$info['id']:''; ?>"/>
            <button type="button" class="btn btn-primary pull-right  save">确定</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/js/role/set.js"></script>
        <footer>
            <p class="pull-left">@baicai</p>
            <p class="pull-right">Power By baicai</p>
        </footer>
    </div>
</div>


</body>
</html>