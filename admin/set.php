<?php
/**
 * 系统设置
**/
include("../includes/common.php");
$title='系统设置';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
$mod=isset($_GET['mod'])?$_GET['mod']:null;
?>
<?php
if($mod=='site'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">网站信息设置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-2 control-label">网站标题</label>
	  <div class="col-sm-10"><input type="text" name="title" value="<?php echo $conf['title']; ?>" class="form-control" required/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">英文网站标题</label>
	  <div class="col-sm-10"><input type="text" name="en_title" value="<?php echo $conf['en_title']; ?>" class="form-control" required/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">关键字</label>
	  <div class="col-sm-10"><input type="text" name="keywords" value="<?php echo $conf['keywords']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">英文网站关键字</label>
	  <div class="col-sm-10"><input type="text" name="en_keywords" value="<?php echo $conf['en_keywords']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">网站描述</label>
	  <div class="col-sm-10"><input type="text" name="description" value="<?php echo $conf['description']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">英文网站描述</label>
	  <div class="col-sm-10"><input type="text" name="en_description" value="<?php echo $conf['en_description']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">禁止访问IP</label>
	  <div class="col-sm-10"><textarea class="form-control" name="blackip" rows="2" placeholder="多个IP用|隔开"><?php echo $conf['blackip']?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">首页公告</label>
	  <div class="col-sm-10"><textarea class="form-control" name="gonggao" rows="3" placeholder="不填写则不显示首页公告"><?php echo htmlspecialchars($conf['gonggao'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">英文首页公告</label>
	  <div class="col-sm-10"><textarea class="form-control" name="en_gonggao" rows="3" placeholder="不填写则不显示首页公告"><?php echo htmlspecialchars($conf['en_gonggao'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">文件查看页公告</label>
	  <div class="col-sm-10"><textarea class="form-control" name="gg_file" rows="3" placeholder="不填写则不显示"><?php echo htmlspecialchars($conf['gg_file'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">英文文件查看页公告</label>
	  <div class="col-sm-10"><textarea class="form-control" name="en_gg_file" rows="3" placeholder="不填写则不显示"><?php echo htmlspecialchars($conf['en_gg_file'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">页脚代码</label>
	  <div class="col-sm-10"><textarea class="form-control" name="tongji" rows="3" placeholder="不填写则不显示统计代码"><?php echo htmlspecialchars($conf['tongji'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">英文页脚代码</label>
	  <div class="col-sm-10"><textarea class="form-control" name="en_tongji" rows="3" placeholder="不填写则不显示统计代码"><?php echo htmlspecialchars($conf['en_tongji'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<?php
}elseif($mod=='api'){
$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$admin_path = substr($sitepath, strrpos($sitepath, '/'));
$siteurl = (is_https() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].str_replace($admin_path,'',$sitepath).'/';
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">上传API设置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-3 control-label">上传API开关</label>
	  <div class="col-sm-9"><select class="form-control" name="api_open" default="<?php echo $conf['api_open']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">来源域名白名单</label>
	  <div class="col-sm-9"><input type="text" name="api_referer" value="<?php echo $conf['api_referer']; ?>" class="form-control" placeholder="多个域名用|隔开"/><font color="green">多个域名用|隔开，不填写则不限制来源域名</font></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
  </div>
</div>
</div>

<div class="panel-heading"><h3 class="panel-title">上传API文档</h3></div>
<pre>
API接口地址：<?php echo $siteurl?>api.php

当前API支持JSON、JSONP、FORM 3种返回方式，支持Web跨域调用，也支持程序中直接调用。

请求方式：POST  multipart/form-data

请求参数说明：
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>是否必填</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>文件</td><td>file</td><td>是</td><td></td><td>multipart格式文件</td></tr>
  <tr><td>是否首页显示</td><td>show</td><td>否</td><td>1</td><td>默认为是</td></tr>
  <tr><td>是否设置密码</td><td>ispwd</td><td>否</td><td>0</td><td>默认为否</td></tr>
  <tr><td>下载密码</td><td>pwd</td><td>否</td><td>123456</td><td>默认留空</td></tr>
  <tr><td>返回格式</td><td>format</td><td>否</td><td>json</td><td>有json、jsonp、form三种选择
默认为json</td></tr>
  <tr><td>跳转页面url</td><td>backurl</td><td>否</td><td>http://...</td><td>上传成功后的跳转地址
只在form格式有效</td></tr>
  <tr><td>callback</td><td>callback</td><td>否</td><td>callback</td><td>只在jsonp格式有效</td></tr>
  </tbody>
</table>
返回参数说明：
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>上传状态</td><td>code</td><td>Int</td><td>0</td><td>0为成功，其他为失败</td></tr>
  <tr><td>提示信息</td><td>msg</td><td>String</td><td>上传成功！</td><td>如果上传失败会有错误提示</td></tr>
  <tr><td>文件MD5</td><td>hash</td><td>String</td><td>f1e807cb0d6ba52d71bdb02864e6bda8</td><td></td></tr>
  <tr><td>文件名称</td><td>name</td><td>String</td><td>exapmle1.jpg</td><td></td></tr>
  <tr><td>文件大小</td><td>size</td><td>Int</td><td>58937</td><td>单位：字节</td></tr>
  <tr><td>文件格式</td><td>type</td><td>String</td><td>jpg</td><td></td></tr>
  <tr><td>下载地址</td><td>downurl</td><td>String</td><td>http://.....</td><td></td></tr>
  <tr><td>预览地址</td><td>viewurl</td><td>String</td><td>http://.....</td><td>只有图片、音乐、视频文件才有</td></tr>
  </tbody>
</table>
</pre>
</div>
</div>
<?php
}elseif($mod=='account_n' && $_POST['do']=='submit'){
	$user=$_POST['user'];
	$oldpwd=$_POST['oldpwd'];
	$newpwd=$_POST['newpwd'];
	$newpwd2=$_POST['newpwd2'];
	if($user==null)showmsg('用户名不能为空！',3);
	saveSetting('admin_user',$user);
	if(!empty($newpwd) && !empty($newpwd2)){
		if($oldpwd!=$conf['admin_pwd'])showmsg('旧密码不正确！',3);
		if($newpwd!=$newpwd2)showmsg('两次输入的密码不一致！',3);
		saveSetting('admin_pwd',$newpwd);
	}
	$ad=$CACHE->clear();
	if($ad)showmsg('修改成功！请重新登录',1);
	else showmsg('修改失败！<br/>'.$DB->error(),4);
}elseif($mod=='account'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">管理员账号设置</h3></div>
<div class="panel-body">
  <form action="./set.php?mod=account_n" method="post" class="form-horizontal" role="form"><input type="hidden" name="do" value="submit"/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">用户名</label>
	  <div class="col-sm-10"><input type="text" name="user" value="<?php echo $conf['admin_user']; ?>" class="form-control" required/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">旧密码</label>
	  <div class="col-sm-10"><input type="password" name="oldpwd" value="" class="form-control" placeholder="请输入当前的管理员密码"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">新密码</label>
	  <div class="col-sm-10"><input type="password" name="newpwd" value="" class="form-control" placeholder="不修改请留空"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">重输密码</label>
	  <div class="col-sm-10"><input type="password" name="newpwd2" value="" class="form-control" placeholder="不修改请留空"/></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<?php
}elseif($mod=='iptype'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">用户IP地址获取设置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
    <div class="form-group">
	  <label class="col-sm-2 control-label">用户IP地址获取方式</label>
	  <div class="col-sm-10"><select class="form-control" name="ip_type" default="<?php echo $conf['ip_type']?>"><option value="0">0_X_FORWARDED_FOR</option><option value="1">1_X_REAL_IP</option><option value="2">2_REMOTE_ADDR</option></select></div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
<div class="panel-footer">
<span class="glyphicon glyphicon-info-sign"></span>
此功能设置用于防止用户伪造IP请求。<br/>
X_FORWARDED_FOR：之前的获取真实IP方式，极易被伪造IP<br/>
X_REAL_IP：在网站使用CDN的情况下选择此项，在不使用CDN的情况下也会被伪造<br/>
REMOTE_ADDR：直接获取真实请求IP，无法被伪造，但可能获取到的是CDN节点IP<br/>
<b>你可以从中选择一个能显示你真实地址的IP，优先选下方的选项。</b>
</div>
</div>
<script>
$(document).ready(function(){
	$.ajax({
		type : "GET",
		url : "ajax.php?act=iptype",
		dataType : 'json',
		async: true,
		success : function(data) {
			$("select[name='ip_type']").empty();
			var defaultv = $("select[name='ip_type']").attr('default');
			$.each(data, function(k, item){
				$("select[name='ip_type']").append('<option value="'+k+'" '+(defaultv==k?'selected':'')+'>'+ item.name +' - '+ item.ip +' '+ item.city +'</option>');
			})
		}
	});
})
</script>
<?php
}elseif($mod=='file'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">文件上传设置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
    <div class="form-group">
	  <label class="col-sm-3 control-label">存储类型</label>
	  <div class="col-sm-9"><select class="form-control" name="storage" default="<?php echo $conf['storage']?>"><option value="local">本地存储</option><option value="oss">阿里云OSS</option><option value="qcloud">腾讯云COS</option><option value="obs">华为云OBS</option><option value="upyun">又拍云</option><?php if (defined('SAE_ACCESSKEY')) {?><option value="sae">SaeStorage</option><?php }?></select></div>
	</div><br/>
	<div id="oss_info" style="<?php echo $conf['storage']!='oss'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">阿里云AccessKey Id</label>
	  <div class="col-sm-9"><input type="text" name="oss_ak" value="<?php echo $conf['oss_ak']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">阿里云AccessKey Secret</label>
	  <div class="col-sm-9"><input type="text" name="oss_sk" value="<?php echo $conf['oss_sk']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">阿里云OSS EndPoint</label>
	  <div class="col-sm-9"><input type="text" name="oss_endpoint" value="<?php echo $conf['oss_endpoint']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">阿里云OSS Bucket</label>
	  <div class="col-sm-9"><input type="text" name="oss_bucket" value="<?php echo $conf['oss_bucket']; ?>" class="form-control"/></div>
	</div><br/>
	</div>
	<div id="qcloud_info" style="<?php echo $conf['storage']!='qcloud'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">腾讯云SecretId</label>
	  <div class="col-sm-9"><input type="text" name="qcloud_id" value="<?php echo $conf['qcloud_id']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">腾讯云SecretKey</label>
	  <div class="col-sm-9"><input type="text" name="qcloud_key" value="<?php echo $conf['qcloud_key']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">COS存储桶地域</label>
	  <div class="col-sm-9"><input type="text" name="qcloud_region" value="<?php echo $conf['qcloud_region']; ?>" class="form-control" placeholder="填写英文名称，例如：ap-shanghai"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">COS存储桶名称</label>
	  <div class="col-sm-9"><input type="text" name="qcloud_bucket" value="<?php echo $conf['qcloud_bucket']; ?>" class="form-control" placeholder="格式：BucketName-APPID"/></div>
	</div><br/>
	</div>
	<div id="obs_info" style="<?php echo $conf['storage']!='obs'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">华为云AccessKeyId</label>
	  <div class="col-sm-9"><input type="text" name="obs_ak" value="<?php echo $conf['obs_ak']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">华为云SecretAccessKey</label>
	  <div class="col-sm-9"><input type="text" name="obs_sk" value="<?php echo $conf['obs_sk']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">OBS EndPoint</label>
	  <div class="col-sm-9"><input type="text" name="obs_endpoint" value="<?php echo $conf['obs_endpoint']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">OBS桶名称</label>
	  <div class="col-sm-9"><input type="text" name="obs_bucket" value="<?php echo $conf['obs_bucket']; ?>" class="form-control"/></div>
	</div><br/>
	</div>
	<div id="upyun_info" style="<?php echo $conf['storage']!='upyun'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">云存储服务名称</label>
	  <div class="col-sm-9"><input type="text" name="upyun_name" value="<?php echo $conf['upyun_name']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">操作员名称</label>
	  <div class="col-sm-9"><input type="text" name="upyun_user" value="<?php echo $conf['upyun_user']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">操作员密码</label>
	  <div class="col-sm-9"><input type="text" name="upyun_pwd" value="<?php echo $conf['upyun_pwd']; ?>" class="form-control"/></div>
	</div><br/>
	</div>
	<div id="local_info" style="<?php echo $conf['storage']!='local'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">本地存储路径</label>
	  <div class="col-sm-9"><input type="text" name="filepath" value="<?php echo $conf['filepath']; ?>" class="form-control"/ placeholder="默认存储在网站file目录"><font color="green">不填写则默认存储在网站file目录下，只能填写以服务器根目录/开始的绝对路径。</font></div>
	</div><br/>
	</div>
	<div id="sae_info" style="<?php echo $conf['storage']!='sae'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">SAE Storage名称</label>
	  <div class="col-sm-9"><input type="text" name="storagename" value="<?php echo $conf['storagename']; ?>" class="form-control"/ placeholder=""></div>
	</div><br/>
	</div>
	<div class="form-group">
	  <label class="col-sm-3 control-label">图片文件类型</label>
	  <div class="col-sm-9"><input type="text" name="type_image" value="<?php echo $conf['type_image']; ?>" class="form-control" placeholder="多个文件类型用|隔开"/><font color="green">在文件预览页面，以上文件类型将以图片的形式展示</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">音频文件类型</label>
	  <div class="col-sm-9"><input type="text" name="type_audio" value="<?php echo $conf['type_audio']; ?>" class="form-control" placeholder="多个文件类型用|隔开"/><font color="green">在文件预览页面，以上文件类型将以音频的形式展示</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">视频文件类型</label>
	  <div class="col-sm-9"><input type="text" name="type_video" value="<?php echo $conf['type_video']; ?>" class="form-control" placeholder="多个文件类型用|隔开"/><font color="green">在文件预览页面，以上文件类型将以视频的形式展示</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">禁止上传的文件类型</label>
	  <div class="col-sm-9"><input type="text" name="type_block" value="<?php echo $conf['type_block']; ?>" class="form-control" placeholder="多个文件类型用|隔开"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">文件名屏蔽关键词</label>
	  <div class="col-sm-9"><input type="text" name="name_block" value="<?php echo $conf['name_block']; ?>" class="form-control" placeholder="多个关键词用|隔开"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">每IP每天限制上传数量</label>
	  <div class="col-sm-9"><input type="text" name="upload_limit" value="<?php echo $conf['upload_limit']; ?>" class="form-control" placeholder="0或留空为不限制"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">视频文件需要审核</label>
	  <div class="col-sm-9"><select class="form-control" name="videoreview" default="<?php echo $conf['videoreview']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<script>
$("select[name='storage']").change(function(){
	if($(this).val() == 'sae'){
		show_form("sae_info")
	}else if($(this).val() == 'oss'){
		show_form("oss_info")
	}else if($(this).val() == 'qcloud'){
		show_form("qcloud_info")
	}else if($(this).val() == 'obs'){
		show_form("obs_info")
	}else if($(this).val() == 'upyun'){
		show_form("upyun_info")
	}else{
		show_form("local_info")
	}
});
function show_form(name){
	$("#qcloud_info").hide();
	$("#oss_info").hide();
	$("#sae_info").hide();
	$("#local_info").hide();
	$("#upyun_info").hide();
	$("#"+name).show();
}
</script>
<?php
}elseif($mod=='green'){
	$green_label_porn = explode(',', $conf['green_label_porn']);
	$green_label_terrorism = explode(',', $conf['green_label_terrorism']);
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">内容安全设置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
    <div class="form-group">
	  <label class="col-sm-3 control-label">图片违规检测</label>
	  <div class="col-sm-9"><select class="form-control" name="green_check" default="<?php echo $conf['green_check']?>"><option value="0">关闭</option><option value="1">开启</option></select><font color="green">开启后下面的选项才会生效</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">阿里云AccessKey Id</label>
	  <div class="col-sm-9"><input type="text" name="aliyun_ak" value="<?php echo $conf['aliyun_ak']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">阿里云AccessKey Secret</label>
	  <div class="col-sm-9"><input type="text" name="aliyun_sk" value="<?php echo $conf['aliyun_sk']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">图片检测接入区域</label>
	  <div class="col-sm-9"><select class="form-control" name="green_check_region" default="<?php echo $conf['green_check_region']?>"><option value="cn-beijing">华北2（北京）</option><option value="cn-shanghai">华东2（上海）</option><option value="cn-shenzhen">华南1（深圳）</option><option value="ap-southeast-1">新加坡</option><option value="us-west-1">美西</option></select><font color="green">你可以选择一个离本站服务器最近的以提升检测速度</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">图片智能鉴黄</label>
	  <div class="col-sm-9"><select class="form-control" name="green_check_porn" default="<?php echo $conf['green_check_porn']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div><br/>
	<div class="form-group" id="green_check_porn_" style="<?php echo $conf['green_check_porn']!=1?'display:none;':null; ?>">
	  <label class="col-sm-3 control-label">图片智能鉴黄屏蔽类型</label>
	  <div class="col-sm-9">
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_porn[]" value="porn" <?php echo in_array('porn',$green_label_porn)?'checked':null;?>> 色情图片（porn）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_porn[]" value="sexy" <?php echo in_array('sexy',$green_label_porn)?'checked':null;?>> 性感图片（sexy）</label>
	  </div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">图片暴恐涉政识别</label>
	  <div class="col-sm-9"><select class="form-control" name="green_check_terrorism" default="<?php echo $conf['green_check_terrorism']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div><br/>
	<div class="form-group" id="green_check_terrorism_" style="<?php echo $conf['green_check_terrorism']!=1?'display:none;':null; ?>">
	  <label class="col-sm-3 control-label">图片暴恐涉政识别屏蔽类型</label>
	  <div class="col-sm-9">
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="bloody" <?php echo in_array('bloody',$green_label_terrorism)?'checked':null;?>> 血腥（bloody）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="explosion" <?php echo in_array('explosion',$green_label_terrorism)?'checked':null;?>> 爆炸烟光（explosion）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="outfit" <?php echo in_array('outfit',$green_label_terrorism)?'checked':null;?>> 特殊装束（outfit）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="logo" <?php echo in_array('logo',$green_label_terrorism)?'checked':null;?>> 特殊标识（logo）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="weapon" <?php echo in_array('weapon',$green_label_terrorism)?'checked':null;?>> 武器（weapon）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="politics" <?php echo in_array('politics',$green_label_terrorism)?'checked':null;?>> 涉政（politics）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="violence" <?php echo in_array('violence',$green_label_terrorism)?'checked':null;?>> 打斗（violence）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="crowd" <?php echo in_array('crowd',$green_label_terrorism)?'checked':null;?>> 聚众（crowd）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="parade" <?php echo in_array('parade',$green_label_terrorism)?'checked':null;?>> 游行（parade）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="carcrash" <?php echo in_array('carcrash',$green_label_terrorism)?'checked':null;?>> 车祸现场（carcrash）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="flag" <?php echo in_array('flag',$green_label_terrorism)?'checked':null;?>> 旗帜（flag）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="location" <?php echo in_array('location',$green_label_terrorism)?'checked':null;?>> 地标（location）</label>
	  </div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">图片检测访问网址</label>
	  <div class="col-sm-9"><input type="text" name="apiurl" value="<?php echo $conf['apiurl']; ?>" class="form-control" placeholder="不填写则默认使用当前网址"/><font color="green">此处是图片检测的时候阿里云访问本站的网址，不填写则默认使用当前网址，如果填写必需以http://开头，以/结尾</font></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
<div class="panel-footer">
<span class="glyphicon glyphicon-info-sign"></span>
阿里云图片违规检测：<a href="https://yundun.console.aliyun.com/?p=cts#/api/statistics" target="_blank" rel="noreferrer">点此进入</a>｜<a href="https://usercenter.console.aliyun.com/#/manage/ak" target="_blank" rel="noreferrer">获取AK/SK</a>
</div>
</div>
<script>
$("select[name='green_check_porn']").change(function(){
	if($(this).val() == 1){
		$("#green_check_porn_").show();
	}else{
		$("#green_check_porn_").hide();
	}
});
$("select[name='green_check_terrorism']").change(function(){
	if($(this).val() == 1){
		$("#green_check_terrorism_").show();
	}else{
		$("#green_check_terrorism_").hide();
	}
});
</script>
<?php
}
?>
    </div>
  </div>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default")||0);
}
function saveSetting(obj){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=set',
		data : $(obj).serialize(),
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert('设置保存成功！', {
					icon: 1,
					closeBtn: false
				}, function(){
				  window.location.reload()
				});
			}else{
				layer.alert(data.msg, {icon: 2})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
	return false;
}
</script>