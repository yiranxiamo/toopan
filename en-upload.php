<?php
include("./includes/common.php");

$title = 'Upload - '.$conf['title'];
include SYSTEM_ROOT.'en-header.php';

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
         <h1 style="color:#404040;">Select a file to start uploading</h1>

         <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo $csrf_token?>">
         <div id="upload_block"></div>
         

         <div id="upload_frame">
         <button id="uploadFile" class="btn btn-raised btn-primary" style="height:50px;font-size:20px;"><i class="fa fa-upload"></i> Immediately upload<div class="ripple-container"></div></button>
<div class="form-group">
<div class="checkbox">
<label>
<input type="checkbox" id="show" value="1" checked> In the home page file square display
</label>
<label>
<input type="checkbox" id="ispwd" value="1"> Set access password
</label>
</div>
</div>
<div class="form-group">
<div class="checkbox">
</div>
</div>
<div class="form-group" style="max-width:220px;display:none;" id="pwd_frame">
<input type="text" class="form-control" id="pwd" placeholder="Please enter your password." autocomplete="off">
<p class="help-block">Passwords can only be letters or Numbers</p>
</div>
         </div>
         <div>
<h3><div style="font:20px Microsoft YaHei; margin:0px auto; text-align:center;">
<font color="#F44336"><a class="<?php echo checkIfActive('en-Agreement')?>"><a href="./en-Agreement.php" aria-hidden="true" class="btn" style="font:18px Microsoft YaHei;"> Use agreement</a><hr/><div font color="#F44336" style="font:16px Microsoft YaHei; margin:0px auto; text-align:center;">Please strictly abide by relevant national laws and regulations, respect copyright, copyright and other third party rights, do not upload illegal documents.If you choose to upload the file, it will be deemed that you have known relevant regulations. Your uploaded IP and characteristic code will be recorded. Please use the warehouse legally.<br><br></h3>
</div>
    <br>
    </div>
    </div>
          <div class="col-sm-3">
      <div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title"><class="fa fa-exclamation-circle"><div style="margin:0px auto; text-align:center;">Upload the prompt</h3>
</div>
<div class="list-group-item"><font color="#616161" margin:0px auto; text-align:center;">
Shared file warehouse, free map bed, free outside the link, upload and download are not limited speed.
</div>
<div class="list-group-item">The uploaded video needs to be reviewed. The maximum support for a single upload is 200m. Please register for large file transfer.
</div>
</div>
      <div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title"><class="fa fa-exclamation-circle"><div style="margin:0px auto; text-align:center;">A small piece of paper</h3>
</div>
<div class="list-group-item"><font color="#616161" margin:0px auto; text-align:center;">
It seems that just know you, blink of an eye like you so long.
</div>
<div class="list-group-item">If I have any weakness, I may be your weakness.
</div>
      </div>
    </div>
  </div>
    </div>
  <script src="assets/js/en-upload.js?v=1001"></script>
<?php include SYSTEM_ROOT.'en-footer.php';?>
