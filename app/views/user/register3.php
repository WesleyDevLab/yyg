<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>注册 </title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/login.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
   	<link rel="stylesheet" href="../../../html/css/new.css">
</head>
<body>
    <div class="h5-1yyg-v1" id="content">
        
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
<div class="n-h-tit"><h1 class="header-logo">注册</h1></div>
</div>
</header>
    <section>
        <div class="registerCon">
	        <ul>
    	        <li><input id="userMobile" type="text" placeholder="请输入用户名" class="rText"><s class="rs1"></s></li>
				<li><input type="password" id="txtPassword" placeholder="密码" class="rText"><s class="rs2"></s></li>
                <!--<li><s class="rs3"></s></li>-->
                <li><a id="btnNext" class="nextBtn  orgBtn" style="margin-top:10px;padding-left:10%;">下一步</a></li>
                <li style="margin-top:10px;"><span id="isCheck"><em></em>我已阅读并同意</span><a href="<?php echo G_WEB_PATH;?>/html/xieyi"> 惠玩车用户服务协议</a></li>
            </ul>
        </div>
        <div class="register_hint">
        	<h2>温馨提示</h2>
        	<span>微信账号非手机注册则无法领取元宝，建议您用手机注册并“领取10元宝”</span>
        </div>
    </section>
        
<script language="javascript" type="text/javascript">
var Path = new Object();
Path.Skin="<?php echo ASSET_FONT;?>";
Path.Webpath = "<?php echo G_WEB_PATH;?>";
  
var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
Base.getScript('<?php echo ASSET_FONT;?>/js/mobile/Bottom.js?v=' + GetVerNum());


$(document).ready(function(){
	$('#btnNext').click(function(){
		var username = $('#userMobile').val();
		var pass = $('#txtPassword').val();

		if(username=='' || pass == ''){
			$.PageDialog.fail('用户名或密码不能为空');
		}
		$.ajax({
		   type: "POST",
		   url:'<?php echo G_WEB_PATH?>/user/regAjax',
		   data:"username="+username+"&pass="+pass,
		   success: function(data){
		   	 data = $.parseJSON(data);
		     if(data.code=='200'){
		     	$.PageDialog.ok('注册成功');
		     	window.location.href="<?php echo G_WEB_PATH;?>"
		     }else{
		     	$.PageDialog.fail(data.msg);
		     }
		   }
		});		


	})	
	
})

</script>
 
    </div>
</body>
</html>