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
			'dir'		: 'goods_thumg',
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
	$('#file_upload2').uploadify({
		'formData'     : {
			'timestamp' : '<?php echo $timestamp;?>',
			'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
			'dir'		: 'goods',
		},
		'swf'      : '<?php echo G_PLUGIN_PATH; ?>/uploadify/uploadify.swf',
		'buttonText': '上传图片',
		'uploader' : '<?php echo G_WEB_PATH; ?>/admin/api/uploadify',
		'multi': true,	
		'uploadLimit':10,		//能同时上传
        'onSelect' : function(file) {
        	$('.upload-img-list').html('');
        },		
		'onUploadSuccess' : function(file, data, response) {
	        //console.log(data);	        
	        $('.upload-img-list').append("<li><img style='border:1px solid #eee; padding:1px;left:0; width:100px; height:100px;' src='"+data+"' /></li>")
	    	var old_html = $('.jq_picarr').val();
	        if(old_html){
	        	old_html += '#';
	        }
	        $('.jq_picarr').val(old_html+data);
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
	<h3 class="nav_icon">添加商品</h3>
	<span class="span_fenge lr10"></span>
	<a href="<?php echo G_WEB_PATH;?>/admin/goods/goods_list">商品管理</a>
	<span class="span_fenge lr5">|</span>
	<a href="<?php echo G_WEB_PATH;?>/admin/goods/goods_add">添加商品</a>
	<span class="span_fenge lr5">|</span>
</div>
<div class="bk10"></div>
<div class="table_form lr10">
<form method="post" action="" onSubmit="return CheckForm()">
	<table width="100%"  cellspacing="0" cellpadding="0">
		<tr>
			<td align="right" style="width:120px"><font color="red">*</font>所属分类：</td>
			<td>
			<select id="category" name="cateid">
			<option value="0">≡ 请选择栏目 ≡</option>
	        <?php
	        foreach($cat_list as $item){
				if( isset($row) && $item['cateid']==$row['cateid'] ){
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
            </td>
		</tr>
        <tr>
			<td align="right" style="width:120px"><font color="red">*</font>所属品牌：</td>
			<td>
            	<select id="brand" name="brandid">
                	<option value="0">≡ 请选择品牌 ≡</option>
	        <?php
	        foreach($brand_list as $item){
				if( isset($row) && $item['id']==$row['brandid'] ){
				?>
					<option selected value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
				<?php
				}else{
				?>
					<option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
				<?php
				}
	    	}
        	?>        				
                      	
				</select>
			</td>
		</tr>      
        <tr>
			<td align="right" style="width:120px"><font color="red">*</font>商品标题：</td>
			<td>
            <input  type="text" id="title" value="<?php echo (isset($row['title'])) ? $row['title'] : '';?>"  name="title" onKeyUp="return gbcount(this,100,'texttitle');"  class="input-text wid400 bg">

            <span style="margin-left:10px">还能输入<b id="texttitle">100</b>个字符</span>
           
            </td>
		</tr>
        <tr>
			<td align="right" style="width:120px">副标题：</td>
			<td><input  type="text" id="title2" value="<?php echo (isset($row['title2'])) ? $row['title2'] : '';?>" name="title2" onKeyUp="return gbcount(this,100,'texttitle2');"  class="input-text wid400">
            <span class="lr10">还能输入<b id="texttitle2">100</b>个字符</span>
            </td>
		</tr>
        <tr>
			<td align="right" style="width:120px">关键字：</td>
			<td><input type="text" name="keywords" value="<?php echo (isset($row['keywords'])) ? $row['keywords'] : '';?>"  name="title"  class="input-text wid300" />
            <span class="lr10">多个关键字请用   ,  号分割开</span>
            </td>
		</tr>
        <tr>
			<td align="right" style="width:120px">商品描述：</td>
			<td><textarea name="description" class="wid400" onKeyUp="gbcount(this,250,'textdescription');" style="height:60px"><?php echo (isset($row['description'])) ? $row['description'] : '';?></textarea><br /> <span>还能输入<b id="textdescription">250</b>个字符</span>
            </td>
		</tr>      
		<tr style="background-color:#FFC">
			<td style="width:120px"></td>
			<td>
				<b>提示：</b> <font color="red">商品总价格请不要填写100，2300,5000这样的整数,整数价格计算出的云购码可能就为10000001</font><br />
				<b>提示：</b> 商品价格过大，添加商品会变慢，请耐心等待！
			</td>
		</tr>
		<tr>
			<td align="right" style="width:120px"><font color="red">*</font>商品总价格：</td>
			<td><input type="text" name="money" <?php if($is_edit){echo "disabled";}?>  name="money" value="<?php echo (isset($row['money'])) ? $row['money'] : '';?>" onKeyUp="value=value.replace(/\D/g,'')" style="width:65px; padding-left:0px; text-align:center" class="input-text">元</td>
		</tr>
		<tr>
			<td align="right" style="width:120px"><font color="red">*</font>云购单次价格：</td>
			<td><input type="text" name="yunjiage" <?php if($is_edit){echo "disabled";}?> onKeyUp="value=value.replace(/\D/g,'')" style="width:65px;padding-left:0px;text-align:center" class="input-text" value="<?php echo (isset($row['yunjiage'])) ? $row['yunjiage'] : '1';?>">元</td>
		</tr>
        <tr>
            <td align="right" style="width:120px"><font color="red">*</font>默认购买人次：</td>
            <td><input type="text" id="default_times"  name="default_times" onKeyUp="value=value.replace(/\D/g,'')" style="width:65px; padding-left:0px; text-align:center" class="input-text" value="<?php echo isset($row['default_times']) ? $row['default_times'] : 1; ?>">&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>      
			<td align="right" style="width:120px"><font color="red">*</font>最大期数：</td>     
            <td><input type="text" name="maxqishu" <?php if($is_edit){echo "disabled";}?> value="<?php echo isset($row['maxqishu']) ? $row['maxqishu'] : 100;?>" class="input-text" style="width:65px; padding-left:0px; text-align:center" onKeyUp="value=value.replace(/\D/g,'')">期,	&nbsp;&nbsp;&nbsp;期数上限为65535期,每期揭晓后会根据此值自动添加新一期商品！</td>
		</tr>	
        
        <tr>
         <td align="right" style="width:120px"><font color="red">*</font>缩略图：</td>
        <td>
        	<div class="show_unit_pic">
        	<input type="hidden" name="thumg" value="" class="input-text jq_thumg">
        	<img id="thumg" src="<?php echo (isset($row['thumb']) && $row['thumb']!='') ? $row['thumb'] : G_UPLOAD_PATH."/photo/goods.jpg"; ?>  " style="border:1px solid #eee; padding:1px;left:0; width:50px; height:50px;">
			</div>
			<input type="button" id="file_upload" class="button" value="上传图片"/>		
        </td>
      </tr>
        <tr>
			<td align="right" style="width:120px">展示图片：</td>            
			<td><fieldset class="uploadpicarr">
					<legend>列表</legend>
					<input type="hidden" name="picarr" value="" class="input-text jq_picarr">
					<div class="picarr-title">最多可以上传<strong>10</strong> 张图片   </div>
					<input id="file_upload2" name="file_upload" type="file" multiple="true">
					<ul id="uppicarr" class="upload-img-list">
					
					<?php
					if(!empty($row['picarr'])){
						$pic_arr = explode("#",$row['picarr']);
						foreach($pic_arr as $pic){
						?>
						<li><img style="border:1px solid #eee; padding:1px;left:0; width:100px; height:100px;" src="<?php echo $pic;?>"></li>
						<?php	
						}
					}
					?>
					</ul>
				</fieldset>
             </td>           
		</tr>        
		<tr>
        	<td height="300" style="width:120px"  align="right"><font color="red">*</font>商品内容详情：</td>
			<td>
				<div style="width:955px;">
				<textarea type="text"  class="form-control kindEditors" name="content" placeholder="content"><?php echo (isset($row['content'])) ? $row['content'] : '';?></textarea>
				</div>				
            </td>        
		</tr>
        <tr>
        	<td align="right" style="width:120px">是否心愿商品：</td>
            <td width="900" class="jq_radio">
	 		<?php
	 		if(isset($row['is_xy'])){
			?>
				<label for="no"><input id="no" name="is_xy" <?php echo ($row['is_xy']==0) ? 'checked' : '' ?> value="0" type="radio" />&nbsp;否&nbsp;&nbsp;</label>
				<label for="yes"><input id="yes" name="is_xy" <?php echo ($row['is_xy']==1) ? 'checked' : '' ?>  value="1" type="radio" />&nbsp;是&nbsp;&nbsp;</label>				
			<?php
			}else{
			?>
				<label for="no"><input id="no" name="is_xy" checked value="0" type="radio" />&nbsp;否&nbsp;&nbsp;</label>
				<label for="yes"><input id="yes" name="is_xy"  value="1" type="radio" />&nbsp;是&nbsp;&nbsp;</label>			
			<?php			
			}
	 		?>			 
            <span class="lr10">(说明：心愿商品不能购买)</span>	
            </td>          
        </tr>
        <tr class="jq_is_show_hide" <?php echo (isset($row) && $row['is_xy']=='1') ? '' : 'style="display:none;"';?> >
        	<td align="right" style="width:120px">起始心愿值：</td>
        	<td><input type="text" name="xinyuan" value="<?php echo (isset($row['xinyuan'])) ? $row['xinyuan'] : '0';?>" num_float int /></td>
        </tr>		 
        <tr>
        	<td align="right" style="width:120px">商品属性：</td>
            <td width="900">
			 <input name="pos" <?php echo (isset($row) && $row['pos']==1) ? "checked" : ''; ?> value="1" type="checkbox" />&nbsp;推荐&nbsp;&nbsp;
			 <input name="renqi" <?php echo (isset($row) && $row['renqi']==1) ? "checked" : ''; ?> value="1" type="checkbox" />&nbsp;人气&nbsp;&nbsp;
             <input name="hot" <?php echo ( isset($row) && $row['hot']==1) ? "checked" : ''; ?> value="1" type="checkbox" />&nbsp;热销爆款&nbsp;&nbsp;
            </td>          
        </tr>
       	<tr>
			<td align="right" style="width:120px">限时揭晓：</td>
			<td>
            
             选择日期：
              <input name="xsjx_time" type="text" value="<?php echo (isset($row) && $row['xsjx_time']!='0') ? date('Y-m-d H:i',$row['xsjx_time']) : ''; ?>" id="xsjx_time" class="input-text posttime"  readonly="readonly" />
				<script type="text/javascript">
				date = new Date();
				Calendar.setup({
					inputField     :    "xsjx_time",
					ifFormat       :    "%Y-%m-%d %H:%M",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script>
 
              <span class="lr10">&nbsp;</span>	<b>不选择时间则不参与限时揭晓, 本期揭晓后自动添加的下一期不是限时揭晓商品！</b>         
        </tr>        
        <tr height="60px">
			<td align="right" style="width:120px"></td>
			<td><input type="submit" name="dosubmit" class="button" value="<?php echo $msg;?>商品" /></td>
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
	/*
	$("#category").change(function(){ 
		var parentId=$("#category").val(); 
		if(null!= parentId && ""!=parentId){ 
			$.getJSON("<?php echo G_WEB_PATH; ?>/admin/ajax/getBrand/"+parentId,{},function(myJSON){
				var options="";
				if(myJSON.length>0){ 			
					//options+='<option value="0">≡ 请选择品牌 ≡</option>'; 
					for(var i=0;i<myJSON.length;i++){ 
						options+="<option value="+myJSON[i].id+">"+myJSON[i].name+"</option>"; 
					} 
					$("#brand").html(options);
					return false;
				}else{
					$("#brand").html("<option value='0'>≡ 请选择栏目 ≡</option>");
				} 
			}); 
		}  
	});
	*/
	
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