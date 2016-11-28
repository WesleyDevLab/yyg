<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页</title>
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/style.css" type="text/css">
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_PLUGIN_PATH; ?>/uploadify/api-uploadify.js" type="text/javascript"></script> 
<link rel="stylesheet" href="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar-blue.css" type="text/css"> 
<script type="text/javascript" charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar.js"></script>
<script src="<?php echo G_PLUGIN_PATH; ?>/uploadify/jquery.uploadify.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo G_PLUGIN_PATH; ?>/uploadify/uploadify.css">

<style>
	.show_unit_pic{float:left;padding-right:10px;}
	.uploadify{float:left;margin-top:10px;}
	.uploadify-queue{margin-top:40px;}
	.bg{background:#fff url(<?php echo G_GLOBAL_STYLE; ?>/global/image/ruler.gif) repeat-x scroll 0 9px }
	.color_window_td a{ float:left; margin:0px 10px;}

</style>
</head>
<body>

<div class="header lr10">
	<h3 class="nav_icon">幻灯管理</h3>
	<span class="span_fenge lr10"></span>
	<a href="/admin/slide/lists">幻灯管理</a>
	<span class="span_fenge lr5">|</span>
	<a href="/admin/slide/add">添加幻灯片</a>
	<span class="span_fenge lr5">|</span>
</div>
<div class="bk10"></div>
<div class="table_form lr10">
<form name="myform" action="" method="post" enctype="multipart/form-data">
  <table width="100%" cellspacing="0">
		<tr>
			<td width="120" align="right">幻灯名称:</td>
			<td>
				<input type="text" name="title" value="<?php echo (isset($row['title'])) ? $row['title'] : '';?>" class="input-text wid300" />
			</td>
		</tr>
		<tr>
			<td width="120" align="right">幻灯链接:</td>
			<td>
				<input type="text" name="link" value="<?php echo (isset($row['link'])) ? $row['link'] : '';?>" class="input-text wid300"/>
			</td>
		</tr>
        <tr>
			<td align="right" width="120">背景颜色：</td>
			<td><input  type="text" id="title_style_color" value="<?php echo (isset($row['color'])) ? $row['color'] : '';?>" name="color" onKeyUp="return gbcount(this,100,'texttitle2');"  class="input-text wid300">
            <script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/colorpicker.js"></script>
            <img src="<?php echo G_GLOBAL_STYLE; ?>/global/image/colour.png" width="15" height="16" onClick="colorpicker('title_colorpanel','set_title_color');" style="cursor:hand"/>
             <img src="<?php echo G_GLOBAL_STYLE; ?>/global/image/bold.png" onClick="set_title_bold();" style="cursor:hand"/>
            <span class="lr10">还能输入<b id="texttitle2">100</b>个字符</span>
            </td>
		</tr>
        <tr>
         <td align="right" style="width:120px"><font color="red">*</font>图片：</td>
        <td>
        	<div class="show_unit_pic">
        	<input type="hidden" name="img" value="<?php echo (isset($row['img']) && $row['img']!='') ? $row['img'] : ''; ?>" class="input-text jq_thumg">
        	<img id="thumg" src="<?php echo (isset($row['img']) && $row['img']!='') ? $row['img'] : G_UPLOAD_PATH."/photo/goods.jpg"; ?>  " style="border:1px solid #eee; padding:1px;left:0; width:50px; height:50px;">
			</div>
			<input type="button" id="file_upload" class="button" value="上传图片"/>		
        </td>
      </tr>		

		<tr>
        	<td width="120" align="right"></td>
            <td>		
            <input type="submit" class="button" name="submit" value="<?php echo $msg;?>" >
            </td>
		</tr>
	</table>
</form>
</div>
 <span id="title_colorpanel" style="position:absolute; left:568px; top:155px" class="colorpanel"></span>
<script type="text/javascript">
<?php $timestamp = time();?>
$(function() {
	$('#file_upload').uploadify({
		'formData'     : {
			'timestamp' : '<?php echo $timestamp;?>',
			'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
			'dir'		: 'slide',
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
})	

function set_title_color(color) {
	$('#title2').css('color',color);
	$('#title_style_color').val(color);
}
function set_title_bold(){
	if($('#title_style_bold').val()=='bold'){
		$('#title_style_bold').val('');	
		$('#title2').css('font-weight','');
	}else{
		$('#title2').css('font-weight','bold');
		$('#title_style_bold').val('bold');
	}
}

//API JS

</script>

</body>
</html> 