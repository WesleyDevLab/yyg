<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>一元购_新手指南</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="<?php echo ASSET_FONT;?>/images/mobile/touch-icon.png" rel="apple-touch-icon-precomposed" />
    <link href="favicon.ico" rel="shortcut icon" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/new.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo ASSET_FONT;?>/jquery190.js"></script>
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
<body>
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

	<!--
	<header class="header">
        <div class="n-header-wrap">
            <div class="backbtn">
				<a href="javascript:;" onclick="history.go(-1)" class="h-count white"></a>
			</div>
			<div class="n-h-tit"><h1 class="header-logo">新手指南</h1></div>
			<a class="share_item" href="javascript:void();"></a>
        </div>
    </header>
	-->
	<div class="newbie_guide">
		<p><img src="<?php echo ASSET_FONT;?>/css/images/guide_bg.png"></p>
		<p><img src="<?php echo ASSET_FONT;?>/css/images/guide_1.png"></p>
		<p><img src="<?php echo ASSET_FONT;?>/css/images/guide_2.png"></p>
		<p><img src="<?php echo ASSET_FONT;?>/css/images/guide_3.png"></p>
		<div class="newbie_rule">
			<img src="<?php echo ASSET_FONT;?>/css/images/guide_bottombg.png" class="method_bg">
			<div class="playing_method">
				<h3>玩法规则</h3>
				<p class="play_rule">根据用户购买时间的先后次序依次产生购买号码；</p>
				<p class="play_rule">随机抽取得到幸运码，购买号码与幸运码一致表示获得该商品；</p>
				<p class="play_rule">填写收货地址,等待收取快递；</p>
			</div>
		</div>
	</div>


</body>
</html>
