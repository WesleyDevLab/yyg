<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>绑定手机号</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/login.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/new.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
	<script id="pageJS" data="<?php echo ASSET_FONT;?>/js/mobile/Register.js" language="javascript" type="text/javascript"></script>
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
<div class="n-h-tit">
    <h1 class="header-logo">
        <?php
        if(!empty($member['mobile'])){
            echo "修改绑定手机号";
        }else{
            echo "绑定手机号";
        }
        ?>
    </h1>
</div>
</div>
</header>

        <section>
        <div class="registerCon">
            <?php
            if(!empty($member['mobile'])){
            ?>
                <div class="linked_phone">
                    <sapn>已绑定手机号:<ins class="linked_number"><?php echo $member['mobile'];?></ins></sapn>
                </div>           
            <?php    
            }
            ?>
			<form method="post" action="<?php echo G_WEB_PATH;?>/home/mobilecheck">
		        <ul>
	    	        <li>
	    	        	<input name="mobile" id="mobile" type="tel" placeholder="请输入新手机号" class="rText"><!--<s class="rs1"></s>-->
					</li>
					<li style="margin-bottom: 20px;">
	    	        	<input name="verification_code" type="verification_code" placeholder="请输入验证码" style="width:60%;float:left;padding-left:30px;">
	    	        	<input type="button" value="获取验证码" class="gain_code" id="btnSendCode" style="width:30%;float:left;"/>
					</li>
					<div class="alert_content"></div>
					<input type="submit" name="submit" class="nextBtn  orgBtn" value="确认" style="width:90%;margin:0 auto;">
	            </ul>
			</form>
			<div class="warm_prompt">
	        	<span>为保护你的账户安全，更换号码需对你已绑定的手机号码进行验证</span> 	
	        </div>
        </div>
        </section>
        

<script language="javascript" type="text/javascript">
var Path = new Object();
Path.Skin="<?php echo ASSET_FONT;?>";
Path.Webpath = "<?php echo G_WEB_PATH;?>";
  
var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
Base.getScript('<?php echo ASSET_FONT;?>/js/mobile/Bottom.js?v=' + GetVerNum());

var InterValObj; //timer变量，控制时间
var curCount = 60;//当前剩余秒数

//timer处理函数
function SetRemainTime() {
    if (curCount == 0) {
        window.clearInterval(InterValObj);//停止计时器
        $("#btnSendCode").val("获取验证码");
    }
    else {
        curCount--;
        $("#btnSendCode").val("已发送(" + curCount + ")");
    }
}

//获取手机验证码
$(function(){
    $('#btnSendCode').click(function(){
        var mobile = $('#mobile').val();
        if( mobile.length <= 0 ){
            $(".alert_content").textContent("*手机号码必须填写");
            return false;
        }
        $.post("<?php echo G_WEB_PATH;?>/home/sendmobilecode", {mobile:mobile}, function(data){
            console.log(data);
            if(data.code == 200 ){
                //设置button效果，开始计时
                $('#btnSendCode').val("已发送(" + curCount + ")");
                InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
            }else{
                $(".alert_content").textContent("*发送失败");
            }
        }, 'json');
        return false;
    });
});
</script>
 
    </div>
</body>
</html>