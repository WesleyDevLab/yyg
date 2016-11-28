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
	<h3 class="nav_icon">商品列表</h3>
	<span class="span_fenge lr10"></span>
	<a href="/admin/goods/goods_add">添加商品</a>
	<span class="span_fenge lr5">|</span>
	<a href="/admin/goods/goods_list/renqi">人气商品</a>
	<span class="span_fenge lr5">|</span>
	<a href="/admin/goods/goods_list/xianshi">限时揭晓商品</a>	
	<span class="span_fenge lr5">|</span>
	<?php
	if($paixu=='qishuasc'){
	?>	
	<a href="/admin/goods/goods_list/qishu">期数倒序</a>
	<?php	
	}else{
	?>
	<a href="/admin/goods/goods_list/qishuasc">期数正序</a>
	<?php	
	}
	?>	
	<span class="span_fenge lr5">|</span>
	<?php
	if($paixu=='money'){
	?>	
	<a href="/admin/goods/goods_list/moneyasc">商品价格倒序</a>
	<?php	
	}else{
	?>
	<a href="/admin/goods/goods_list/money">商品价格正序</a>
	<?php	
	}
	?>

	<span class="span_fenge lr5">|</span>
	<a href="/admin/goods/goods_list/jiexiaook">已揭晓</a>
	<span class="span_fenge lr5">|</span>
	<a href="/admin/goods/goods_list/maxqishu"><font color="#f00">期数已满商品</font></a>
	<span class="span_fenge lr5">|</span>
</div>

<div class="bk10"></div>
<div class="header-data lr10">
	<b>提示:</b> 已经购买过的商品不能在修改，点击查看往期可以查看该商品的所有期数商品！
	<br>
	<b>提示:</b> 因为商品添加后云购码已经生成成功,所以不能在本期内修改价格了.
</div>
<div class="bk10"></div>

<div class="header-data lr10">
<form action="#" method="post">
 添加时间: <input name="posttime1" value="<?php echo isset($posttime1) ? $posttime1 : '';?>" type="text" id="posttime1" class="input-text posttime" readonly="readonly"> -  
 		  <input name="posttime2" value="<?php echo isset($posttime2) ? $posttime2 : '';?>" type="text" id="posttime2" class="input-text posttime" readonly="readonly">
<script type="text/javascript">
	date = new Date();
	Calendar.setup({
				inputField     :    "posttime1",
				ifFormat       :    "%Y-%m-%d %H:%M:%S",
				showsTime      :    true,
				timeFormat     :    "24"
	});
	Calendar.setup({
				inputField     :    "posttime2",
				ifFormat       :    "%Y-%m-%d %H:%M:%S",
				showsTime      :    true,
				timeFormat     :    "24"
	});				
</script>

<select name="sotype">
	<option value="cateid">栏目id</option>
	<option value="catename">栏目名称</option>
	<option value="title">文章标题</option>
	<option value="id">文章ID</option>
</select>
<input type="text" value="<?php echo isset($sosotext) ? $sosotext : '';?>" name="sosotext" class="input-text wid100">
<input class="button" type="submit" name="sososubmit" value="搜索">
</form>
</div>

<div class="bk10"></div>

<div class="table-list lr10">

      <table width="100%" cellspacing="0">
     	<thead>
        		<tr>
                    <th width="5%">ID</th>                          
                    <th width="25%">所属分类</th>  
                    <th width="20%">文章标题</th>             
                    <th width="10%">发布人</th>
                    <th width="5%">点击量</th>
                    <th width="15%">添加时间</th>     
                    <th width="20%">管理</th>
				</tr>
        </thead>
        <tbody>	
          <?php
          if(!$shoplist){
          ?>
          <tr>
          	<td colspan="8" align="center">没有找到任何记录</td>
          </tr>
          <?php	
          }
          ?>        		
        	<?php foreach($shoplist as $v) { ?>
            <tr align="center">  
                <td><?php echo $v['id'];?></td>
                <td><?php echo $categorys[$v['cateid']]['name'];?></td>
                <td>
                <span  ><?php echo sub_str($v['title'],30);?></span>
                </td>
                <td><?php echo $v['author'];?></td>
                <td><?php echo $v['hit'];?></td>
                <td><?php echo $v['posttime'];?></td>
                <td class="action">			
				[<a href="/admin/article/add/<?php echo $v['id'];?>">修改</a>]
				[<a href="javascript:window.parent.Del('<?php echo G_WEB_PATH;?>/admin/ajax/delgoods/<?php echo $v['id'];?>', '确认删除『 <?php echo $v['title']?> 』商品？');">删除</a>]
				</td>
            </tr>
            <?php } ?>
        </tbody>
     </table>



  <div id="pages">
  	<ul>
        <?php echo $pagebar;?>
    </ul>
  </div>
  
</div>

<!--table-list end-->
</body>
</html>