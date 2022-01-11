<?php
function get_curl($url, $post=0, $referer=0, $cookie=0, $header=0, $ua=0, $nobaody=0)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$httpheader[] = "Accept: */*";
	$httpheader[] = "Accept-Encoding: gzip,deflate,sdch";
	$httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
	$httpheader[] = "Connection: close";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	if ($post) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	if ($header) {
		curl_setopt($ch, CURLOPT_HEADER, true);
	}
	if ($cookie) {
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	}
	if($referer){
		if($referer==1){
			curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
		}else{
			curl_setopt($ch, CURLOPT_REFERER, $referer);
		}
	}
	if ($ua) {
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	}
	else {
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0");
	}
	if ($nobaody) {
		curl_setopt($ch, CURLOPT_NOBODY, 1);
	}
	curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}
function real_ip($type=0){
$ip = $_SERVER['REMOTE_ADDR'];
if($type<=0 && isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
	foreach ($matches[0] AS $xip) {
		if (filter_var($xip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
			$ip = $xip;
			break;
		}
	}
} elseif ($type<=0 && isset($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif ($type<=1 && isset($_SERVER['HTTP_CF_CONNECTING_IP']) && filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
	$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
} elseif ($type<=1 && isset($_SERVER['HTTP_X_REAL_IP']) && filter_var($_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
	$ip = $_SERVER['HTTP_X_REAL_IP'];
}
return $ip;
}
function get_ip_city($ip)
{
    $url = 'http://whois.pconline.com.cn/ipJson.jsp?json=true&ip=';
    $city = get_curl($url . $ip);
	$city = mb_convert_encoding($city, "UTF-8", "GB2312");
    $city = json_decode($city, true);
    if ($city['city']) {
        $location = $city['pro'].$city['city'];
    } else {
        $location = $city['pro'];
    }
	if($location){
		return $location;
	}else{
		return false;
	}
}
function daddslashes($string, $force = 0, $strip = FALSE) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force, $strip);
			}
		} else {
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}

function strexists($string, $find) {
	return !(strpos($string, $find) === FALSE);
}

function dstrpos($string, $arr) {
	if(empty($string)) return false;
	foreach((array)$arr as $v) {
		if(strpos($string, $v) !== false) {
			return true;
		}
	}
	return false;
}

function checkmobile() {
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$ualist = array('android', 'midp', 'nokia', 'mobile', 'iphone', 'ipod', 'blackberry', 'windows phone');
	if((dstrpos($useragent, $ualist) || strexists($_SERVER['HTTP_ACCEPT'], "VND.WAP") || strexists($_SERVER['HTTP_VIA'],"wap")))
		return true;
	else
		return false;
}
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : ENCRYPT_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
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
function showmsg($content = '未知的异常（Unknown anomaly）',$type = 4,$back = false)
{
switch($type)
{
case 1:
	$panel="success";
break;
case 2:
	$panel="info";
break;
case 3:
	$panel="warning";
break;
case 4:
	$panel="danger";
break;
}

echo '<div class="panel panel-'.$panel.'">
      <div class="panel-heading">
        <h3 class="panel-title">提示信息（Prompt information）</h3>
        </div>
        <div class="panel-body">';
echo $content;

if ($back) {
	echo '<hr/><a href="'.$back.'"><< 返回上一页（Go back to the previous page）</a>';
}
else
    echo '<hr/><a href="javascript:history.back(-1)"><< 返回上一页（Go back to the previous page）</a>';

echo '</div>
    </div>';
	exit;
}
function sysmsg($msg = '未知的异常（Unknown anomaly）',$title = '站点提示信息（Site prompt message）') {
    ?>  
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title?></title>
        <style type="text/css">
html{background:#F8BBD0body{background:#F8BBD0;color:#333;font-family:"微软雅黑","Microsoft YaHei",sans-serif;margin:2em auto;padding:1em 2em;max-width:700px;-webkit-box-shadow:10px 10px 10px rgba(0,0,0,.13);box-shadow:10px 10px 10px rgba(0,0,0,.13);opacity:.8}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px "微软雅黑","Microsoft YaHei",,sans-serif;margin:30px 0 0 0;padding:0;padding-bottom:7px}#error-page{margin-top:50px}h3{text-align:center}#error-page p{font-size:9px;line-height:1.5;margin:25px 0 20px}#error-page code{font-family:Consolas,Monaco,monospace}ul li{margin-bottom:10px;font-size:9px}a{color:#21759B;text-decoration:none;margin-top:-10px}a:hover{color:#D54E21}.button{background:#f7f7f7;border:1px solid #ccc;color:#555;display:inline-block;text-decoration:none;font-size:9px;line-height:26px;height:28px;margin:0;padding:0 10px 1px;cursor:pointer;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top}.button.button-large{height:29px;line-height:28px;padding:0 12px}.button:focus,.button:hover{background:#fafafa;border-color:#999;color:#222}.button:focus{-webkit-box-shadow:1px 1px 1px rgba(0,0,0,.2);box-shadow:1px 1px 1px rgba(0,0,0,.2)}.button:active{background:#eee;border-color:#999;color:#333;-webkit-box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5);box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5)}table{table-layout:auto;border:1px solid #333;empty-cells:show;border-collapse:collapse}th{padding:4px;border:1px solid #333;overflow:hidden;color:#333;background:#eee}td{padding:4px;border:1px solid #333;overflow:hidden;color:#333}
        </style>
    </head>
    <body id="error-page">
        <?php echo '<h3>'.$title.'</h3>';
        echo $msg; ?>
    </body>
    </html>
    <?php
    exit;
}

if(!function_exists("is_https")){
	function is_https() {
		if(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443){
			return true;
		}elseif(isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $server['HTTPS'] == '1')){
			return true;
		}elseif(isset($_SERVER['HTTP_X_CLIENT_SCHEME']) && $_SERVER['HTTP_X_CLIENT_SCHEME'] == 'https'){
			return true;
		}elseif(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){
			return true;
		}elseif(isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https'){
			return true;
		}elseif(isset($_SERVER['HTTP_EWS_CUSTOME_SCHEME']) && $_SERVER['HTTP_EWS_CUSTOME_SCHEME'] == 'https'){
			return true;
		}
		return false;
	}
}

function checkIfActive($string) {
	$array=explode(',',$string);
	$php_self=substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['REQUEST_URI'],'/')+1,strrpos($_SERVER['REQUEST_URI'],'.')-strrpos($_SERVER['REQUEST_URI'],'/')-1);
	if (in_array($php_self,$array)){
		return 'active';
	}else
		return null;
}

function getSetting($k, $force = false){
	global $DB,$CACHE;
	if($force) return $DB->getColumn("SELECT v FROM pre_config WHERE k=:k LIMIT 1", [':k'=>$k]);
	$cache = $CACHE->get($k);
	return $cache[$k];
}
function saveSetting($k, $v){
	global $DB;
	return $DB->exec("REPLACE INTO pre_config SET v=:v,k=:k", [':v'=>$v, ':k'=>$k]);
}

function size_format($size)
{
    if ($size<1024) {
        $size.=' B';
    } else {
        $size/=1024;
        if ($size<1024) {
            $size=round($size, 2).' KB';
        } else {
            $size/=1024;
            if ($size<1024) {
                $size=round($size, 2).' MB';
            } else {
                $size/=1024;
                if ($size<1024) {
                    $size=round($size, 2).' GB';
                }
            }
        }
    }
    return $size;
}

function minetype($type){
	$mime = array (
    //applications
    'ai'  => 'application/postscript',
    'eps'  => 'application/postscript',
    'exe'  => 'application/octet-stream',
    'doc'  => 'application/vnd.ms-word',
    'xls'  => 'application/vnd.ms-excel',
    'ppt'  => 'application/vnd.ms-powerpoint',
    'pps'  => 'application/vnd.ms-powerpoint',
    'pdf'  => 'application/pdf',
    'xml'  => 'application/xml',
    'odt'  => 'application/vnd.oasis.opendocument.text',
    'swf'  => 'application/x-shockwave-flash',
    // archives
    'gz'  => 'application/x-gzip',
    'tgz'  => 'application/x-gzip',
    'bz'  => 'application/x-bzip2',
    'bz2'  => 'application/x-bzip2',
    'tbz'  => 'application/x-bzip2',
    'zip'  => 'application/zip',
    'rar'  => 'application/x-rar',
    'tar'  => 'application/x-tar',
    '7z'  => 'application/x-7z-compressed',
    // texts
    'txt'  => 'text/plain',
    'php'  => 'text/x-php',
    'html' => 'text/html',
    'htm'  => 'text/html',
    'js'  => 'text/javascript',
    'css'  => 'text/css',
    'rtf'  => 'text/rtf',
    'rtfd' => 'text/rtfd',
    'py'  => 'text/x-python',
    'java' => 'text/x-java-source',
    'rb'  => 'text/x-ruby',
    'sh'  => 'text/x-shellscript',
    'pl'  => 'text/x-perl',
    'sql'  => 'text/x-sql',
    // images
    'bmp'  => 'image/x-ms-bmp',
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'gif'  => 'image/gif',
    'png'  => 'image/png',
    'tif'  => 'image/tiff',
    'tiff' => 'image/tiff',
	'tga'  => 'image/x-targa',
	'ico'  => 'image/x-icon',
	'svg'  => 'image/x-svgz',
	'svgz'  => 'image/x-svgz',
	'webp'  => 'image/webp',
    'psd'  => 'image/vnd.adobe.photoshop',
    //audio
    'mp3'  => 'audio/mpeg',
    'mid'  => 'audio/midi',
    'ogg'  => 'audio/ogg',
    'mp4a' => 'audio/mp4',
	'm4a' => 'audio/m4a',
    'wav'  => 'audio/wav',
    'wma'  => 'audio/x-ms-wma',
    // video
    'avi'  => 'video/x-msvideo',
    'dv'  => 'video/x-dv',
    'mp4'  => 'video/mp4',
	'f4v'  => 'video/x-flv',
    'mpeg' => 'video/mpeg',
    'mpg'  => 'video/mpeg',
    'mov'  => 'video/quicktime',
    'wmv'  => 'video/x-ms-wmv',
    'flv'  => 'video/x-flv',
	'mkv'  => 'video/x-matroska',
	'ts'  => 'video/x-flv',
	'3gp'  => 'video/3gpp',
	'3gpp'  => 'video/3gpp',
	'webm'  => 'video/webm',
    );
	return $mime[$type];
}

function type_to_icon($type){
	global $conf;
	$type_image = explode('|',$conf['type_image']);
	$type_audio = explode('|',$conf['type_audio']);
	$type_video = explode('|',$conf['type_video']);
	$type_image = array_merge($type_image, ['png','jpg','jpeg','gif','bmp','webp','ico','svg','svgz','tif','tiff','heic','psd','exif','pcx','tga','fpx','cdr','pcd','eps','ai','wmf','raw','ufo']);
	$type_audio = array_merge($type_audio, ['mp3','wav','wma','ogg','m4a','flac','ape','aac','ra','cda','midi','mid','aif','au','voc','aac','ac3']);
	$type_video = array_merge($type_video, ['mp4','webm','flv','f4v','mov','3gp','3gpp','avi','mpg','mpeg','wmv','mkv','ts','dat','asf','rm','rmvb','ram','divx','vob','qt','fli','flc','mod','m2t','swf','mts','m2ts','mpe','div','lavf']);
	$type_text = ['txt','text','log','md','yaml','yml','conf','config','ini'];
	$type_code = ['c','cpp','cxx','rc','php','py','cs','h','htm','html','css','less','js','hdml','dtd','wml','xml','vbs','vb','rtx','xsd','dpr','sql','java','go','jsp','asp','aspx','asa','asax','pl','bat','cmd','rb','reg','sh','json','lua','r','mm','mak','swift'];
	$type_archive = ['zip','7z','rar','tgz','gz','xz','tar','jar','iso','z','zipx','cab','bz2','arj','lz','lzh'];
	$type_word = ['doc','docx','xps','rtf','wps'];
	$type_excel = ['xls','xlsx'];
	$type_pdf = ['pdf'];
	$type_powerpoint = ['ppt','pptx'];
	$type_android = ['apk'];
	$type_apple = ['ipa','dmg'];
	$type_windows = ['exe','appx'];
	if(in_array($type, $type_image)){
		return 'fa-file-image-o';
	}elseif(in_array($type, $type_audio)){
		return 'fa-file-audio-o';
	}elseif(in_array($type, $type_video)){
		return 'fa-file-video-o';
	}elseif(in_array($type, $type_text)){
		return 'fa-file-text-o';
	}elseif(in_array($type, $type_code)){
		return 'fa-file-code-o';
	}elseif(in_array($type, $type_archive)){
		return 'fa-file-archive-o';
	}elseif(in_array($type, $type_word)){
		return 'fa-file-word-o';
	}elseif(in_array($type, $type_excel)){
		return 'fa-file-excel-o';
	}elseif(in_array($type, $type_pdf)){
		return 'fa-file-pdf-o';
	}elseif(in_array($type, $type_powerpoint)){
		return 'fa-file-powerpoint-o';
	}elseif(in_array($type, $type_android)){
		return 'fa-android';
	}elseif(in_array($type, $type_apple)){
		return 'fa-apple';
	}elseif(in_array($type, $type_windows)){
		return 'fa-windows';
	}else{
		return 'fa-file-o';
	}
}

function is_view($type){
	global $conf;
	$type_image = explode('|',$conf['type_image']);
	$type_audio = explode('|',$conf['type_audio']);
	$type_video = explode('|',$conf['type_video']);
    if (in_array($type, $type_image) || in_array($type, $type_audio) || in_array($type, $type_video)) {
        return true;
	}
	return false;
}


function checkImage($fileurl){
	global $conf;
	$scenes = [];
    if ($conf['green_check_porn']==1) {
		$scenes[] = 'porn';
		$label_porn = explode(',', $conf['green_label_porn']);
    }
    if ($conf['green_check_terrorism']==1) {
		$scenes[] = 'terrorism';
		$label_terrorism = explode(',', $conf['green_label_terrorism']);
    }
	if(count($scenes)==0)return false;

	$client = new \lib\AliyunGreen($conf['aliyun_ak'], $conf['aliyun_sk'], $conf['green_check_region']);
	$task1 = array('dataId' => uniqid(), 'url' => $fileurl);
	$request = array("tasks" => array($task1), "scenes" => $scenes);

try {
	$response = $client->doCheck($request);
	//print_r($response);
    if(200 == $response->code){
        $taskResults = $response->data;
        foreach ($taskResults as $taskResult) {
            if(200 == $taskResult->code){
                $sceneResults = $taskResult->results;
                foreach ($sceneResults as $sceneResult) {
					$scene = $sceneResult->scene;
					$label = $sceneResult->label;
                    $suggestion = $sceneResult->suggestion;
					if($scene == 'porn' && (in_array($label, $label_porn) || $suggestion == 'block')){
						return true;
					}elseif($scene == 'terrorism' && (in_array($label, $label_terrorism) || $suggestion == 'block')){
						return true;
					}
                }
            }else{
                writeLog("task process fail:" . $taskResult->code . ' ' . $taskResult->msg);
            }
        }
    }else{
		writeLog("detect not success. code:" . $response->code . ' ' . $response->msg);
    }
} catch (Exception $e) {
    print_r($e);
}
return false;
}
function writeLog($text) {
	file_put_contents ( SYSTEM_ROOT."log.txt", date ( "Y-m-d H:i:s" ) . "  " . $text . "\r\n", FILE_APPEND );
}