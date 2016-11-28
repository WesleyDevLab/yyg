<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>收货地址</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css?v=20150129" rel="stylesheet" type="text/css" />
	<link href="<?php echo ASSET_FONT;?>/css/mobile/login.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo ASSET_FONT;?>/js/mobile/area.js"></script>
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
	<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/aui.css">
    <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">

<style>
    .checked{ background: #F5484C!important; }
    .checkedspan{left:-30px!important;}
</style>
</head>
<body>
<!-- 内页顶部 -->
<header class="header">
<div class="n-header-wrap">
<div class="backbtn">
<a href="javascript:;" onclick="history.go(-1)" class="h-count white">
</a>
</div>
<div class="h-top-right ">
<a href="{WEB_PATH}/mobile/home" class="h-search white"></a>
</div>
<div class="n-h-tit"><h1 class="header-logo">编辑收货地址</h1></div>
</div>
</header>

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
</style>

 <section>
     
	   <form class="registerform" method="post" action="<?php echo G_WEB_PATH;?>/home/updateddress" onsubmit="return check_form();">

	<!--
		<div class="registerCon">
			
    	        <ul style="display: block;" class="form">
			
					<li>
					<p>省</p>
						<input name="sheng" placeholder="" value="" type="text">
                    </li>
					<li>
					 <p>市</p>
						<input name="shi" placeholder="" value="" type="text">
                    </li>
					 <li>
					<p>县</p>
						<input name="xian" placeholder="" value="" type="text">
                    </li>
                    </li>
        	        <li>
						<select style="display: none;" name="shi"></select>
                    </li>
        	        <li>
						<select style="display: none;" name="qu"></select>
                    </li>
        	        <li>
						<select style="display: none;" name="jie"></select>
                    </li>
        	        <li>
					<p>详细地址</p>
						<input name="jiedao" placeholder="" value="" type="text">
                    </li>
					<li>
					<p>邮政编码</p>
						<input name="youbian" placeholder="" value="" type="text">
                    </li>
        	        <li>
					<p>收货人</p>
						<input name="shouhuoren" placeholder="" value="" type="text">
                    </li>
        	        <li>
					<p>手机号</p>
						<input name="mobile" placeholder="" value="" type="text">
                    </li>
					
                    <li>
					<input name="default" placeholder="" value="Y" type="hidden">
						<input style="margin-right:20px;" name="submit" class="orangebut" id="btn_consignee_save" value="保存" title="保存提交" type="submit"> 
						
					</li>
                </ul>
				</div>
-->

				
	<br/>	<br/>	
		<div class="aui-content aui-card">       
        <div class="aui-form">
        	<div class="aui-input-row">
                <span class="aui-input-addon">联系人</span>
                <input name="shouhuoren" id="shouhuoren" type="text" class="aui-input" value="<?php echo $member_dizhi['shouhuoren'];?>"/>
            </div>
			<div class="aui-input-row">
                <span class="aui-input-addon">手机号</span>
                <input name="mobile" id="mobile" type="text" class="aui-input" value="<?php echo $member_dizhi['mobile'];?>"/>
            </div>
            <div class="aui-input-row">
            	<span class="aui-input-addon">所在地区</span>
 				<script>var s=["province","city","county"];</script>    
					<select style="margin-bottom:0;border-bottom:0;border-right:0;border-left:0;height:53px;" datatype="*" nullmsg="请选择有效的省市区" class="select" id="province" runat="server" name="sheng"></select>
					<select style="margin-bottom:0;border-bottom:0;border-right:0;border-left:0;height:53px;" datatype="*" nullmsg="请选择有效的省市区" id="city" runat="server" name="shi"></select>
					<select style="margin-bottom:0;border-bottom:0;border-right:0;border-left:0;height:53px;" datatype="*" nullmsg="请选择有效的省市区" id="county" runat="server" name="xian"></select>	
				<script type="text/javascript">setup()</script>        
        	</div>
        	<!-- roby 08-05 
            <div class="aui-input-row">
                <span class="aui-input-addon">省</span>
                <input name="sheng" type="text" class="aui-input" placeholder=""/>
            </div>

            <div class="aui-input-row">
                <span class="aui-input-addon">市</span>
                <input name="shi" type="text" class="aui-input" placeholder=""/>
            </div>
            <div class="aui-input-row">
                <span class="aui-input-addon">县</span>
                <input name="xian" type="text" class="aui-input" placeholder=""/>
            </div>
            -->
            <div class="aui-input-row">
                <span class="aui-input-addon">详细地址</span>
                <input name="jiedao" id="jiedao" type="text" class="aui-input" value="<?php echo $member_dizhi['jiedao'];?>"/>
            </div>
            <!--<div class="aui-input-row">
                <span class="aui-input-addon">邮政编码</span>
                <input name="youbian" type="text" class="aui-input" placeholder=""/>
            </div>-->
            <div class="aui-input-row">
                <span class="aui-input-addon">设为默认地址</span>
                <section id="radio_frame_roby">
					<input id="radio_1" class="radio" name="radio" type="radio" value="<?php echo $member_dizhi['default'];?>">
                    <?php
                    if($member_dizhi['default'] == 'Y'){
					?>
                        <label for="radio_1" class="trigger checked"></label>
                        <span class="checkedspan"></span>					
					<?php                    	
                    }else{
                    ?>
                        <label for="radio_1" class="trigger"></label>
                        <span></span>                    
                    <?php	
                    }
                    ?>

				</section>              
            </div>	
        </div>
    </div>
    	<input name="default" id="default" placeholder="" value="<?php echo $member_dizhi['default'];?>" type="hidden">
        <input name="id" value="<?php echo $member_dizhi['id'];?>" type="hidden" />
		<input style="margin-right:20px;" name="submit" class="aui-btn aui-btn-block aui-btn-success" id="btn_consignee_save" value="保存" title="保存提交" type="submit">
	</form>
</section>





<script>
var spl = new Array("<?php echo $member_dizhi['sheng'];?>", "<?php echo $member_dizhi['shi'];?>", "<?php echo $member_dizhi['xian'];?>");;
$(document).ready(function(){
    //$("#province").append('<option selected value="'+spl[0]+'">'+spl[0]+'</option>');


    $("#province option").each(function(){
        if($(this).html() == spl[0]){
            $(this).attr("selected", true);
            $('#province option:not(:selected)').eq(0).change();
            $(this).click();
        }
    })
    $("#province").append('<option selected value="'+spl[0]+'">'+spl[0]+'</option>');
    $("#city").append('<option selected value="'+spl[1]+'">'+spl[1]+'</option>');
    $("#county").append('<option selected value="'+spl[2]+'">'+spl[2]+'</option>');

    $('#radio_frame_roby').click(function(){
        var defalutVal = $('#default').val();
        if( defalutVal == 'N' ){
            console.log('aa');
            $('#radio_1').attr('checked',true);
            $('.trigger').removeClass('nochecked').addClass('checked');
            $('.trigger').next('span').addClass('checkedspan');
            $('#default').val('Y');
        }else{
            console.log('bb');
            $('.trigger').removeClass('checked');
            $('.trigger').next('span').removeClass('checkedspan');
            $('#radio_1').removeAttr("checked");
            $('#default').val('N');
        }
        return false;
    })
})



</script>

	<script language="javascript" type="text/javascript">
	var Path = new Object();
	Path.Skin="<?php echo ASSET_FONT;?>";
	Path.Webpath = "<?php echo G_WEB_PATH;?>";
	  
	var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
	function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
	Base.getScript('<?php echo ASSET_FONT;?>/js/mobile/Bottom.js?v=' + GetVerNum());

	Base.getScript('<?php echo ASSET_FONT;?>/js/mobile/pageDialog.js?v='+GetVerNum());

function changeStyle(obj){
  var defalutVal = $('#default').val();
  if( defalutVal == 'N' ){
      console.log('aa');
	  $('#radio_1').attr('checked',true);
      $('.trigger').removeClass('nochecked').addClass('checked');
      $('.trigger').next('span').addClass('checkedspan');
	  $('#default').val('Y');
  }else{
      console.log('bb');
      $('.trigger').removeClass('checked');
      $('.trigger').next('span').removeClass('checkedspan');
	  $('#radio_1').removeAttr("checked");
	  $('#default').val('N');
  }
}

function check_form(){
	var shouhuoren = $('#shouhuoren').val();
	var mobile = $('#mobile').val();
	if(shouhuoren == ''){
		$.PageDialog.fail('收货人不能为空');
		return false;
	}
	if(mobile == ''){
		$.PageDialog.fail('手机号不能为空');
		return false;
	}
	var w = /^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/;
	if(!w.test(mobile)){
		$.PageDialog.fail('请输入正确的手机号码');
		return false;
	}

	var province = $('#province option:selected').val();
	var city = $('#city option:selected').val();
	var county = $('#county option:selected').val();
	var jiedao = $('#jiedao').val();
	if(province=='' || province=='选择省份'){
		$.PageDialog.fail('请选择省份');
		return false;
	}
	if(city=='' || city=='选择城市'){
		$.PageDialog.fail('请选择城市');
		return false;
	}
	if(county=='' || county=='选择县/区'){
		$.PageDialog.fail('请选择县/区');
		return false;
	}
	if(jiedao==''){
		$.PageDialog.fail('详细地址不能为空');
		return false;
	}
	
	return true;
}
</script>

    </div>

