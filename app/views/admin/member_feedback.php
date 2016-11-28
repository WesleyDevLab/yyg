<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/layer.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/style.css?v=123" type="text/css">
<link rel="stylesheet" href="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar-blue.css" type="text/css"> 
<script type="text/javascript" charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/layer.min.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/global.js"></script>
 <style>
 	th{ border:0px solid #000;}
 	.calendar table{top:-60px;}
 </style>
</head>
<body>
<div class="header lr10">
	<h3 class="nav_icon">问题反馈</h3>

</div>

<div class="bk10"></div>

<div class="header-data lr10">
	<b>提示:</b> 已经购买过的商品不能在修改，点击查看往期可以查看该商品的所有期数商品！
	<br>
	<b>提示:</b> 因为商品添加后云购码已经生成成功,所以不能在本期内修改价格了.
</div>

<div class="table-list lr10" >
  <div class="header-data lr10" style="margin-bottom:20px;margin-top:20px;">

   
 		
         
              用户名: <input name="username" value="<?php echo isset($username) ? $username : '';?>" type="text" id="username" class="input-text">&nbsp;&nbsp;  
               联系方式 ：<input id="good_name" value="<?php echo isset($good_name) ? $good_name : '';?>" type="text" class="input-text">&nbsp;&nbsp;
      反馈日期: <input name="posttime1" value="<?php echo isset($posttime1) ? $posttime1 : '';?>" type="text" id="posttime1" class="input-text posttime" readonly="readonly">-
      	<input name="posttime1" value="<?php echo isset($posttime2) ? $posttime2 : '';?>" type="text" id="posttime2" class="input-text posttime" readonly="readonly">

       <input class="button jq_button" type="button" id="sososubmit" value="查询">

  </div>
<script type="text/javascript">
	date = new Date();
	Calendar.setup({
				inputField     :    "posttime1",
				ifFormat       :    "%Y-%m-%d",
				showsTime      :    false,
				timeFormat     :    "24"
	});
	Calendar.setup({
				inputField     :    "posttime2",
				ifFormat       :    "%Y-%m-%d",
				showsTime      :    false,
				timeFormat     :    "24"
	});
			
</script>
 <table width="100%" cellspacing="0">
    <thead>
      <tr>
          <th width="50">序号</th>
          <th width="center">用户名</th>
          <th width="center">联系方式</th>
          <th align='center'>反馈内容</th>
          <th align='center'>收藏日期</th>
      </tr>
    </thead>
    <tbody>
    	  <form action="#" method="post" name="myform">    	  
          <?php
          if(!$list){
          ?>
          <tr>
          	<td colspan="11" align="center">没有找到任何记录</td>
          </tr>
          <?php	
          }

          foreach($list as $row){
          ?>
          	<tr>
          		<td align='center'><?php echo $row['id']?></td>
          		<td align='center'>
          			<?php
						echo $row['username'];
          			?>
          		</td>
              <td align='center'>
              	<?php echo $row['contact'];?>
              </td>
              <td align='center'><?php echo $row['content']?></td>
          	  <td align='center'><?php echo $row['feed_date']?></td>

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

$(function(){
	$('.jq_button').click(function(){
		var p = <?php echo $p;?>;
		console.log(p);
		var where = '?act=form&per_page='+p;
		var posttime1 = $('#posttime1').val();
		if(posttime1){
			where += "&posttime1="+posttime1;
		}
		var posttime2 = $('#posttime2').val();
		if(posttime2){
			where += "&posttime2="+posttime2;
		}		
		var username = $('#username').val();
		if(username){
			where += "&username="+username;
		}
		var good_type = $('#good_type').val();
		if(good_type){
			where += "&good_type="+good_type;
		}
		var good_name = $('#good_name').val();
		if(good_name){
			where += "&good_name="+good_name;
		}

		console.log("<?php echo G_WEB_PATH;?>/admin/member/feedback"+where);
		window.location.href="<?php echo G_WEB_PATH;?>/admin/membercount/feedback"+where;
	})
})
	
</script>
</body>
</html> 