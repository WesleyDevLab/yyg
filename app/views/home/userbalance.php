<!DOCTYPE html>
<html>
<head><title>
	账户明细
</title>
<meta content="app-id=518966501" name="apple-itunes-app" /><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" /><meta content="yes" name="apple-mobile-web-app-capable" /><meta content="black" n/cssame="apple-mobile-web-app-status-bar-style" /><meta content="telephone=no" name="format-detection" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/member.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
	<script id="pageJS" data="<?php echo ASSET_FONT;?>/js/mobile/consumptionlist.js" language="javascript" type="text/javascript"></script>


	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
</head>
<style type="text/css">
	.m-name{
		background-color:#fff;
	}
</style>
<body>
<div class="h5-1yyg-v1" id="loadingPicBlock">
	<input name="loadDataType" type="hidden" id="loadDataType" value="0" />

	<!-- 栏目页面顶部 -->


	<!-- 内页顶部 -->
	<header class="header">
		<div class="n-header-wrap">
	        <div class="backbtn">
	            <a href="javascript:;" onClick="history.go(-1)" class="h-count white">
	            </a>
	        </div>
			<div class="h-top-right ">
				<!--<a href="{WEB_PATH}/mobile/home" class="h-search white"></a>-->
			</div>
			<div class="n-h-tit"><h1 class="header-logo">帐户明细</h1></div>
			<a style="margin-top: 10px;margin-right:-15px;color:white; " href="<?php echo G_WEB_PATH;?>/cart/userrecharge" class="fr z-Recharge-btn">充值</a>
		</div>
	</header>
	
	<section class="clearfix g-member">
<style>
.u-mbr-info li {
    width: 100%;
    line-height: 30px;
    padding: 3px 0;
    float: left;
    text-align: left;
    text-indent: 5px;
    box-shadow: -1px 0 0 #EFEFEF inset;
    /*color: #ffba00;*/
    font-size: 14px;
}
.u-mbr-info .mybeans {
    border: 0px solid red;
    text-align: center;
    height: 95px;
    padding-top: 36px;
    vertical-align: middle;
}
.u-mbr-info .mybeans span{
	font-size: 1.6rem;
}
.u-mbr-info .beans{
	border:0px solid red;
	border-top:1px solid #EFEFEF;

}
.beans div {
    width: 50%;
    float: left;
    text-align: center;
}
.u-mbr-info .beans .convalue{
	font-size:1.3rem;
}
.u-mbr-info .beans .convalue .colue{
	color:#F5484C;
	font-size: 16px;
}

.u-mbr-info .beans .rechvalue{
	font-size:1.3rem;
}
.u-mbr-info .beans .rechvalue .relue{
	color:#F5484C;
	font-size: 16px;;
}
</style>
	    <div class="clearfix m-round m-name">
			<!--<div class="fl f-Himg">-->
				<!--<a href="{WEB_PATH}/mobile/mobile/userindex/{wc:$member['uid']}" class="z-Himg">-->
				<!--<img src="{G_UPLOAD_PATH}/{wc:fun:get_user_key($member['uid'],'img')}" border=0/></a>-->
				<!--<span class="z-class-icon01 gray02">{wc:$member['yungoudj']}</span>-->
			<!--</div>-->
			<!--<div class="fl f-Himg">-->
				<!--<a href="{WEB_PATH}/mobile/mobile/userindex/{wc:$member['uid']}" class="z-Himg">-->
				<!--<img src="{G_UPLOAD_PATH}/{wc:fun:get_user_key($member['uid'],'img')}" border=0/></a>-->
				<!--&lt;!&ndash;<span class="z-class-icon01 gray02">{wc:$member['yungoudj']}</span>&ndash;&gt;-->
			<!--</div>-->
			<div><p class="u-name">
				<!--<b class="z-name gray01">{wc:fun:get_user_name($member['uid'])}</b>--></p>
				<ul class="clearfix u-mbr-info">
				<li style="font-size:15px; " class="mybeans"><span>我的元宝</span> <div class="orange" style="font-size:28px;"><?php echo $member['money'];?></div></li>
				<li class="beans"><div class="convalue"><p class="colue"><?php echo $xfsum;?></p> <p class="consumption">累计消费（元宝）</p></div>
				<div class="rechvalue"><p class="relue"><?php echo $czsum;?></p> <p class="recharge">累计充值（元宝）</p></div></li>
				<!--<a style="margin-top: 15px;margin-right:10px;" href="{WEB_PATH}/mobile/home/userrecharge" class="fr z-Recharge-btn">去充值</a></li>-->

				</ul>
			</div>
		</div>
		<div class="m-userMoneyNav">
			<li><a id="btnConsumption" href="javascript:;"><b>消费明细</b></a><s></s></li>
			<li><a id="btnRecharge" href="javascript:;"><b>充值明细</b></a></li>
		</div>
		<article class="mt10 m-round">
			<ul id="ulConsumption" class="m-userMoneylst m-Consumption">
			</ul>
			<ul id="ulRechage" class="m-userMoneylst" style="display:none;">
			</ul>
			<div id="divLoad" class="loading"><b></b>正在加载</div>
			<a id="btnLoadMore" class="loading" href="javascript:;" style="display:none;">点击加载更多</a>
		</article>
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

