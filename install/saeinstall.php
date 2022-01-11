<?php
//程序安装文件 FOR SAE
error_reporting(0);
require '../config.php';

@header('Content-Type: text/html; charset=UTF-8');
$step=isset($_GET['step'])?$_GET['step']:1;
$action=isset($_POST['action'])?$_POST['action']:null;
if(file_exists('install.lock')){
    exit('你已经成功安装，如需重新安装，请手动删除install目录下install.lock文件！');
}


function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}

if($action=='install'){
    $admin_user=isset($_POST['admin_user'])?$_POST['admin_user']:null;
    $admin_pwd=isset($_POST['admin_pwd'])?$_POST['admin_pwd']:null;
    if(empty($admin_user) || empty($admin_pwd)){
        $errorMsg='请填写管理员信息';
    }else{
        try{
            $db=new PDO("mysql:host=".$dbconfig['host'].";dbname=".$dbconfig['dbname'].";port=".$dbconfig['port'],$dbconfig['user'],$dbconfig['pwd']);
        }catch(Exception $e){
            $errorMsg='链接数据库失败:'.$e->getMessage();
        }
        if(empty($errorMsg)){
			date_default_timezone_set("PRC");
			$date = date("Y-m-d");
            $db->exec("set names utf8");
            $sqls=file_get_contents('install.sql');
            $sqls=explode(';', $sqls);
			$sqls[]="INSERT INTO `pre_config` VALUES ('syskey', '".random(32)."')";
            $sqls[]="INSERT INTO `pre_config` VALUES ('build', '".$date."')";
            $sqls[]="UPDATE `pre_config` SET `v`='{$admin_user}' WHERE `k`='admin_user'";
            $sqls[]="UPDATE `pre_config` SET `v`='{$admin_pwd}' WHERE `k`='admin_pwd'";
            $success=0;$error=0;$errorMsg=null;
            foreach ($sqls as $value) {
                $value=trim($value);
                if(!empty($value)){
                    if($db->exec($value)===false){
                        $error++;
                        $dberror=$db->errorInfo();
                        $errorMsg.=$dberror[2]."<br>";
                    }else{
                        $success++;
                    }
                }
            }
            $step=3;
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <title>云托盘-安装程序 FOR SAE</title>
    <link href="//cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container"><br>
    <div class="row">
        <div class="col-xs-12">
            <pre><h4>云托盘 - 安装程序 FOR SAE</h4></pre>
        </div>
        <div class="col-xs-12">
            <div class="panel panel-warning">
                <?php
                if(isset($errorMsg)){
                    echo '<div class="alert alert-danger text-center" role="alert">'.$errorMsg.'</div>';
                }
                if($step==2){
                ?>
                <div class="panel-heading text-center">请填写以下信息</div>
                <div class="panel-body">
                    <div class="list-group text-success">
                        <form class="form-horizontal" action="#" method="post">
                            <input type="hidden" name="action" class="form-control" value="install">
                            <h4>管理员信息配置</h4>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">管理员用户名</label>
                                <div class="col-sm-10">
                                    <input type="text" name="admin_user" class="form-control" value="admin">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">管理员密码</label>
                                <div class="col-sm-10">
                                    <input type="text" name="admin_pwd" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success btn-block">确认无误，下一步</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <?php }elseif($step==3){ ?>
                <div class="panel-heading text-center">数据导入完毕</div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">成功执行SQL语句<?php echo $success;?>条，失败<?php echo $error;?>条！</li>
                        <li class="list-group-item">系统已成功安装完毕！</li>
                        <li class="list-group-item">后台地址：<a href="../admin/" target="_blank">/admin/</a></li>
                        <li class="list-group-item">管理员账号：<?php echo $admin_user?>  密码：<?php echo $admin_pwd?></li>
						<li class="list-group-item"><font color="red">请自行删除install文件夹！</font></li>
                        <a href="/" class="btn list-group-item">进入网站首页</a>
                    </ul>
                </div>
                <?php }else{ ?>
                <div class="panel-heading text-center">安装环境检测</div>
                <div class="panel-body">
                    <?php
                    $install=true;
                    if(!file_exists('./install.lock')){
                        $check[2]='<span class="badge badge-success">未锁定</span>';
                    }else{
                        $check[2]='<span class="badge badge-danger">已锁定</span>';
                        $install=false;
                    }
                    if(class_exists("PDO")){
                        $check[0]='<span class="badge badge-success">支持</span>';
                    }else{
                        $check[0]='<span class="badge badge-danger">不支持</span>';
                        $install=false;
                    }
                    if(version_compare(PHP_VERSION,'5.4.0','<')){
                        $check[3]='<span class="badge badge-danger">不支持</span>';
						$install=false;
                    }else{
                        $check[3]='<span class="badge badge-success">支持</span>';
                    }
					if(!$dbconfig['user']||!$dbconfig['pwd']||!$dbconfig['dbname']){
                        $check[1]='<span class="badge badge-danger">未填写</span>';
						$install=false;
                    }else{
                        $check[1]='<span class="badge badge-success">已填写</span>';
                    }

                    ?>
                    <ul class="list-group">
                        <li class="list-group-item">已填写好数据库信息 <?php echo $check[1];?></li>
						<li class="list-group-item">检测安装是否锁定 <?php echo $check[2];?></li>
                        <li class="list-group-item">PDO_MYSQL组件 <?php echo $check[0];?></li>
                        <li class="list-group-item">PHP版本>=5.4 <?php echo $check[3];?></li>
                        <li class="list-group-item">成功安装后安装文件就会锁定，如需重新安装，请手动删除install目录下install.lock配置文件！</li>
                        <?php
                        if($install) echo'<a href="?step=2" class="btn list-group-item">检测通过，下一步</a>';
                        ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <pre><center>Powered by <a href="https://www.toopan.cn/">云托盘</a> !</center></pre>
    </footer>
</div>
</body>
</html>
