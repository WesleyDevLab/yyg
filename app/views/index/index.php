<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>全民惠玩车</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="<?php echo ASSET_FONT;?>/images/mobile/touch-icon.png" rel="apple-touch-icon-precomposed" />
    <link href="favicon.ico" rel="shortcut icon" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/index.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
    <script id="pageJS" data="<?php echo ASSET_FONT;?>/js/mobile/Index.js" language="javascript" type="text/javascript"></script>    
    <script src="<?php echo ASSET_FONT;?>/js/mobile/goods.js" language="javascript" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
    <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/js/mobile/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
    <script src="<?php echo ASSET_FONT;?>/roby_plug.js" language="javascript" type="text/javascript"></script>
    <style>
        .cur{color:blue!important;}
        .swiper-container {
            width: 100%;
            height: 100%;
        }
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
        .weui_mask_transparent {
            position: fixed;
            z-index: 999;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.6);
        }
      	#indexheadpopup {
		    overflow: hidden;
		    display: none;
		    margin: 0 auto;
		    position: absolute;
		}
        a.affirm {
		    position: absolute;
		    top: 26.5rem;
		    z-index: 99999;
		    left: 5.4rem;
		}
        .affirm > img{
            width:12rem;
        }
        img.pop_bg {
		    position: relative;
		    z-index: 99998;
		    width: 22rem;
		    height: 32rem;
		}
		.sort_management img {
		    width: 5rem;
		    height: 5rem;
		}
		.take_part_in a{
			background-color: #F5484C!important;
			color:#fff!important;
			border:none;
		}
		.benefit {
		    border-top: 1px solid #eee!important;
		    border-bottom: 1px solid #eee!important;
		    float: left;
		    width: 100%;
		    background-color: #fff;
		    display: inline-flex;
		    background: url(<?php echo ASSET_FONT;?>/css/images/icon_logo.png)no-repeat 10px 10px;
		}
		@media only screen and (-webkit-min-device-pixel-ratio: 2), 
			only screen and (min-device-pixel-ratio: 2) {
			.benefit {
			    background-image: url(<?php echo ASSET_FONT;?>/css/images/icon_logo@2x.png);
			    background-size: 68px 14px;
			}
		}
		.t_news{padding-left: 24%;}
		.m-tt1 h2{
			background: url(<?php echo ASSET_FONT;?>/css/images/edge.png)no-repeat 0px 7px;
			margin-left:0;
		}
		@media only screen and (-webkit-min-device-pixel-ratio: 2), 
			only screen and (min-device-pixel-ratio: 2) {
			.m-tt1 h2 {
			    background-image: url(<?php echo ASSET_FONT;?>/css/images/edge@2x.png);
			    background-size: 5px 17px;
			}
		}
		.g-main{margin-top:10px;}
    </style>
  
    <script type="text/javascript">
	// 单行新闻文字滚动
	function b(){	
		t = parseInt(x.css('top'));
		y.css('top','19px');	
		x.animate({top: t - 19 + 'px'},'slow');	//19为每个li的高度
		if(Math.abs(t) == h-19){ //19为每个li的高度
			y.animate({top:'0px'},'slow');
			z=x;
			x=y;
			y=z;
		}
		setTimeout(b,3000);//滚动间隔时间 现在是3秒
	}
	$(document).ready(function(){
		$('.swap').html($('.news_li').html());
		x = $('.news_li');
		y = $('.swap');
		h = $('.news_li li').length * 19; //19为每个li的高度
		setTimeout(b,3000);//滚动间隔时间 现在是3秒
		
	})
	
	//恭喜您获得淘豆积分
    $(function(){     
    	var isNewRegister = 0 ;
    	show_or_hide(isNewRegister);
    	function show_or_hide(isNewRegister){
    		$(".weui_mask_transparent").hide();
    		if(isNewRegister =="1"){
    			/*$("body").addClass("weui_mask_transparent");*/
				$(".weui_mask_transparent").show();
					var winH = $(window).height();
	            	var winW = $(window).width();       
	            	$("#indexheadpopup").css({'top': winH/2-$("#indexheadpopup").height()/1.2,'left': winW/2-$("#indexheadpopup").width()/2 });
	                $("#indexheadpopup").slideDown(800, function() {
	            	$("body,html").css({"overflow":"hidden"});
	       		});
		        $(".weui_mask_transparent, .affirm").click(function(){
		            $("#indexheadpopup").hide();
		            $(".weui_mask_transparent").hide();
		            $("body,html").css({"overflow":"visible"}); 
		        });
			}
    	}
    	

    });


    
    </script>

</head>
<body>
<!--恭喜你弹出框-->
<div class="weui_mask_transparent"></div>
<div id="indexheadpopup">
    <a href="javascript:;" class="affirm" onclick="indexheadpopup.style.display='none'"><img src="<?php echo ASSET_FONT;?>/css/images/sure_btn.png"></a>
    <img src="<?php echo ASSET_FONT;?>/css/images/pop_bg.png" class="pop_bg">
</div>
<!--END恭喜你弹出框-->


<div class="h5-1yyg-v1" id="loadingPicBlock">
    <!--<header class="header">
        <div class="n-header-wrap">
            <div class="backbtn">
            </div>
		<div class="n-h-tit"><span class="system_name">全民惠玩车</span></div>
        </div>
    </header>-->

    <!-- 内页顶部 -->

    <input name="hidStartAt" type="hidden" id="hidStartAt" value="0" />
    <!-- 焦点图 -->

    <div class="swiper-container">
        <div class="swiper-wrapper">

			<?php
			foreach($slides as $slide){
			?>
                <div class="swiper-slide">
                    <a href="<?php echo $slide['link'];?>"><img style="width: 100%;"  src="<?php echo G_WEB_PATH.$slide['img'];?>"></a>
                </div>			
			<?php	
			}
			?>		
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>

    <!-- Swiper JS -->
    <script src="<?php echo ASSET_FONT;?>/js/mobile/swiper/js/swiper.min.js" language="javascript" type="text/javascript"></script>
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: true
        });
    </script>
	<div class="sort_management">
		<ul>
			<?php
			foreach($catlist as $cat){
				if($cat['url']){
				?>
				<li><a href="<?php echo $cat['url'];?>"><img src="<?php echo G_WEB_PATH.$cat['pic'];?>"><!--<ins>HOT</ins>--><p><?php echo $cat['name']?></p></a></li>
				<?php	
				}else{
				?>
				<li><a href="<?php echo G_WEB_PATH.'/index/classify/'.$cat['cateid'];?>"><img src="<?php echo G_WEB_PATH.$cat['pic'];?>"><!--<ins>HOT</ins>--><p><?php echo $cat['name']?></p></a></li>
				<?php	
				}	
			}
			?>
		</ul>
	</div>
	<div class="benefit" style="background-color:#fff;">
		<div class="box">
			<div class="t_news">
				<ul class="news_li">
					<?php
					foreach($listItems as $qishu){
					?>
						<li>
							<a href="<?php echo $qishu['good_url'];?>">恭喜
								<b style="color"><?php echo $qishu['q_user'];?></b>
								获得价值<?php echo $qishu['money'];?>元的<?php echo $qishu['title'];?>									
							</a>
						</li>
					<?php	
					}
					?>
				</ul>
				<ul class="swap"></ul>
			</div>
		</div>
	</div>
    <!--<div class="textnav">-->
    <!--</div>-->
    <!--最新揭晓 -->
    <section class="g-main">
        <div class="m-tt1">
            <h2 class="fl"><a href="<?php echo G_WEB_PATH;?>/index/jiexiao/soon">即将揭晓</a></h2>
            <div class="fl z-tips"><!-- 每天10点、15点、22点热门揭晓 --></div>
            <div class="fr u-more">
                <a href="<?php echo G_WEB_PATH.'/index/jiexiao/soon';?>" class="u-rs-m2"><b class="z-arrow"></b>更多</a>
            </div>
        </div>
        <article class="h5-1yyg-w310 m-round m-lott-li" id="divLottery">
            <ul class="clearfix">
            	<?php
            	foreach($jiexiao as $k=>$good){
            	?>
                <li>
                    <a href="<?php echo $good['good_url'];?>" class="u-lott-pic">
                        <img src="<?php echo ASSET_FONT;?>/images/loading.jpg" src2="<?php echo G_WEB_PATH.$good['thumb'];?>" border="0" alt="" />
                    </a>
			        <div class="count_down" id="jq_html<?php echo $k;?>">
			            <em id="emH<?php echo $k;?>"></em> <strong>:</strong><em id="emM<?php echo $k;?>"></em><strong>:</strong><em id="emS<?php echo $k;?>"></em>
			        </div>
					<div class="announce_name">
                        <a href="<?php echo $good['good_url'];?>" class="blue z-user"><?php echo _strcut($good['title'],15);?></a>
                    </div>
                </li>
                <script>
                fresh('<?php echo date('Y-m-d H:i:s', $good['xsjx_time'])?>',<?php echo $k?>);
                </script>            	
            	<?php	
            	}
            	?>

        </ul>
        </article>
    </section>    
 
 
 
	<section class="g-main">
        <div class="m-tt1">
            <h2 class="fl"><a href="<?php echo G_WEB_PATH;?>/index/catgoods">热门商品</a></h2>
            <div class="fl z-tips"><!-- 每天10点、15点、22点热门揭晓 --></div>
            <div class="fr u-more">
                <a href="<?php echo G_WEB_PATH;?>/index/catgoods" class="u-rs-m2"><b class="z-arrow"></b>更多</a>
            </div>
        </div>
        <article class="clearfix h5-1yyg-w310 m-round m-tj-li">
            <ul id="ulRecommend">
            <?php
			foreach($cat_hot_goods as $k=>$cat_goods){
				if($cat_goods){
            		foreach($cat_goods as $good){
            		?>
            	<li id="31">
                    <div class="f_bor_tr">
                        <div class="m-tj-pic">
                            <a href="<?php echo $good['good_url'];?>" class="u-lott-pic">
                                <img src="<?php echo ASSET_FONT;?>/images/loading.jpg" src2="<?php echo G_WEB_PATH.$good['thumb']?>" border=0 alt="" />
                            </a>
                            <ins class="u-promo">价值:￥<?php echo $good['money']?></ins>
                        </div>
                        <div class="brand_introduce">
                            <a href="<?php echo $good['good_url'];?>"><?php echo _strcut($good['title'],15);?></a>
                        </div>
                        <div class="Progress-bar">
                        	<div class="proportion">
	                            <p class="u-progress" title="已完成<?php echo percent($good['canyurenshu'],$good['zongrenshu']);?>">
									<span class="pgbar" style="width:<?php echo width($good['canyurenshu'],$good['zongrenshu'],100);?>%;">
									<span class="pging"></span>
									</span>
	                            </p>
	                            <ul class="Pro-bar-li">
	                                <!--<li class="P-bar01"><em>52</em>已参与</li>-->
	                                <li class="P-bar02"><em><?php echo $good['zongrenshu'];?></em>总需人次</li>
	                                <li class="P-bar03"><em><?php echo $good['zongrenshu']-$good['canyurenshu'];?></em>剩余人次</li>
	                            </ul>
                           </div>
                        </div>
                        <div class="take_part_in">
                            <?php 
                            if($good['shenyurenshu']>0){
                            ?>
                            <a href="javascript:void(0);" class="participation" attr_goodsid="<?php echo $good['id'];?>" attr_maxnum="<?php echo $good['shenyurenshu'];?>" attr_times="1">参与</a>
                            <?php	
                            }else{
                            ?>
                            <a class="participation canyudis">参与</a>
                            <?php	
                            }
                            ?>
                        </div>
                    </div>
                </li>             		
            		<?php
            		}
				}
			?>
			
			<?php
			} 
			?>           
           		

            </ul>
        </article>
    </section>
    
        
 


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

