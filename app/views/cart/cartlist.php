<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>购物车</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css?v=20150129" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/cartList.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
	<script id="pageJS" data="<?php echo ASSET_FONT;?>/js/mobile/Cartindex.js" language="javascript" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
</head>
<body>
<div class="h5-1yyg-v1" id="loadingPicBlock">

<!-- 栏目页面顶部 -->


<!-- 内页顶部 -->

<header class="header">
<div class="n-header-wrap">
<div class="backbtn">
<a href="javascript:;" onClick="history.go(-1)" class="h-count white">
</a>
</div>

<div class="n-h-tit"><h1 class="header-logo">购物车</h1></div>
</div>
<script type="text/javascript">

</script>
</header>

    <input name="hidLogined" type="hidden" id="hidLogined" value="1" />
    <section class="clearfix g-Cart">
    	<?php
    	if($shop){
		?>
 	      <article class="clearfix m-round g-Cart-list">
	            <ul id="cartBody">
	            	<?php
		    		$buyshopmoney=0;
		    		foreach($shoplist as $key=>$val){
						   $num = count($shoplist);
						   $buyshopmoney+=$Mcartlist[$val['id']]['num']*$Mcartlist[$val['id']]['money'];    			
		    			            	
	            	?>
					<li>
						<a class="fl u-Cart-img" href="<?php echo $val['good_url']?>">
							<img src="<?php echo ASSET_FONT;?>/images/loading.gif" src2="<?php echo G_WEB_PATH.$val['thumb'];?>" border="0" alt=""/>
						</a>
						<div class="u-Cart-r">
							<p class="z-Cart-tt"><a href="<?php echo G_WEB_PATH?>/goods/<?php echo $val['id'];?>" class="gray6">(第<?php echo $val['qishu'];?>期)<?php echo $val['title'];?></a></p>
							<ins class="z-promo gray9">剩余<em class="arial"><?php echo $val['zongrenshu']-$val['canyurenshu'];?></em>人次</ins>
							<p class="gray9">总共1元淘：<em class="arial"><?php echo $Mcartlist[$val['id']]['num'];?></em>人次/<em class="orange arial">￥<?php echo $Mcartlist[$val['id']]['money']*$Mcartlist[$val['id']]['num'];?>.00</em></p>
							<p class="f-Cart-Other">
								<a href="javascript:;" class="fr z-del" name="delLink" cid="<?php echo $val['id'];?>"></a>
								<a href="javascript:;" class="fl z-jian <?php echo ($Mcartlist[$val['id']]['num']==1) ? 'z-jiandis': '';?> ">-</a>

								<input id="txtNum<?php echo $val['id'];?>" name="num" data-money="<?php echo $Mcartlist[$val['id']]['money'];?>" type="text" maxlength="7" value="<?php echo $Mcartlist[$val['id']]['num'];?>" class="fl z-amount" />
								<a href="javascript:;" class="fl z-jia <?php echo ($Mcartlist[$val['id']]['num']==$val['zongrenshu']) ? 'z-jiadis' : ''?>">+</a>
								<input type="hidden" value="<?php echo $Mcartlist[$val['id']]['num'];?>" />
								<input type="hidden" value="<?php echo $val['zongrenshu']-$val['canyurenshu'];?>" />
							</p>
						</div>
					</li>
		    		<?php
		    		}
		    		?>
	            </ul>
	        </article>		



	    <div id="divBtmMoney" class="g-Total-bt"><p>总共1元淘
			<span class="orange arial z-user"><?php echo $num;?></span>个商品  合计元宝：
			<span class="orange arial"><?php echo $buyshopmoney;?></span> </p>
			<a href="javascript:;" class="orgBtn">结 算</a>
		</div>   	
    	<?php	
    	}
    	?>

	    <div id="divNone" class="haveNot z-minheight" style="display:none"><s></s><p>抱歉，您的购物车没有商品记录！</p>
		</div>

    </section>


<script language="javascript" type="text/javascript">

var Path = new Object();
Path.Skin="<?php echo ASSET_FONT;?>";
Path.Webpath = "<?php echo G_WEB_PATH;?>";


var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
Base.getScript('<?php echo ASSET_FONT;?>/js/mobile/Bottom.js?v=' + GetVerNum());
</script>

<footer class="footer">
    <p>&nbsp;</p>
	<p class="grayc">客服热线<span class="orange"><a href="400-805-0095">400-805-0095</a>   </span></p>
	<!--<p class="grayc">{wc:fun:_cfg('web_copyright')}</p>-->
	<a id="btnTop" href="javascript:;" class="z-top" style="display:none;">
		<!-- <b class="z-arrow"></b> --><img src="<?php echo ASSET_FONT;?>/css/images/stick01.png">
	</a>
	<a id="shopping_cart" href="/cart/cartlist" class="z-shoppingcart">
		<img src="<?php echo ASSET_FONT;?>/css/images/shopping_cart01.png">
		<ins></ins>
	</a>
</footer>
    
<p>
	<br />
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>



<div class="footerdi" style="bottom: 0px;">
	<ul>
		<li class="f_home">
			<a title="首页" href="<?php echo G_WEB_PATH;?>"><i class="<?php echo ($curr=='index') ? 'cur' : ''?>">&nbsp;</i>首页</a>
		</li>
		<!--<li class="f_whole">
			<a title="所有商品" href="http://wx.91k8.me/index.php/mobile/mobile/glist"><i class="">&nbsp;</i>所有商品</a>
		</li>-->
		<li class="f_jiexiao">
			<a title="即将揭晓" href="<?php echo G_WEB_PATH;?>/index/jiexiao/soon"><i class="<?php echo ($curr=='lottery') ? 'cur' : ''?>">&nbsp;</i>即将揭晓</a>
		</li>
		<li class="f_car">
			<a title="购物车" href="<?php echo G_WEB_PATH;?>/cart/cartlist"><i class="<?php echo ($curr=='cart') ? 'cur' : ''?>">&nbsp;</i>购物车</a>
		</li>
		<li class="f_personal">
			<a title="我的云购" href="<?php echo G_WEB_PATH;?>/home"><i class="<?php echo ($curr=='home') ? 'cur' : ''?>">&nbsp;</i>个人中心</a>
		<li>
	</ul>
</div>
<script src="<?php echo ASSET_FONT;?>/js/mobile/pageDialog.js" language="javascript" type="text/javascript"></script>
<script>
    var init_step = 1;
    var person_enable =  <?php echo $person_enable;?>;                          //个人能够购买的数量
    var goods_enable = '';                             //商品能够购买的数量
    var goods_id = '';


    function go_buy()
    {
        //alert('12321');
    }

    $(document).ready(function(){
        // update 08-23
        $.getJSON('/ajax/cartnum',function(data){
            $("#btnCart").append('<em>'+data.num+'</em>');
            if(data.num > 0){
                $('#shopping_cart ins').html(data.num);
            }

        });
        $('#person_time').focus(function(){
            var v = $(this).val();
            var w = /^[1-9]{1}\d{0,6}$/;
            if (!w.test(v)) {
                alert('只能输正整数哦');
            }
        })
        /**参与弹出选择人数**/
        var showcart = ('.participation');
        $(document).on('click',showcart,function(){
        	//须登录才能购买
        	var obj = $(this);
        	goods_id = obj.attr('attr_goodsid');
	        $.getJSON('/ajax/islogin/'+goods_id,function(data){	            
	            if(data.code == 400){
	                $.PageDialog.fail('登录后才能购买');
	                return false;
	            }else{
		            if($(this).hasClass('canyudis')){
		                return false;
		            }
		            var default_times = obj.attr('attr_times');
		            goods_enable = obj.attr('attr_maxnum');
		            goods_id = obj.attr('attr_goodsid');
		            person_enable = data.person_enable;
		            goods_enable = data.goods_enable;
		            init_step = data.init_step;
		            $(".choose_people").show();
		            $(".weui_mask_transparent").show();
		            $('#jq_money').html(person_enable);
		            if(default_times>0){
		                $('.person_time').val(default_times);
		            }else{
		                $('.person_time').val(1);
		            }	            	
	            }	
	        });

        });



        $('.person_time').blur(function(){
            var obj = $(this);
            var this_num = parseInt(obj.val());
            
            if(person_enable >0 && this_num>person_enable){
                alert('您的元宝最多购买'+person_enable+'次');
                $("#person_time").val(person_enable);
                return false;
            }
            
            if(this_num>goods_enable){
                alert('该商品最多能购买'+goods_enable+'次');
                $("#person_time").val(goods_enable);
                return false;
            }


        })
        $("#person_number a").click(function(){
            var obj = $(this);
            var this_num = parseInt(obj.html());
            
            if(person_enable >0 && this_num>person_enable){
                alert('您的元宝最多购买'+person_enable+'次');
                $("#person_time").val(person_enable);
                return false;
            }
            
            if(this_num>goods_enable){
                alert('该商品最多能购买'+goods_enable+'次');
                $("#person_time").val(goods_enable);
                return false;
            }
            $("#person_number a").removeClass("selected");
            obj.addClass("selected");
            $("#person_time").val(this_num);
        })
        //提交直接购物
        $(".confirm_btn").click(function(){
            //$(".weui_mask_transparent").hide();
            var num = $('#person_time').val();
            //console.log(goods_id+'>'+num);
            if(num>0){
                $.getJSON('/ajax/addShopCart/'+goods_id+'/'+num,function(data){
                	console.log(goods_id);
                    if(data.code==1){
                        addsuccess('添加失败');
                    }else if(data.code==0){
                        addsuccess('添加成功');
                        //location.href="/mobile/cart/cartlist";
                    }
                });
                return false;
            }else{
                alert('请添加数量');
            }

        });
        function addsuccess(dat){
            $('.choose_people').hide();
            $('.weui_mask_transparent').css('display','none');
            $("#pageDialogBG .Prompt").text("");
            var w=($(window).width()-255)/2,
                    h=($(window).height()-45)/2;
            $("#pageDialogBG").css({top:h,left:w,opacity:0.8});
            $("#pageDialogBG").stop().fadeIn(1000);
            $("#pageDialogBG .Prompt").append('<s></s>'+dat);
            $("#pageDialogBG").fadeOut(1000);
            //购物车数量
            $.getJSON('/ajax/cartnum',function(data){
                $("#btnCart").append('<em>'+data.num+'</em>');
                if(data.num > 0){
                    $('#shopping_cart ins').html(data.num);
                }
            });
        }


    })
    //点击加减方法
    function Calculation(obj){
        var old_num = parseInt($("#person_time").val());    //当前购买次数
        if(obj =="reduce"){         //减
            if(old_num>init_step){
                $("#person_time").val(old_num-init_step);
            }else{
                alert('亲，不能再减了');
                return false;
            }
        }else if(obj =="plus"){
            var now_num = old_num + init_step;
            
            if(person_enable>0 && now_num>person_enable){
                alert('您的元宝最多购买'+person_enable+'次');
                return false;
            }
            
            if(now_num>goods_enable){
                alert('该商品最多能购买'+goods_enable+'次');
                return false;
            }
            $("#person_time").val(now_num);
        }
    }
    //点击数字方法
    function selected(id){
        $("#person_number a").each(function(){
            $(this).removeClass("selected");
            if($(this).attr("id") == id ){
                $(this).addClass("selected");
                $("#person_time").val($(this).text());
            }
        });
    }
</script>


</div>
</body>
</html>
