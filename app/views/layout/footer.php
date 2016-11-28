<style type="text/css">
.person_number ul {
    width: 100%;
    height: 72px;
}
p.fast_add {
    text-align: left;
    line-height: 30px;
    height: 40px;
}
.person_number a.selected {
    background-color: #F5484C;
    border: none!important;
    color: #fff!important;
}
.person_number a:active {
    background-color: #F5484C;
    color: #fff!important;
    border: none!important;
}
input#person_time {
    position: relative;
}
ins.person_trip {
    position: absolute;
    right: 38%;
    display: block;
    top: 23%;
}
</style>
<!--选择人数-->
<div class="choose_people" style="display:none;">
    <h2>请选择参与人次</h2>
    <div class="number_various">
        <div class="choose_number">
            <a class="reduce" href="javascript:void(0);"><img src="<?php echo ASSET_FONT;?>/css/images/reduce.png" onclick="Calculation('reduce')"></a>
            <input type="number" class="person_time" value="" id="person_time"/><ins class="person_trip">人次</ins>
            <a class="plus" href="javascript:void(0);"><img src="<?php echo ASSET_FONT;?>/css/images/plus.png"  onclick="Calculation('plus')"></a>
        </div>
        <div id="person_number"  class="person_number">
            <ul class="justify_list">
                <li><a attrnum="10" href="javascript:void(0);">+10</a></li>
                <li><a attrnum="20" href="javascript:void(0);">+20</a></li>
                <li><a attrnum="50" href="javascript:void(0);">+50</a></li>
                <li><a attrnum="100" href="javascript:void(0);">+100</a></li>
                <li style="margin-right:0;"><a attrnum="200" href="javascript:void(0);">+200</a></li>
            </ul>
            <p class="fast_add">(可快速增加参与人次)</p>
        </div>
    </div>
    <div class="surplus">
        <span>您账户当前共有<ins><b id="jq_money"></b></ins>元宝</span>, 
        <a href="<?php echo G_WEB_PATH;?>/cart/userrecharge" style="color:#F5484C;text-decoration: underline;font-size:14px;">去充值</a>
    </div>
    <div class="surplus red">该商品最多购买<ins class="degrees" id="jq_good_enable">86</ins>次</div>
    <a href="" class="confirm_btn">确定</a>
    <a href="" class="closed_btn">×</a>
</div>
<!--END选择人数-->

<footer class="footer">
    <p>&nbsp;</p>
	<p class="grayc">客服热线<span class="orange"><a href="tel:400-805-0095">400-805-0095</a>   </span></p>
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
    var person_enable =   '';                          //个人能够购买的数量
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
        $('#person_time').keyup(function(){
            var v = $(this).val();
            var w = /^[1-9]{1}\d{0,6}$/;
            if (!w.test(v)) {
                alert('只能输正整数哦');
            }
            if(v>9999){
                alert('最长5位数');
                $(this).val(10000);
            }
        })

        
        /**参与弹出选择人数**/
        var showcart = ('.participation');
        $(document).on('click',showcart,function(){
        	//须登录才能购买
        	var obj = $(this);
        	goods_id = obj.attr('attr_goodsid');
        	var attr_num = obj.attr('attr_maxnum');
        	if(attr_num==0){
        		$.PageDialog.fail('该商品已经买完了');
        		return false;
        	}
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
		            $('#jq_good_enable').html(data.goods_enable);

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
            var this_num = obj.val();
            this_num = parseInt(this_num.replace('人次',''));
            
            /*
            if(person_enable >0 && this_num>person_enable){
                alert('您的元宝最多购买'+person_enable+'次');
                $("#person_time").val(person_enable);
                return false;
            }
            */            
            if(this_num>goods_enable){
                alert('该商品最多能购买'+goods_enable+'次');
                $("#person_time").val(goods_enable);
                return false;
            }

        })
        $("#person_number a").click(function(){
            var obj = $(this);

            var old_num = $('.person_time').val();       //人数
            old_num = parseInt(old_num.replace('人次',''));            
            var this_num = parseInt(obj.attr('attrnum'));
            
            this_num += old_num;
            /*
            if(person_enable >0 && this_num>person_enable){
                alert('您的元宝最多购买'+person_enable+'次');
                $("#person_time").val(person_enable);
                return false;
            }
            */
            
            if(this_num>goods_enable){
                alert('该商品最多能购买'+goods_enable+'次');
                $("#person_time").val(goods_enable);
                return false;
            }
            
            $("#person_time").val(this_num);
        })
        //提交直接购物
        $(".confirm_btn").click(function(){
            //$(".weui_mask_transparent").hide();
            var num = $('#person_time').val();
            var old_maxnum_obj = $('.participation');
            var old_attr_maxnum = old_maxnum_obj.attr('attr_maxnum');
            console.log(old_attr_maxnum);
            //console.log(goods_id+'>'+num);
            if(num>0){
                $.getJSON('/ajax/addShopCart/'+goods_id+'/'+num,function(data){
                    if(data.code==1){
                        addsuccess('添加失败');
                    }else if(data.code==0){
                        addsuccess('添加成功');
                        var new_max_num = parseInt(old_attr_maxnum) - num;
                        console.log(new_max_num);
                        old_maxnum_obj.attr('attr_maxnum',new_max_num);
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
            /*
            if(person_enable>0 && now_num>person_enable){
                alert('您的元宝最多购买'+person_enable+'次');
                return false;
            }
            */
            
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
