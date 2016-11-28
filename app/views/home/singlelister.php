<!doctype html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>我的晒单</title>
<meta content="app-id=518966501" name="apple-itunes-app">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css">
<link href="<?php echo ASSET_FONT;?>/css/mobile/member.css" rel="stylesheet" type="text/css">
<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo ASSET_FONT;?>/jquery.cookie.js"></script>
<meta name="pinggu-site-verification" content="99cdd3d4e37ce0865dd158cab6d87cfb" />
<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
<style type="text/css">
	a.gray9, .gray9{
		border-top: none;
		margin-top: 0;
	}
	.m_listNav{
		border-bottom: none;
	}
	.g-Single-lst .u-sgl-r p{
		text-align: left;
	}
</style>

</head>
<body style="background-color:#F4F4F4;">
<div class="h5-1yyg-v1" id="loadingPicBlock">
    
<!-- 栏目页面顶部 -->
<header class="header">
<div class="n-header-wrap">
<div class="backbtn">
<a href="javascript:;" onclick="history.go(-1)" class="h-count white">
</a>
</div>
<div class="h-top-right ">
<a href="{WEB_PATH}/mobile/home" class="h-search white"></a>
</div>
<div class="n-h-tit"><h1 class="header-logo">我的晒单</h1></div>
</div>
</header>
<!-- 内页顶部 -->

 <div class="g-snav m_listNav">
	    <div class="g-snav-lst"><a id="btnPost" href="<?php echo G_WEB_PATH?>/home/singlelist" class="gray9">已晒单</a><!--<b></b>--></div>
	    <div class="g-snav-lst z-sgl-crt"><a id="btnUnPost" href="<?php echo G_WEB_PATH?>/home/singlelister" class="gray9">未晒单</a></div>
    </div>
    <section id="divUnPost" class="clearfix g-Single-lst z-minheight" style="">
	<?php
	if(empty($record)){
	?>
	<div id="divPostLoad" class="loading"><b></b>暂无记录</div>
	<?php	
	}
	?>



    <ul>
    <?php
    foreach($record as $sd){
    ?>
        <li class="jq_go_sd" sd_id="<?php echo $sd['id'];?>">

		<a class="fl z-Limg">
		<img src="<?php echo G_WEB_PATH.$sd['thumb'];?>" alt="" border="0">
		</a>
		<div class="u-sgl-r gray9">
		<p class="z-sgl-tt">
		<a class="gray6"><ins class="periods">【第一期】</ins><?php echo $sd['title'];?></a>
		</p>
		<p>
		<a href="<?php echo G_WEB_PATH;?>/home/singleinsert/<?php echo $sd['id'];?>" class="z-gds-btn">去晒单</a>
		</p>
		</div>
		<!--<b class="z-arrow"></b>-->
		</li>    
    <?php	
    }
    ?>
    </ul>
    </section>
   
<script>
$(function(){
	$('.jq_go_sd').click(function(){
		var sd_id = $(this).attr('sd_id');
		window.location.href='{WEB_PATH}/mobile/home/singleinsert/'+sd_id;
	})
	$(".subMenu a").click(function(){
		var id=$(".subMenu a").index(this);
		$(".subMenu a").removeClass().eq(id).addClass("current");
		$(".R-content .topic").hide().eq(id).show();
	});
})
function shaidan(id){
	if(confirm("您确认要删除该条信息吗？")){
		window.location.href="{WEB_PATH}/member/home/shaidandel/"+id;
	}
	//FixedConfirm('你确定要删除？',240);
}
/*$("#btnShow6").click(function(){
		FixedConfirm('你确定要删除？',240);
});*/
function FixedConfirm(content,minwidth){
	var div=FixedStar();
		div+='<div id="foucs_close"></div>';
		div+='<div id="foucs_main">';
		div+='<div class="title" style="display:black">提示</div>';
		div+='<div class="content"><div class="PopMsgC"  style="display:black"><s></s>'+content+'</div>';
		div+='<div class="PopMsgbtn" style="display:black">';
		div+='<a class="orangebut" id="btnMsgOK" href="javascript:;">确认</a>&nbsp;&nbsp;';
		div+='<a class="cancelBtn" id="btnMsgCancel" href="javascript:;">取消</a>';
		div+='</div></div></div>';
		div+='</div>';
	$("body").append(div);
	Fixed(minwidth);
	FixedClose();
}
$(function(){
	$(window).resize(function(){
		Fixed();
	})
})
//关闭弹窗
function FixedClose(){
	$("#foucs_close,#page_close,#btnMsgCancel").click(function(){
		$("#foucs_big,#foucs_min,#w3foucs").fadeOut(200,function(){
			$("#foucs_big,#foucs_min,#w3foucs").remove();
		});
	})
};
function FixedStar(){
	var div='<div id="foucs_big"></div>';
		div+='<div id="foucs_min"></div>';
		div+='<div id="w3foucs">';
	return div;
}
function Fixed(w,h){
	var bigheight=document.body.clientHeight,
	    bigwidth=document.body.clientWidth;
	var big=$("#foucs_big"),
	    min=$("#foucs_min");
	var w3foucs=$("#w3foucs");
	if(w==null){
		if(w3foucs.text()!=null){
			w = w3foucs.width();
		}else{
			w = 200;
		}
	}
	if(h==null){
		var h = w3foucs.height();
	}
	big.height(bigheight);
    big.width(bigwidth);
    big.fadeTo(500,0.5);
	min.width(w+14);
    min.height(h+14);
    min.fadeTo(500,0.5);

	w3foucs.css("height",h);
	w3foucs.width(w);
    var t = ($(window).height()/2) - (h/2);
    if(t < 0) t = 0;
    $("#w3foucs,#foucs_min").css({display:"block",position:"fixed"});
	$("#foucs_close").css({display:"block"});
    var l = ($(window).width()/2) - (w/2);
    if(l < 0) l = 0;
    $("#foucs_min").css({left: l-5+'px', top: t-5+'px'});
    w3foucs.css({left: l+'px', top: t+'px'});
}
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