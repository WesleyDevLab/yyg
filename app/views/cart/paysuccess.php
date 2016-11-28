<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>购买成功</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta name="CMBNETPAYMENT" content="China Merchants Bank">
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css?v=20150129" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/cartList.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
	<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
</head>
<body>
    <div class="h5-1yyg-v1">

<!-- 栏目页面顶部 -->


<!-- 内页顶部 -->
<header class="header">
<div class="n-header-wrap">
<div class="backbtn">
<a href="javascript:;" onClick="history.go(-1)" class="h-count white">
</a>
</div>
<div class="h-top-right ">
<a href="<?php echo G_WEB_PATH;?>/home" class="h-search white"></a>
</div>
<div class="n-h-tit"><h1 class="header-logo">1元淘结果</h1></div>
</div>
</header>



        <input name="hidShopID" type="hidden" id="hidShopID" value="131118151938166319">
        <section id="shopResultBox" class="clearfix g-pay-success">
		<div class="g-pay-auto">
		<div class="z-pay-tips"><s></s><b><em class="gray6">支付成功，请等待系统为您揭晓！</em></b></div>
		</div>
		<div class="u-Btn"><div class="u-Btn-li"><a href="<?php echo G_WEB_PATH;?>/home/userbuylist" class="z-CloseBtn">查看1元淘记录</a></div><div class="u-Btn-li"><a href="<?php echo G_WEB_PATH;?>" class="z-DefineBtn">继续购物</a></div></div>
		</section>
    </div>


<script language="javascript" type="text/javascript">
var Path = new Object();
Path.Skin="<?php echo ASSET_FONT;?>";
Path.Webpath = "<?php echo G_WEB_PATH;?>";

var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
Base.getScript('<?php echo ASSET_FONT;?>/js/mobile/Bottom.js?v=' + GetVerNum());
</script>

</body>
</html>
