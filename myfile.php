<?php
include("./includes/common.php");

$title = '我的文件 - ' . $conf['title'];
include SYSTEM_ROOT.'header.php';
?>
<style type="text/css">
</style>
<div class="container">
        <h2>我上传的文件<small>（根据浏览器缓存记录，私密文件请备留文件地址）</small></h2>
        <div class="table-responsive">
       <table class="table table-striped table-hover ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>操作</th>
                    <th>文件名</th>
                    <th>文件大小</th>
                    <th>文件格式</th>
                    <th>上传时间</th>
                    <th>上传者IP</th>
                </tr>
            </thead>
            <tbody>
<?php
if(isset($_SESSION['fileids']) && count($_SESSION['fileids'])>0){
    $ids = implode(',',$_SESSION['fileids']);
    $numrows=$DB->getColumn("SELECT count(*) from pre_file WHERE id IN($ids)");
    $pagesize=15;
    $pages=ceil($numrows/$pagesize);
    $page=isset($_GET['page'])?intval($_GET['page']):1;
    $offset=$pagesize*($page - 1);
    
    $rs=$DB->query("SELECT * FROM pre_file WHERE id IN($ids) order by id desc limit $offset,$pagesize");
    $i=1;
    while($res = $rs->fetch())
    {
        $fileurl = './down.php/'.$res['hash'].'.'.($res['type']?$res['type']:'file');
        $viewurl = './file.php?hash='.$res['hash'];
    echo '<tr><td><b>'.$i++.'</b></td><td><a href="'.$fileurl.'" class="btn btn-xs btn-warning">下载</td><td><a href="'.$viewurl.'" target="_blank" class="btn btn-xs btn-info">管理</a><a href="'.$viewurl.'" target="_blank"><i class="fa '.type_to_icon($res['type']).' fa-fw"></i>'.$res['name'].'</td><td>'.size_format($res['size']).'</td><td><font color="blue">'.($res['type']?$res['type']:'未知').'</font></td><td>'.$res['addtime'].'</td><td>'.preg_replace('/\d+$/','*',$res['ip']).'</b></td></tr>';
    }
}else{
    echo '<tr><td colspan="7" align="center">你还没上传过文件</td></tr>';
}

?>
            </tbody>
        </table>
        </div>
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
echo '<li><a href="myfile.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="myfile.php?page='.$prev.$link.'">上一页</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>上一页</a></li>';
}
$start=$page-10>1?$page-10:1;
$end=$page+10<$pages?$page+10:$pages;
for ($i=$start;$i<$page;$i++)
echo '<li><a href="myfile.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$end;$i++)
echo '<li><a href="myfile.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="myfile.php?page='.$next.$link.'">下一页</a></li>';
echo '<li><a href="myfile.php?page='.$last.$link.'">尾页</a></li>';
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
</div>
    </div>
  </div>
<?php include SYSTEM_ROOT.'footer.php';?>
