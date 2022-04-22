<?php
include("../includes/common.php");
$title='Cloud tray backstage management center';
include './en-head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./en-login.php';</script>");
?>
<?php
$mysqlversion=$DB->getColumn("select VERSION()");
?>
<style
type="text/css">
<!--
a:link
{
text-decoration:
none;
}
a:visited
{
text-decoration:
none;
}
a:hover
{
text-decoration:
none;
}
a:active
{
text-decoration:
none;
}
-->
</style>
<link href="../assets/css/admin.css" rel="stylesheet"/>
<div class="container" style="padding-top:70px;">
<div class="col-md-12 col-lg-10 center-block" style="float: none;">
<div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cloud fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="count2">0</div>
                                    <div>Upload file today</div>
                                </div>
                            </div>
                        </div>
                        <a href="en-file.php">
                            <div class="panel-footer">
                                <span class="pull-left" herf="en-file.php">Check the details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cloud-upload fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="count3">0</div>
                                    <div>Upload yesterday</div>
                                </div>
                            </div>
                        </div>
                        <a href="en-file.php">
                            <div class="panel-footer">
                                <span class="pull-left">Check the details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-inbox fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="count1">0</div>
                                    <div>The existing file</div>
                                </div>
                            </div>
                        </div>
                        <a href="en-file.php">
                            <div class="panel-footer">
                                <span class="pull-left">Check the details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="count4">0</div>
                                    <div>Today's visit</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Check the details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Server information</h3>
	</div>
	<ul class="list-group">
		<li class="list-group-item">
			<b>PHP version：</b><?php echo phpversion() ?>
			<?php if(ini_get('safe_mode')) { echo 'Thread safety'; } else { echo 'Non-thread-safe'; } ?>
		</li>
		<li class="list-group-item">
			<b>MySQL version：</b><?php echo $mysqlversion ?>
		</li>
		<li class="list-group-item">
			<b>Server software：</b><?php echo $_SERVER['SERVER_SOFTWARE'] ?>
		</li>
		
		<li class="list-group-item">
			<b>Maximum running time of the program：</b><?php echo ini_get('max_execution_time') ?>s
		</li>
		<li class="list-group-item">
			<b>POST The license：</b><?php echo ini_get('post_max_size'); ?>
		</li>
		<li class="list-group-item">
			<b>File upload license：</b><?php echo ini_get('upload_max_filesize'); ?>
		</li>
	</ul>
</div>
	</div>
</div>
<script>
$(document).ready(function(){
    $.ajax({
		type : "GET",
		url : "ajax.php?act=getcount",
		dataType : 'json',
		async: true,
		success : function(data) {
            $('#count1').html(data.count1);
			$('#count2').html(data.count2);
			$('#count3').html(data.count3);
        }
    })
})
</script>

<div class="ctr-p" id="footer">
	<style>
		.f6F9Be{background:#E0E0E0;line-height:40px;min-width:980px;border-top:1px solid #E0E0E0;min-width:400px}
		.B4GxFc{margin-left:166px}
		.fbar p,.fbar a,#fsettl,#fsett a{color:#5f6368}
		.fbar a:hover,#fsett a:hover{color:#333}
		.fbar{font-size:14px}
		.EvHmz{bottom:auto;left:0;position:absolute;right:0}
		.hRvfYe a:hover{text-decoration:underline}#fsl{margin-left:30px;float:left}#fsr{float:right;margin-right:30px;}@media (max-width:805px){#fsl,#fsr{display:block;margin:1;float:none}
	</style>
	
<div class="ctr-p" id="footer">
	<style>
		.f6F9Be{background:#F5F5F5;line-height:40px;min-width:980px;border-top:1px solid #F5F5F5;min-width:400px}
		.B4GxFc{margin-left:166px}
		.fbar p,.fbar a,#fsettl,#fsett a{color:#E0E0E0}
		.fbar a:hover,#fsett a:hover{color:#333}
		.fbar{font-size:14px}
		.EvHmz{bottom:auto;left:0;position:absolute;right:0}
		.hRvfYe a:hover{text-decoration:underline}#fsl{margin-left:30px;float:left}#fsr{float:right;margin-right:30px;}@media (max-width:805px){#fsl,#fsr{display:block;margin:1;float:#E0E0E0}
	</style>
