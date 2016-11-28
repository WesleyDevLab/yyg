<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
    <title>我的资料</title>
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css?v=130715" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/member.css?v=130726" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/new.css?v=130726" rel="stylesheet" type="text/css" />
    <script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
    <script src="<?php echo ASSET_FONT;?>/js/mobile/exif.js?v=130726"></script>
    <script src="<?php echo ASSET_FONT;?>/js/mobile/imghelper.js?v=130726"></script>
</head>
<style>
    .u-mbr-info li {
        width: 100%;
        line-height: 55px;
        padding: 3px 0;
        float: left;
        text-align: left;
        text-indent: 5px;
    }
    .m-name-info{
        border-left:none;
    }
    a.fr.z-Recharge-btn{
        border:1px solid #F5484C;
        background-color: #fff;
        color:#F5484C;
        padding:1px 10px;
        border-radius: 5px;
    }
    .u-name {
        height: 32px;
        line-height: 47px;
    }
    .home_nc{
        background: url(<?php echo ASSET_FONT;?>/css/images/icon_nc@2x.png) 10px 14px no-repeat;
        background-size: 20px 20px;        
    }
</style>
<script type="text/javascript">
  //图片上传预览  
    function previewImage(file)
    {
      var MAXWIDTH  = 60; 
      var MAXHEIGHT = 60;
      var div = document.getElementById('preview');
      console.log('000');
      if (file.files && file.files[0])
      {
          div.innerHTML ='<img id=imghead>';
          var img = new Image();
          var showimg = document.getElementById('imghead');
          console.log('111');
		 // var URL = URL || webkitURL;  
		//获取照片方向角属性，用户旋转控制  
		var Orientation = null;
		EXIF.getData(file.files[0], function() {  
			//alert(EXIF.pretty(this));  
			EXIF.getAllTags(this);   
			//alert(EXIF.getTag(this, 'Orientation'));   
			Orientation = EXIF.getTag(this, 'Orientation');  
			//return;  
		});  
		
		var reader = new FileReader();
		reader.onload = function (e) {
		
		    var img = new Image();
		    img.src = e.target.result;
		
		    img.onload = function () {
		        var data = compress(this,Orientation);
		        showimg.src = data;
		        
	            var uid = <?php echo $member['uid'];?>;
	            var newBase64 = data.replace(/\+/g, "%2B");        //防止
	            $.ajax({
	                   type: "POST",
	                   url: "/home/editImg",
	                   data: "id="+uid+"&img="+newBase64,
	                   success: function(r){
	                     console.log(r);
	                }
	            }); 
		    }
		};
		reader.readAsDataURL(file.files[0]);
          
          
          
  
      }
      else //兼容IE用了滤镜
      {
        var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
        file.select();
        var src = document.selection.createRange().text;
        div.innerHTML = '<img id=imghead>';
        var img = document.getElementById('imghead');
        img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
        status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
        div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
      }


    }
    

 

    //将图片压缩转成base64 
    function getBase64Image(img) { 
    	var square = 320;
        var canvas = document.createElement("canvas"); 
        var width = 320; 
        var height = 320; 
        // calculate the width and height, constraining the proportions 
        if (width > height) { 
            if (width > 120) { 
                height = Math.round(height *= 120 / width); 
                width = 120; 
            } 
        } else { 
            if (height > 120) { 
                width = Math.round(width *= 120 / height); 
                height = 120; 
            } 
        } 
        canvas.width = width;   /*设置新的图片的宽度*/ 
        canvas.height = height; /*设置新的图片的长度*/ 
        var ctx = canvas.getContext("2d");
        ctx.clearRect(0, 0, square, square); 
        
		ctx.drawImage(img, 0, 0, width, height); /*绘图*/ 
        var dataURL = canvas.toDataURL("image/png", 0.8); 
        return dataURL;
        
                
        
        //return dataURL.replace("data:image/png;base64,", ""); 
    } 
 
    function clacImgZoomParam( maxWidth, maxHeight, width, height ){
        var param = {top:0, left:0, width:width, height:height};
        if( width>maxWidth || height>maxHeight )
        {
            rateWidth = width / maxWidth;
            rateHeight = height / maxHeight;
            
            if( rateWidth > rateHeight )
            {
                param.width =  maxWidth;
                param.height = Math.round(height / rateWidth);
            }else
            {
                param.width = Math.round(width / rateHeight);
                param.height = maxHeight;
            }
        }
        
        param.left = Math.round((maxWidth - param.width) / 2);
        param.top = Math.round((maxHeight - param.height) / 2);
        return param;
    }
</script>
<body>
<div class="h5-1yyg-v11">   
<!-- 栏目页面顶部 -->
<!-- 内页顶部 -->
<header class="header">
    <div class="n-header-wrap">
        <div class="backbtn">
            <a href="<?php echo G_WEB_PATH.'/home'?>" class="h-count white"></a>
        </div>      
        <div class="n-h-tit"><h1 class="header-logo">我的资料</h1></div>
    </div>
</header>
    <section class="clearfix g-member">
        <div class="clearfix m-round m-name" style="text-align:center;width:100%;">
            <div class="f-Himg" id="preview" style="text-align:center;width:100%;">
                <a href="#" class="z-Himg">
                    <?php
                        if(strpos($member['img'],'http://')!== false){
                        ?>
                        <img src="<?php echo $member['img'];?>" id="imghead" border=0/>
                        <?php    
                        }else{
                        ?>
                        <img src="<?php echo G_WEB_PATH.$member['img'];?>" id="imghead" border=0/>
                        <?php    
                        }
                    ?>
                    
                </a>
            </div>
            <input type="file" class="edit_pho" style="position:absoulte;left:42%;top:55px;" onchange="previewImage(this)" />
            <!--
            <div class="m-name-info">
                <p class="u-name"><a class="z-name gray01" href="<?php echo G_WEB_PATH.'/home/edit_username/'.$member['uid'];?>"><?php echo $member['user'];?></a></p>
                <ul class="clearfix u-mbr-info">
        
                <li><span style="color:#F5484C;">元宝 <?php echo $member['money'];?></span>
                <a style="margin-right:10px;" href="<?php echo G_WEB_PATH;?>/cart/userrecharge" class="fr z-Recharge-btn">充值</a></li>
                </ul>
            </div>
            -->
        </div>
        <div class="m-round m-member-nav">
            <ul id="ulFun">              
                <li class="home_nc"><a href="<?php echo G_WEB_PATH.'/home/edit_username/'.$member['uid'];?>">
                <b class="z-arrow"></b>昵称
                    <ins><?php echo $member['username'];?></ins>                              
                </a>
                </li>                
                <!--<li><a href="http://wx.91k8.me/index.php/mobile/invite/friends"><img src="http://wx.91k8.me/statics/templates/yungou/css/images/play_car.png"><b class="z-arrow"></b>邀请管理</a></li>-->
                
                <li class="home_blinding"><a href="<?php echo G_WEB_PATH?>/home/mobilechecking">
                <b class="z-arrow"></b>绑定手机号
                    <?php
                        if($member['mobile'] != ''){
                            echo "<ins style='color:red;'>已绑定</ins>";
                        }else{
                            echo "<ins>未绑定</ins>";
                        }
                    ?>                                
                </a>
                </li>
                <li class="home_address"><a href="<?php echo G_WEB_PATH;?>/home/address"><b class="z-arrow"></b>我的收货地址</a></li>
                <!--<li><a href="http://wx.91k8.me/index.php/mobile/user/headimg"><b class="z-arrow"></b>修改头像</a></li>-->
                <!--<li><a href="http://wx.91k8.me/index.php/mobile/user/profile"><b class="z-arrow"></b>修改资料</a></li>-->
                <li class="home_password"><a href="<?php echo G_WEB_PATH;?>/home/password"><b class="z-arrow"></b>修改密码</a></li>             
            </ul>
        </div>
        <a href="<?php echo G_WEB_PATH;?>/user/cook_end" id="btnLogin" class="nextBtn orgBtn">退出登录</a>
    </section>


 



<script language="javascript" type="text/javascript">
var Path = new Object();
Path.Skin="<?php echo ASSET_FONT;?>";
Path.Webpath = "<?php echo G_WEB_PATH;?>";
  
var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
Base.getScript('<?php echo ASSET_FONT;?>/js/mobile/Bottom.js?v=' + GetVerNum());
</script> 


<script src="http://static.jsbin.com/js/render/edit.js?3.40.2"></script>

</div>
