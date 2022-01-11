<?php
@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="renderer" content="webkit">
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?php echo $title ?></title>
  <link href="//cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
  <script src="//cdn.staticfile.org/modernizr/2.8.3/modernizr.min.js"></script>
  <script src="//cdn.staticfile.org/jquery/2.1.4/jquery.min.js"></script>
  <script src="//cdn.staticfile.org/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!--[if lt IE 9]>
    <script src="//cdn.staticfile.org/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<?php if($islogin==1){?>
  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">导航按钮</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./">云端托盘管理中心</a>
          <ul class="navbar-brand" style="font:14px Microsoft YaHei; margin:0px auto; text-align:center;">
            <a href="../"><i class="fa fa-bookmark" aria-hidden="true"></i> 返回前台</a>
          </li>
      </div><!-- /.navbar-header -->
      <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
        <ul class="nav navbar-nav navbar-right">
          <li class="<?php echo checkIfActive('index,')?>">
            <a href="./"><i class="fa fa-home"></i> 后台首页</a>
          </li>
		      <li class="<?php echo checkIfActive('file')?>">
            <a href="./file.php"><i class="fa fa-list"></i> 文件管理</a>
          </li>
		      <li class="<?php echo checkIfActive('set')?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i> 系统设置<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./set.php?mod=site">网站信息设置</a></li>
			        <li><a href="./set.php?mod=file">文件上传设置</a><li>
			        <li><a href="./set.php?mod=green">内容安全设置</a><li>
					<li><a href="./set.php?mod=api">上传API设置</a><li>
              <li><a href="./set.php?mod=iptype">用户IP地址设置</a><li>
              <li><a href="./set.php?mod=account">管理账号设置</a><li>
            </ul>
          </li>
          <li><a href="./login.php?logout"><i class="fa fa-power-off"></i> 退出登录</a></li>
          <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-globe" class="navbar-right" aria-hidden="true"></i> 语言切换
        </a>
        <div style="text-align:center;" class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="./en-index.php"><i class="fa fa-language" aria-hidden="true"></i> English</a>
        </div>
      </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
<?php }?>