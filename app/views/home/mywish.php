<!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>我的心愿</title>
<meta content="app-id=518966501" name="apple-itunes-app" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ASSET_FONT;?>/css/mobile/goods.css" rel="stylesheet" type="text/css" />
<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
<link href="<?php echo ASSET_FONT;?>/css/mobile/new.css?v=123" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	/**最新揭晓倒计时**/
	function fresh() {
            var d = "2016-10-30";
            var endtime = new Date(d);
            var nowtime = new Date();
            var leftsecond = parseInt((endtime.getTime() - nowtime.getTime()) / 1000);
            d = parseInt(leftsecond / 3600 / 24);
            h = parseInt((leftsecond / 3600) % 24);
            m = parseInt((leftsecond / 60) % 60);
            s = parseInt(leftsecond % 60);
            var td = d * 24 + h;
            if(td<10){
         		td="0"+td
         	}
            if(m<10){
         		m="0"+m
         	}
            if(s<10){
         		s="0"+s
         	}
            $("#emH").html(td);
            $("#emM").html(m);
            $("#emS").html(s);
            if (leftsecond <= 0) {
                    $("#emH").html("00");
                    $("#emM").html("00");
                    $("#emS").html("00");
                clearInterval(sh);
            }
        }
        fresh();
        var sh;
        sh = setInterval(fresh, 1000);
</script>
</head>
<body>

<header class="header">
    <div class="n-header-wrap">
        <div class="backbtn">
            <a href="javascript:;" onClick="history.go(-1)" class="h-count white">
            </a>
        </div>


        <div class="n-h-tit"><h1 class="header-logo">我的心愿</h1></div>
    </div>
</header><script src="http://wx.91k8.me/statics/templates/yungou/js/mobile/ajax.js"></script>

<!-- 内页顶部 -->

    <section class="goodsCon">
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

    var cateid = getParam('cateid');
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
//获得两数相除百分比
function percentNum(num, num2) {
	return (Math.round(num / num2 * 10000) / 100.00 + "%"); //小数点后两位百分比
}
//获取数据
function glist_json(parm){
	$("#urladdress").val('');
	$("#pagenum").val('');
	$.getJSON('<?php echo G_WEB_PATH?>/goods/getXyAjax/'+parm,function(data){
		$("#divGoodsLoading").css('display','none');
        console.log(data);
		//roby 8-8将价格排序变为可切换
		var canshu = parm.split('/');
		var sort = canshu[1];		
		if(sort=='50'){
			$("#divGoodsNav li").eq(3).attr('order',60);
		}
		if(sort == '60'){
			$("#divGoodsNav li").eq(3).attr('order',50);
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
			for(var i=0;i<data.length;i++){
			var ul ='<ul>';
			    ul +='<li>';
			  	ul +='<span id="'+data[i].good_url+'" class="z-Limg"><img src="'+data[i].thumb+'"></span>';
			    ul +='<div class="goodsListR">';
			    ul +='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].good_url+'"><em class="red">【待上线】</em>'+data[i].title+'</h2></a>';
				ul +='<div class="pRate">';
				ul +='<div class="Progress-bar">';
				ul +='<p class="u-progress" title="已完成'+data[i].xinyuan/5000+'%">';
				ul +='<span class="pgbar" style="width:'+data[i].xinyuan/5000+'%">';
				ul +='<span class="pging"></span>';
				ul +='</span>';
				ul +='</p>';
				ul +='<ul class="Pro-bar-li">';
				ul +='<li class="P-bar02">许愿人次<em class="red">'+data[i].xinyuan+'</em></li>';						
				ul +='</ul></div><a id="not_online"></a></div></div>';
			  	ul +='</li></ul>';			

				$("#divGoodsLoading").before(ul);			
			}
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
	//添加到购物车
	$(document).on("click",'.add',function(){
		var codeid=$(this).attr('codeid');
		$.getJSON('http://wx.91k8.me/index.php/mobile/ajax/addShopCart/'+codeid+'/1',function(data){
			if(data.code==1){
				addsuccess('添加失败');
			}else if(data.code==0){
				addsuccess('添加成功');				
			}return false;
		});
	});
	function addsuccess(dat){
		$("#pageDialogBG .Prompt").text("");
		var w=($(window).width()-255)/2,
			h=($(window).height()-45)/2;
		$("#pageDialogBG").css({top:h,left:w,opacity:0.8});
		$("#pageDialogBG").stop().fadeIn(1000);
		$("#pageDialogBG .Prompt").append('<s></s>'+dat);
		$("#pageDialogBG").fadeOut(1000);
		//购物车数量
		$.getJSON('http://wx.91k8.me/index.php/mobile/ajax/cartnum',function(data){
			$("#btnCart").append('<em>'+data.num+'</em>');
		});
	}
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