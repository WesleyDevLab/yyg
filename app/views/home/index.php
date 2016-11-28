<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
    <title>个人中心</title>
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css?v=130715" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/member.css?v=130726" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/new.css?v=130726" rel="stylesheet" type="text/css" />
    <script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
</head>
<style>
    .u-mbr-info li {
        width: 100%;
        line-height: 55px;
        padding: 3px 0;
        float: left;
        text-align: left;
        text-indent: 5px;
    }
    .m-name-info{
    	border-left:none;
    }
    a.fr.z-Recharge-btn{
    	border:1px solid #F5484C;
    	background-color: #fff;
    	color:#F5484C;
    	padding:1px 10px;
    	border-radius: 5px;
    }
    .u-name {
	    height: 32px;
	    line-height: 47px;
	}
</style>

<body>
<div class="h5-1yyg-v11">   
<!-- 栏目页面顶部 -->
<!-- 内页顶部 -->
<header class="header">
	<div class="n-header-wrap">
		<div class="backbtn">
			<a href="javascript:;" onClick="history.go(-1)" class="h-count white"></a>
		</div>		
		<div class="n-h-tit"><h1 class="header-logo" >个人中心</h1></div>
	</div>
</header>
    <section class="clearfix g-member">
		<div class="clearfix m-round m-name jq_click">
			<div class="fl f-Himg" id="preview">
				<a href="javascript:void(0);" class="z-Himg">
                    <?php
                        if(strpos($member['img'],'http://')!== false){
                        ?>
                        <img src="<?php echo $member['img'];?>" id="imghead" border=0/>
                        <?php    
                        }else{
                        ?>
                        <img src="<?php echo G_WEB_PATH.$member['img'];?>" id="imghead" border=0/>
                        <?php    
                        }
                    ?>
                    
                </a>
			</div>

			<div class="m-name-info">
				<p class="u-name"><a class="z-name gray01" href="javascript:void(0);"><?php echo $member['user'];?></a></p>
				<ul class="clearfix u-mbr-info">
		
				<li><span style="color:#F5484C;">元宝 <?php echo $member['money'];?></span>
				<a style="margin-right:10px;" href="<?php echo G_WEB_PATH;?>/cart/userrecharge" class="fr z-Recharge-btn">充值</a></li>
				</ul>
			</div>
		</div>
	    <div class="m-round m-member-nav">
			<ul id="ulFun">
                <li class="home_record"><a href="<?php echo G_WEB_PATH;?>/home/userbuylist"><b class="z-arrow"></b>我的惠玩车记录</a></li>
                <li class="home_commodity"><a href="<?php echo G_WEB_PATH;?>/home/orderlist"><b class="z-arrow"></b>获得的商品</a></li>
                <!--<li class="home_shai"><a href="<?php echo G_WEB_PATH;?>/home/singlelist"><b class="z-arrow"></b>我的晒单</a></li>-->
                <li class="home_detail"><a href="<?php echo G_WEB_PATH;?>/home/userbalance"><b class="z-arrow"></b>帐户明细</a></li>
                <li class="home_bask"><a href="<?php echo G_WEB_PATH;?>/home/mywish"><b class="z-arrow"></b>我的心愿</a></li>
				<li class="home_shai"><a href="<?php echo G_WEB_PATH;?>/home/mysotre"><b class="z-arrow"></b>我的收藏</a>
				<!--<li><a href="http://wx.91k8.me/index.php/mobile/invite/friends"><img src="http://wx.91k8.me/statics/templates/yungou/css/images/play_car.png"><b class="z-arrow"></b>邀请管理</a></li>-->
                			
			</ul>
	    </div>
	    
    </section>


 

<script type="text/javascript">
$(document).ready(function(){
    $('.jq_click').click(function(){
        window.location.href="<?php echo G_WEB_PATH.'/home/edit_user/'.$member['uid'];?>";
    })

})
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
