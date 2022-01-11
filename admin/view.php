<?php
$nosession=true;
$nosecu=true;
include("../includes/common.php");
if($islogin==1){}else exit();

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
    $type=substr($url,strpos($url,".")+1);
}else{
    exit;
}

$row = $DB->getRow("SELECT * FROM `pre_file` WHERE `hash`=:hash limit 1", [':hash'=>$hash]);
if ($row && $stor->exists($row['hash'])) {
    $type_image = explode('|',$conf['type_image']);
    $type_audio = explode('|',$conf['type_audio']);
    $type_video = explode('|',$conf['type_video']);
    if(in_array($type,$type_image) || in_array($type,$type_audio) || in_array($type,$type_video))
    {
        $DB->exec("UPDATE `pre_file` SET `lasttime`=NOW(),`count`=`count`+1 WHERE `id`='{$row['id']}'");
        
        header("Pragma: no-cache");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Content-Length: {$row['size']}");
        header("Content-type: ".minetype($type));
        $stor->downfile($row['hash']);
    }
}
