<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页</title>
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/style.css" type="text/css">
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_PLUGIN_PATH; ?>/uploadify/jquery.uploadify.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo G_PLUGIN_PATH; ?>/uploadify/uploadify.css">

<style>
body{ background-color:#fff}
#category_select span{
	border:1px solid #ccc;
	background:#eee;
	padding:3px;
}
#category_select b{
 color:#f00;cursor:pointer;
}
#category_select input{
	width:0px;border:0px;
}

.show_unit_pic{float:left;padding-right:10px;}
.uploadify{float:left;margin-top:10px;}
.uploadify-queue{margin-top:40px;}

</style>
</head>
<body>
<div class="header lr10">
	<h3 class="nav_icon">品牌管理</h3>
	<span class="span_fenge lr10"></span>
	<a href="/admin/brand/lists">品牌管理</a>
	<span class="span_fenge lr5">|</span>
	<a href="/admin/brand/addbrand">添加品牌</a>
	<span class="span_fenge lr5">|</span>
</div>
<div class="bk10"></div>

<div class="table_form lr10">

<form name="form" id="form" action="" method="post">
<input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : '';?>" />
<table width="100%"  cellspacing="0" cellpadding="0">
	<tr>
		<td align="right" class="wid100">所属分类：</td>
		<td>
		<select name="info[cateid]" class="wid150">
	        <option value="0">≡ 作为一级分类 ≡</option>
	        <?php 
	        foreach($list as $item){
	        	if(isset($row['cateid'])){
	        	?>
	        	<option <?php echo ($item['cateid'] == $row['cateid']) ? "selected" : "";?> value="<?php echo $item['cateid']?>"><?php echo $item['name']?></option>
	        	<?php	
	        	}else{
	        	?>
	        	<option value="<?php echo $item['cateid']?>"><?php echo $item['name']?></option>
	        	<?php	
	        	}
	        ?>
	        		
	        <?php
	        }
	        ?>
	        </select>
		</td>						
    </tr>
    <tr>
		<td align="right">品牌名称：</td>
		<td><input type="text"  name="info[name]" value="<?php echo isset($row['name']) ? $row['name'] : '';?>" class="input-text wid100"></td>
	</tr>
    <tr>
		<td align="right">品牌图片：</td>
		<td>
        	<div class="show_unit_pic">
        	<input type="hidden" name="info[pic]" class="input-text jq_thumg" />
        	<?php
        	if(!empty($row['pic'])){
        	?>
        	<img id="thumg" src="<?php echo $row['pic'];?>" style="border:1px solid #eee; padding:1px;left:0; width:50px; height:50px;">
        	<?php	
        	}else{
        	?>
        	<img id="thumg" src="<?php echo G_UPLOAD_PATH;?>/photo/goods.jpg" style="border:1px solid #eee; padding:1px;left:0; width:50px; height:50px;">
        	<?php	
        	}
        	?>        	
			</div>
			<input type="button" id="file_upload" class="button" value="上传图片"/>		
		</td>
	</tr>		
    <tr>
		<td align="right">排序：</td>
		<td><input type="text"  name="info[sort]" value="<?php echo isset($row['sort']) ? $row['sort'] : '0';?>" onKeyUp="value=value.replace(/[^\d]/ig,'')" class="input-text wid100">
        <span>数值越大,排序越靠前</span>
        </td>
	</tr>
    <tr>
		<td align="right">外链地址：</td>
		<td><input type="text"  name="info[url]" class="input-text wid300"></td>
	</tr>	
    <tr height="60px">
			<td align="right"></td>
			<td><input type="button" value=" 提交 " onClick="checkform();" class="button"></td>
	</tr>
</form>
</table>

</div>

<script>
<?php $timestamp = time();?>
$(function() {
	$('#file_upload').uploadify({
		'formData'     : {
			'timestamp' : '<?php echo $timestamp;?>',
			'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
			'dir'		: 'brand',
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

function checkform(){
	var form=document.getElementById('form');
	var error=null;	
	if(form.elements[1].value=='' || form.elements[1].value=='0'){error='请选择所属分类!';}
	if(form.elements[2].value==''){error='请输入品牌名称!';}
	if(error!=null){window.parent.message(error,8,2);return false;}
	form.submit();	
}
</script>


</body>
</html> 
