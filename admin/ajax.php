<?php
include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

if(strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])===false)exit('{"code":403}');

@header('Content-Type: application/json; charset=UTF-8');

switch($act){
case 'getcount':
	$thtime=date("Y-m-d").' 00:00:00';
	$lastday=date("Y-m-d",strtotime("-1 day")).' 00:00:00';
	$count1=$DB->getColumn("SELECT count(*) from pre_file");
	$count2=$DB->getColumn("SELECT count(*) from pre_file WHERE addtime>='$thtime'");
	$count3=$DB->getColumn("SELECT count(*) from pre_file WHERE addtime>='$lastday' AND addtime<'$thtime'");

	$result=["code"=>0,"count1"=>$count1,"count2"=>$count2,"count3"=>$count3];
	exit(json_encode($result));
break;
case 'setBlock':
	$id=intval($_GET['id']);
	$status=intval($_GET['status']);
	$sql = "UPDATE pre_file SET `block`='$status' WHERE id='$id'";
	if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改成功！"}');
	else exit('{"code":-1,"msg":"修改失败['.$DB->error().']"}');
break;
case 'delFile':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_file where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前文件不存在！"}');
	$result = $stor->delete($row['hash']);
	$sql = "DELETE FROM pre_file WHERE id='$id'";
	if($DB->exec($sql))exit('{"code":0,"msg":"删除文件成功！"}');
	else exit('{"code":-1,"msg":"删除文件失败['.$DB->error().']"}');
break;
case 'operation':
	$checkbox=$_POST['checkbox'];
	if(!$checkbox)exit('{"code":-1,"msg":"未选中文件"}');
	$i=0;
	foreach($checkbox as $id){
		$hash=$DB->getColumn("select hash from pre_file where id='$id' limit 1");
		$stor->delete($hash);
		$DB->exec("DELETE FROM pre_file WHERE id='$id'");
		$i++;
	}
	exit('{"code":0,"msg":"成功删除'.$i.'个文件"}');
break;
case 'getFileInfo':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_file where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前文件不存在！"}');
	$row['code'] = 0;
	$row['size2'] = size_format($row['size']);
	exit(json_encode($row));
break;
case 'saveFileInfo':
	$id = intval($_POST['id']);
	$name = trim(htmlspecialchars($_POST['name']));
	$type = trim(htmlspecialchars($_POST['type']));
	$hide = intval($_POST['hide']);
	$ispwd = intval($_POST['ispwd']);
	$pwd = $ispwd==1?trim(htmlspecialchars($_POST['pwd'])):null;
	if(empty($name))exit('{"code":-1,"msg":"文件名称不能为空"}');
	if($ispwd==1 && !empty($pwd)){
        if (!preg_match('/^[a-zA-Z0-9]+$/', $pwd)) {
			exit('{"code":-1,"msg":"下载密码只能为字母和数字"}');
        }
	}
	$data = [':id'=>$id, ':name'=>$name, ':type'=>$type, ':hide'=>$hide, ':pwd'=>$pwd];
	$sql = "UPDATE `pre_file` SET `name`=:name,`type`=:type,`hide`=:hide,`pwd`=:pwd WHERE `id`=:id";
	if($DB->exec($sql, $data)!==false)exit('{"code":0,"msg":"修改文件信息成功！"}');
	else exit('{"code":-1,"msg":"修改文件信息失败['.$DB->error().']"}');
break;
case 'set':
	if(isset($_POST['green_label_porn'])){
		$_POST['green_label_porn'] = implode(',',$_POST['green_label_porn']);
	}
	if(isset($_POST['green_label_terrorism'])){
		$_POST['green_label_terrorism'] = implode(',',$_POST['green_label_terrorism']);
	}
	foreach($_POST as $k=>$v){
		saveSetting($k, $v);
	}
	$ad=$CACHE->clear();
	if($ad)exit('{"code":0,"msg":"succ"}');
	else exit('{"code":-1,"msg":"修改设置失败['.$DB->error().']"}');
break;
case 'iptype':
	$result = [
	['name'=>'0_X_FORWARDED_FOR', 'ip'=>real_ip(0), 'city'=>get_ip_city(real_ip(0))],
	['name'=>'1_X_REAL_IP', 'ip'=>real_ip(1), 'city'=>get_ip_city(real_ip(1))],
	['name'=>'2_REMOTE_ADDR', 'ip'=>real_ip(2), 'city'=>get_ip_city(real_ip(2))]
	];
	exit(json_encode($result));
break;
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}