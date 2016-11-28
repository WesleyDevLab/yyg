<!DOCTYPE html>
<html>
<head>
   <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
   <title>修改密码 </title>
   <meta content="app-id=518966501" name="apple-itunes-app" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
   <meta content="yes" name="apple-mobile-web-app-capable" />
   <meta content="black" name="apple-mobile-web-app-status-bar-style" />
   <meta content="telephone=no" name="format-detection" />
   <script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
   <link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/new.css">
   <link rel="stylesheet" href="../../../html/css/new.css">
</head>
<body style="background-color: #F0EFF5;">
 <div class="h5-1yyg-v1" id="content">
<!-- 栏目页面顶部 -->
<!-- 内页顶部 -->
<form class="registerform" method="post" action="" onsubmit="return check_form();">
<input type="hidden" name="uid" value="">  
<header class="header">
	<div class="n-header-wrap">
		<div class="backbtn">
			<a href="javascript:;" onClick="history.go(-1)" class="h-count white"></a>
		</div>		
		<div class="n-h-tit"><h1 class="header-logo">我的资料</h1></div>
		<a class="data_preserve">保存</a>
	</div>
</header>
	<div class="m-username">
        <input type="text" name="edit_usename" maxlength="10" class="edit_usename" value="<?php echo $member['username'];?>"/>
        <a class="username_del">×</a>        			
  </div>
</form>



</div>

<script>
function check_form(){
  var obj = $('.edit_usename');
  var edit_usename = obj.val();
  if(edit_usename==''){
    $.PageDialog.fail('昵称不能为空!');
    return false;    
  }  
  return true;
}
$(document).ready(function(){
  $('.data_preserve').click(function(){
    $('.registerform').submit();
  })
  $('.username_del').click(function(){
      $('.edit_usename').attr('placeholder','');
      $(".edit_usename").val("");
      var input_val = $('edit_usename').val();
      if(input_val!=''){
        $('edit_usename').val('');
      }
      
  })
})
</script>

</body>
</html>
