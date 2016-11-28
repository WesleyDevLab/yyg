<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title><?php echo $string;?></title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/cartList.css" rel="stylesheet" type="text/css" />
<script>
function locahost(){
	<?php 
	if($defurl == ':js:'){
	?>
		window.history.back();
	<?php	
	}else{
	?>
		location.href="<?php echo $defurl?>";
	<?php	
	}	
	?>
}

function closeWindow(){window.open('', '_self', '');window.close();}

var i = <?php echo $time;?>;	
if(i!=0){window.close_id = setInterval(function() {if (i > 0) {document.getElementById('time').innerHTML = i;i = i - 1;} else {
		locahost();clearInterval(window.close_id);}}, 1000);}</script>
</script>	
</head>
<body>
    <div class="h5-1yyg-v1">

<!-- 栏目页面顶部 -->


<!-- 内页顶部 -->
<header class="header">
<div class="n-header-wrap">
<div class="backbtn">
<a href="javascript:;" onclick="history.go(-1)" class="h-count white">
</a>
</div>
<div class="h-top-right ">
<a href="<?php echo G_WEB_PATH;?>/mobile/home" class="h-search white"></a>
</div>
<div class="n-h-tit"><h1 class="header-logo">提示</h1></div>
</div>
</header>


<div class="g-pay-auto">
	<div class="z-pay-tips"><b><em class="gray6"><?php echo $string;?></em></b></div>
</div>

<div class="g-pay-auto">
	 <div class="box-button"><a class="a-2" href="javascript:;" onclick="locahost()"><font id="time" style="color:red;"><?php echo $time;?></font>秒后返回上一页面</a><a class="a-1" href="<?php echo $defurl;?>"></a></div> 
</div>





</div>

