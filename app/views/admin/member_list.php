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
	<h3 class="nav_icon">会员管理</h3>
	<span class="span_fenge lr10"></span>
	<a href="/admin/member/lists/">会员管理</a>
	<span class="span_fenge lr5">|</span>
	<a href="/admin/member/addmem/">添加会员</a>
</div>

<div class="bk10"></div>

<div class="header-data lr10">
	<b>提示:</b> 已经购买过的商品不能在修改，点击查看往期可以查看该商品的所有期数商品！
	<br>
	<b>提示:</b> 因为商品添加后云购码已经生成成功,所以不能在本期内修改价格了.
</div>

<div class="table-list lr10" >
  <div class="header-data lr10" style="margin-bottom:20px;margin-top:20px;">

 注册时间: <input name="posttime1" value="<?php echo isset($posttime1) ? $posttime1 : '';?>" type="text" id="posttime1" class="input-text posttime" readonly="readonly"> -  
 		 <input name="posttime2" value="<?php echo isset($posttime2) ? $posttime2 : '';?>" type="text" id="posttime2" class="input-text posttime" readonly="readonly">    	
       uid: <input name="uid" value="<?php echo isset($uid) ? $uid : '';?>" type="text" id="uid" class="input-text">  
       用户名: <input name="username" value="<?php echo isset($username) ? $username : '';?>" type="text" id="username" class="input-text">  
       姓名：<input name="shouhuoren" value="<?php echo isset($shouhuoren) ? $shouhuoren : '';?>" type="text" id="shouhuoren" class="input-text">
       手机：<input name="mobile" value="<?php echo isset($mobile) ? $mobile : '';?>" type="text" id="mobile" class="input-text">
   <select name="tiaojian" id="tiaojian">
   	<option value=''>请选择条件</option>
   	<option <?php echo (isset($tiaojian) && $tiaojian==2) ? 'selected' : '';?> value="2">按注册时间降序</option>
   	<option <?php echo (isset($tiaojian) && $tiaojian==1) ? 'selected' : '';?> value="1">按注册时间升序</option>  	
   	<option <?php echo (isset($tiaojian) && $tiaojian==3) ? 'selected' : '';?> value="3">高级会员</option>
   	<option <?php echo (isset($tiaojian) && $tiaojian==4) ? 'selected' : '';?> value="4">非高级会员</option>
   </select>    
       <input class="button jq_button" type="button" id="sososubmit" value="查询">

  </div>
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
 <table width="100%" cellspacing="0">
    <thead>
      <tr>
          <th width="50">UID</th>
          <th width="center">昵称</th>
          <th width="center">收货人姓名</th>
          <th align='center'>邮箱</th>
          <th align='center'>手机</th>
          <th align='center'>元宝</th>
          <th align='center'>登录时间，地址，ip</th>
          <th align='center'>收货地址</th>
		      <th align='center'>注册时间</th>
          <th align='center'>是否高级会员</th>
          <th align='center'>操作</th>
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
          		<td align='center'><?php echo $row['userid']?></td>
          		<td align='center'>
          			<?php
						echo $row['username'] ? $row['username'] : $row['u_mobile'];
          			?>
          		</td>
              <td align='center'><?php echo $row['shouhuoren']?></td>
              <td align='left'><?php echo $row['email']?></td>
          		<td align='left'><?php echo $row['u_mobile']?></td>
          		<td align='center'><?php echo $row['money']?></td>
          		<td align='center'><?php echo short_time($row['login_time'],"未登录"); ?>, <?php echo trim($row['user_ip'],","); ?></td>
              <td align='center'><?php echo $row['sheng'].$row['shi'].$row['xian'].$row['jiedao']?></td>
              <td align='center'><?php echo date('Y-m-d H:i:s',$row['reg_time']);?></td>
              <td align='center'><?php echo ($row['user_type']=='1') ? '<font style="color:red;">是</font>' : '否';?></td>
				      <td align="center">
	                <!--<a href="http://www.mall.com/index.php/admin/category/addcate/def/149">添加子栏目</a><span class="span_fenge lr5">|</span>-->   
					       <a href="<?php echo G_WEB_PATH;?>/admin/member/addmem/<?php echo $row['userid'];?>">编辑</a>
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
		var uid = $('#uid').val();
		if(uid){
			where += "&uid="+uid;
		}
		var username = $('#username').val();
		if(username){
			where += "&username="+username;
		}
		var shouhuoren = $('#shouhuoren').val();
		if(shouhuoren){
			where += "&shouhuoren="+shouhuoren;
		}
		var mobile = $('#mobile').val();
		if(mobile){
			where += "&mobile="+mobile;
		}
		var tiaojian = $('#tiaojian').val();
		if(tiaojian){
			where += "&tiaojian="+tiaojian;
		}
		console.log("<?php echo G_WEB_PATH;?>/admin/member/list"+where);
		window.location.href="<?php echo G_WEB_PATH;?>/admin/member/lists"+where;
	})
})
	
</script>
</body>
</html> 