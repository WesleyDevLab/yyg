<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends NoCheckHomeBase {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}
	public function test(){
		phpinfo();
	}	
	//首页	
	public function index(){
		//$this->output->cache(3600);
		$Mcartlist = _getcookie('Cartlist');
		//print_r($Mcartlist);
		$data['curr'] = 'index';	//首页选中
		$data['slides'] = $this->db->query("select * from go_slide where type=1")->result_array();
		//一级分类
		$catlist = $this->db->query("select * from go_goods_cat where type=0 and parentid=0 and status=0 order by sort desc")->result_array();	//商品分类	
		$cat_level = array();
		foreach ($catlist as $cat){
			$cat_level[$cat['cateid']] = $cat;
		}
		$data['catlist'] = $cat_level;
		//所有分类选择两个热门商品,注意满员商品不能显示【有可能未开奖】
		$cat_hot_goods = array();
		foreach($catlist as $cat){
			$in_self_cats = $this->getChildCat($cat['cateid'], 1);
			$out_self = implode(',', $in_self_cats);
			$out_sql = "cateid in ($out_self)";
			$goods = $this->db->query("select * from `go_goods` where $out_sql and shenyurenshu!=0 and `status`=0 and `hot`=1 and is_xy=0 limit 2")->result_array();
			$goods = $this->readHtml($goods);
			$cat_hot_goods[$cat['cateid']] = $goods;
		}
		$data['cat_hot_goods'] = $cat_hot_goods;
		//已开奖列表
		$data['listItems'] = $this->db->query("select * from `go_goods` where `q_uid`!='' and status=0 ORDER BY `q_end_time` DESC limit 0,5")->result_array();
        if(!empty($data['listItems'])){
            foreach($data['listItems'] as $key=>$val){
                //查询出购买次数
                $recodeinfo=$this->db->query("select `gonumber` from `go_member_go_record` where `uid` ='$val[q_uid]'  and `shopid`='$val[id]' ")->row_array();
                //echo "select `gonumber` from `@#_member_go_record` where `uid` !='$val[q_uid]'  and `shopid`='$val[id]' ";
                $data['listItems'][$key]['q_user']=$this->get_user_name($val['q_uid']);
                $data['listItems'][$key]['q_end_time']=$val['q_end_time'];
                $data['listItems'][$key]['gonumber']=$recodeinfo['gonumber'];
            }
        }
        $data['listItems'] = $this->readHtml($data['listItems']);   		
		$nowtime = time();
		//即将揭晓：分满员购买及限时快到[此时只显示限时]  (`xsjx_time`>'$nowtime' or shenyurenshu=0)
		$jiexiao=$this->db->query("select * from `go_goods` where `q_uid`='0' and status=0 and (shenyurenshu=0 or xsjx_time!=0 or shenyurenshu<10) and is_xy=0 order by shenyurenshu asc")->result_array();		

		$now_time = time();
		$new_array = array();
		foreach($jiexiao as $k=>$row){
			if(count($new_array)>=3){		//只显示3条
				continue;
			}
			if($row['xsjx_time']>0){		//限时过期的也显示
				if( ($row['xsjx_time']-$now_time)<0 || ($row['xsjx_time']>$now_time && $row['xsjx_time']-$now_time<10*60) ){
					$new_array[$k] = $row;
				}
			}else{
				$new_array[$k] = $row;
			}
		}
		$data['jiexiao'] = $this->readHtml($new_array);
		//print_r($data['jiexiao']);
		$this->load->view('index/index',$data);
		$this->load->view('layout/footer');
	}
	//频道页 【路由以后来】 商品在goods.php 异步加载
	public function classify(){
		$data['curr'] = '';
		$cateid =htmlspecialchars($this->uri->segment(3));
		$data['cateid'] = $cateid;
		if($cateid){
			$out_self_cats = $this->getChildCat($cateid, 0);	//该分类下所有子分类，不包含自身
			$data['child_cat_list'] = array();
			if($out_self_cats){
				$out_self = implode(',', $out_self_cats);
				$out_sql = "cateid in ($out_self)";
				$data['child_cat_list'] = $this->db->query("select * from go_goods_cat where $out_sql and status=0 order by sort desc,cateid desc")->result_array();
			}
			$data['curr_cat'] = $this->db->query("select * from go_goods_cat where cateid='".$cateid."' and status=0")->row_array();
			$data['brand_list1'] = $this->db->query("select * from go_goods_brand where status=0 and cateid='".$cateid."' order by sort desc,id desc limit 0,10")->result_array();
			$data['brand_list2'] = $this->db->query("select * from go_goods_brand where status=0 and cateid='".$cateid."' order by sort desc,id desc limit 11,10")->result_array();
			$data['brand_list3'] = $this->db->query("select * from go_goods_brand where status=0 and cateid='".$cateid."' order by sort desc,id desc limit 21,10")->result_array();
			
			$this->load->view('index/classify',$data);
			$this->load->view('layout/footer');
		}		
	}
	//品牌页 商品在goods.php 异步加载
	public function brand(){
		$data['curr'] = '';
		$cateid =htmlspecialchars($this->uri->segment(3));	//品牌Id
		$data['cateid'] = $cateid;
		if($cateid){			
			$data['curr_cat'] = $this->db->query("select * from go_goods_brand where id='".$cateid."' and status=0")->row_array();
			$data['brand_list1'] = $this->db->query("select * from go_goods_brand where status=0 order by sort desc,id desc limit 0,10")->result_array();
			$data['brand_list2'] = $this->db->query("select * from go_goods_brand where status=0 order by sort desc,id desc limit 11,10")->result_array();
			$data['brand_list3'] = $this->db->query("select * from go_goods_brand where status=0 order by sort desc,id desc limit 21,10")->result_array();
			$data['child_cat_list'] = $this->db->query("select * from go_goods_cat where parentid=0 and status=0 order by sort desc,cateid desc")->result_array();

			$this->load->view('index/brand',$data);
			$this->load->view('layout/footer');
		}		
	}
	//从分类点进来的页面
	public function catgoods(){
		$data['curr'] = '';
		$data['catlist'] = $this->getCatList(0);
		$cateid =intval($this->uri->segment(3));	
		if($cateid){
			$data['curr_cat'] = $this->getRow('go_goods_cat',"status=0 and cateid='".$cateid."'");			
		}else{
			$data['curr_cat'] = '';			
		}	
		$this->load->view('index/catgoods',$data);
		$this->load->view('layout/footer');			
	}
	//揭晓[即将、往期]
	public function jiexiao(){
		$data['type'] = $this->uri->segment(3) ? htmlspecialchars($this->uri->segment(3)) : 'soon';
		$data['sid'] = '';
		if($data['type'] == 'soon' || $data['type'] =='before'){
			$data['title'] = ($data['type']=='soon') ? '即将揭晓' : '往期揭晓';
			$data['curr'] = ($data['type']=='soon') ? 'lottery' : '';
			if($data['type'] == 'before'){			//往期揭晓
				$data['sid'] = safe_replace($this->uri->segment(4));
			}
			$this->load->view('index/jiexiao',$data);
			$this->load->view('layout/footer');				
		}
	}
	//商品详情
	public function info(){
		$good_id = htmlspecialchars($this->uri->segment(3));
		if(!intval($good_id)){			//为重写路由判断用
			$good_id = htmlspecialchars($this->uri->segment(2));
		}
		$item = $this->getRow('go_goods',"id='".$good_id."' and status=0");
		if(!$item){
			$this->_mobileMsg("商品不存在！");return false;
		}
		$qishu = $this->getAll('go_goods',"sid='".$item['sid']."' order by qishu desc limit 0,3");			//获取所有期数
		$qishu = $this->readHtml($qishu);
		$path_file = G_WEB_PATH.'/'.$this->getCatDir($item['cateid']);				//获取当前静态文件路径
		$data['good_dir'] = $path_file;		
		$data['item'] = $item;
		$data['curr'] = $xycords = '';
		$data['qishu'] = $qishu;
		if($item['is_xy']==1){			//获取留言
			$cords = $this->getAll('go_goods_comment',"good_id='$good_id' and sid='".$item['sid']."' order by updatetime desc limit 0,10");		//所有留言记录
			foreach($cords as $k=>$row){
				$member = $this->getRow('go_member',"uid='".$row['q_uid']."'");
				$cords[$k]['user'] = $this->get_user_name($row['q_uid']);
				//$cords[$k]['user'] = $member['username'];
				$cords[$k]['img'] = $member['img'];
				$cords[$k]['user_ip'] = $member['user_ip'];
			}
			$xycords = $this->db->query("select sum(xinyuan) as xyed from go_xy where good_id='$good_id' and sid='".$item['sid']."'")->row_array();	//获得该商品所有心愿值
		}else{							//获取购买记录
			$cords = $this->getAll('go_member_go_record',"shopid='$good_id' order by time desc,id desc limit 0,10");
			foreach($cords as $k=>$row){
				$goucode_arr = explode(',',$row['goucode']);
				if(count($goucode_arr)>1){
					$cords[$k]['code_duan'] = $goucode_arr[0].'-'.end($goucode_arr);
				}else{
					$cords[$k]['code_duan'] = $goucode_arr[0];
				}
				
				$member = $this->getRow('go_member',"uid='".$row['uid']."'");
				$cords[$k]['user'] = $this->get_user_name($row['uid']);
				//$cords[$k]['user'] = $row['username'];
				$cords[$k]['user_ip'] = $member['user_ip'];
				//$cords[$k]['img'] = $member['img'];
				$cords[$k]['img'] = $row['uphoto'];
			}									
		}
		$data['cords'] = $cords;
		$data['xycords'] = $xycords;
		//期数
		$curr_qishu = $item['qishu'];			//当前期数.需要获取紧邻的期数以后做		
		$pre_id = 0;
		$itemlist = $this->db->query("select * from `go_goods` where `sid`='$item[sid]' and `q_end_time`!=''  order by `qishu` DESC")->result_array();	
		$gorecode = $benrecode = array();
		if(!empty($itemlist)){
			$pre_id = $itemlist[0]['id'];
			$pre_qishu = $itemlist[0]['qishu'];			//上期参数默认取第一个
			$pre_q_end_time = $itemlist[0]['q_end_time'];
			foreach($itemlist as $k=>$row){
				if($row['id'] == $item['id']){	//本期商品已获奖
					if(isset($itemlist[$k+1])){			//上期商品存在
						$pre_id = $itemlist[$k+1]['id'];
						$pre_qishu = $itemlist[$k+1]['qishu'];
						$pre_q_end_time = $itemlist[$k+1]['q_end_time'];
					}else{
						$pre_id = 0;			//说明上一期不存在
					}
				}
			}
			$gorecode=$this->db->query("select * from `go_member_go_record` where `shopid`='".$pre_id."' AND `shopqishu`='".$pre_qishu."' and huode!=0 ORDER BY id DESC LIMIT 1")->row_array();
			if($gorecode){
				$gorecode['q_end_time'] = $pre_q_end_time;
			}
		}
		$data['pre_id'] = $pre_id;
		$benrecode = $this->db->query("select * from `go_member_go_record` where `shopid`='".$good_id."' AND `shopqishu`='".$item['qishu']."' and huode!=0 ORDER BY id DESC LIMIT 1")->row_array();
		$benrecode['q_end_time']=$item['q_end_time'];
		$data['gorecode'] = $gorecode;
		$data['benrecode'] = $benrecode;
		$this->load->helper('file');
		$this->load->view('index/detail',$data);
		$this->load->view('layout/footer');				
	}	
	//商品详情：图文详情
	public function goodsdesc(){
		$data['key']="图文详情";
		$itemid=intval($this->uri->segment(3));
		$desc = $this->getRow('go_goods',"id='".$itemid."'");
		if(!$desc){
			$this->_messagemobile('页面错误!');
		}
		$data['desc'] = $desc;
		$data['curr'] = '';
		$this->load->view('index/goodsdesc',$data);
		$this->load->view('layout/footer');			
	}
	//某件商品的全部购买记录
	public function userbuylist(){
		$data['curr'] = '';
		$data['good_id']=intval($this->uri->segment(3));
		$this->load->view('index/userbuylist',$data);
		$this->load->view('layout/footer');			
	}
	//某件商品全部留言
	public function message(){
		$data['curr'] = '';
		$itemid=intval($this->uri->segment(3));
		if(intval($itemid)){
			$data['good_id'] = $itemid;
			$this->load->view('index/message',$data);
			$this->load->view('layout/footer');				
		}

	}
		
}
