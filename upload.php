<?php
include("./includes/common.php");

$title = '上传文件 - '.$conf['title'];
include SYSTEM_ROOT.'header.php';

$maxfilesize=ini_get('upload_max_filesize');

$csrf_token = md5(mt_rand(0,999).time());
$_SESSION['csrf_token'] = $csrf_token;
?>
<div class="container">
    <div class="row">
      <div class="col-sm-9">
        <div align="center" class="list-group-item">
        <div id="progressBar" style="min-height:0px;">
        </div>
         <h1 style="color:#404040;">选择一个文件开始上传</h1>

         <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo $csrf_token?>">
         <div id="upload_block"></div>
         

         <div id="upload_frame">
         <button id="uploadFile" class="btn btn-raised btn-primary" style="height:50px;font-size:20px;"><i class="fa fa-upload"></i> 立即上传<div class="ripple-container"></div></button>
<div class="form-group">
<div class="checkbox">
<label>
<input type="checkbox" id="show" value="1" checked> 在首页文件列表显示
</label>
<label>
<input type="checkbox" id="ispwd" value="1"> 设置访问密码
</label>
</div>
</div>
<div class="form-group">
<div class="checkbox">
</div>
</div>
<div class="form-group" style="max-width:220px;display:none;" id="pwd_frame">
<input type="text" class="form-control" id="pwd" placeholder="请输入密码" autocomplete="off">
<p class="help-block">密码只能为字母或数字</p>
</div>
         </div>
         <div>
<h3><div style="font:20px Microsoft YaHei; margin:0px auto; text-align:center;">
<font color="#F44336"><a class="<?php echo checkIfActive('Agreement')?>"><a href="./Agreement.php" aria-hidden="true" style="font:18px Microsoft YaHei;" class="btn" class="ripple-container"> 使用协议</a><hr/><div font color="#F44336" style="font:16px Microsoft YaHei;">请严格遵守国家相关法律法规，尊重著作权、版权等第三方权利，切勿上传违规文件。选择上传文件将视为您已知悉相关规定，您的上传IP与特征码会被记录，请合法使用本仓库，违规文件将被删除。<br><br></h3>
</div>
    <br>
    </div>
    </div>
          <div class="col-sm-3">
      <div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title"><class="fa fa-exclamation-circle"><div style="margin:0px auto; text-align:center;">上传提示</h3>
</div>
<div class="list-group-item"><font color="#616161" margin:0px auto; text-align:center;">
共享的文件仓库，免费图床、免费外链、临时网盘、上传下载均不限速。
</div>
<div class="list-group-item">上传视频需审核，其他无限制。单个上传最大支持200M，大文件传输请注册。
</div>
</div>
      <div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title"><class="fa fa-exclamation-circle"><div style="margin:0px auto; text-align:center;">小纸条</h3>
</div>
<div class="list-group-item"><font color="#616161" margin:0px auto; text-align:center;">
似乎才刚刚认识你，转眼都喜欢你那么久了。
</div>
<div class="list-group-item">要说我有什么缺点，我可能就是缺点你。
</div>
      </div>
    </div>
  </div>
    </div>
  <script src="assets/js/upload.js?v=1001"></script>
<?php include SYSTEM_ROOT.'footer.php';?>
