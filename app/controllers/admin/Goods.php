<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Goods extends AdminBase {
	/*后台框架首页*/
	public function index()
	{
		$this->load->view('admin/iframe');
	}
	public function admin_index(){
		$this->load->view('admin/admin_index');
	}
	//商品列表
	public function goods_list(){
		$cateid = $this->uri->segment(4);
		
		$catlist = $this->getAll('go_goods_cat','1=1');
		$last_catlist = array();
		foreach($catlist as $row){
			$last_catlist[$row['cateid']] = $row;
		}
		$res['categorys']=$last_catlist;
		$res['paixu']=$cateid;		
		$list_where = '';
		if($cateid){
			if($cateid=='jiexiaook'){
				$list_where = "`q_uid`!=''";
			}
			if($cateid=='maxqishu'){
				$list_where = "`qishu` = `maxqishu` and `q_end_time`!=''";
			}			
			if($cateid=='renqi'){
				$list_where = "`renqi` = '1'";
			}
			if($cateid=='xinyuan'){
				$list_where = "`is_xy` = '1'";
			}			
			if($cateid=='xianshi'){
				$list_where = "`xsjx_time` != '0'";
			}
			if($cateid=='qishu'){
				$list_where = "1 order by `qishu` DESC";
			}
			if($cateid=='qishuasc'){
				$list_where = "1 order by `qishu` ASC";
			}
			if($cateid=='danjia'){
				$list_where = "1 order by `yunjiage` DESC";
			}
			if($cateid=='danjiaasc'){
				$list_where = "1 order by `yunjiage` ASC";
			}
			if($cateid=='money'){
				$list_where = "1 order by `money` DESC";
			}
			if($cateid=='moneyasc'){
				$list_where = "1 order by `money` ASC";
			}
			if($cateid==''){
				$list_where = "`q_uid`=''  order by `order` ASC,`id` DESC";
			}
			$p = intval($this->uri->segment(6));		//当前页数	
			if($cateid=='page'){
				$list_where = "`q_end_time`=''  order by `id` DESC";
				$p = intval($this->uri->segment(5));
			}			
			if(intval($cateid)){
				$list_where = "`cateid` = '$cateid'";
			}
		}else{
			$list_where = "`q_end_time`=''  order by `id` DESC";
			$p = intval($this->uri->segment(5));		//当前页数
		}
		if(isset($_POST['sososubmit'])){			
			$posttime1 = !empty($_POST['posttime1']) ? $_POST['posttime1'] : NULL;
			$posttime2 = !empty($_POST['posttime2']) ? $_POST['posttime2'] : NULL;
			$res['posttime1'] = $posttime1;
			$res['posttime2'] = $posttime2;		
			$sotype = $_POST['sotype'];
			$sosotext = $_POST['sosotext'];			
			if($posttime1 && $posttime2){
				if($posttime2 < $posttime1){$this->_message("结束时间不能小于开始时间");return false;}
				$list_where = "`createtime` > '$posttime1' AND `createtime` < '$posttime2'";
			}
			if($posttime1 && empty($posttime2)){				
				$list_where = "`createtime` > '$posttime1'";
			}
			if($posttime2 && empty($posttime1)){				
				$list_where = "`createtime` < '$posttime2'";
			}
			if(empty($posttime1) && empty($posttime2)){				
				$list_where = false;
			}			
			if(!empty($sosotext)){			
				if($sotype == 'cateid'){
					$sosotext = intval($sosotext);
					if($list_where)
						$list_where .= "AND `cateid` = '$sosotext'";
					else
						$list_where = "`cateid` = '$sosotext'";
				}
				if($sotype == 'brandid'){
					$sosotext = intval($sosotext);
					if($list_where)
						$list_where .= "AND `brandid` = '$sosotext'";
					else
						$list_where = "`brandid` = '$sosotext'";
				}
				
				if($sotype == 'brandname'){
					$sosotext = htmlspecialchars($sosotext);
					$info = $this->getRow('go_goods_brand',"`name` LIKE '%$sosotext%'");
					
					if($list_where && $info)
						$list_where .= "AND `brandid` = '$info[id]'";
					elseif ($info)
						$list_where = "`brandid` = '$info[id]'";
					else
						$list_where = "1";
				}
				
				
				if($sotype == 'catename'){
					$sosotext = htmlspecialchars($sosotext);
					$info = $this->getRow('go_goods_cat',"`name` LIKE '%$sosotext%'");
					
					if($list_where && $info)
						$list_where .= "AND `cateid` = '$info[cateid]'";
					elseif ($info)
						$list_where = "`cateid` = '$info[cateid]'";
					else
						$list_where = "1";
				}
				if($sotype == 'title'){
					$sosotext = htmlspecialchars($sosotext);
					$list_where = "`title` = '$sosotext'";
				}
				if($sotype == 'id'){
					$sosotext = intval($sosotext);
					$list_where = "`id` = '$sosotext'";
				}
				$res['sosotext'] = $sosotext;
			}else{
				if(!$list_where) $list_where='1';					
			}		
		}		

		$num=20;
		if($list_where){
			$list_where = "status=0 and $list_where";
		}
		$total=$this->db->query("SELECT * FROM `go_goods` WHERE $list_where")->num_rows();
		$this->load->library('pagination');
		if($cateid!='page'){
			$config['base_url'] = G_WEB_PATH.'/admin/goods/goods_list/'.$cateid.'/page';
		}else{
			$config['base_url'] = G_WEB_PATH.'/admin/goods/goods_list/page';
		}
		
		$config['total_rows'] = $total;
		$config['per_page'] = 10;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';	
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';		
		$config['first_link'] = '首页';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '尾页';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['use_page_numbers'] = TRUE;
		$config['cur_tag_open'] = '<li>';
		$config['cur_tag_close'] = '</li>';		
				
		$this->pagination->initialize($config);

        $res['pagebar'] = $this->pagination->create_links();	
        	
        if(!$p){
        	$p=1;
        }
        $page_size = $config['per_page'];
        $start = ($p-1) * $page_size;
		$res['shoplist']=$this->db->query("SELECT * FROM `go_goods` WHERE status=0 and $list_where limit $start, $page_size")->result_array();	
		$this->load->view('admin/goods_list',$res);
	}
	//添加商品
	public function goods_add(){
		$res['cat_list'] = $this->getCatList();	//获取分类
		$id=$this->uri->segment(4);
		$submit = $this->input->post('dosubmit');
		$is_edit = false;
		$msg = '添加';
		$data = array();
		if(intval($id)){			//是编辑模式
			$msg = '编辑';
			$is_edit = true;
			$res['row'] = $this->getRow("go_goods","id='".$id."'");
			$res['brand_list'] = $this->getAll("go_goods_brand","cateid='".$res['row']['cateid']."' and status=0");
		}
		$res['brand_list'] = $this->getAll("go_goods_brand","status=0");
		$res['is_edit'] = $is_edit;		
		$res['msg'] = $msg;
		//print_r($this->input->post());exit;		
		if(isset($submit)){
			$cateid = intval($this->input->post('cateid'));
			$brandid = intval($this->input->post('brandid'));
			$title = htmlspecialchars($this->input->post('title'));
			$thumb = htmlspecialchars($this->input->post('thumg'));
			$picarr = htmlspecialchars($this->input->post('picarr'));
			$default_times = intval($this->input->post('default_times'));
			
			$canyurenshu = 0;
			//编辑时价格表单disabled了，所以先判断有没有这个表单值传来
			$money = $this->input->post('money');
			if( isset($money)){
				$money = intval($money);
				$yunjiage = intval($this->input->post('yunjiage'));	
				if(!$yunjiage){
					$this->_message("云购价格不正确");return false;
				}
				if($money < $yunjiage){
					$this->_message("商品价格不能小于购买价格");return false;				
				}					
				$zongrenshu = ceil($money/$yunjiage);
				$shenyurenshu = $zongrenshu-$canyurenshu;
				if($zongrenshu==0 || ($zongrenshu-$canyurenshu)==0){
					$this->_message("云购价格不正确");return false;
				}
				$data2['money'] = $money;
				$data2['yunjiage'] = $yunjiage;
				$data2['canyurenshu'] = 0;
				$data2['zongrenshu'] = $zongrenshu;
				$data2['shenyurenshu'] = $shenyurenshu;				
			}else{		//没有价格，只有编辑时。此时读原数据
				$data2['money'] = $res['row']['money'];
				$data2['yunjiage'] = $res['row']['yunjiage'];
				$data2['canyurenshu'] = $res['row']['canyurenshu'];
				$data2['zongrenshu'] = $res['row']['zongrenshu'];
				$data2['shenyurenshu'] = $res['row']['shenyurenshu'];					
			}
			if(!$cateid){$this->_message("请选择分类");return false;}
			if(!$brandid){$this->_message("请选择品牌");return false;}
			//if(!$brandid)$this->_message("请选择品牌");
			if(!$title){$this->_message("标题不能为空");return false;}
			if(!$thumb && !$is_edit){$this->_message("缩略图不能为空");return false;}
			if(!$default_times){$this->_message("默认购买人次不能为空");return false;}	
			$maxqishu = intval($this->input->post('maxqishu'));
			if($maxqishu > 65535){
				$this->_message("最大期数不能超过65535期");return false;
			}
			$temp = $this->input->post('xsjx_time');		
			if($temp != ''){
				$temp .= ':00';			
				$xsjx_time = strtotime($temp) ? strtotime($temp) : time();
			}else{
				$xsjx_time = '0';
			}			 			
			$data = array(
			    'cateid' => intval($this->input->post('cateid')),
			    'brandid' => intval($this->input->post('brandid')),
			    'title' => htmlspecialchars($this->input->post('title')),
			    'title2' => htmlspecialchars($this->input->post('title2')),
			    'keywords' => htmlspecialchars($this->input->post('keywords')),
			    'description' => htmlspecialchars($this->input->post('description')),
			    'default_times' => $default_times,
			    'maxqishu' => intval($this->input->post('maxqishu')),
			    'qishu' => 1,
			    'maxqishu' => $maxqishu,
			    'content' => stripslashes($this->input->post('content')),
			    'codes_table' => 'go_goods_code_1',				//购物码表【为将来分表作准备】
			    'pos' => intval($this->input->post('pos')),
			    'renqi' => intval($this->input->post('renqi')),
			    'hot' => intval($this->input->post('hot')),
			    'is_xy' => intval($this->input->post('is_xy')),
			    'xinyuan' => intval($this->input->post('xinyuan')),
			    'xsjx_time' => $xsjx_time
			);
			if(!empty($thumb)){
				$data['thumb'] = $thumb;
			}
			if(!empty($picarr)){
				$data['picarr'] = $picarr;
			}
			$data = (isset($data2)) ? array_merge($data,$data2) : $data;				
			if($is_edit){			//编辑
				$data['id'] = $id;
				$data['maxqishu'] = $res['row']['maxqishu'];
				if($res['row']['thumb']){			//原来就有图片
					if(!empty($thumb)){			
						unlink(ROOTPATH.$res['row']['thumb']);					
					}else{
						$data['thumb'] = $res['row']['thumb'];
					}					
				}
				if($res['row']['picarr']){			//原来就有图片
					if(!empty($picarr)){			//有新图片，删除旧图
						$pic_arr = explode('#',$res['row']['picarr']);	
						foreach($pic_arr as $pic){
							unlink(ROOTPATH.$pic);
						}			
					}else{			
						$data['picarr'] = $res['row']['picarr'];
					}					
				}				
				$flag = $this->db->replace('go_goods', $data);
			}else{				
				//判断是否名字已存在				
				$data['createtime'] = date('Y-m-d H:i:s'); 
				$flag = $this->db->insert('go_goods', $data);
			}
			if($flag){			
				$sid = $this->db->insert_id();
				$this->db->Query("update `go_goods` SET `sid` = '$sid' where `id` = '$sid'");
				$this->_message("商品".$msg."成功!",G_WEB_PATH.'/admin/goods/goods_list');
			}else{
				$this->_message("商品".$msg."失败!");
			}
			return false;									
		}	
		$this->load->view('admin/goods_add',$res);
	}
}
