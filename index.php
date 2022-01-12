<?php
include("./includes/common.php");
$title = $conf['title'];
include SYSTEM_ROOT.'header.php';
$type = isset($_GET['type'])?trim($_GET['type']):0;
$dstatus = isset($_GET['dstatus'])?trim($_GET['dstatus']):0;
if (isset($_GET['dstatus']) && $_GET['dstatus']>0) {
	if($_GET['dstatus']==3){
		$sqls = " AND `block`=2";
		$links = "&dstatus=".$_GET['dstatus'];
	}elseif($_GET['dstatus']==2){
		$sqls = " AND `block`=1";
		$links = "&dstatus=".$_GET['dstatus'];
	}elseif($_GET['dstatus']==1){
		$sqls = " AND `block`=0";
		$links = "&dstatus=".$_GET['dstatus'];
	}
}

if(isset($_GET['kw']) && !empty($_GET['kw'])) {
	$type = intval($_GET['type']);
	$kw = trim(daddslashes($_GET['kw']));
	if($type == 1){
		$sql=" `name` LIKE '%{$kw}%'";
	}elseif($type == 2){
		$sql=" `hash`='{$kw}'";
	}elseif($type == 3){
		$sql=" `type`='{$kw}'";
	}elseif($type == 4){
		$sql=" `ip`='{$kw}'";
	}
	$sql.=$sqls;
}else{
	$sql=" 1".$sqls;
}
$sql .= " and hide=0";
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
<script>
    function searchClear(){
        $("input[name='kw']").val('');
        $("select[name='type']").val(1);
        $("select[name='dstatus']").val(0);
        $('#search-btn').click()
    }
</script>
</div>
<style type="text/css">
</style>
<div style="font:14px Microsoft YaHei;">
<div class="col-xs-12 center-block" style="float: none;  margin:0px auto; text-align:center;">
<div class="btn-group pull-right" style="display: inline-block;">
</div>
  </div>
  <div class="container">
    <div class="col-xs-12 col-sm-6 center-block" style="float: none;">
	    <form onsubmit="return searchFile()" method="GET" class="form-inline">
	        <div class="form-group">
          <label>搜索</label>
		  <select name="type" class="form-control">
		      <option value="1" <?php if($type==1){echo "selected";};?>>文件名</option>
		      <option value="2" <?php if($type==2){echo "selected";};?>>文件Hash</option>
		      <option value="3" <?php if($type==3){echo "selected";};?>>文件格式</option>
		      <option value="4" <?php if($type==4){echo "selected";};?>>上传者IP</option>
		  </select>
		    </div>
			<div class="form-group" id="searchword">
			<input type="text" class="form-control" name="kw" placeholder="搜索内容" value="<?php echo trim($_GET['kw'])?>">
			</div>
			<div class="form-group">
				<a href="javascript:searchClear()" class="btn btn-default"><i class="fa fa-repeat"></i>重置</a>
				<button class="btn btn-primary" type="submit" id="search-btn"><i class="fa fa-search"></i>搜索</button>
			</div>
		    </div>
		</form>
      <div id="listTable"></div>
    </div>
  </div>
<div class="container">
        <h3>文件列表</h3>
        <div class="table-responsive">
       <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>操作</th>
                    <th>文件名</th>
                    <th>文件大小</th>
                    <th>文件格式</th>
                    <th>上传时间</th>
                    <th>上传IP / 下载量</th>
                </tr>
            </thead>
            <tbody>
<?php
$numrows=$DB->getColumn("SELECT count(*) from pre_file WHERE {$sql}");
$pagesize=15;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);
$rs=$DB->query("SELECT * FROM pre_file WHERE {$sql} order by id desc limit $offset,$pagesize");
$i=1;
while($res = $rs->fetch())
{
	$fileurl = './down.php/'.$res['hash'].'.'.($res['type']?$res['type']:'file');
	$viewurl = './file.php?hash='.$res['hash'];
echo '<tr><td><b>'.$i++.'</b></td><td><a href="'.$fileurl.'" class="btn btn-xs btn-warning">下载</a></td><td><a href="'.$viewurl.'"><i class="fa '.type_to_icon($res['type']).' fa-fw"></i>'.$res['name'].'</td><td>'.size_format($res['size']).'</td><td><font color="blue">'.($res['type']?$res['type']:'未知').'</font></td><td>'.$res['addtime'].'</td><td>'.preg_replace('/\d+$/','* / <font color="blue">',$res['ip']),$res['count'].'</b></td></tr>';
}
?>
            </tbody>
        </table>
        </div>
        <div style="font:13px Microsoft YaHei;">
        <div class="row">
        <div class="col-md-6"><br>共有 <?php echo $numrows?> 个文件&nbsp;&nbsp;当前第 <?php echo $page?> 页，共 <?php echo $pages?> 页</div>
        <div class="col-md-6"><nav>
  <ul class="pagination pagination-sm" style="float:right;">
<?php
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="index.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="index.php?page='.$prev.$link.'">上一页</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>上一页</a></li>';
}
$start=$page-5>1?$page-5:1;
$end=$page+10<$pages?$page+10:$pages;
for ($i=$start;$i<$page;$i++)
echo '<li><a href="index.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$end;$i++)
echo '<li><a href="index.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="index.php?page='.$next.$link.'">下一页</a></li>';
echo '<li><a href="index.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>下一页</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
?>
  </ul>
</nav></div>
</div>
    </div>
    </div>
</div>
<?php include SYSTEM_ROOT.'footer.php';?>
<?php if(!empty($conf['gonggao'])){?>
<link href="//cdn.staticfile.org/snackbarjs/1.1.0/snackbar.min.css" rel="stylesheet">
<script src="//cdn.staticfile.org/snackbarjs/1.1.0/snackbar.min.js"></script>
<script>
$(function() {
$.snackbar({content: "<?php echo $conf['gonggao']?>", timeout: 10000});
});

</script>
<?php }?>
<div style="text-align: center;">
    	<style>
		.f6F9Be{background:#F5F5F5;line-height:40px;min-width:980px;border-top:1px solid #F5F5F5;min-width:400px}
		.B4GxFc{margin-left:166px}
		.fbar p,.fbar a,#fsettl,#fsett a{color:#E0E0E0}
		.fbar a:hover,#fsett a:hover{color:#333}
		.fbar{font-size:14px}
		.EvHmz{left:0;right:0}
		.hRvfYe a:hover{text-decoration:0}#fsl{margin-left:30px;float:left}#fsr{float:right;margin-right:30px;}
	</style>	
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

<a class="btn" href="https://www.toopan.cn/" target="_blank"><font color="#6496b4">首页</a>&nbsp;|&nbsp;<a class="btn" href="https://www.mediy.cn/" target="_blank"><font color="#6496b4">社区论坛</a>&nbsp;|&nbsp;<a class="btn" href="https://www.doodq.com/Agreement.php" target="_blank"><font color="#6496b4">用户协议</a>&nbsp;|&nbsp;<a class="btn" href="https://www.toopan.cn" target="_blank"><font color="#6496b4">文件广场</a>
<hr/>
<div style="font:12px Microsoft YaHei; margin:0px auto; text-align:center;">
<link href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	  <a class="btn" href="https://www.mediy.cn" target="_blank"><font color="#757575">Copyright &copy; 2020 Mediy.cn 版权所有</a><a class="btn" href="https://beian.miit.gov.cn" target="_blank"><font color="#757575">蜀ICP备2020028076号</a>
</div>
