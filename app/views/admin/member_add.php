<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页</title>
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/style.css?v=1" type="text/css">
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_PLUGIN_PATH; ?>/uploadify/jquery.uploadify.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo G_PLUGIN_PATH; ?>/uploadify/uploadify.css">
<link rel="stylesheet" href="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar-blue.css" type="text/css"> 
<script type="text/javascript" charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar.js"></script>

<link rel="stylesheet" href="<?php echo G_PLUGIN_PATH; ?>/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/kindeditor/kindeditor-all.js?v=334455"></script>
<script charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/kindeditor/kindeditor.configs.js"></script>
<script src="<?php echo ASSET_BAK ?>/js/roby.js"></script>


<style>
	.bg{background:#fff url(<?php echo G_GLOBAL_STYLE; ?>/global/image/ruler.gif) repeat-x scroll 0 9px }
	.color_window_td a{ float:left; margin:0px 10px;}
	.show_unit_pic{float:left;padding-right:10px;}
	.uploadify{float:left;margin-top:10px;}
	.uploadify-queue{margin-top:40px;}
	.uploadpicarr .picarr-title{padding-bottom:0;}
</style>
</head>
<body>
<script>
<?php $timestamp = time();?>
$(function() {
	$('#file_upload').uploadify({
		'formData'     : {
			'timestamp' : '<?php echo $timestamp;?>',
			'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
			'dir'		: 'photo',
		},
		'swf'      : '<?php echo G_PLUGIN_PATH; ?>/uploadify/uploadify.swf',
		'buttonText': '上传图片',
		'uploader' : '<?php echo G_WEB_PATH; ?>/admin/api/uploadify',
		'multi': false,
		'onInit': function () {                        //载入时触发，将flash设置到最小
        	$("#file_upload-queue").hide();
        },			
		'onUploadSuccess' : function(file, data, response) {
	        $('#thumg').attr('src',data);
	        $('.jq_thumg').val(data);
	    }			
	});		
	
});

function CheckForm(){
	var money = parseInt($("#money").val());
		if(money >= 10000000){
			window.parent.message("价格大于1000万，商品添加会很慢,请耐心等待，不要关闭窗口!",1,5);
		}	
		return true;
}
</script>
<div class="header lr10">
	<h3 class="nav_icon"><?php echo $msg;?>会员</h3>
	<span class="span_fenge lr10"></span>
	<a href="/admin/member/lists/">会员管理</a>
	<span class="span_fenge lr5">|</span>
	<a href="/admin/member/addmem/">添加会员</a>
</div>
<div class="bk10"></div>
<div class="table_form lr10">
<form method="post" action="" onSubmit="return CheckForm()">
	<input type="hidden" name="eid" value="<?php echo (isset($row['uid'])) ? $row['uid'] : '';?>" />
	<table width="100%"  cellspacing="0" cellpadding="0">
		<tr>
			<td align="right" style="width:120px">昵称：</td>
			<td>
			<input type="text" name="username" value="<?php echo (isset($row['username'])) ? $row['username'] : '';?>" class="input-text">		
            </td>
		</tr>
		<tr>
			<td width="120" align="right">邮箱：</td>
			<td><input type="text" name="email" value="<?php echo (isset($row['email'])) ? $row['email'] : '';?>" class="input-text"></td>
		</tr> 
		<tr>
			<td width="120" align="right"><font color="red">*</font>手机：</td>
			<td><input type="text" name="mobile" value="<?php echo (isset($row['mobile'])) ? $row['mobile'] : '';?>" class="input-text"></td>
		</tr>		    
		<tr>
			<td width="120" align="right"><?php echo ($is_edit != true) ? '<font style="color:red;">*</font>' : '';?>密码：</td>
			<td><input type="password" name="password" value="" class="input-text"><?php echo $is_edit ? '(不填写默认为原密码)' : ''?></td>
		</tr>
		<tr>
			<td width="120" align="right">元宝：</td>
			<td><input type="text" name="money" value="<?php echo (isset($row['money'])) ? $row['money'] : '';?>" class="input-text"></td>
		</tr>
		<tr>
			<td width="120" align="right">邮箱验证：</td>
			<td>
		 		<?php
		 		if(isset($row['emailcode'])){
				?>
					<input type="radio" name="emailcode" value="1" <?php echo ($row['emailcode']==1) ? 'checked' : '' ?> class="input-text">已验证
					<input type="radio" name="emailcode" value="-1" bb <?php echo ($row['emailcode']==-1) ? 'checked' : '' ?> class="input-text">未验证
				<?php
				}else{
				?>
					<input type="radio" name="emailcode" value="1" checked class="input-text">已验证
					<input type="radio" name="emailcode" value="-1"  class="input-text">未验证
				<?php			
				}
		 		?>					
			</td>
		</tr>
		<tr>
			<td width="120" align="right">手机验证：</td>
			<td>
		 		<?php
		 		if(isset($row['emailcode'])){
				?>
					<input type="radio" name="mobilecode" value="1" <?php echo ($row['mobilecode']==1) ? 'checked' : '' ?> class="input-text">已验证
					<input type="radio" name="mobilecode" value="-1" bb <?php echo ($row['mobilecode']==-1) ? 'checked' : '' ?> class="input-text">未验证
				<?php
				}else{
				?>
					<input type="radio" name="mobilecode" value="1" checked class="input-text">已验证
					<input type="radio" name="mobilecode" value="-1"  class="input-text">未验证
				<?php			
				}
		 		?>					
			</td>
		</tr>		        
        <tr>
	        <td align="right" style="width:120px">头像：</td>
	        <td>
	        	<div class="show_unit_pic">
	        	<input type="hidden" name="thumg" value="" class="input-text jq_thumg">
	        	<img id="thumg" src="<?php echo (isset($row['img']) && $row['img']!='') ? G_WEB_PATH.'/'.$row['img'] : G_UPLOAD_PATH."/photo/member.jpg"; ?>  " style="border:1px solid #eee; padding:1px;left:0; width:50px; height:50px;">
				</div>
				<input type="button" id="file_upload" class="button" value="上传图片"/>		
	        </td>
        </tr>
		<tr>
			<td width="120" align="right">签名：</td>
			<td><textarea style="width:400px;height:100px;" name="qianming"><?php echo (isset($row['qianming'])) ? $row['qianming'] : '';?></textarea></td>
		</tr>
		<tr>
			<td width="120" align="right">用户权限组：</td>
			<td>
				<select name="membergroup">
					<option <?php echo (isset($row['groupid']) && $row['groupid']==1) ? 'selected' : '' ?> value="1">惠玩车新兵</option>
					<option <?php echo (isset($row['groupid']) && $row['groupid']==2) ? 'selected' : '' ?> value="2">惠玩车连长</option>
					<option <?php echo (isset($row['groupid']) && $row['groupid']==3) ? 'selected' : '' ?> value="3">惠玩车团长</option>
					<option <?php echo (isset($row['groupid']) && $row['groupid']==4) ? 'selected' : '' ?> value="4">惠玩车师长</option>
					<option <?php echo (isset($row['groupid']) && $row['groupid']==5) ? 'selected' : '' ?> value="5">惠玩车军长</option>
					<option <?php echo (isset($row['groupid']) && $row['groupid']==6) ? 'selected' : '' ?> value="6">惠玩车元帅</option>
				</select>
			</td>
		</tr>
      
        <tr height="60px">
			<td align="right" style="width:120px"></td>
			<td><input type="submit" name="dosubmit" class="button" value="<?php echo $msg;?>会员" /></td>
		</tr>
	</table>
</form>
</div>
 <span id="title_colorpanel" style="position:absolute; left:568px; top:155px" class="colorpanel"></span>
<script type="text/javascript">
var info=new Array();
function gbcount(message,maxlen,id){
	
	if(!info[id]){
		info[id]=document.getElementById(id);
	}			
    var lenE = message.value.length;
    var lenC = 0;
    var enter = message.value.match(/\r/g);
    var CJK = message.value.match(/[^\x00-\xff]/g);//计算中文
    if (CJK != null) lenC += CJK.length;
    if (enter != null) lenC -= enter.length;		
	var lenZ=lenE+lenC;		
	if(lenZ > maxlen){
		info[id].innerHTML=''+0+'';
		return false;
	}
	info[id].innerHTML=''+(maxlen-lenZ)+'';
}
$(function(){	
	$(".jq_radio input[type='radio']").on('click',function(){
		var o = $(this);
		if(o.val()==1){			//选中
			$('.jq_is_show_hide').show();
		}else{
			$('.jq_is_show_hide').hide();
		}
	})	
	
}); 
</script>
</body>
</html> 