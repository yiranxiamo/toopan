<?php
/**
 * 文件预览
**/
include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$id = isset($_GET['id'])?intval($_GET['id']):exit();
$row = $DB->getRow("SELECT * FROM pre_file WHERE id=:id", [':id'=>$id]);
if(!$row)exit();
$name = $row['name'];
$type = $row['type'];
$viewurl = $siteurl.'view.php/'.$row['hash'].'.'.$type;

$type_image = explode('|',$conf['type_image']);
$type_audio = explode('|',$conf['type_audio']);
$type_video = explode('|',$conf['type_video']);

if(in_array($type, $type_image)){
  $filetype = 1;
}elseif(in_array($type, $type_audio)){
  $filetype = 2;
}elseif(in_array($type, $type_video)){
  $filetype = 3;
}else{
  $filetype = 0;
}

@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="renderer" content="webkit">
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?php echo $title ?></title>
  <link href="//cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="//cdn.staticfile.org/aplayer/1.10.1/APlayer.min.css">
  <link href="../assets/css/style.css" rel="stylesheet"/>
  <script src="//cdn.staticfile.org/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
<div class="panel-body" align="center">
<?php
if($filetype==1){
  echo '<a href="'.$viewurl.'" title="点击查看原图" target="_blank"><img alt="loading" src="'.$viewurl.'" class="image_view"></a>';
}elseif($filetype==2){
  echo '<div class="view"><div id="aplayer"></div></div>';
}elseif($filetype==3){
  echo '<div class="videosamplex"><video id="videoplayer"></video></div>';
}else{
  exit;
}
?>
</div>
<?php if($filetype==2){?>
<script type="text/javascript" src="//cdn.staticfile.org/aplayer/1.10.1/APlayer.min.js"></script>
<script type="text/javascript">
var ap1 = new APlayer({
    element: document.getElementById('aplayer'),
    narrow: false,
    autoplay: false,
    showlrc: false,
    mutex: true,
    theme: '#b2dae6',
    music: {
        title: '<?php echo $name?>',
        author: '',
        url: '<?php echo $viewurl?>',
    }
});
</script>
<?php }elseif($filetype==3){?>
<script type="text/javascript" src="../assets/js/ckplayer.min.js"></script>
<script type="text/javascript">
    var videoObject = {
      container: '.videosamplex',
      variable: 'player',
      mobileCkControls:true,
      mobileAutoFull:false,
      h5container:'#videoplayer',
      flashplayer:false,
      video:'<?php echo $viewurl?>'
    };
    var player=new ckplayer(videoObject);
</script>
<?php }?>
</body>
</html>