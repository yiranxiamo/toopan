<?php
/**
 * System Settings
**/
include("../includes/common.php");
$title='System Settings';
include './en-head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./en-login.php';</script>");
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
<div class="panel-heading"><h3 class="panel-title">Website information Settings</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-2 control-label">Site title</label>
	  <div class="col-sm-10"><input type="text" name="en_title" value="<?php echo $conf['en_title']; ?>" class="form-control" required/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">Title of Chinese website</label>
	  <div class="col-sm-10"><input type="text" name="title" value="<?php echo $conf['title']; ?>" class="form-control" required/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">The keyword</label>
	  <div class="col-sm-10"><input type="text" name="en_keywords" value="<?php echo $conf['en_keywords']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">Chinese website keywords</label>
	  <div class="col-sm-10"><input type="text" name="keywords" value="<?php echo $conf['keywords']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">Website description</label>
	  <div class="col-sm-10"><input type="text" name="en_description" value="<?php echo $conf['en_description']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">Chinese website description</label>
	  <div class="col-sm-10"><input type="text" name="description" value="<?php echo $conf['description']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">No access to IP</label>
	  <div class="col-sm-10"><textarea class="form-control" name="blackip" rows="2" placeholder="Multiple IP with|separated"><?php echo $conf['en_blackip']?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">Home page announcement</label>
	  <div class="col-sm-10"><textarea class="form-control" name="en_gonggao" rows="3" placeholder="Do not fill in does not show the homepage announcement"><?php echo htmlspecialchars($conf['en_gonggao'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">Notice on Chinese website</label>
	  <div class="col-sm-10"><textarea class="form-control" name="gonggao" rows="3" placeholder="Do not fill in does not show the homepage announcement"><?php echo htmlspecialchars($conf['gonggao'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">File view page announcement</label>
	  <div class="col-sm-10"><textarea class="form-control" name="en_gg_file" rows="3" placeholder="Do not fill in will not show"><?php echo htmlspecialchars($conf['en_gg_file'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">Chinese website file view announcement</label>
	  <div class="col-sm-10"><textarea class="form-control" name="gg_file" rows="3" placeholder="Do not fill in will not show"><?php echo htmlspecialchars($conf['gg_file'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">The footer code</label>
	  <div class="col-sm-10"><textarea class="form-control" name="en_tongji" rows="3" placeholder="If you do not fill in, the statistics code will not be displayed"><?php echo htmlspecialchars($conf['en_tongji'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">Chinese website footer code</label>
	  <div class="col-sm-10"><textarea class="form-control" name="tongji" rows="3" placeholder="If you do not fill in, the statistics code will not be displayed"><?php echo htmlspecialchars($conf['tongji'])?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="Modify the" class="btn btn-primary form-control"/><br/>
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
<div class="panel-heading"><h3 class="panel-title">Upload API Settings</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-3 control-label">Upload API switch</label>
	  <div class="col-sm-9"><select class="form-control" name="api_open" default="<?php echo $conf['api_open']?>"><option value="0">Shut down</option><option value="1">open</option></select></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Source domain name whitelist</label>
	  <div class="col-sm-9"><input type="text" name="api_referer" value="<?php echo $conf['api_referer']; ?>" class="form-control" placeholder="Multiple domain name|separated"/><font color="green">Multiple domain name|Separate, do not fill in the domain name does not limit the source</font></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9"><input type="submit" name="submit" value="Modify the" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
  </div>
</div>
</div>

<div class="panel-heading"><h3 class="panel-title">Upload API documentation</h3></div>
<div class="panel-body">
<pre>
API interface address：<?php echo $siteurl?>api.php

The current API supports JSON, JSONP, FORM 3 return methods, support Web cross-domain calls, but also support direct calls in the program.

Request way：POST  multipart/form-data

Description of request parameters：
<table class="table table-bordered table-hover">
  <thead><tr><th>The field name</th><th>The variable name</th><th>If required</th><th>The sample value</th><th>describe</th></tr></thead>
  <tbody>
  <tr><td>file</td><td>file</td><td>yes</td><td></td><td>multipart Format file</td></tr>
  <tr><td>Whether the front page is displayed</td><td>show</td><td>no</td><td>1</td><td>The default yes</td></tr>
  <tr><td>Whether to set password or not</td><td>ispwd</td><td>no</td><td>0</td><td>The default no</td></tr>
  <tr><td>Download the password</td><td>pwd</td><td>no</td><td>123456</td><td>The default empty</td></tr>
  <tr><td>Returns the format</td><td>format</td><td>no</td><td>json</td><td>Json, JSONP, form three choices
The default isjson</td></tr>
  <tr><td>The jump pageurl</td><td>backurl</td><td>no</td><td>http://...</td><td>The jump address after successful upload will only be valid in form format</td></tr>
  <tr><td>callback</td><td>callback</td><td>no</td><td>callback</td><td>Only valid in JSONP format</td></tr>
  </tbody>
</table>
Return parameter description：
<table class="table table-bordered table-hover">
  <thead><tr><th>The field name</th><th>The variable name</th><th>type</th><th>The sample value</th><th>describe</th></tr></thead>
  <tbody>
  <tr><td>Upload status</td><td>code</td><td>Int</td><td>0</td><td>0For success，Others are failures</td></tr>
  <tr><td>Prompt information</td><td>msg</td><td>String</td><td>Upload successful!</td><td>There will be an error message if the upload fails</td></tr>
  <tr><td>fileMD5</td><td>hash</td><td>String</td><td>f1e807cb0d6ba52d71bdb02864e6bda8</td><td></td></tr>
  <tr><td>The file name</td><td>name</td><td>String</td><td>exapmle1.jpg</td><td></td></tr>
  <tr><td>The file size</td><td>size</td><td>Int</td><td>58937</td><td>Unit: Bytes</td></tr>
  <tr><td>The file format</td><td>type</td><td>String</td><td>jpg</td><td></td></tr>
  <tr><td>Download address</td><td>downurl</td><td>String</td><td>http://.....</td><td></td></tr>
  <tr><td>Preview the address</td><td>viewurl</td><td>String</td><td>http://.....</td><td>Only pictures, music and video files</td></tr>
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
	if($user==null)showmsg('User name cannot be empty!',3);
	saveSetting('admin_user',$user);
	if(!empty($newpwd) && !empty($newpwd2)){
		if($oldpwd!=$conf['admin_pwd'])showmsg('The old password is incorrect!',3);
		if($newpwd!=$newpwd2)showmsg('The two passwords do not match!',3);
		saveSetting('admin_pwd',$newpwd);
	}
	$ad=$CACHE->clear();
	if($ad)showmsg('Modified successfully!Please log in again',1);
	else showmsg('Modification failed!<br/>'.$DB->error(),4);
}elseif($mod=='account'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">Administrator account setting</h3></div>
<div class="panel-body">
  <form action="./en-set.php?mod=account_n" method="post" class="form-horizontal" role="form"><input type="hidden" name="do" value="submit"/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">The user name</label>
	  <div class="col-sm-10"><input type="text" name="user" value="<?php echo $conf['admin_user']; ?>" class="form-control" required/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">The old password</label>
	  <div class="col-sm-10"><input type="password" name="oldpwd" value="" class="form-control" placeholder="Please enter your current administrator password"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">The new password</label>
	  <div class="col-sm-10"><input type="password" name="newpwd" value="" class="form-control" placeholder="Leave blank if not modified"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">Heavy lost password</label>
	  <div class="col-sm-10"><input type="password" name="newpwd2" value="" class="form-control" placeholder="Leave blank if not modified"/></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="Modify the" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<?php
}elseif($mod=='iptype'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">User IP address fetch Settings</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
    <div class="form-group">
	  <label class="col-sm-2 control-label">User IP address acquisition method</label>
	  <div class="col-sm-10"><select class="form-control" name="ip_type" default="<?php echo $conf['ip_type']?>"><option value="0">0_X_FORWARDED_FOR</option><option value="1">1_X_REAL_IP</option><option value="2">2_REMOTE_ADDR</option></select></div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="Modify the" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
<div class="panel-footer">
<span class="glyphicon glyphicon-info-sign"></span>
This feature is set to prevent users from making bogus IP requests.<br/>
X_FORWARDED_FOR：The previous access to real IP, IP is easy to be forged<br/>
X_REAL_IP：Select this option if the site is using a CDN, and it will be faked if the site is not using a CDN<br/>
REMOTE_ADDR：Direct access to the real request IP, can not be forged, but may be obtained is the CDN node IP<br/>
<b>You can choose one of the IP addresses that shows your real address, and choose the option below first.</b>
</div>
</div>
<script>
$(document).ready(function(){
	$.ajax({
		type : "GET",
		url : "en-ajax.php?act=iptype",
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
<div class="panel-heading"><h3 class="panel-title">File upload Settings</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
    <div class="form-group">
	  <label class="col-sm-3 control-label">Storage type</label>
	  <div class="col-sm-9"><select class="form-control" name="storage" default="<?php echo $conf['storage']?>"><option value="local">The local store</option><option value="oss">aliyun OSS</option><option value="qcloud">Tencent cloud COS</option><option value="obs">huawei OBS</option><option value="upyun">upyun</option><?php if (defined('SAE_ACCESSKEY')) {?><option value="sae">SaeStorage</option><?php }?></select></div>
	</div><br/>
	<div id="oss_info" style="<?php echo $conf['storage']!='oss'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">aliyun AccessKey Id</label>
	  <div class="col-sm-9"><input type="text" name="oss_ak" value="<?php echo $conf['oss_ak']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">aliyun AccessKey Secret</label>
	  <div class="col-sm-9"><input type="text" name="oss_sk" value="<?php echo $conf['oss_sk']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">aliyun OSS EndPoint</label>
	  <div class="col-sm-9"><input type="text" name="oss_endpoint" value="<?php echo $conf['oss_endpoint']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">aliyun OSS Bucket</label>
	  <div class="col-sm-9"><input type="text" name="oss_bucket" value="<?php echo $conf['oss_bucket']; ?>" class="form-control"/></div>
	</div><br/>
	</div>
	<div id="qcloud_info" style="<?php echo $conf['storage']!='qcloud'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">Tencent cloud SecretId</label>
	  <div class="col-sm-9"><input type="text" name="qcloud_id" value="<?php echo $conf['qcloud_id']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Tencent cloud SecretKey</label>
	  <div class="col-sm-9"><input type="text" name="qcloud_key" value="<?php echo $conf['qcloud_key']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">COS Bucket area</label>
	  <div class="col-sm-9"><input type="text" name="qcloud_region" value="<?php echo $conf['qcloud_region']; ?>" class="form-control" placeholder="Fill in the English name, for example:ap-shanghai"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">COS Bucket name</label>
	  <div class="col-sm-9"><input type="text" name="qcloud_bucket" value="<?php echo $conf['qcloud_bucket']; ?>" class="form-control" placeholder="Format:BucketName-APPID"/></div>
	</div><br/>
	</div>
	<div id="obs_info" style="<?php echo $conf['storage']!='obs'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">Huawei cloud AccessKeyId</label>
	  <div class="col-sm-9"><input type="text" name="obs_ak" value="<?php echo $conf['obs_ak']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Huawei cloud SecretAccessKey</label>
	  <div class="col-sm-9"><input type="text" name="obs_sk" value="<?php echo $conf['obs_sk']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">OBS EndPoint</label>
	  <div class="col-sm-9"><input type="text" name="obs_endpoint" value="<?php echo $conf['obs_endpoint']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">OBS Bucket name</label>
	  <div class="col-sm-9"><input type="text" name="obs_bucket" value="<?php echo $conf['obs_bucket']; ?>" class="form-control"/></div>
	</div><br/>
	</div>
	<div id="upyun_info" style="<?php echo $conf['storage']!='upyun'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">Cloud storage service name</label>
	  <div class="col-sm-9"><input type="text" name="upyun_name" value="<?php echo $conf['upyun_name']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Operator name</label>
	  <div class="col-sm-9"><input type="text" name="upyun_user" value="<?php echo $conf['upyun_user']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Operator code</label>
	  <div class="col-sm-9"><input type="text" name="upyun_pwd" value="<?php echo $conf['upyun_pwd']; ?>" class="form-control"/></div>
	</div><br/>
	</div>
	<div id="local_info" style="<?php echo $conf['storage']!='local'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">Local storage path</label>
	  <div class="col-sm-9"><input type="text" name="filepath" value="<?php echo $conf['filepath']; ?>" class="form-control"/ placeholder="By default it is stored in the file directory of the site"><font color="green">If you do not fill it, it will be stored in the file directory of the website by default. You can only fill in the absolute path starting with the server root directory /.</font></div>
	</div><br/>
	</div>
	<div id="sae_info" style="<?php echo $conf['storage']!='sae'?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">SAE Storage The name of the</label>
	  <div class="col-sm-9"><input type="text" name="storagename" value="<?php echo $conf['storagename']; ?>" class="form-control"/ placeholder=""></div>
	</div><br/>
	</div>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Image file type</label>
	  <div class="col-sm-9"><input type="text" name="type_image" value="<?php echo $conf['type_image']; ?>" class="form-control" placeholder="Multiple file types are separated by |"/><font color="green">On the file preview page, the above file types will be shown as images</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Audio file type</label>
	  <div class="col-sm-9"><input type="text" name="type_audio" value="<?php echo $conf['type_audio']; ?>" class="form-control" placeholder="Multiple file types are separated by |"/><font color="green">On the file preview page, the above file types will be shown as audio</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Video file type</label>
	  <div class="col-sm-9"><input type="text" name="type_video" value="<?php echo $conf['type_video']; ?>" class="form-control" placeholder="Multiple file types are separated by |"/><font color="green">On the file preview page, the above file types will be shown as videos</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Type of file not allowed to be uploaded</label>
	  <div class="col-sm-9"><input type="text" name="type_block" value="<?php echo $conf['type_block']; ?>" class="form-control" placeholder="Multiple file types are separated by |"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Filename masking keyword</label>
	  <div class="col-sm-9"><input type="text" name="name_block" value="<?php echo $conf['name_block']; ?>" class="form-control" placeholder="Multiple file types are separated by |"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Limit the number of uploads per IP per day</label>
	  <div class="col-sm-9"><input type="text" name="upload_limit" value="<?php echo $conf['upload_limit']; ?>" class="form-control" placeholder="0 or leave blank for unrestricted"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">The video file needs to be reviewed</label>
	  <div class="col-sm-9"><select class="form-control" name="videoreview" default="<?php echo $conf['videoreview']?>"><option value="0">Shut down</option><option value="1">open</option></select></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9"><input type="submit" name="submit" value="Modify the" class="btn btn-primary form-control"/><br/>
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
<div class="panel-heading"><h3 class="panel-title">Content security Settings</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
    <div class="form-group">
	  <label class="col-sm-3 control-label">Picture violation detection</label>
	  <div class="col-sm-9"><select class="form-control" name="green_check" default="<?php echo $conf['green_check']?>"><option value="0">Shut down</option><option value="1">open</option></select><font color="green">The following options will not take effect until turned on</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">aliyun AccessKey Id</label>
	  <div class="col-sm-9"><input type="text" name="aliyun_ak" value="<?php echo $conf['aliyun_ak']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">aliyun AccessKey Secret</label>
	  <div class="col-sm-9"><input type="text" name="aliyun_sk" value="<?php echo $conf['aliyun_sk']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Image detection access area</label>
	  <div class="col-sm-9"><select class="form-control" name="green_check_region" default="<?php echo $conf['green_check_region']?>"><option value="cn-beijing">North China 2 (Beijing)</option><option value="cn-shanghai">East China 2 (Shanghai)</option><option value="cn-shenzhen">South China 1 (Shenzhen)</option><option value="ap-southeast-1">Singapore</option><option value="us-west-1">The spanish-american</option></select><font color="green">You can choose the one closest to the server on this site to speed up the detection</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Picture intelligence yellow</label>
	  <div class="col-sm-9"><select class="form-control" name="green_check_porn" default="<?php echo $conf['green_check_porn']?>"><option value="0">Shut down</option><option value="1">open</option></select></div>
	</div><br/>
	<div class="form-group" id="green_check_porn_" style="<?php echo $conf['green_check_porn']!=1?'display:none;':null; ?>">
	  <label class="col-sm-3 control-label">Picture intelligent yellow screen type</label>
	  <div class="col-sm-9">
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_porn[]" value="porn" <?php echo in_array('porn',$green_label_porn)?'checked':null;?>> pornography（porn）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_porn[]" value="sexy" <?php echo in_array('sexy',$green_label_porn)?'checked':null;?>> Sexy pictures（sexy）</label>
	  </div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Photo violence and terrorism related identification</label>
	  <div class="col-sm-9"><select class="form-control" name="green_check_terrorism" default="<?php echo $conf['green_check_terrorism']?>"><option value="0">Shut down</option><option value="1">open</option></select></div>
	</div><br/>
	<div class="form-group" id="green_check_terrorism_" style="<?php echo $conf['green_check_terrorism']!=1?'display:none;':null; ?>">
	  <label class="col-sm-3 control-label">Photo violence and terrorism related identification of the type of shielding</label>
	  <div class="col-sm-9">
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="bloody" <?php echo in_array('bloody',$green_label_terrorism)?'checked':null;?>> bloody（bloody）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="explosion" <?php echo in_array('explosion',$green_label_terrorism)?'checked':null;?>> The explosion smoke light（explosion）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="outfit" <?php echo in_array('outfit',$green_label_terrorism)?'checked':null;?>> A special costume（outfit）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="logo" <?php echo in_array('logo',$green_label_terrorism)?'checked':null;?>> Special label（logo）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="weapon" <?php echo in_array('weapon',$green_label_terrorism)?'checked':null;?>> weapons（weapon）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="politics" <?php echo in_array('politics',$green_label_terrorism)?'checked':null;?>> politics（politics）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="violence" <?php echo in_array('violence',$green_label_terrorism)?'checked':null;?>> Fighting,（violence）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="crowd" <?php echo in_array('crowd',$green_label_terrorism)?'checked':null;?>> group（crowd）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="parade" <?php echo in_array('parade',$green_label_terrorism)?'checked':null;?>> The parade（parade）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="carcrash" <?php echo in_array('carcrash',$green_label_terrorism)?'checked':null;?>> An accident -（carcrash）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="flag" <?php echo in_array('flag',$green_label_terrorism)?'checked':null;?>> The flag（flag）</label>
	  <label class="checkbox-inline"><input type="checkbox" name="green_label_terrorism[]" value="location" <?php echo in_array('location',$green_label_terrorism)?'checked':null;?>> landmark（location）</label>
	  </div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">Image detection visit url</label>
	  <div class="col-sm-9"><input type="text" name="apiurl" value="<?php echo $conf['apiurl']; ?>" class="form-control" placeholder="If not, the current url will be used by default"/><font color="green">This is the website address of aliyun when the image is detected. If you do not fill it in, you will use the current website by default.If the entry must start with http:// and end with /</font></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9"><input type="submit" name="submit" value="Modify the" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
<div class="panel-footer">
<span class="glyphicon glyphicon-info-sign"></span>
Aliyun Cloud image violation detection:<a href="https://yundun.console.aliyun.com/?p=cts#/api/statistics" target="_blank" rel="noreferrer">Click here to enter</a>｜<a href="https://usercenter.console.aliyun.com/#/manage/ak" target="_blank" rel="noreferrer">For AK/SK</a>
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
		url : 'en-ajax.php?act=set',
		data : $(obj).serialize(),
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert('Setup saved successfully!', {
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
			layer.msg('Server error');
			return false;
		}
	});
	return false;
}
</script>