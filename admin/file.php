<?php
include("../includes/common.php");
$title='文件管理';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<style>
.form-inline .form-control {
    display: inline-block;
    width: auto;
    vertical-align: middle;
}
.form-inline .form-group {
    display: inline-block;
    margin-bottom: 0;
    vertical-align: middle;
}
.table>tbody>tr>td {
	vertical-align: middle;
    max-width: 360px;
	word-break: break-all;
}
</style>
<div class="modal" id="modal-store" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated flipInX">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span
							aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
				<h4 class="modal-title" id="modal-title">文件信息修改</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form-store">
					<input type="hidden" name="action" id="action"/>
					<input type="hidden" name="id" id="id"/>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right">文件名称</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" id="name">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right">文件类型</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="type" id="type">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right">文件大小</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="size" id="size" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right">文件MD5</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="hash" id="hash" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right">是否隐藏</label>
						<div class="col-sm-10">
							<select id="hide" name="hide" class="form-control"><option value="0">0_否</option><option value="1">1_是</option></select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right">开启密码</label>
						<div class="col-sm-10">
							<select id="ispwd" name="ispwd" class="form-control" onchange="change_ispwd(this)"><option value="0">0_否</option><option value="1">1_是</option></select>
						</div>
					</div>
					<div class="form-group" id="pwd_frame">
						<label class="col-sm-2 control-label no-padding-right">下载密码</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="pwd" id="pwd">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-primary" id="store" onclick="save()">保存</button>
			</div>
		</div>
	</div>
</div>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 center-block" style="float: none;">
	    <form onsubmit="return searchFile()" method="GET" class="form-inline">
	        <div class="form-group">
          <label>搜索</label>
		  <select name="type" class="form-control" default="<?php echo trim($_GET['type'])?>"><option value="1">文件名</option><option value="2">文件Hash</option><option value="3">文件格式</option><option value="4">上传者IP</option></select>
		    </div>
			<div class="form-group" id="searchword">
			<input type="text" class="form-control" name="kw" placeholder="搜索内容" value="<?php echo trim($_GET['kw'])?>">
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i>搜索</button>
				<a href="javascript:searchClear()" class="btn btn-default"><i class="fa fa-repeat"></i>重置</a>
			</div>
			<div class="form-group">
			<select id="dstatus" name="dstatus" class="form-control"><option value="0">全部文件</option><option value="1">正常文件</option><option value="2">已屏蔽文件</option><option value="3">待审核文件</option></select>
		    </div>
		</form>
      <div id="listTable"></div>
    </div>
  </div>
<script src="//cdn.staticfile.org/layer/3.1.1/layer.min.js"></script>
<script>
var checkflag1 = "false";
function check1(field) {
if (checkflag1 == "false") {
for (i = 0; i < field.length; i++) {
field[i].checked = true;}
checkflag1 = "true";
return "false"; }
else {
for (i = 0; i < field.length; i++) {
field[i].checked = false; }
checkflag1 = "false";
return "true"; }
}

function unselectall1()
{
    if(document.form1.chkAll1.checked){
	document.form1.chkAll1.checked = document.form1.chkAll1.checked&0;
	checkflag1 = "false";
    }
}

var dstatus = 0;
function listTable(query){
	var url = window.document.location.href.toString();
	var queryString = url.split("?")[1];
	query = query || queryString;
	if(query == 'start' || query == undefined){
		query = '';
		history.replaceState({}, null, './file.php');
	}else if(query != undefined){
		history.replaceState({}, null, './file.php?'+query);
	}
	layer.closeAll();
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'file-table.php?dstatus='+dstatus+'&'+query,
		dataType : 'html',
		cache : false,
		success : function(data) {
			layer.close(ii);
			$("#listTable").html(data)
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function change_ispwd(obj){
	if($(obj).val()==1){
		$('#pwd_frame').show()
	}else{
		$('#pwd_frame').hide()
	}
}
function searchFile(){
	var type=$("select[name='type']").val();
	var kw=$("input[name='kw']").val();
	if(kw==''){
		listTable();
	}else{
		listTable('type='+type+'&kw='+kw);
	}
	return false;
}
function searchClear(){
	$("input[name='kw']").val('');
	listTable('start');
}
function setBlock(id,status) {
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=setBlock&id='+id+'&status='+status,
		dataType : 'json',
		success : function(data) {
			listTable();
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function editframe(id){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=getFileInfo&id='+id,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				$("#modal-store").modal('show');
				$("#action").val("edit");
				$("#form-store #id").val(data.id);
				$("#form-store #name").val(data.name);
				$("#form-store #type").val(data.type);
				$("#form-store #size").val(data.size2+" ("+data.size+" 字节)");
				$("#form-store #hash").val(data.hash);
				$("#form-store #hide").val(data.hide);
				if(data.pwd==null||data.pwd==""){
					$("#form-store #ispwd").val(0);
					$("#form-store #pwd").val("");
					$('#pwd_frame').hide()
				}else{
					$("#form-store #ispwd").val(1);
					$("#form-store #pwd").val(data.pwd);
					$('#pwd_frame').show()
				}
			}else{
				layer.alert(data.msg, {icon: 2})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function save(){
	if($("#name").val()==''){
		layer.alert('请确保各项不能为空！');return false;
	}
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=saveFileInfo',
		data : $("#form-store").serialize(),
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert(data.msg,{
					icon: 1,
					closeBtn: false
				}, function(){
					$("#modal-store").modal('hide');
					listTable();
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
}
function delFile(id) {
	var confirmobj = layer.confirm('你确定要删除此文件吗？', {
	  btn: ['确定','取消'], icon: 0
	}, function(){
	  $.ajax({
		type : 'GET',
		url : 'ajax.php?act=delFile&id='+id,
		dataType : 'json',
		success : function(data) {
			if(data.code == 0){
				layer.alert('删除成功', {icon:1}, function(){listTable();});
			}else{
				layer.alert(data.msg, {icon:2});
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	  });
	}, function(){
	  layer.close(confirmobj);
	});
}
function operation(){
	var confirmobj = layer.confirm('你确定要批量删除文件吗？', {
	  btn: ['确定','取消'], icon: 0
	}, function(){
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : 'POST',
			url : 'ajax.php?act=operation',
			data : $('#form1').serialize(),
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					layer.alert(data.msg, {icon:1}, function(){listTable();});
				}else{
					layer.alert(data.msg, {icon:2});
				}
			},
			error:function(data){
				layer.msg('请求超时');
				listTable();
			}
		});
	}, function(){
	  layer.close(confirmobj);
	});
}
function showfile(id) {
	layer.open({
	   type: 2,
	   title: '文件预览',
	   shadeClose: true,
	   closeBtn:2,
	   scrollbar: false,
	   area: [";max-width:90%;min-width:480px",";max-height:90%;min-height:420px"],
	   content: './file-view.php?id='+id
	});
}
$(document).ready(function(){
	var items = $("select[default]");
	for (i = 0; i < items.length; i++) {
		if($(items[i]).attr("default")!=''){
			$(items[i]).val($(items[i]).attr("default")||0);
		}
	}
	listTable();
	$("#dstatus").change(function () {
		var val = $(this).val();
		dstatus = val;
		listTable();
	});
})
</script>