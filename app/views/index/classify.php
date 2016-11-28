<!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>频道页-<?php echo $curr_cat['name'];?></title>
<meta content="app-id=518966501" name="apple-itunes-app" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ASSET_FONT;?>/css/mobile/goods.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/js/mobile/swiper/css/swiper.min.css">
<link href="<?php echo ASSET_FONT;?>/images/mobile/touch-icon.png" rel="apple-touch-icon-precomposed" />
<script id="pageJS" data="<?php echo ASSET_FONT;?>/js/mobile/Index.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo ASSET_FONT;?>/js/mobile/goods.js?v=201" language="javascript" type="text/javascript"></script>
<link href="<?php echo ASSET_FONT;?>/css/mobile/new.css" rel="stylesheet" type="text/css" />
<style>
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
    top: 0;
    font-size: 29px;
    display: block;
    color: #999;
    font-weight: 400;
}
</style>
</head>
<body>
<div class="weui_mask_transparent"></div>

    <div class="h5-1yyg-v1" id="loadingPicBlock">
    
<!-- 栏目页面顶部 -->


<style type="text/css">
    .h-count:before {
        content: url("<?php echo ASSET_FONT;?>/css/../images/mobile/1.png");
    }
    .backbtn {
        float: left;
        margin-left: 12px;
        margin-top: 5px;
        height: 20px;
        overflow: hidden;
    }
    .header-logo {
        overflow: hidden;
    }
    .h-search, .back, .h-count, .h-share {
        display: inline-block;
        height: 20px;
        font-family: "iconfont" !important;
        line-height: 20px;
        font-size: 20px;
        font-style: normal;
        -webkit-font-smoothing: antialiased;
        -webkit-text-stroke-width: 0.2px;
        -moz-osx-font-smoothing: grayscale;
    }
    .n-h-tit {
        float: left;
        text-align: left;
        margin-left: auto;
        margin-right: auto;
        font-size: 9px;
        line-height: 35px;
        color: rgb(255,255,255);
    }
</style>

<header class="header">
    <div class="n-header-wrap">
        <div class="backbtn">
            <a href="javascript:;" onClick="history.go(-1)" class="h-count white">
            </a>
        </div>


        <div class="n-h-tit"><h1 class="header-logo"><?php echo $curr_cat['name'];?></h1></div>
    </div>
</header>

<!-- 内页顶部 -->

    <section class="goodsCon">
    <!--品牌名轮播-->
	    <div class="swiper-container">
        <div class="swiper-wrapper">           
    		<?php
    		if($brand_list1){
			?>
             <div class="swiper-slide">
            	<ul>
        			<?php
	    			foreach($brand_list1 as $brand){		//跳到该分类下所有商品
	    			?>
					<li>
						<a href="<?php echo G_WEB_PATH;?>/index/brand/<?php echo $brand['id'];?>"><img src="<?php echo G_WEB_PATH.$brand['pic'];?>"></a>
					</li>
	    			<?php	
	    			}
	    			?>           	
            	</ul>                
            </div>			
			<?php    			
    		}
    		?> 
    		<?php
    		if($brand_list2){
			?>
             <div class="swiper-slide">
            	<ul>
        			<?php
	    			foreach($brand_list2 as $brand){		//跳到该分类下所有商品
	    			?>
					<li>
						<a href="<?php echo G_WEB_PATH;?>/index/brand/<?php echo $brand['id'];?>"><img src="<?php echo G_WEB_PATH.$brand['pic'];?>"></a>
					</li>
	    			<?php	
	    			}
	    			?>           	
            	</ul>                
            </div>			
			<?php    			
    		}
    		?>                      
    		<?php
    		if($brand_list3){
			?>
             <div class="swiper-slide">
            	<ul>
        			<?php
	    			foreach($brand_list3 as $brand){		//跳到该分类下所有商品
	    			?>
					<li>
						<a href="<?php echo G_WEB_PATH;?>/index/brand/<?php echo $brand['id'];?>"><img src="<?php echo G_WEB_PATH.$brand['pic'];?>"></a>
					</li>
	    			<?php	
	    			}
	    			?>           	
            	</ul>                
            </div>			
			<?php    			
    		}
    		?>           
            
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
	<div class="kind_classify">
		<ul>
    		<?php
    		if($child_cat_list){
    			foreach($child_cat_list as $cat){		//跳到该分类下所有商品
    			?>
				<li>
					<a href="<?php echo G_WEB_PATH;?>/index/catgoods/<?php echo $cat['cateid'];?>"><img src="<?php echo G_WEB_PATH.$cat['pic'];?>"><p><?php echo $cat['name'];?></p></a>
				</li>
    			<?php	
    			}
    		}
    		?>
    				
		</ul>
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
        <!-- 列表 -->
        <div class="goodsList">
			
			<div id="divGoodsLoading" class="loading" style="display:none;"><b></b>正在加载...</div>
            <a id="btnLoadMore" class="loading" href="javascript:;" style="display: block;">点击加载更多</a>
            <a id="btnLoadMore2" class="loading" style="display:none;">没有数据</a>
            <a id="btnLoadMore3" class="loading" style="display:none;">已经到底了</a>
        </div>
    </section>
	
    <input id="urladdress" value="" type="hidden" />
    <input id="pagenum" value="" type="hidden" />
﻿


<script type="text/javascript">
    $(".weui_mask_transparent").hide();
    function trim(str) {
        return str.replace(/(^\s*)|(\s*$)/g, "");
    }
    var getParam = function (name) {
        var search = document.location.search;
        var pattern = new RegExp("[?&]" + name + "\=([^&]+)", "g");
        var matcher = pattern.exec(search);
        var items = null;
        if (null != matcher) {
            try {
                items = decodeURIComponent(decodeURIComponent(matcher[1]));
            } catch (e) {
                try {
                    items = decodeURIComponent(matcher[1]);
                } catch (e) {
                    items = matcher[1];
                }
            }
        }
        return items;
    };

//打开页面加载数据
window.onload=function(){

    var cateid = <?php echo $curr_cat['cateid']?>;
    if(cateid > 0){
       var text = $('#'+cateid).text();
       $('#product_all_0').attr('cid',cateid);
        $('#product_all_0').html(text+'<s class="arrowUp"></s>');
        glist_json(+cateid+"/10");
    }
    else {
        glist_json("list/10");
    }

}
function go_buy(){

}
//获取数据
function glist_json(parm){
	$("#urladdress").val('');
	$("#pagenum").val('');
	$.getJSON('<?php echo G_WEB_PATH?>/goods/glistajax/'+parm,function(data){
		console.log(data);
		$("#divGoodsLoading").css('display','none');
		//roby 8-8将价格排序变为可切换
		var canshu = parm.split('/');
		var sort = canshu[1];		
		if(sort=='50'){
			$("#divGoodsNav li").eq(2).attr('order',60);
		}
		if(sort == '60'){
			$("#divGoodsNav li").eq(2).attr('order',50);
		}
        //分类选中与不选中
        $('#divGoodsNav dl a').each(function(){
            var obj = $(this);
            if( obj.attr('id') == canshu[0]){
                obj.parent().addClass('pitch_on').removeClass('weed_out');
            }else{
                obj.parent().removeClass('pitch_on').addClass('weed_out');
            }
        })
        if(canshu[0]>0){
            $('#divGoodsNav dl dd').eq(0).addClass('weed_out').removeClass('pitch_on');
        }else{
            $('#divGoodsNav dl dd').eq(0).addClass('pitch_on').removeClass('weed_out');
        }
		if(data[0].sum){
			var fg=parm.split("/");
			$("#urladdress").val(fg[0]+'/'+fg[1]);
			$("#pagenum").val(data[0].page);
			//要判断是 上线商品【正常商品，限时揭晓商品】、未上线商品 

			handleData(data,'<?php echo G_WEB_PATH;?>','divGoodsLoading');						
			
			if(data[0].page<=data[0].sum){
				$("#btnLoadMore").css('display','block');
				$("#btnLoadMore2").css('display','none');
				$("#btnLoadMore3").css('display','none');
			}else if(data[0].page>data[0].sum){
				$("#btnLoadMore").css('display','none');
				$("#btnLoadMore2").css('display','none');
				$("#btnLoadMore3").css('display','block');
			}
		}else{
			
			$("#btnLoadMore").css('display','none');
			$("#btnLoadMore2").css('display','block');	
			$("#btnLoadMore3").css('display','none');			
		}
	});
}

$(document).ready(function(){
	//即将揭晓,人气,最新,价格	
	$("#divGoodsNav li:not(:last)").click(function(){
		var l=$(this).index();
		$("#divGoodsNav li").removeClass().eq(l).addClass('current');
		var parm=$("#divGoodsNav li").eq(l).attr('order');
		$("#divGoodsLoading").css('display','block');
		$(".goodsList ul").remove();
		//roby 将商品分类传值
		var cid = $('#product_all_0').attr('cid');
		if(!cid){
			cid = "list";
		}
		var glist=glist_json(cid+"/"+parm);
	});
	
	//商品分类
	var dl=$("#divGoodsNav dl"),
		last=$("#divGoodsNav li:last"),
		first=$("#divGoodsNav dd:first");
	$("#divGoodsNav li:last a:first").click(function(){
		$('#product_all_0').attr('cid','');
		if(dl.css("display")=='none'){
			dl.show();
			last.addClass("gSort");
			first.addClass("sOrange");			
		}else{
			dl.hide();
			last.removeClass("gSort");
			first.removeClass("sOrange");
		}
	});
	$("#divGoodsNav  dd").click(function(){


		var s=$(this).index();
		var t=$("#divGoodsNav .gSort dd a").eq(s).html();
		var id=$("#divGoodsNav .gSort dd a").eq(s).attr('id');
		$('#product_all_0').attr('cid',id);		//roby商品分类赋值
		$("#divGoodsNav .gSort a:first").html(t+'<s class="arrowUp"></s>');
		var l=$("#divGoodsNav .current").index(),
			parm=$("#divGoodsNav li").eq(l).attr('order');
		if(id){
			$("#divGoodsLoading").css('display','block');
			$(".goodsList ul").remove();
			glist_json(id+'/'+parm);
		}else{
			glist_json("list/10");
			$(".goodsList ul").remove();
		}
		dl.hide();
		last.removeClass("gSort");
		first.removeClass("sOrange");
	});
	//加载更多
	$("#btnLoadMore").click(function(){		
		var url=$("#urladdress").val(),
			page=$("#pagenum").val();
		glist_json(url+'/'+page);
	});	
	//返回顶部
	$(window).scroll(function(){
		if($(window).scrollTop()>50){
			$("#btnTop").show();
		}else{
			$("#btnTop").hide();
		}
	});
	$("#btnTop").click(function(){
		$("body").animate({scrollTop:0},10);
	});
	
	//跳转页面
	var gt='.goodsList span, .goodsList h2, .goodsList, .Progress-bar';
	$(document).on('click',gt,function(){
		var id=$(this).attr('id');
		if(id){
			window.location.href=id;
		}			
	});

});

</script>

</div>
</body>
</html>
<style>
#pageDialogBG{-webkit-border-radius:5px; width:255px;height:45px;color:#fff;font-size:16px;text-align:center;line-height:45px;}
</style>
<div id="pageDialogBG" class="pageDialogBG">
<div class="Prompt"></div>
</div>