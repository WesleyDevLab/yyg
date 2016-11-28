<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/style.css" type="text/css">
<style>
tbody tr{ line-height:30px; height:30px;} 
</style>
</head>
<body>
<div class="header lr10">
	<h3 class="nav_icon">幻灯管理</h3>
	<span class="span_fenge lr10"></span>
	<a href="/admin/slide/lists">幻灯管理</a>
	<span class="span_fenge lr5">|</span>
	<a href="/admin/slide/add/<?php echo $type;?>">添加幻灯片</a>
	<span class="span_fenge lr5">|</span>
</div>
<div class="bk10"></div>
<div class="table-list lr10">
<!--start-->
  <table width="100%" cellspacing="0">
    <thead>
		<tr>
		<th width="80px">id</th>
        <th width="" align="center">跳转链接</th>
		<th width="" align="center">幻灯图片</th>
		<th width="30%" align="center">操作</th>
		</tr>
    </thead>
    <tbody>
    	<?php
    	if(!$lists){
    	?>
    	<tr>
    		<td colspan="4" align="center">没有找到任何记录</td>
    	</tr>
    	<?php
    	}
    	?>
		<?php foreach($lists as $v){ ?>
		<tr>
			<td align="center"><?php echo $v['id']; ?></td>
            <td align="center"><?php echo $v['link']; ?></td>
			<td align="center"><img height="50px" src="<?php echo G_WEB_PATH; ?>/<?php echo $v['img']; ?>"/></td>
			<td align="center">
				<a href="<?php echo G_WEB_PATH; ?>/admin/slide/add/<?php echo $v['type'];?>/<?php echo $v['id'];?>">修改</a>
				<a href="<?php echo G_WEB_PATH; ?>/admin/slide/delete/<?php echo $v['id'];?>">删除</a>
			</td>	
		</tr>
		<?php } ?>
  	</tbody>
</table>
	<div class="btn_paixu"></div>
</div><!--table-list end-->

<script>
</script>
</body>
</html> 