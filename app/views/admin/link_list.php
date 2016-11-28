<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/layer.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar-blue.css" type="text/css"> 
<script type="text/javascript" charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/layer.min.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/global.js"></script>
 <style>
 	th{ border:0px solid #000;}
 </style>
</head>
<body>
<div class="header lr10">
	<h3 class="nav_icon">友情链接</h3>
	<span class="span_fenge lr10"></span>
	<a href="/admin/link/lists/<?php echo $cateid;?>">友情链接</a>
	<span class="span_fenge lr5">|</span>
	<a href="/admin/link/addlink">添加链接</a>
	
	<span style="margin-left:40px;">(根据分类查看友情链接)</span>
	<select class="jq_link_change">
        <?php
        foreach($cat_list as $item){
			if( isset($cateid) && $item['cateid']==$cateid ){
			?>
				<option selected value="<?php echo $item['cateid']?>"><?php echo $item['name']?></option>
			<?php
			}else{
			?>
				<option value="<?php echo $item['cateid']?>"><?php echo $item['name']?></option>
			<?php
			}
    	}
    	?>
	</select>	
	
</div>

<div class="bk10"></div>
<div class="table-list lr10">
 <table width="100%" cellspacing="0">
    <thead>
            <tr>
            <th width="10%">id</th>
            <th width="10%">链接名称</th>
            <th align='30%'>链接图片</th>
            <th align='30%'>链接文字</th>
			<th align='20%'>管理操作</th>
            </tr>
    </thead>
    <tbody>
    	  <form action="#" method="post" name="myform">    	  
          <?php
          if(!$list){
          ?>
          <tr>
          	<td colspan="6" align="center">没有找到任何记录</td>
          </tr>
          <?php	
          }
          foreach($list as $row){
          ?>
          	<tr align="center">
          		<td><?php echo $row['id']?></td>
          		<td><?php echo $row['name']?></td>
          		<td>
				<?php echo $row['logo']?>
          		</td>
          		<td><?php echo $row['url']?></td>
				<td align="center">
	                <!--<a href="http://www.mall.com/index.php/admin/category/addcate/def/149">添加子栏目</a><span class="span_fenge lr5">|</span>-->   
					<a href="<?php echo G_WEB_PATH;?>/admin/link/addlink/<?php echo $row['id'];?>">修改</a><span class="span_fenge lr5">|</span>
					<a href="javascript:window.parent.Del('<?php echo G_WEB_PATH;?>/admin/ajax/dellink/<?php echo $row['id'];?>', '确认删除『 <?php echo $row['name']?> 』友情链接？');">删除</a>
            	</td>
          	</tr>
          <?php	
          }
          ?>
          </form>
    </tbody>
  </table>
  
</div><!--table-list end-->



<script type="text/javascript">
$(document).ready(function(){
	$('.jq_link_change').change(function(){
		var this_val = $(this).val();
		console.log(this_val);
		window.location.href="/admin/link/lists/"+this_val;		
	})
	
})
</script>

</body>
</html> 