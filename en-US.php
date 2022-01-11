<?php
include("./includes/common.php");
$title = $conf['title'];
include SYSTEM_ROOT.'en-header.php';
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
          <label>Search</label>
		  <select name="type" class="form-control">
		      <option value="1" <?php if($type==1){echo "selected";};?>>File Name</option>
		      <option value="2" <?php if($type==2){echo "selected";};?>>File Hash</option>
		      <option value="3" <?php if($type==3){echo "selected";};?>>File Format</option>
		      <option value="4" <?php if($type==4){echo "selected";};?>>Upload Ip</option>
		  </select>
		    </div>
			<div class="form-group" id="searchword">
			<input type="text" class="form-control" name="kw" placeholder="Search content" value="<?php echo trim($_GET['kw'])?>">
			</div>
			<div class="form-group">
			<a href="javascript:searchClear()" class="btn btn-default"><i class="fa fa-repeat"></i>Reset</a>
			<button class="btn btn-primary" type="submit" id="search-btn"><i class="fa fa-search"></i>Search</button>
			</div>
		    </div>
		</form>
      <div id="listTable"></div>
    </div>
  </div>
<div class="container">
        <h3>File list</h3>
        <div class="table-responsive">
       <table class="table table-striped table-hover ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>operation</th>
                    <th>file name</th>
                    <th>file size</th>
                    <th>file format</th>
                    <th>Upload time</th>
                    <th>Upload IP / downloads</th>
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
	$fileurl = './en-down.php/'.$res['hash'].'.'.($res['type']?$res['type']:'file');
	$viewurl = './en-file.php?hash='.$res['hash'];
echo '<tr><td><b>'.$i++.'</b></td><td><a href="'.$fileurl.'" class="btn btn-xs btn-warning">Download</a></td><td><a href="'.$viewurl.'"><i class="fa '.type_to_icon($res['type']).' fa-fw"></i>'.$res['name'].'</td><td>'.size_format($res['size']).'</td><td><font color="blue">'.($res['type']?$res['type']:'unknown').'</font></td><td>'.$res['addtime'].'</td><td>'.preg_replace('/\d+$/','* / <font color="blue">',$res['ip']),$res['count'].'</b></td></tr>';
}
?>
            </tbody>
        </table>
        </div>
        <div style="font:12px Microsoft YaHei;">
        <div class="row">
        <div class="col-md-6"><br>A total of <?php echo $numrows?> a file&nbsp;&nbsp;The current first <?php echo $page?> page，A total of <?php echo $pages?> page</div>
        <div class="col-md-6"><nav>
  <ul class="pagination pagination-sm" style="float:right;">
<?php
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="en-US.php?page='.$first.$link.'">Home page</a></li>';
echo '<li><a href="en-US.php?page='.$prev.$link.'">previous page</a></li>';
} else {
echo '<li class="disabled"><a>Home page</a></li>';
echo '<li class="disabled"><a>previous page</a></li>';
}
$start=$page-5>1?$page-5:1;
$end=$page+10<$pages?$page+10:$pages;
for ($i=$start;$i<$page;$i++)
echo '<li><a href="en-US.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$end;$i++)
echo '<li><a href="en-US.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="en-US.php?page='.$next.$link.'">next page</a></li>';
echo '<li><a href="en-US.php?page='.$last.$link.'">back</a></li>';
} else {
echo '<li class="disabled"><a>next page</a></li>';
echo '<li class="disabled"><a>back</a></li>';
}
?>
  </ul>
</nav></div>
</div>
    </div>
    </div>
</div>
<?php include SYSTEM_ROOT.'en-footer.php';?>
<?php if(!empty($conf['en_gonggao'])){?>
<link href="//cdn.staticfile.org/snackbarjs/1.1.0/snackbar.min.css" rel="stylesheet">
<script src="//cdn.staticfile.org/snackbarjs/1.1.0/snackbar.min.js"></script>
<script>
$(function() {
$.snackbar({content: "<?php echo $conf['en_gonggao']?>", timeout: 10000});
});
</script>
<?php }?>