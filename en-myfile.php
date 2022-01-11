<?php
include("./includes/common.php");

$title = 'My file - ' . $conf['title'];
include SYSTEM_ROOT.'en-header.php';
?>
<style type="text/css">
</style>
<div class="container">
        <h2>I uploaded the file<small>（browser cache records, please keep the file address for private files）</small></h2>
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
                    <th>uploader IP</th>
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
        $fileurl = './en-down.php/'.$res['hash'].'.'.($res['type']?$res['type']:'file');
        $viewurl = './en-file.php?hash='.$res['hash'];
    echo '<tr><td><b>'.$i++.'</b></td><td><a href="'.$fileurl.'" class="btn btn-xs btn-warning">download</a></td><td><a href="'.$viewurl.'" target="_blank" class="btn btn-xs btn-info">management</a><a href="'.$viewurl.'" target="_blank"><i class="fa '.type_to_icon($res['type']).' fa-fw"></i>'.$res['name'].'</td><td>'.size_format($res['size']).'</td><td><font color="blue">'.($res['type']?$res['type']:'unknown').'</font></td><td>'.$res['addtime'].'</td><td>'.preg_replace('/\d+$/','*',$res['ip']).'</b></td></tr>';
    }
}else{
    echo '<tr><td colspan="7" align="center">There are no files you uploaded</td></tr>';
}

?>
            </tbody>
        </table>
        </div>
        <div class="row">
        <div class="col-md-6"><br>A total of <?php echo $numrows?> A file，&nbsp;&nbsp;The current first <?php echo $page?> page，A total of <?php echo $pages?> page</div>
        <div class="col-md-6"><nav>
  <ul class="pagination pagination-sm" style="float:right;">
<?php
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="en-myfile.php?page='.$first.$link.'">Home page</a></li>';
echo '<li><a href="en-myfile.php?page='.$prev.$link.'">previous page</a></li>';
} else {
echo '<li class="disabled"><a>Home page</a></li>';
echo '<li class="disabled"><a>previous page</a></li>';
}
$start=$page-10>1?$page-10:1;
$end=$page+10<$pages?$page+10:$pages;
for ($i=$start;$i<$page;$i++)
echo '<li><a href="en-myfile.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$end;$i++)
echo '<li><a href="en-myfile.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="en-myfile.php?page='.$next.$link.'">next page</a></li>';
echo '<li><a href="en-myfile.php?page='.$last.$link.'">back</a></li>';
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
</div>
    </div>
  </div>
<?php include SYSTEM_ROOT.'en-footer.php';?>
