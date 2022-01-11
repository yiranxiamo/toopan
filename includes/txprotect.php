<?php
/*
反腾讯网址安全检测系统
Description:屏蔽腾讯电脑管家网址安全检测
*/
if($nosecu==true)return;
if(strpos($_SERVER['HTTP_REFERER'], 'urls.tr.com')!==false||strpos($_SERVER['HTTP_REFERER'], 'sc.wsd.com')!==false){
	$_SESSION['txprotectblock']=true;
}
//HEADER特征屏蔽
if(!isset($_SERVER['HTTP_ACCEPT']) || preg_match("/manager/", strtolower($_SERVER['HTTP_USER_AGENT'])) || strpos($_SERVER['HTTP_USER_AGENT'], 'ozilla')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla')===false || preg_match("/Windows NT 6.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*' || preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*' || preg_match("/vnd.wap.wml/", $_SERVER['HTTP_ACCEPT']) && preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT']) || strpos($_SERVER['HTTP_REFERER'], 'urls.tr.com')!==false || strpos($_SERVER['HTTP_REFERER'], 'sc.wsd.com')!==false || strpos($_SERVER['HTTP_REFERER'], '/membercomprehensive/')!==false || strpos($_SERVER['HTTP_REFERER'], '111.202.27.196')!==false || isset($_COOKIE['ASPSESSIONIDQASBQDRC']) || empty($_SERVER['HTTP_USER_AGENT']) || preg_match("/Alibaba.Security.Heimdall/", $_SERVER['HTTP_USER_AGENT']) || strpos($_SERVER['HTTP_USER_AGENT'], 'wechatdevtools/')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'libcurl/')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'python')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'Go-http-client')!==false || $_SESSION['txprotectblock']==true) {
	exit('欢迎使用！- Welcome to use!');
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Coolpad Y82-520')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'Mac OS X 10_12_4')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'Baiduspider/')===false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'Android')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'Baiduspider/')===false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS 9_1')!==false && $_SERVER['HTTP_CONNECTION']=='close') {
	exit('您当前浏览器不支持或操作系统语言设置非中文，无法访问本站！- Your current browser does not support or operating system language Settings are not Chinese, can not visit this site!');
}