<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>验证身份 </title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/login.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
	<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
	<script id="pageJS" data="<?php echo ASSET_FONT;?>/js/mobile/MobileCheck.js" language="javascript" type="text/javascript"></script>
</head>
<body>
    <div class="h5-1yyg-v1" id="content">
        
<!-- 栏目页面顶部 -->


<!-- 内页顶部 -->
<header class="header">
<div class="n-header-wrap">
<div class="backbtn">
<a href="javascript:;" onclick="history.go(-1)" class="h-count white">
</a>
</div>
<div class="h-top-right ">
<a href="<?php echo G_WEB_PATH;?>/home" class="h-search white"></a>
</div>
<div class="n-h-tit"><h1 class="header-logo">验证身份</h1></div>
</div>
</header>

        <section>
	        <div class="registerCon">
	            <input type="hidden" id="inpMobile" value="<?php echo $name;?>" />
    	        <ul>
        	        <li><input type="text" id="mobileCode" placeholder="请输入手机验证码" class="rText"/><s class="rs2"></s></li>
                    <li><a href="javascript:void(0);" id="btnPostCode" class="nextBtn  orgBtn" style="margin-top:10px;">确认，下一步</a></li>
                    <li style="font-size:12px;margin: 15px 0px 15px 14px;">如未收到验证短信，请在150秒后点击重新发送。</li>
                    <li><a id="btnGetCode" class="resendBtn grayBtn">重新发送</a></li>
                </ul>
	        </div>
        </section>
        
<script language="javascript" type="text/javascript">
var Path = new Object();
Path.Skin="<?php echo ASSET_FONT;?>";
Path.Webpath = "<?php echo G_WEB_PATH;?>";
  
var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
Base.getScript('<?php echo ASSET_FONT;?>/js/mobile/Bottom.js?v=' + GetVerNum());
</script>

    </div>
</body>
</html>
