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
          <span class="sr-only">Navigation buttons</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./en-index.php">Management center</a>
          <ul class="navbar-brand" style="font:14px Microsoft YaHei; margin:0px auto; text-align:center;">
            <a href="../en-US.php"><i class="fa fa-bookmark" aria-hidden="true"></i> Return</a>
          </li>
      </div><!-- /.navbar-header -->
      <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
        <ul class="nav navbar-nav navbar-right">
          <li class="<?php echo checkIfActive('index,')?>">
            <a href="./en-index.php"><i class="fa fa-home"></i> The background page</a>
          </li>
		      <li class="<?php echo checkIfActive('file')?>">
            <a href="./en-file.php"><i class="fa fa-list"></i> File management</a>
          </li>
		      <li class="<?php echo checkIfActive('set')?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i> System Settings<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./en-set.php?mod=site">Website information Settings</a></li>
			        <li><a href="./en-set.php?mod=file">File upload Settings</a><li>
			        <li><a href="./en-set.php?mod=green">Content security Settings</a><li>
					<li><a href="./en-set.php?mod=api">Upload API Settings</a><li>
              <li><a href="./en-set.php?mod=iptype">User IP address setting</a><li>
              <li><a href="./en-set.php?mod=account">Management account Settings</a><li>
            </ul>
          </li>
          <li><a href="./en-login.php?logout"><i class="fa fa-power-off"></i> Log out</a></li>
          <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-globe" class="navbar-right" aria-hidden="true"></i> Language
        </a>
        <div style="text-align:center;" class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="./"><i class="fa fa-language" aria-hidden="true"></i> Simplified Chinese</a>
        </div>
      </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
<?php }?>