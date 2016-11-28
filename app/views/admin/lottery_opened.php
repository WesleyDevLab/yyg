<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>非限时待开奖</title>
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/layer.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar-blue.css" type="text/css"> 
<script type="text/javascript" charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/layer/layer.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/global.js"></script>
 <style>
 	th{ border:0px solid #000;}
 	.kjul{padding:20px;}
 	.kjul li{line-height:30px;}
 	.kjul li span{width:120px;display:inline-block;text-align:right;}
 </style>
</head>
<body>
<div class="header lr10">
	<h3 class="nav_icon">开奖管理</h3>
	<span class="span_fenge lr10"></span>
	<a href="/admin/lottery/opened/notxs"><?php echo ($curr=='notxs')? '<font color="#f00">非限时已开奖</font>' : '非限时已开奖'?></a>
	<span class="span_fenge lr5">|</span>
	<a href="/admin/lottery/opened/xs"><?php echo ($curr=='xs')? '<font color="#f00">限时已开奖</font>' : '限时已开奖'?></a>
	<span class="span_fenge lr5">|</span>
</div>

<div class="bk10"></div>
<div class="table-list lr10">
 <table width="100%" cellspacing="0">
    <thead>
            <tr>
            <th width="90">排序</th>
            <th align='center'>商品名称</th>
            <th align='center' width="70">所属分类</th>
            <th align='center'>获奖码</th>
            <th align='center'>获奖uid</th>
            <th align='center'>开奖时间</th>
            <th align='center'>开奖视频地址</th>
            <?php
            if($curr =='xs'){
            ?>
            <th align='center'>限时揭晓时间</th>
            <?php	
            }
            ?>
			<th align='center'>管理操作</th>
            </tr>
    </thead>
    <tbody>
    	  <form action="#" method="post" name="myform"> 
          <?php
          if(!$list){
          ?>
          <tr>
          	<td colspan="<?php echo ($curr =='xs') ? '8' : '7';?>" align="center">没有找到任何记录</td>
          </tr>
          <?php	
          }
          ?>    	     	  
          <?php
          foreach($list as $row){
          ?>
          	<tr>
          		<td align='center'><?php echo $row['order']?></td>
          		<td align='left'><?php echo $row['title']?></td>
          		<td align='center'><?php echo $categorys[$row['cateid']]['name'];?></td>
          		<td align='center'><?php echo $row['q_user_code'];?></td>
              <td align='center'><?php echo $row['q_uid'];?></td>
          		<td align='center'><?php echo date('Y-m-d H:i:s', $row['q_end_time']);?></td>
          		<td align='center'><?php echo $row['q_video'];?></td>
				<?php
				if($curr == 'xs'){
				?>
				<td align='center'><?php echo date('Y-m-d H:i:s',$row['xsjx_time']);?></td>
				<?php	
				}
				?>
				<td align="center">
				<?php
				if(empty($row['q_video'])){
				?>
				<input gid="<?php echo $row['id'];?>" type="button" name="dosubmit" class="button jq_kj" value="开奖视频地址">
				<?php	
				}else{
					echo '已完成开奖';
				}
				?>
				
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
<script>
$(document).ready(function(){

	$(document).on("click",'.jq_kjbtn',function(){
	  var gid = $('.jq_gid').val();
	  var kj_code = $('.jq_kj_viode').val();
      $.ajax({
            type: "POST",
            url: '<?php echo G_WEB_PATH?>/admin/lottery/kjvideo',
            data: "kj_video="+kj_code+"&gid="+gid,
            success: function(data){
            	data = $.parseJSON(data);
            	console.log(data);
			  	if(data.code=='200'){
			  		layer.msg('您已成功开奖', function(){
					  window.location.href='/admin/lottery/opened/notxs';
					}); 
			  	}else if(data.code=='400'){
			  		layer.msg('您输入的开奖码没有购买记录，请确认后重新录入');
			  	}else{
			  		layer.msg('开奖码只能是数字');
			  	}            	
            }
        });

	})
	
	
})

layer.ready(function(){
	$('.jq_kj').click(function(){
	  var gid=$(this).attr('gid');
	  //官网欢迎页
	  layer.open({
	    type: 1,
		skin: 'layui-layer-rim', //加上边框
	  	area: ['400px', '200px'], //宽高
	    title: '录入开奖视频',
	    fix: false,
	    shadeClose: true,
	    maxmin: true,
	    content: '<ul class="kjul"><li><input type="hidden" class="jq_gid" value="'+gid+'"></li><li><span>开奖视频地址：</span><input type="text" class="jq_kj_viode"></li><li><span></span><input gid="7" type="button" class="button jq_kjbtn" value="开奖"></li>'
	  });
	})		
})



</script>
</body>
</html> 