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
}else{
    $hash=$url;
}

$row = $DB->getRow("SELECT * FROM `pre_file` WHERE `hash`=:hash limit 1", [':hash'=>$hash]);
if(!$row)exit('404 Not Found');
if($row['block']>=1)exit('File is blocked!');

if($row['pwd']!=null && $row['pwd']!=$pwd){ ?>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>请输入密码下载文件</title>
    <script type="text/javascript">
    var pwd=prompt("请输入密码","")
    if (pwd!=null && pwd!="")
    {
        window.location.href='<?php echo $siteurl.'down.php/'.$hash?>&'+pwd
    }
    </script>
    请刷新页面，或[ <a href="javascript:history.back();">返回上一页</a> ]
<?php
    exit;
}

if($stor->exists($hash))
{
    $seconds_to_cache = 3600*24*7;
    $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
    
    header("Content-Description: File Transfer");
    header("Content-Type:application/force-download");
    header("Content-Length: {$row['size']}");
    header("Content-Disposition:attachment; filename={$row['name']}");
    header("Expires: $ts");
    header("Pragma: cache");
    header("Cache-Control: max-age=$seconds_to_cache");
    
    $DB->exec("UPDATE `pre_file` SET `lasttime`=NOW(),`count`=`count`+1 WHERE `id`='{$row['id']}'");
    
    $stor->downfile($hash, $row['size']);
}
else{
    exit('File Not Found');
}
