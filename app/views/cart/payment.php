<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>结算支付</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css?v=20150129" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/cartList.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
	<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
	<script id="pageJS" data="<?php echo ASSET_FONT;?>/js/mobile/Payment.js" language="javascript" type="text/javascript"></script>
	<script id="pageJS" data="<?php echo ASSET_FONT;?>/js/mobile/recharge.js" language="javascript" type="text/javascript"></script>
</head>
<body>
<style>
.registerCon select{
background: #FFF none repeat scroll 0% 0%;
border: 5px solid #DDD;
color: #CCC;
border-radius: 5px;
padding: 0px 5px;
display: inline-block;
position: relative;
font-size: 16px;
height: 50px;
width: 101%;
}
.registerCon .loading{
	padding-top: 20px;
	color: #999;
}
.registerCon .form{
	display:none;
}


.regular-radio {
	display: none;
}

.regular-radio + label {
	-webkit-appearance: none;
	background-color: #fafafa;
	border: 1px solid #cacece;
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
	padding: 5px;
	border-radius: 50px;
	display: inline-block;
	position: relative;
}

.regular-radio:checked + label:after {
	content: ' ';
	width: 12px;
	height: 12px;
	border-radius: 50px;
	position: absolute;
	top: 0px;
	background: #99a1a7;
	box-shadow: inset 0px 0px 10px rgba(0,0,0,0.3);
	text-shadow: 0px;
	left: 0px;
	font-size: 32px;
}

.regular-radio:checked + label {
	background-color: #e9ecee;
	color: #99a1a7;
	border: 0px solid #ADB8C0;
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1), inset 0px 0px 10px rgba(0,0,0,0.1);
}

.regular-radio + label:active, .regular-radio:checked + label:active {
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
}
</style>
<div class="h5-1yyg-v1">

<!-- 栏目页面顶部 -->


<!-- 内页顶部 -->

<header class="header">
<div class="n-header-wrap">
<div class="backbtn">
<a href="<?php echo G_WEB_PATH.'/cart/cartlist'?>" class="h-count white">
</a>
</div>
<div class="h-top-right ">
<a href="{WEB_PATH}/mobile/home" class="h-search white"></a>
</div>
<div class="n-h-tit"><h1 class="header-logo">结算支付</h1></div>
</div>
</header>

<form id="form_paysubmit" action="<?php echo G_WEB_PATH;?>/cart/paysubmit" method="post">
    <input name="hidShopMoney" type="hidden" id="hidShopMoney" value="<?php echo $MoenyCount;?>" />
    <input name="hidBalance" type="hidden" id="hidBalance" value="<?php echo $Money;?>" />
    <input name="hidPoints" type="hidden" id="hidPoints" value="<?php echo $member['money'];?>" />
    <input name="shopnum" type="hidden" id="shopnum" value="<?php echo $shopnum;?>" />
    <input name="pointsbl" type="hidden" id="pointsbl" value="<?php echo $fufen_dikou;?>" />
    <section class="clearfix g-pay-lst">
		<ul>
		<?php
		foreach($shoplist as $key=>$val){
		?>
			<li>
			    <a href="<?php echo $val['good_url'];?>" class="gray6">(第<?php echo $val['qishu'];?>期)<?php echo $val['title'];?>  </a>
			    <span>
			        <em class="orange arial"><?php echo $val['cart_xiaoji'];?></em>人次
			    </span>
			</li>		
		<?php	
		}
		?>


		</ul>
		<p class="g-pay-Total gray9">合计：<span class="orange arial Fb F16"><?php echo $MoenyCount;?></span> 元</p>
		<p class="g-pay-bline"></p>
    </section>
    <section class="clearfix g-Cart">
	    <article class="clearfix m-round g-pay-ment">
		    <ul id="ulPayway">
		    <?php
		    if($Money >= $MoenyCount){
		    ?>
				<li class="gray9 z-pay-ye z-pay-grayC">
				<i id="spBalance" class="z-pay-ment" sel="0"></i>
				<span>您可以使用元宝付款（账户元宝：<?php echo $Money;?> ）</span>
				</li>		    
		    <?php	
		    }else{
		    ?>
			    <li class="gray6 z-pay-ye z-pay-grayC">
				<a href="<?php echo G_WEB_PATH;?>/cart/userrecharge" class="z-pay-Recharge">去充值</a>
				<span>您的元宝不足（账户元宝：<?php echo $Money;?> ）</span>
				</li>		    
		    <?php	
		    }
		    ?>
		    </ul>
	    </article>
            <br/>
            <?php
            if($Money >= $MoenyCount){
            ?>
            <a id="btnPay" href="javascript:;" class="orgBtn">确认支付</a>
            <?php	
            }
            ?>

        </section>
</form>

<script language="javascript" type="text/javascript">

var Path = new Object();
Path.Skin="<?php echo ASSET_FONT;?>";
Path.Webpath = "<?php echo G_WEB_PATH;?>";
Path.submitcode = '<?php echo $submitcode;?>';

var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
Base.getScript('<?php echo ASSET_FONT;?>/js/mobile/Bottom.js?v=' + GetVerNum());
</script>
</div>
</body>
</html>