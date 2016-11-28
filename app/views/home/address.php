<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>收货地址管理</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/member.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSET_FONT;?>/css/mobile/new.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
    <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
    <script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
<style>
#radio_frame{width：80px;height:23px;display:inline-block;}
span.set_default{margin-left:2px;}
</style>
</head>
<body>
<div class="h5-1yyg-v1" id="loadingPicBlock">

    <!-- 栏目页面顶部 -->


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
            <div class="n-h-tit"><h1 class="header-logo">地址管理</h1></div>
        </div>
    </header>


    <input name="hidTotalCount" type="hidden" id="hidTotalCount" />
    <input name="hidPageMax" type="hidden" id="hidPageMax" />
    <section class="clearfix g-member g-goods">

        <ul id="ulListBox" class="">

			<?php
			foreach($member_dizhi as $dizhi){
			?>
           <li class="addr-current">
                <div class="fl addr_left">
                    <p class="z-gds-tt" style="padding-bottom: 10px;"><?php echo $dizhi['shouhuoren'];?>
                        <span style="float:right;padding-right:20px;"><?php echo $dizhi['mobile'];?></span>
                    </p>
                    <p class="z-gds-tt">收货地址：<?php echo $dizhi['sheng'].$dizhi['shi'].$dizhi['xian'].$dizhi['jiedao'];?></p>
                </div>
                <div class="address_manage">
                	<section id="radio_frame" class="jq_ajax" aid="<?php echo $dizhi['id'];?>">
                        <?php
                        if($dizhi['default']=='Y'){
                        ?>
                        <input id="radio_1" class="radio" name="radio" style="display:none;" type="radio" checked>
                        <label for="radio_1" class="trigger"></label><span class="set_default">设为默认</span>                        
                        <?php	
                        }else{
                        ?>
                        <input id="radio_1" class="radio" name="radio" type="radio">
                        <label for="radio_1" class="trigger"></label><span class="set_default">设为默认</span>                        
                        <?php	
                        }
                        ?>

					</section>
					<div class="del_edit">
                		<div class="addr-arrow" aid="<?php echo $dizhi['id'];?>">编辑</div>
                		<div class="addr-del" aid="<?php echo $dizhi['id'];?>">删除</div>
                	</div>
                </div>
            </li>			
			<?php	
			}
			?>



        </ul>
    </section>

    <section class="clearfix g-member g-goods">
        <div class="add mt10 "><a id="btnAddnewAddr" href="javascript:;" type="button" class="orangebut orgBtn" style="display: block;">添加地址</a></div>

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
    <script>
        $(document).ready(function(){
            var ini_num = $('.addr-current').length;
            if(ini_num==0){
                $('#ulListBox li:eq(0)').addClass('addr-current');
            }
            $('.jq_ajax').click(function(){
                var obj = $(this);
                var aid = obj.attr('aid');
                $('.radio').removeAttr('checked');
                $.post("<?php echo G_WEB_PATH;?>/home/ajax_addr",{id:aid},function(r){
                    history.go(0);
                });
            })            
            $('.addr-del').click(function(){
                var id = $(this).attr('aid');
                if (confirm("您确认要删除该条信息吗？")){
                    window.location.href="<?php echo G_WEB_PATH;?>/home/deladdress/"+id;
                }
            })
            $('.addr-arrow').click(function(){
                var id = $(this).attr('aid');
                window.location.href='<?php echo G_WEB_PATH;?>/home/editadd/'+id;
            })
            $('#btnAddnewAddr').click(function(){
                window.location.href='<?php echo G_WEB_PATH;?>/home/add';
            })
        })
    </script>

</div>
</body>
</html>
