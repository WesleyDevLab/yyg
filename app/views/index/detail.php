<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="app-id=518966501" name="apple-itunes-app" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
	<meta content="yes" name="apple-mobile-web-app-capable" />
	<meta content="black" name="apple-mobile-web-app-status-bar-style" />
	<meta content="telephone=no" name="format-detection" />
	<title>商品详情</title>
	<link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css?v=20150129" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/goods.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/top.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/new.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
    <script src="<?php echo ASSET_FONT;?>/js/mobile/pageDialog.js" language="javascript" type="text/javascript"></script>
    <script src="<?php echo ASSET_FONT;?>/js/mobile/goods.js" language="javascript" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo ASSET_FONT;?>/jquery.cookie.js"></script>
      
<style type="text/css">
.count_zero b{color:#fff;}
.participation_detail img{
    width: 40px;
    height: 40px;
    margin: 2px 0 0 3px;
}
.weui_mask_transparent {
    position: fixed;
    z-index: 100;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.6);
    display: none;
}
.share_pop {
    position: absolute;
    right: 19px;
    top: 44px;
    z-index: 10000;
    display: none;
}
.weui_mask_transparent {
    position: fixed;
    z-index: 60;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.6);
}
/**请选择参与人次弹出框**/
.choose_people {
    border-top: 3px solid #F5484C;
    position: fixed;
    width: 94%;
    bottom: 0;
    background-color: #fff;
    z-index: 999999;
    padding: 0% 3% 3%;
    color: #9c9c9c;
    text-align: center;
}
.choose_people h2{
    border-bottom: 1px solid #eee;
    line-height: 40px;
    text-align: left;
}
.surplus {
    width: 100%;
    text-align: center;
    line-height: 12px;
    height: 30px;
}
ins.doudou {
    color: #F5484C;
}
a.confirm_btn {
    color: #fff;
    font-size: 16px;
    width: 100%;
    background-color: #F5484C;
    text-align: center;
    padding: 5px 0;
    border-radius: 10px;
    display: block;
}
.number_various {
    margin-top: 15px;
    text-align: center;
}
a.reduce {
    float: left;
}
input.person_time {
    width: 70%;
    border: 1px solid #ccc;
    background-color: #eee;
    height: 28px;
    text-align: center;
    margin: 0 auto;
}
a.plus {
    float: right;
}
.person_number {
    width: 80%;
    text-align: center;
    margin: 0 auto;
}
.person_number ul {
    width: 100%;
}
.person_number li {
    width:45px;
    text-align: center;
    display: inline-block;
}
.justify_list{text-align: justify;text-justify:distribute-all-lines;}
.justify_list:after {width: 100%;height: 0;margin: 0;display: inline-block;overflow: hidden;content: '';}
a.selected {
    background-color: #f00;
    color: #fff;
    border: none;
}
.person_number a {
    border: 1px solid #ccc;
    padding: 3px 10px;
    display: inline-block;
    border-radius: 5px;
    width: 23px;
    color:#999;
}
.choose_number {
    float: left;
    width: 80%;
    margin-bottom: 10px;
    padding: 0 10%;
}
.clear{clear: both;}
.roby-go-buy{
   height:35px;
   width:90%;
   line-height: 35px;
   border-radius: 5px;
   color: #fff;
   font-size:16px;
   text-align: center;
   margin: 15px auto 10px;
   background: #F5484C;
}
a.closed_btn {
    position: absolute;
    right: 5px;
    top: -5px;
    font-size: 29px;
    display: block;
    color: #999;
    font-weight: 400;
}
.join_time{
    float: right;
}
a#not_online{
    top:0;
    right:0;
}



.participation_detail img{
    width: 40px;
    height: 40px;
    margin: 2px 0 0 3px;
}
.weui_mask_transparent {
    position: fixed;
    z-index: 100;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.6);
    display: none;
}
.share_pop {
    position: absolute;
    right: 19px;
    top: 44px;
    z-index: 10000;
    display: none;
}
.weui_mask_transparent {
    position: fixed;
    z-index: 60;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.3);
}
.roby-go-buy{
   height:35px;
   width:90%;
   line-height: 35px;
   border-radius: 5px;
   color: #fff;
   font-size:16px;
   text-align: center;
   margin: 15px auto 10px;
   background: #F5484C;
}
</style>
</head>
<script type="text/javascript" >
	$(function(){
		$(".share").click(function(){
			$(".weui_mask_transparent").show();
			$(".share_pop").show();
			$("body,html").css({"overflow":"hidden"});
		});
		$(".share_pop").click(function(){
			$(".share_pop").hide();
			$("body,html").css({"overflow":"visible"});
		});
		
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
<!--分享-->
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{},"image":{"viewList":["weixin","tsina","qzone","tqq"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","tsina","qzone","tqq"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script> 
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script> 
<script>  
  var url = "http://ygtest.98czs.net/";  
    var desc_ = "惠玩车-一元购";        
    function tencentWeiBo(){  
         var _url = "http://ygtest.98czs.net/";     
         var _showcount = 0;  
         var _summary = "";  
         var _title = desc_;  
         var _site = "http://ygtest.98czs.net/";    
         var _width = "600px";  
         var _height = "800px";  
         var _pic = "http://ygtest.98czs.net/uploads/allimg/150510/1-150510104044.jpg";  
         var _shareUrl = 'http://share.v.t.qq.com/index.php?c=share&a=index';  
         _shareUrl += '&title=' + encodeURIComponent(_title||document.title);    //分享的标题  
         _shareUrl += '&url=' + encodeURIComponent(_url||location.href);    //分享的链接  
         _shareUrl += '&appkey=5bd32d6f1dff4725ba40338b233ff155';    //在腾迅微博平台创建应用获取微博AppKey  
         //_shareUrl += '&site=' + encodeURIComponent(_site||'');   //分享来源  
         _shareUrl += '&pic=' + encodeURIComponent(_pic||'');    //分享的图片，如果是多张图片，则定义var _pic='图片url1|图片url2|图片url3....'  
         window.open(_shareUrl,'width='+_width+',height='+_height+',left='+(screen.width-_width)/2+',top='+(screen.height-_height)/2+',toolbar=no,menubar=no,scrollbars=no,resizable=1,location=no,status=0');  
    }      
    var top = window.screen.height / 2 - 250;    
    var left = window.screen.width / 2 - 300;    
    var height = window.screen.height;  
    var width =  window.screen.width;   
    /*title是标题，rLink链接，summary内容，site分享来源，pic分享图片路径,分享到新浪微博*/    
    
     function qqFriend() {  
            var p = {  
                url : 'http://ygtest.98czs.net/', /*获取URL，可加上来自分享到QQ标识，方便统计*/  
                desc:'',  
                //title : '新玩法，再不来你就out了！', /*分享标题(可选)*/  
                title:desc_,  
                //summary : '', /*分享摘要(可选)*/  
                pics : 'http://ygtest.98czs.net//uploads/allimg/150510/1-150510104044.jpg', /*分享图片(可选)*/  
                flash : '', /*视频地址(可选)*/  
                site : 'http://ygtest.98czs.net/', /*分享来源(可选) 如：QQ分享*/  
                style : '201',  
                width : 32,  
                height : 32  
            };  
            var s = [];  
            for ( var i in p) {  
                s.push(i + '=' + encodeURIComponent(p[i] || ''));  
            }  
            var url = "http://connect.qq.com/widget/shareqq/index.html?"+s.join('&');  
            return url;  
            //window.location.href = url;  
            //document.write(['<a class="qcShareQQDiv" href="http://connect.qq.com/widget/shareqq/index.html?',s.join('&'), '" >分享给QQ好友</a>' ].join(''));  
        }  
      
    function qqZone(){  
         var _url = "http://ygtest.98czs.net/";     
         var _showcount = 0;  
         var _desc = desc_;  
         var _summary = "";  
         var _title = "惠玩车-一元购";  
         var _site = "";  
         var _width = "600px";  
         var _height = "800px";  
         var _summary = "";  
         var _pic = "http://ygtest.98czs.net//uploads/allimg/150510/1-150510104044.jpg";  
         var _shareUrl = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?';  
         _shareUrl += 'url=' + encodeURIComponent(_url||document.location);   //参数url设置分享的内容链接|默认当前页location  
         _shareUrl += '&showcount=' + _showcount||0;      //参数showcount是否显示分享总数,显示：'1'，不显示：'0'，默认不显示  
         _shareUrl += '&desc=' + encodeURIComponent(_desc||'分享的描述');    //参数desc设置分享的描述，可选参数  
         //_shareUrl += '&summary=' + encodeURIComponent(_summary||'分享摘要');    //参数summary设置分享摘要，可选参数  
         _shareUrl += '&title=' + encodeURIComponent(_title||document.title);    //参数title设置分享标题，可选参数  
         //_shareUrl += '&site=' + encodeURIComponent(_site||'');   //参数site设置分享来源，可选参数  
         _shareUrl += '&pics=' + encodeURIComponent(_pic||'');   //参数pics设置分享图片的路径，多张图片以＂|＂隔开，可选参数  
        window.open(_shareUrl,'width='+_width+',height='+_height+',top='+(screen.height-_height)/2+',left='+(screen.width-_width)/2+',toolbar=no,menubar=no,scrollbars=no,resizable=1,location=no,status=0');   
    }  
      
     $(function(){     
        var url = qqFriend();  
        $("#qq_id").attr("href",url);      
     })  
</script>
<!--End分享-->
<body>
	
<div class="weui_mask_transparent"></div>
<!--限购规则-->
    <div class="quota_pop" style="display: none;">
    	<h2>限购规则</h2>
    	<ul>
    		<li>1.系统采取随机抽选的方式进行开奖；</li>
    		<li>2.商品将在限购时间结束后进行开奖；</li>
    		<li>3.此次限购活动对人数不做限制；</li>
    		<li>4.本活动最终解释权归惠玩车所有；</li>
    	</ul>
    	<a class="quota_confirm" onclick="quota_pop.style.display='none'">确定</a>
    </div>
<!--END限购规则-->
<div class="share_pop"><img src="http://wx.91k8.me/statics/templates/yungou/css/images/introduce.png"></div>

<div class="h5-1yyg-v1" id="loadingPicBlock">

<!-- 栏目页面顶部 -->
<!-- 内页顶部 -->
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
					<a href="javascript:;"  id="qq_id" class="qiuqiu" title="分享给QQ好友" target="_blank"></a>
					<p>QQ好友</p>
				</li>
				<li>
					<a href="javascript:void(0);" class="koukou" onclick = "qqZone()" title="分享到QQ空间"></a>
					<p>QQ空间</p>
				</li>
				<li>
					<a href="javascript:;"  class="tengxun" onclick = "tencentWeiBo()" title="分享到腾讯微博"></a>
					<p>腾讯微博</p>
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
		<div class="n-h-tit">
			<h1 class="header-logo">商品详情</h1>
		</div>
		<a class="share_item" href="javascript:void();"></a>
	</div>
	<!-- 栏目页面顶部 -->			
</header><!-- 内页顶部 -->

    <input name="hidGoodsID" type="hidden" id="hidGoodsID" value="1202"/>   <!--上期获奖者id-->
    <input name="hidCodeID" type="hidden" id="hidCodeID" value="35"/>     <!--本期商品id-->
    <section class="goodsCon pCon">
	    <!-- 导航 -->
        <div id="divPeriod" class="pNav">
    	    <ul class="slides" style="display:block;">
          	<?php
          	foreach($qishu as $good){
          		if($good['qishu'] == $item['qishu']){
          		?>
          		<li class="cur"><a href="javascript:;">第<?php echo $good['qishu']?>期</a><b></b></li>
          		<?php	
          		}else{
          		?>
          		<li><a href="<?php echo $good_dir.$good['id'].'.html';?>">第<?php echo $good['qishu']?>期</a></li>
          		<?php	
          		}	
          	}
          	?>    	    
    	    </ul>
        </div>


        <!-- 产品图 -->
        <div class="pPic pPicBor">
            <div style="width:65%;max-height:400px; overflow:hidden;margin:0 auto;">
                <img src="<?php echo $item['thumb'];?>" style="width:100%;max-height:400px;" class="animClass" />
            </div>
		</div>

	    <!-- 条码信息 -->
		<?php
		//判断是否揭晓
		$is_jx = false;
		if($item['q_end_time']>0){		//已揭晓
			$is_jx = true;
		}
        if($item['is_xy']==1){			//心愿商品
        ?>
	        <div class="pDetails ">
                <b><ins>(待上线)</ins>第<?php echo $item['qishu'];?>期 &nbsp;&nbsp;<?php echo $item['title'];?><span></span></b>
                <p class="price">价值：<em class="arial gray">￥<?php echo $item['money'];?></em></p>

				<div class="Progress-bar">
					<!--<?php echo percent($item['xinyuan'],MAXXINYUAN);?>-->
					<p class="u-progress" title="已完成<?php echo percent($item['xinyuan'],MAXXINYUAN);?>">
						<span class="pgbar" style="width:<?php echo percent($item['xinyuan'],MAXXINYUAN);?>">
							<span class="pging"></span>
						</span>
					</p>
					<ul class="Pro-bar-li">
						<li class="P-bar02">许愿人次<em class="red"><?php echo $item['xinyuan'];?></em></li>
						<li class="P-bar04"><a class="not_online" attr_gid="<?php echo $item['id'];?>" attr_sid="<?php echo $item['sid'];?>"><img src="<?php echo ASSET_FONT;?>/css/images/not_online.png" /></a></li>
					</ul>
				</div>
				<div class="hint" style="text-align:left;line-height:20px;">温馨提示：每天可许愿一次，心愿值到达一定数值后，客服将上架该商品</div>
            </div>
            <div class="roby-go-buy u-btn-w"  id="btnComment"><a href="javascript:void(0);" class="z-btn-comment"><s></s>我要留言</a></div> 
	        <!--未上线我要留言-->
	        <div class="m-comment" style="display:none;">
	            <div class="u-comment ">
	                <textarea name="comment" id="comment" rows="3" class="z-comment-txt" placeholder="请输入内容..."></textarea>
	            </div>
	            <div class="u-Btn">
	                <div class="u-Btn-li"><a id="btnCancel" href="javascript:;" class="z-CloseBtn">取 消</a></div>
	                <div class="u-Btn-li"><a id="btnPublish" gid="<?php echo $item['id'];?>" href="javascript:;" class="z-DefineBtn">发表留言</a></div>
	            </div>
	        </div>                   
        <?php
        }else{
			if($item['xsjx_time']){		//限时抢购	
				if($is_jx){		//已揭晓
				?>
	        <div class="pDetails ">
                <b><ins>(已揭晓)</ins>第<?php echo $item['qishu'];?>期 &nbsp;&nbsp;<?php echo $item['title'];?><span></span></b>
                <p class="price">价值：<em class="arial gray">￥<?php echo $item['money'];?></em></p>            	
            </div>
            <div class="roby-go-buy" onclick="unable_buy();" attr_goodsid="<?php echo $item['id'];?>" attr_maxnum="<?php echo $item['shenyurenshu'];?>" attr_times="1">立即参与</div>				
				<?php	
				}else{
					$nowtime = time();
	            	if($item['xsjx_time']>$nowtime){		//未到揭晓时间
	            	?>
	        <div class="pDetails ">
                <b><ins>(进行中)</ins>第<?php echo $item['qishu'];?>期 &nbsp;&nbsp;<?php echo $item['title'];?><span></span></b>
                <p class="price">价值：<em class="arial gray">￥<?php echo $item['money'];?></em></p>
	        	<div class="count_zero" id="jq_html1">
		                        揭晓倒计时：<em id="emH1"></em> <strong>:</strong><em id="emM1"></em><strong>:</strong><em id="emS1"></em>
		            <a class="quota">限购规则</a>
		        </div> 
                <script>
                fresh('<?php echo date('Y-m-d H:i:s', $item['xsjx_time'])?>','1');
                </script>             	
            </div>
			<div class="roby-go-buy participation" onclick="go_buy();"  attr_goodsid="<?php echo $item['id'];?>" attr_maxnum="<?php echo $item['shenyurenshu'];?>" attr_times="1">立即抢购</div>            	            	
	            	<?php	
	            	}else{									//已到气揭晓时间,禁止购买
	            	?>
	        <div class="pDetails ">
                <b><ins>(进行中)</ins>第<?php echo $item['qishu'];?>期 &nbsp;&nbsp;<?php echo $item['title'];?><span></span></b>
                <p class="price">价值：<em class="arial gray">￥<?php echo $item['money'];?></em></p>            	
            </div>	
			<div class="roby-go-buy" onclick="unable_buy2();" attr_goodsid="<?php echo $item['id'];?>" attr_maxnum="<?php echo $item['shenyurenshu'];?>" attr_times="1">立即参与</div>
	            	<?php	
	            	}
				}       		
        	}else{						//正常商品
        	?>
			<div class="pDetails ">
                <b><ins>(<?php echo ($is_jx==true) ? '已揭晓' : '进行中';?>)</ins><?php echo $item['title'];?> <span></span></b>
                <p class="price">价值：<em class="arial gray">￥<?php echo $item['money'];?></em></p>
                <?php
                if($is_jx){				//已揭晓
				?>
	        	<!--开奖直播-->
	        	<div class="joinAndGet" style="border:none;">
		        	<div class="lottery_tomlive">
		        		<div class="participation_detail">			                                     
		                    <img src="<?php echo G_UPLOAD_PATH;?>/photo/90875612810352.jpg">
		                    <a class="paly_button"></a>
		                    <div class="takename_date">
		                        <p class="join_name">本期已揭晓</p>
		                        <p>2016-10-26</p>
		                    </div>
		                </div>
		                <dl><a class="play_video" href="<?php echo (!empty($item['q_video'])) ? $item['q_video'] : ROOM;?>"><b class="fr z-arrow" style="top:21px;"></b><em>播放开奖视频</em></a></dl>                
		        	</div>
		        </div>
				<div class="lottery">
					<div class="win_lottery">
						<span class="luck_number">幸运号码：<ins class="lottery_number"><?php echo $item['q_user_code']?></ins></span>
						<a href="" class="join_detail">参与详情</a>
					</div>
					<div class="lottery_detail">
						<img src="<?php echo G_UPLOAD_PATH;?>/<?php echo $item['q_pic'];?>" class="lottery_photo">
						<!--<img src="<?php echo G_UPLOAD_PATH;?>/touimg/20160813/25337068048076.jpg" class="lottery_photo"> -->
						<div class="luck_people">
							<p class="luckpeople_name">
							<?php echo $item['q_user']?>
							</p>
							<p class="luckpeople_ID">一元购时间：<?php echo $item['time'];?></p>
							<p class="publish_time">揭晓时间：<?php echo date('Y-m-d H:i:s',$item['q_end_time']);?></p>
							<p class="publish_time">本期参与<ins class="person-time"><?php echo $benrecode['gonumber'];?></ins>人次</p>
						</div>
					</div>
				</div>	        				
				<?php	                	
                }else{
                ?>
				<div class="Progress-bar">
					<p class="u-progress" title="已完成<?php echo percent($item['canyurenshu'],$item['zongrenshu']);?>">
						<span class="pgbar" style="width:<?php echo percent($item['canyurenshu'],$item['zongrenshu']);?>;">
							<span class="pging"></span>
						</span>
					</p>
					<ul class="Pro-bar-li">
						<li class="P-bar02"><em><?php echo $item['zongrenshu'];?></em>总需人次(<?php echo $item['yunjiage'];?>元宝/次)</li>
						<li class="P-bar03"><em class="jq_roby_enable_add"><?php echo $item['shenyurenshu'];?></em>剩余人次</li>
					</ul>
				</div>
				<div class="hint">1元能让你失去什么？万一中了呢?</div>                
                <?php	
                }
                ?>

            </div>
            <!--注意判断：注意判断满员的仍是进行中，但不能参与抢购-->
            <?php

            if(!$is_jx){
            ?>
            <div class="roby-go-buy participation" onclick="go_buy();" attr_goodsid="<?php echo $item['id'];?>" attr_maxnum="<?php echo $item['shenyurenshu'];?>" attr_times="1">立即参与</div>
            <?php	
            }
            ?>
                              	
        	<?php	
        	}        	
        }
        ?>	        



       	
			
        <!--进行中未参加夺宝提示参加-->
        <!--<div class="hint">您还没有参加哦，赶快试一试吧，万一中了呢~</div> -->
        
        <!-- 参与记录，商品详细，晒单导航 -->
        <div class="joinAndGet">
        	<?php
        	if(!$is_jx and $item['is_xy']!=1){		//揭晓商品跟心愿商品不显示直播中
        	?>
        	<div class="lottery_tomlive">
        		<div class="participation_detail">			                                     
                    <img src="<?php echo G_UPLOAD_PATH;?>/photo/90875612810352.jpg">
                    <a class="paly_button"></a>
                    <div class="takename_date">
                        <p class="join_name">开奖直播中</p>
                        <p><?php echo date('Y-m-d');?></p>
                    </div>
                </div>
                <dl><a class="play_video" href="<?php echo (!empty($item['q_video'])) ? $item['q_video'] : ROOM;?>"><b class="fr z-arrow" style="top:21px;"></b><em>播放开奖视频</em></a></dl>                
        	</div>        	
        	<?php	
        	}
        	?>
    	    <dl>
				<a href="<?php echo G_WEB_PATH.'/index/goodsdesc/'.$item['id']?>"><b class="fr z-arrow"></b>图文详情<em>建议在WIFI环境下使用</em> </a>
				<a href="<?php echo G_WEB_PATH.'/index/jiexiao/before/'.$item['sid']?>"><b class="fr z-arrow"></b>往期揭晓</a>
				<!--<a href="http://wx.91k8.me/index.php/mobile/mobile/goodspost/22"><b class="fr z-arrow"></b>晒单分享</a>-->               
            </dl>
        <!--上期获得者-->
        <?php
        if(!empty($gorecode) && $gorecode['shopid']!=$item['id'] && $pre_id){			//上期获得者 商品id不是本期才会显示上期获得者
        ?>
		<div class="luck_code">幸运1元购码：<?php echo $gorecode['huode'];?></div>
 			<ul id="prevPeriod" class="m-round" codeid="27" uweb="1202">
                <li class="fl"><s></s>
                <img src="<?php echo ASSET_FONT;?>/images/loading.gif" src2="<?php echo G_UPLOAD_PATH;?>/<?php echo $gorecode['uphoto']?>"/> 
                </li>
                <li class="fr"><!--<b class="z-arrow"></b>--></li>
                <li class="getInfo">
                    <dd>
                        <em class="blue"><?php echo $gorecode['username'];?></em>
                    </dd>
                    <dd>总共1元购：<em class="orange arial"><?php echo $gorecode['gonumber'];?></em>人次</dd>
                    <dd>1元购时间：<?php echo date('Y-m-d H:i:s',$gorecode['time']);?></dd>
                    <dd>揭晓时间：<?php echo date('Y-m-d H:i:s',$gorecode['q_end_time']);?></dd>
                </li>
            </ul>
        </div>        
        <?PHP	
        }
        ?>
		</div>
        <!--所有参与记录-->
        <?php
        if($item['is_xy']==1){		//显示留言
		?>
		<div class="participation_record">
        	<div class="participation_bar">
	        	<span>留言</span>
	        	<div class="participation_more fr">
					<a href="<?php echo G_WEB_PATH;?>/index/message/<?php echo $item['id']?>" class="u-rs-m2">全部&nbsp;&gt;</a>
	            </div>
            </div>
        	<div class="participation_list">
        		<?php
        		foreach($cords as $c){
        		?>
				<ul>
                    <li>
                        <div class="participation_detail">
                            <?php
                            if(strpos($c['img'],'http://')!== false){
                            ?>
                            <img src="<?php echo $c['img'];?>">                          
                            <?php    
                            }else{
                            ?>
                            
                            <img src="<?php echo G_WEB_PATH.$c['img'];?>">
                            <?php    
                            }
                            ?>
                            <div class="takename_date">
                                <p class="join_name fleft"><?php echo $c['user'];?></p>
                                <p class="join_time"><?php echo $c['updatetime'];?></p>
                                <div class="leave_essage"><?php echo $c['good_comment'];?></div>                               
                            </div> 
                        </div> 
                    </li>
                </ul>        		
        		       		
        		<?php	
        		}
        		?>        
        	</div>
            <div class="clear"></div>           
        </div>		
		<?php        	
        }else{
        ?>
		<div class="participation_record">
        	<div class="participation_bar">
	        	<span>所有参与记录</span>
	        	<div class="participation_more fr">
					<a href="<?php echo G_WEB_PATH;?>/index/userbuylist/<?php echo $item['id'];?>" class="u-rs-m2">更多&nbsp;&gt;</a>
	            </div>
            </div>
        	<div class="participation_list">
        		<?php  
		        foreach($cords as $c){
				?>
        		<ul>
                    <li>
                        <div class="participation_detail">
                            <?php
                            if(strpos($c['img'],'http://')!== false){
                            ?>
                            <img src="<?php echo $c['img'];?>">
                                                      
                            <?php    
                            }else{
                            ?>
                            <img src="<?php echo G_WEB_PATH.$c['img'];?>">
                            <?php    
                            }
                            ?>
                            
                            <div class="takename_date">
                                <p class="join_name"><?php echo $c['user'];?></p>
                                <p class="purchase_number" style="font-weight: bold;">购买号码:<?php echo $c['code_duan']?></p>
                                <p>(<?php echo $c['user_ip']?>)</p>
                                <p><?php echo date("Y-m-d H:i:s",$c['time']);?></p>
                            </div>
                        </div>
                        <div class="ren_number">
                            	参与<ins style="color:#F5484C;"><?php echo $c['gonumber'];?></ins>人次
                        </div>
                    </li>
                </ul>							
				<?php		        	
		        }    		
        		?>           
        	</div>
            <div class="clear"></div>           
        </div>        
        <?php	
        }
        ?>
        

    </section>

﻿

<script>
	function unable_buy(){
		$.PageDialog.fail('已揭晓商品不能参与购买');
	}
	function unable_buy2(){
		$.PageDialog.fail('揭晓时间已到，不能参与购买');
	}	
	
	//我要留言
	$("#btnComment").click(function(){
		$.getJSON('/ajax/islogin/'+goods_id,function(data){	            
	        if(data.code == 400){
	            $.PageDialog.fail('登录后才能留言');
	            return false;
	        }else{
	        	$(".m-comment").show();
	        }
		});		
		
	});
	$("#btnCancel").click(function(){
		$(".m-comment").hide();	
	});
	$("#btnPublish").click(function(){
		var comment = $("#comment").val();
		var good_id = $(this).attr('gid');
		if(comment==''){
			$.PageDialog.ok('留言内容不能为空');
			return false;
		}
		$.ajax({
		   type: "POST",
		   url: "/ajax/goodcomment",
		   data: "comment="+comment+"&gid="+good_id,
		   success: function(msg){
		   	 msg = $.parseJSON(msg);
		     if(msg.code==200){
		     	$.PageDialog.ok('成功留言');
		     	$("#comment").val('')
		     	$(".m-comment").hide();	
		     }
		   }
		});	
	})
	//限购规则弹出框
	$(".quota").click(function(){
		$(".quota_pop").show();
		$(".weui_mask_transparent").show();
   		var winH = $(window).height();
	    var winW = $(window).width(); 
	    $(".quota_pop").css({'top': winH/2-$(".quota_pop").height()/2,'left': winW/2-$(".quota_pop").width()/2 });
        	$(".quota_pop").slideDown(800, function() {
        	setTimeout("ClearIndexHeadPopup()", '3000');
        	$("body,html").css({"overflow":"hidden"});
        });
   		$(".weui_mask_transparent, .quota_confirm").click(function(){
	            $(".quota_pop").hide();
	            $(".weui_mask_transparent").hide();
	            $("body,html").css({"overflow":"visible"}); 
	        });
	});
</script>
<script language="javascript" type="text/javascript">
var Path = new Object();
Path.Skin="<?php echo ASSET_FONT;?>";
Path.Webpath = "<?php echo G_WEB_PATH;?>";

var Base = {
    head: document.getElementsByTagName("head")[0] || document.documentElement,
    Myload: function(B, A) {
        this.done = false;
        B.onload = B.onreadystatechange = function() {
            if (!this.done && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete")) {
                this.done = true;
                A();
                B.onload = B.onreadystatechange = null;
                if (this.head && B.parentNode) {
                    this.head.removeChild(B)
                }
            }
        }
    },
    getScript: function(A, C) {
        var B = function() {};
        if (C != undefined) {
            B = C
        }
        var D = document.createElement("script");
        D.setAttribute("language", "javascript");
        D.setAttribute("type", "text/javascript");
        D.setAttribute("src", A);
        this.head.appendChild(D);
        this.Myload(D, B)
    },
    getStyle: function(A, B) {
        var B = function() {};
        if (callBack != undefined) {
            B = callBack
        }
        var C = document.createElement("link");
        C.setAttribute("type", "text/css");
        C.setAttribute("rel", "stylesheet");
        C.setAttribute("href", A);
        this.head.appendChild(C);
        this.Myload(C, B)
    }
}
function GetVerNum() {
    var D = new Date();
    return D.getFullYear().toString().substring(2, 4) + '.' + (D.getMonth() + 1) + '.' + D.getDate() + '.' + D.getHours() + '.' + (D.getMinutes() < 10 ? '0': D.getMinutes().toString().substring(0, 1))
}
Base.getScript('<?php echo ASSET_FONT;?>/js/mobile/Bottom.js?v=' + GetVerNum());


</script>

</div>
