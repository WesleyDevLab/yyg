<!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>获得的商品</title>
<meta content="app-id=518966501" name="apple-itunes-app" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ASSET_FONT;?>/css/mobile/goods.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ASSET_FONT;?>/css/mobile/lottery.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ASSET_FONT;?>/css/mobile/member.css" rel="stylesheet" type="text/css" /> 
<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo ASSET_FONT;?>/js/mobile/goods.js" language="javascript" type="text/javascript"></script>
<link href="<?php echo ASSET_FONT;?>/css/mobile/new.css?v=24" rel="stylesheet" type="text/css" />
<link href="../html/css/new.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="weui_mask_transparent"></div>
<!--选择人次-->
<div class="choose_people" style="display:none;">
    <h2>请选择参与人次</h2>
    <div class="number_various">
    	<div class="choose_number">
        	<a class="reduce"><img src="http://wx.91k8.me/statics/templates/yungou/css/images/reduce.png" onclick="Calculation('reduce')"></a>
        	<input type="number" class="person_time" value="" id="person_time"/>
        	<a class="plus"><img src="http://wx.91k8.me/statics/templates/yungou/css/images/plus.png"  onclick="Calculation('plus')"></a>
        </div>
        <div id="person_number"  class="person_number">
            <ul class="justify_list"> 
                <li><a id="number_10" href="javascript:void(0);">10</a></li>
                <li><a id="number_20" href="javascript:void(0);">20</a></li>
                <li><a id="number_50" href="javascript:void(0);">50</a></li>
                <li><a id="number_100" href="javascript:void(0);">100</a></li>
                <li style="margin-right:0;"><a id="number_200" href="javascript:void(0);">200</a></li>
            </ul>
        </div>
    </div>
    <div class="surplus">
   		<span>您账户当前共有<ins><b id="jq_money"></b></ins>元宝</span>, 
   		<a href="http://wx.91k8.me/index.php/mobile/home/userrecharge" style="color:#F5484C;text-decoration: underline;font-size:14px;">去充值</a>
   	</div>
   	<div class="surplus red">该商品最多购买<ins class="degrees">86</ins>次</div>
		<a href="" class="confirm_btn">确定</a>
		<a href="" class="closed_btn" onclick="choose_people.style.display='none'">×</a>
	</div>
    <div class="h5-1yyg-v1" id="loadingPicBlock">
  
<header class="header">
    <div class="n-header-wrap">
        <div class="backbtn">
            <a href="javascript:;" onClick="history.go(-1)" class="h-count white"></a>
        </div>
		<div class="n-h-tit"><h1 class="header-logo">获得的商品</h1></div>
    </div>
</header>
    <div class="goodsList">   	
		<div id="divGoodsLoading" class="loading" style="display:none;"><b></b>正在加载...</div>		
        <a id="btnLoadMore" class="loading" href="javascript:;" style="display: block;">点击加载更多</a>
        <a id="btnLoadMore2" class="loading" style="display:none;">没有数据</a>
        <a id="btnLoadMore3" class="loading" style="display:none;">已经到底了</a>
    </div>
    <input id="urladdress" value="" type="hidden" />
    <input id="pagenum" value="" type="hidden" />	
	

﻿

<script>
    var init_step = 5;
    var person_enable =   16;                          //个人能够购买的数量
    var goods_enable = 120;                            //商品能够购买的数量
    var goods_id = '';


    function go_buy()
    {
        //alert('12321');
    }




</script>
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
var cateid = '';
window.onload=function(){    
    glist_json(cateid);
}
 
//获取数据
function glist_json(parm){
	$("#urladdress").val('');
	$("#pagenum").val('');
	console.log(parm);
	$.getJSON('<?php echo G_WEB_PATH?>/goods/getOrderList/'+parm,function(data){
		$("#divGoodsLoading").css('display','none');
		//roby 8-8将价格排序变为可切换
		var canshu = parm.split('/');
		var sort = canshu[1];		
		if(data[0].sum){
			var fg=parm.split("/");
			$("#urladdress").val(fg[0]+'/'+fg[1]);
			$("#pagenum").val(data[0].page);
			//要判断是 上线商品【正常商品，限时揭晓商品】、未上线商品 
	
			var webpath = '<?php echo G_WEB_PATH;?>';
			console.log(webpath+'fff');
for(var i=0;i<data.length;i++){
		if(data[i].q_uid>0){			//往期揭晓
			var timestamp = new Date(parseInt(data[i].q_end_time)*1000);						
			var date = dateToStr(timestamp);			
			var ul='<ul><li>';
				ul+='<span id="'+data[i].good_url+'" class="z-Limg">';
				ul+= '<a class="fl z-Limg"><span class="z-Imgbg z-ImgbgC02"></span><em class="z-Imgtxt">已揭晓</em><img src="'+webpath+data[i].thumb+'"  border="0"></a></span>';
				ul+='<div class="goodsListR">';
				ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].good_url+'"><em class="red">【恭喜】</em>您获得'+(data[i].title).substr(0,15)+'</h2></a>';
				ul+='<div class="pRate">';
				ul+='<p>幸运一元淘码：<em class="red">'+data[i].q_user_code+'</em></p><p style="color:#B5B5B5">揭晓时间：'+date+'</p>'
				ul+='</div></div></li></ul>';	
		}else{
			if(data[i].xsjx_time!=0){		//限时商品[不可能购完] 
				var timestamp = new Date(parseInt(data[i].xsjx_time)*1000);						
				var date = dateToStr(timestamp);
				fresh(date,i);
				var nowtimestamp = Date.parse(new Date());			//当前时间
				if(nowtimestamp > timestamp){						//揭晓时间已过了，等待开奖
					var ul='<ul><li>';
						ul+='<span id="'+data[i].good_url+'" class="z-Limg"><img src="'+webpath+data[i].thumb+'"></span>';
						ul+='<div class="goodsListR">';
						ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].good_url+'"><em class="red">【第'+data[i]['qishu']+'期】</em>'+(data[i].title).substr(0,15)+'</h2></a>';
						ul+='<div class="pRate">';
						ul+='<div class="lottery_wait">等待开奖</div>';
						ul+='</ul></div>';							
				}else{
					var ul='<ul><li>';
					ul+='<span id="'+data[i].good_url+'" class="z-Limg">';
					ul+= '<a class="fl z-Limg"><span class="z-Imgbg z-ImgbgC01"></span><em class="z-Imgtxt">进行中</em><img src="'+webpath+data[i].thumb+'"  border="0"></a></span>';
					ul+='<div class="goodsListR">';
					ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].good_url+'"><em class="red">【第'+data[i].qishu+'期】</em>'+(data[i].title).substr(0,15)+'</h2></a>';
					ul+='<div class="pRate">';
					ul+= '<div class="announce_countdown">揭晓倒计时';			        	
				    ul+= '<em id="emH'+i+'">16</em> <strong>:</strong><em id="emM'+i+'">20</em><strong>:</strong><em id="emS'+i+'">21</em>';
				    ul+= '</div>';
					ul+= '</div></div></li></ul>';							
				}			
			}else{
				if(data[i].shenyurenshu == 0){			//卖完了，等待开奖
					var ul='<ul><li>';
						ul+='<span id="'+data[i].good_url+'" class="z-Limg">';
						ul+= '<a class="fl z-Limg"><span class="z-Imgbg z-ImgbgC02"></span><em class="z-Imgtxt">已揭晓</em><img src="'+webpath+data[i].thumb+'"  border="0"></a></span>';
						ul+='<div class="goodsListR">';
						ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].good_url+'"><em class="red">【第'+data[i]['qishu']+'期】</em>'+(data[i].title).substr(0,15)+'</h2></a>';
						ul+='<div class="pRate">';
						ul+='<div class="lottery_wait">等待开奖</div>';
						ul+='</ul></div>';
				}else{
					var ul='<ul><li>';
						ul+='<span id="'+data[i].good_url+'" class="z-Limg">';
						ul+= '<a class="fl z-Limg"><span class="z-Imgbg z-ImgbgC02"></span><em class="z-Imgtxt">已揭晓</em><img src="'+webpath+data[i].thumb+'"  border="0"></a></span>';
						ul+='<div class="goodsListR">';
						ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].good_url+'"><em class="red">【第'+data[i]['qishu']+'期】</em>'+(data[i].title).substr(0,15)+'</h2></a>';
						ul+='<div class="pRate">';
						ul+='<div class="Progress-bar" id="'+data[i].good_url+'">';				
						ul+='<p class="u-progress"><span class="pgbar" style="width:'+(data[i].gonumber / data[i].zongrenshu)*100+'%;"><span class="pging"></span></span></p>';
						ul+='<ul class="Pro-bar-li">';
						ul+='<li class="P-bar02"><em>'+data[i].gonumber+'</em>已参与22</li>';
						ul+='</ul></div>';
						ul+='</div></div></li></ul>';						
				}

			}		
		}
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
	//加载更多
	$("#btnLoadMore").click(function(){		
		var url=$("#urladdress").val(),
			page=$("#pagenum").val();
		glist_json(cateid+'/'+page);
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
	var gt='.goodsList span,.goodsList h2, .goodsList, .Progress-bar';
	$(document).on('click',gt,function(){
		var id=$(this).attr('id');
		if(id){
			window.location.href=id;
		}			
	});

});

</script>

</div>

<style>
#pageDialogBG{-webkit-border-radius:5px; width:255px;height:45px;color:#fff;font-size:16px;text-align:center;line-height:45px;}
</style>
<div id="pageDialogBG" class="pageDialogBG">
<div class="Prompt"></div>
</div>