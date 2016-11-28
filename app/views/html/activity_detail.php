<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
    <title>活动详情</title>
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/goods.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
    <script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
    <script type="text/javascript">
    	$(function(){
			$(".share_item").click(function(){
				$(".weui_mask_transparent").show();
				$(".share_popup").css("display","block");
				$("body,html").css({"overflow":"hidden"});
			});
			$("#btnSubmit").click(function(){
				$(".weui_mask_transparent").hide();
				$(".share_popup").hide();
				$("body,html").css({"overflow":"visible"});
			});
		});
    </script>

</head>
<body style="background-color:#DB2C01;">
	<!--分享弹出框-->
	<div class="weui_mask_transparent"></div>
	<div class="share_popup">
		<div class="share_where">
			<ul>
				<li>
					<a class="xinlang" href="javascript:void((function(s,d,e){try{}catch(e){}var f='http://v.t.sina.com.cn/share/share.php?',u=d.location.href,p=['url=',e(u),'&title=',e(d.title),'&appkey=2924220432'].join('');function a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=620,height=450,left=',(s.width-620)/2,',top=',(s.height-450)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent)){setTimeout(a,0)}else{a()}})(screen,document,encodeURIComponent));">
					</a>
					<p>新浪微博</p>
				</li>
				<li>
					<a href="javascript:void(0);" class="koukou" onclick="window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+encodeURIComponent(document.location.href));return false;" 
					title="分享到QQ空间"></a>
					<p>QQ空间</p>
				</li>
				<li>
					<a href="javascript:void(0)" onclick="postToWb();" class="tengxun"></a> 
					<script type="text/javascript">
					function postToWb(){					 
					var _t = encodeURI(document.title);					 
					var _url = encodeURI(document.location);					 
					var _appkey = encodeURI("appkey");//你从腾讯获得的appkey					 
					var _pic = encodeURI('');//（列如：var _pic='图片url1|图片url2|图片url3....）					 
					var _site = '';//你的网站地址					 
					var _u = 'http://v.t.qq.com/share/share.php?title='+_t+'&url='+_url+'&appkey='+_appkey+'&site='+_site+'&pic='+_pic;					 
					window.open( _u,'转播到腾讯微博', 'width=700, height=680, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, location=yes, resizable=no, status=no' );					 
					}
					</script>
					</a><p>腾讯微博</p>
				</li>
				<li>					
					<a class="jiathis_button_renren renren"></a>											
					<p>人人网</p>
					<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js" charset="utf-8"></script>
				</li>
			</ul>
		</div>
		<div class="mt10 f-Recharge-btn"> 
			<a id="btnSubmit" href="javascript:;" class="orgBtn" onclick="share_popup.style.display='none'">取消</a> 
		</div>	
	</div>
	<header class="header">
	    <div class="n-header-wrap">
	        <div class="backbtn">
	            <a href="javascript:;" onclick="history.go(-1)" class="h-count white">
	            </a>
	        </div>
	        <div class="n-h-tit"><h1 class="header-logo">活动详情</h1></div>
	        <a class="share_item" href="javascript:void();"></a>
	    </div>
	</header>
	 	   
    <div class="FAQ_item">
    	<div class="activity_theme"><img src="<?php echo ASSET_FONT;?>/images/activity_bg.jpg"></div>
        <div class="join_way">
        	<div class="participate">活动详情</div>
        	<div class="activity_rule">
	            <p>1、注册成功即送10元宝</p>
	            <p>2、可分享到QQ.微博等第三方软件</p>
	            <p>3、本活动最终解释权归惠玩车所有。</p>
            </div>
        </div>
        <div class="annotation">本活动仅针对真实用户开放，任何恶意注册公司有权取消其优惠资格</div>
    </div>
</body>
</html>
