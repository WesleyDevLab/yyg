<!DOCTYPE html>
<html>
<head>
   <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>修改密码 </title>
   <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/login.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/qqlogin.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
	<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
</head>
<style>
.co{height: 40px;
width: 45px;
display: block;
margin: -40px auto;
background: transparent url("statics/templates/quyu-1yygkuan/css/images/icon_all.png") no-repeat scroll 0px 0px / 127px auto; }
.cq{background-position: 0px -26px;}
.registerCon li input {
    width: 90%;
    padding: 0 5%;
}
</style>
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
<div class="n-h-tit"><h1 class="header-logo">修改密码</h1></div>
</div>

</header>





        <section>
		<form class="registerform" method="post" action="<?php echo G_WEB_PATH;?>/home/userpassword">
	        <div class="registerCon">
    	        <ul class="form">
					<li>
						<input name="password" type="password" placeholder="请输入原密码">						
                    </li>
        	        <li>
						<input name="userpassword" type="password" placeholder="请输入新密码">						
                    </li>
        	        <li>
						<input name="userpassword2" type="password" placeholder="请重复输入新密码">					
                    </li>
                    <li style="text-align:center;">
						<input id="btnSubmitSave" type="submit" style="background:#F5484C;border:1px solid #F5484C;color:#FFFFFF;margin-top:20px;border-radius: 5px;" class="bluebut" value="确定修改" >
					</li>
                </ul>
	        </div>
		</form>
        </section>

<script>
$(function(){

    var b = function() {
		var submiting = false;
		var pwd1 = $('input[name=password]');
		var pwd2 = $('input[name=userpassword]');
		var pwd3 = $('input[name=userpassword2]');
		$('#btnSubmitSave').click(function(){
			if (submiting) {
				return false;
			}
			var post = {
				pwd1 : pwd1.val(),
				pwd2 : pwd2.val(),
				pwd3 : pwd3.val()
			};
			if ( post.pwd1 == '' ) {
				$.PageDialog.fail("原密码不能为空哦");
				return false;
			}
			if ( post.pwd2 == '' ) {
				$.PageDialog.fail("新密码不能为空哦");
				return false;
			}
			if ( post.pwd2 != post.pwd3 ) {
				$.PageDialog.fail("两次新密码输入不一致哦");
				return false;
			}
			if ( post.pwd2.length < 6 || post.pwd2.length > 20) {
				$.PageDialog.fail("密码长度为6-20个字符！");
				return false;
			}



		});
	};

    var a = function() {
        Base.getScript(Path.Skin + "/js/mobile/pageDialog.js", b);
    };
    Base.getScript(Path.Skin + "/js/mobile/Comm.js", a);
});

</script>


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
