<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(defined('IN_CRONLITE'))return;
define('IN_CRONLITE', true);
define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('ROOT', dirname(SYSTEM_ROOT).'/');
date_default_timezone_set('Asia/Shanghai');
$date = date("Y-m-d H:i:s");

if(!$nosession)session_start();

if(is_file(SYSTEM_ROOT.'360safe/360webscan.php')){//360网站卫士
//    require_once(SYSTEM_ROOT.'360safe/360webscan.php');
}

include_once(SYSTEM_ROOT.'txprotect.php');
include_once(SYSTEM_ROOT."autoloader.php");
Autoloader::register();

require ROOT.'config.php';

if(!$dbconfig['user']||!$dbconfig['pwd']||!$dbconfig['dbname'])//检测安装1
{
header('Content-type:text/html;charset=utf-8');
echo '你还没安装！<a href="./install/">点此安装中文版</a>';
echo '  |  You need to install it! <a href="./install/en-US.php">Click here to install the English version</a>';
exit();
}

$DB = new \lib\PdoHelper($dbconfig);

if($DB->query("select * from pre_config where 1")==FALSE)//检测安装2
{
header('Content-type:text/html;charset=utf-8');
echo '你还没安装！<a href="./install/">点此安装</a>';
echo '  |  You need to install it! <a href="./install/en-US.php">Click here to install the English version</a>';
exit();
}

$CACHE=new \lib\Cache();
$conf=$CACHE->pre_fetch();
$password_hash='!@#%!s!0'.serialize($dbconfig);

include_once(SYSTEM_ROOT."functions.php");

$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = (is_https() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath.'/';

$clientip=real_ip($conf['ip_type']?$conf['ip_type']:0);
if(isset($_COOKIE["admin_session"]))
{
	$session=md5($conf['admin_user'].$conf['admin_pwd'].$password_hash);
	if($session===$_COOKIE["admin_session"]) {
		$islogin=1;
	}
}
$denyip = explode('|',$conf['blackip']);
if(in_array($clientip,$denyip) && !$islogin){
	Header("HTTP/1.1 403 Forbidden");
	exit;
}

include_once(SYSTEM_ROOT."vendor/autoload.php");

//加载存储模块
switch($conf['storage']){
	case 'local':$stor=new \lib\Storage\Local($conf['filepath']);break;
	case 'oss':$stor=new \lib\Storage\Oss($conf['oss_ak'], $conf['oss_sk'], $conf['oss_endpoint'], $conf['oss_bucket']);break;
	case 'sae':$stor=new \lib\Storage\Sae($conf['storagename']);break;
	case 'qcloud':$stor=new \lib\Storage\Qcloud($conf['qcloud_id'], $conf['qcloud_key'], $conf['qcloud_region'], $conf['qcloud_bucket']);break;
	case 'obs':$stor=new \lib\Storage\Obs($conf['obs_ak'], $conf['obs_sk'], $conf['obs_endpoint'], $conf['obs_bucket']);break;
	case 'upyun':$stor=new \lib\Storage\Upyun($conf['upyun_user'], $conf['upyun_pwd'], $conf['upyun_name']);break;
	default:$stor=new \lib\Storage\Local($conf['filepath']);break;
}

if (!file_exists(ROOT.'install/install.lock') && file_exists(ROOT.'install/index.php')) {
	sysmsg('<h2>检测到无 install.lock 文件</h2><ul><li><font size="4">如果您尚未安装本程序，<a href="./install/">点此安装中文版</a> | 无法跳转请手动进入*/install</font></li><li><font size="4">如果您已经安装本程序，请手动放置一个空的 install.lock 文件到 /install 文件夹下，<b>为了您站点安全，在您完成它之前我们不会工作。</b></font></li></ul><br/><h4>为什么必须建立 install.lock 文件？</h4>它是安装保护文件，如果检测不到它，就会认为站点还没安装，此时任何人都可以安装/重装你的网站。<br/><br/><h2>No install.lock file detected</h2><ul><li><font size="4">If you have not already installed this program,<a href="./install/en-US.php">Click here to install the English version</a> | Unable to jump please enter */install manually</font></li><li><font size="4">If you have already installed this program, please manually place a blank install.lock file under /install folder.<b>For the security of your site, we will not work until you have completed it.</b></font></li></ul><br/><h4>Why do I have to create an install.lock file?</h4>It is the installation protection file. If it is not detected, the site will be considered uninstalled and anyone can reinstall your site.<br/><br/>');exit;
}
?>