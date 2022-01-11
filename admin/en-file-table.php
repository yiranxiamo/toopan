<?php
/**
 * File management
**/
include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./en-login.php';</script>");

function display_status($status, $id){
	if($status == 2){
		return '<a href="javascript:setBlock('.$id.',0)" class="btn btn-xs btn-warning">pending</a>';
	}elseif($status == 1){
		return '<a href="javascript:setBlock('.$id.',0)" class="btn btn-xs btn-danger">banned</a>';
	}else{
		return '<a href="javascript:setBlock('.$id.',1)" class="btn btn-xs btn-success">normal</a>';
	}
}

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
	$numrows=$DB->getColumn("SELECT count(*) from pre_file WHERE{$sql}");
	$con='contains '.$kw.' A total of <b>'.$numrows.'</b> A record';
	$link='&type='.$type.'&kw='.$kw.$links;
}else{
	$sql=" 1".$sqls;
	$numrows=$DB->getColumn("SELECT count(*) from pre_file WHERE{$sql}");
	$con='System consists of <b>'.$numrows.'</b> records';
	$link=$links;
}

?>
<?php echo $con?>
<form name="form1" id="form1">
	  <div class="table-responsive">
        <table class="table table-striped table-vcenter table-hover">
		  <thead><tr><th>ID</th><th>file name</th><th>file size</th><th>file format</th><th>Upload date/last download</th><th>Upload IP/downloads </th><th>state</th><th>operation</th></tr></thead>
          <tbody>
<?php
$pagesize=15;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM pre_file WHERE{$sql} order by id desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
	$pwd_ext1='';$pwd_ext2='';
	if(!empty($res['pwd'])){
		$pwd_ext1='&'.$res['pwd'];
		$pwd_ext2='&pwd='.$res['pwd'];
	}
	$fileurl = './down.php/'.$res['hash'].'.'.($res['type']?$res['type']:'file').$pwd_ext1;
	$viewurl = '../en-file.php?hash='.$res['hash'].$pwd_ext2;
echo '<tr><td><input type="checkbox" name="checkbox[]" id="list1" value="'.$res['id'].'" onClick="unselectall1()"><b>'.$res['id'].'</b></td><td><a href="'.$fileurl.'" title="Click on the download"><i class="fa '.type_to_icon($res['type']).' fa-fw"></i>'.$res['name'].'</a>'.(is_view($res['type'])?' <a class="btn btn-xs btn-warning" href="javascript:showfile('.$res['id'].')">preview</a>':null).'</td><td>'.size_format($res['size']).'</td><td><font color="blue">'.($res['type']?$res['type']:'unknown').'</font></td><td>'.$res['addtime'].'<br/>'.$res['lasttime'].'</td><td><a href="https://m.ip138.com/iplookup.asp?ip='.$res['ip'].'" target="_blank" rel="noreferrer">'.$res['ip'].'</a><br/><b>'.$res['count'].'</b></td><td>'.display_status($res['block'], $res['id']).'</td><td><a href="javascript:editframe('.$res['id'].')" class="btn btn-xs btn-info">editor</a>&nbsp;<a href="'.$fileurl.'" class="btn btn-xs btn-warning" target="_blank">Download</a>&nbsp;<a href="javascript:delFile('.$res['id'].')" class="btn btn-xs btn-danger">delete</a></td></tr>';
}
?>
          </tbody>
        </table>
		<label class="checkbox-inline"><input name="chkAll1" type="checkbox" id="chkAll1" onClick="this.value=check1(this.form.list1)" value="checkbox">Future generations</label>&nbsp;&nbsp;<button type="button" onclick="operation()">Delete the selected</button>
      </div>
	  </form>
<?php
echo'<div class="text-center"><ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$first.$link.'\')">Home page</a></li>';
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$prev.$link.'\')">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>Home page</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
$start=$page-10>1?$page-10:1;
$end=$page+10<$pages?$page+10:$pages;
for ($i=$start;$i<$page;$i++)
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$i.$link.'\')">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$end;$i++)
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$i.$link.'\')">'.$i .'</a></li>';
if ($page<$pages)
{
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$next.$link.'\')">&raquo;</a></li>';
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$last.$link.'\')">back</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>back</a></li>';
}
echo'</ul></div>';
