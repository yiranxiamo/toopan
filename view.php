<?php
$nosession=true;
$nosecu=true;
include("./includes/common.php");

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
    if($row['block']>=1){
        header("Content-type: ".minetype('gif'));
        readfile(ROOT.'assets/img/block.gif');
    }else{
        if(is_view($type))
        {
            $DB->exec("UPDATE `pre_file` SET `lasttime`=NOW(),`count`=`count`+1 WHERE `id`='{$row['id']}'");
            $seconds_to_cache = 3600*24*30;
            $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
            header("Expires: $ts");
            header("Pragma: cache");
            header("Cache-Control: max-age=$seconds_to_cache");
            header("Content-Length: {$row['size']}");
            header("Content-type: ".minetype($type));
            $stor->downfile($row['hash'], $row['size']);
        }
    }
}