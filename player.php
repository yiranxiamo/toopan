<?php
include("./includes/common.php");

$hash = isset($_GET['hash'])?trim($_GET['hash']):exit();
$row = $DB->getRow("SELECT * FROM pre_file WHERE hash=:hash", [':hash'=>$hash]);
if(!$row)exit('404 Not Found');
if($row['block']!=0)exit('File is blocked!');
$name = $row['name'];
$type = $row['type'];
$viewurl = $siteurl.'view.php/'.$row['hash'].'.'.$type;

$type_audio = explode('|',$conf['type_audio']);
$type_video = explode('|',$conf['type_video']);

if(in_array($type, $type_audio)){
    $title = '音乐播放器 - '.$conf['title'];
    $filetype = 2;
}elseif(in_array($type, $type_video)){
    $title = '视频播放器 - '.$conf['title'];
    $filetype = 3;
}else{
    exit('NO player');
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
  <link rel="stylesheet" href="//cdn.staticfile.org/aplayer/1.10.1/APlayer.min.css">
  <script src="//cdn.staticfile.org/jquery/2.1.4/jquery.min.js"></script>
<style type="text/css">
 body {
 margin:0px 0px 0px 0px;
}
</style> 
</head>
<body>
<div id="preview" align="center">
<?php
if($filetype==2){
  echo '<div id="aplayer"></div>';
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
<script type="text/javascript" src="./assets/js/ckplayer.min.js"></script>
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