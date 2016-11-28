<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>设置您的登录密码 - </title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
	<link href="<?php echo ASSET_FONT;?>/css/mobile/login.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
	 <script src="<?php echo ASSET_FONT;?>/js/mobile/pageDialog.js" language="javascript" type="text/javascript"></script>
	<script id="pageJS" data="<?php echo ASSET_FONT;?>/js/mobile/MobileCheck.js" language="javascript" type="text/javascript"></script>
<style>
.registerCon li s.rs3 {
    margin-top: 0;
}
</style>
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
<div class="n-h-tit"><h1 class="header-logo">设置您的登录密码</h1></div>
</div>


  

        <section>
		<form class="registerform" method="post" action="<?php echo G_WEB_PATH;?>/finduser/resetpassword" onsubmit="return checkform();">
        <div class="registerCon">
	        <ul>
				<li><input name="hidKey" type="hidden" id="hidKey" value="<?php echo $key;?>">
					<p class="Ptxt_F14">请重新设置您的登录密码，您的帐号是：<span class="orange Fb"><?php echo $checkcode[0];?></span></p>
				</li>

				<li><input name="userpassword" type="password" id="txtPassword" placeholder="新密码" class="rText" required><s class="rs3"></s>
				</li>
				<li><input name="userpassword2" type="password" id="txtPassword2" placeholder="确认密码" class="rText" required><s class="rs3"></s>
				</li>
                <li><input type="submit"  id="submitBtn" style="background:#EF6000;color:#FFFFFF" name="submit" class="login_Email_but" value="确认修改" /></li>



			</ul>
        </div>
		</form>
        </section>
  <script>
	
    function checkform(){
		var txtPassword = $('#txtPassword').val();
		var txtPassword2 = $('#txtPassword2').val();

		if(!txtPassword || txtPassword.length < 6 || txtPassword.length > 20){
			$.PageDialog.fail('密码小于6位或大于20位');
			return false;
		} else if (!txtPassword2 || txtPassword != txtPassword2) {
			$.PageDialog.fail('两次密码输入不一致');
			return false;
		}
		return true;
    	
    }


</script>      
﻿