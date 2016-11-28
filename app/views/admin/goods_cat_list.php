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
	<h3 class="nav_icon">分类管理</h3>
	<span class="span_fenge lr10"></span>
	<a href="/admin/cate/lists/<?php echo $type;?>">分类管理</a>
	<span class="span_fenge lr5">|</span>
	<a href="/admin/cate/addcate/<?php echo $type;?>">添加分类</a>
</div>

<div class="bk10"></div>
<div class="table-list lr10">
 <table width="100%" cellspacing="0">
    <thead>
            <tr>
            <th width="90">排序</th>
            <th width="60">catid</th>
            <th align='center'>栏目名称</th>
            <th align='center' width="70">所属分类</th>
            <th align='center'>访问地址</th>
			<th align='center'>管理操作</th>
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
          	<tr>
          		<td align='center'><?php echo $row['sort']?></td>
          		<td align='center'><?php echo $row['cateid']?></td>
          		<td align='left'><?php echo $row['name']?></td>
          		<td align='center'>
          		<?php 
          		if($row['parentid']==0){
          			echo "一级分类";
          		}else{
          			echo $all_list[$row['parentid']]['name'];
          		}
          		
          		?>
          		</td>
          		<td align='center'><?php echo $row['url']?></td>
				<td align="center">
	                <!--<a href="http://www.mall.com/index.php/admin/category/addcate/def/149">添加子栏目</a><span class="span_fenge lr5">|</span>-->   
					<a href="<?php echo G_WEB_PATH;?>/admin/cate/addcate/<?php echo $type;?>/<?php echo $row['cateid'];?>">修改</a><span class="span_fenge lr5">|</span>
					<a href="javascript:window.parent.Del('<?php echo G_WEB_PATH;?>/admin/ajax/delcate/<?php echo $type;?>/<?php echo $row['cateid'];?>', '确认删除『 <?php echo $row['name']?> 』分类？');">删除</a>
            	</td>
          	</tr>
          <?php	
          }
          ?>
          </form>
    </tbody>
  </table>
  <div id="pages">
  	<ul>
        <?php echo $pagebar;?>
    </ul>
  </div>  
  
</div><!--table-list end-->

</body>
</html> 