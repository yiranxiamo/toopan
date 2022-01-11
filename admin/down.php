<?php
$nosession=true;
$nosecu=true;
include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$urlarr=explode('/',$_SERVER['PATH_INFO']);
if (($length = count($urlarr)) > 1) {
$url = $urlarr[$length-1];
}
$extension=explode('&',$url);
if (($length = count($extension)) > 1) {
$pwd = $extension[$length-1];
$url = $extension[0];
}

if(strpos($url,".")){
    $hash=substr($url,0,strpos($url,"."));
}else{
    $hash=$url;
}

$row = $DB->getRow("SELECT * FROM `pre_file` WHERE `hash`=:hash limit 1", [':hash'=>$hash]);
if(!$row)exit('404 Not Found');

if($stor->exists($hash))
{
    header("Content-Description: File Transfer");
    header("Content-Type:application/force-download");
    header("Content-Length: {$row['size']}");
    header("Content-Disposition:attachment; filename={$row['name']}");
    header("Pragma: no-cache");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    
    $DB->exec("UPDATE `pre_file` SET `lasttime`=NOW(),`count`=`count`+1 WHERE `id`='{$row['id']}'");
    
    $stor->downfile($hash);
}
else{
    exit('File Not Found');
}