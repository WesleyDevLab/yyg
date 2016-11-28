<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lottery extends AdminBase {
	public function index()
	{
		
	}
	public function kjajax(){
		$code = $this->input->post('kj_code');
		$gid = $this->input->post('gid');
		if($code && $gid){		//必须是数字
			$rows = $this->getAll("go_member_go_record","shopid='".$gid."'","id,uid,username,uphoto,goucode,time");
			$flag = false;
			if(count($rows)>0){
				foreach($rows as $row){
					$buy_time = date('Y-m-d H:i:s',$row['time']);
					$code_arr = explode(',',$row['goucode']);
					if(in_array($code,$code_arr)){
						$this->db->trans_start();
						$flag = $this->db->Query("update `go_member_go_record` SET `huode` = '$code' where `id` = '".$row['id']."'");
						if(!$flag){
							$this->db->trans_rollback();
							$out = array('code'=>404,'msg'=>'更新购买记录数据失败');
							exit(json_encode($out));
						}						
						$nowtime = time();
						$flag2 = $this->db->Query("update `go_goods` SET `q_uid` = '".$row['uid']."',`q_user`='".$row['username']."',`q_pic`='".$row['uphoto']."',`q_user_code`='".$code."',`time`='$buy_time',`q_end_time`='$nowtime' where `id` = '$gid'");
						if(!$flag2){
							$this->db->trans_rollback();
							$out = array('code'=>404,'msg'=>'更新商品中奖信息失败');
							exit(json_encode($out));
						}
						//获取当前商品期数
						
						$good = $this->getRow('go_goods',"id='".$gid."'");
						if($good['maxqishu']>$good['qishu'] and $good['qishu']<MAXQISHU){		//还可添加期
							$data2 = array(
								'sid' => $good['sid'],
								'cateid' => $good['cateid'],
								'brandid' => $good['brandid'],
								'title' => $good['title'],
								'title2' => $good['title2'],
								'keywords' => $good['keywords'],
								'description' => $good['description'],
								'money' => $good['money'],
								'yunjiage' => $good['yunjiage'],
								'default_times' => $good['default_times'],
								'zongrenshu' => $good['zongrenshu'],
								'canyurenshu' => 0,												//改
								'shenyurenshu' => $good['zongrenshu'],				//改
								'qishu' => $good['qishu']+1,							//改
								'maxqishu' => $good['maxqishu'],
								'thumb' => $good['thumb'],
								'picarr' => $good['picarr'],
								'content' => $good['content'],
								'codes_table'=> $good['codes_table'],
								'pos' => $good['pos'],
								'renqi' => $good['renqi'],
								'hot' => $good['hot'],
								'order' => $good['order'],
								'createtime' => date('Y-m-d H:i:s'),
							);
							$flag4 =  $this->db->insert('go_goods', $data2);
							if(!$flag4){
								$this->db->trans_rollback();
								$out = array('code'=>404,'msg'=>'重新生成一期商品失败!');
								exit(json_encode($out));
							}
						}
						
						$this->db->trans_complete();
						$out['code'] = 200;
					}					
				}				
			}
			if(!$flag){					//输入的获奖码不存在
				$out['code'] = 400;
			}
		}else{
			$out['code'] = 403;
		}
		exit(json_encode($out));			
	}
	//开奖视频
	public function kjvideo(){
		$kj_video = $this->input->post('kj_video');
		$gid = $this->input->post('gid');
		if($kj_video && is_numeric($gid)){		//必须是数字
			$flag = $this->db->Query("update `go_goods` SET `q_video`='$kj_video' where `id` = '$gid'");
			$out['code'] = 200;	
			if(!$flag){					//输入的获奖码不存在
				$out['code'] = 400;
			}
		}else{
			$out['code'] = 403;
		}
		exit(json_encode($out));			
	}	
	//待开奖[非限时、限时]
	public function daikj(){
		$type = $this->uri->segment(4);				//待开奖分类
		$catlist = $this->getAll('go_goods_cat','1=1');
		$last_catlist = array();
		foreach($catlist as $row){
			$last_catlist[$row['cateid']] = $row;
		}
		if(!$type){
			$type="notxs";
		}
		$data['curr'] = $type;
		$data['categorys']=$last_catlist;
		switch($type){
			case 'notxs':
			$where = " and status=0 and xsjx_time=0 and q_end_time=0 and shenyurenshu=0";
			break;
			case 'xs':
			$where = " and status=0 and xsjx_time>0 and q_end_time=0";
			break;
		}	
		$all = $this->db->query("select * from go_goods where 1=1 $where order by `order` asc");
		$total = $all->num_rows();
		$this->load->library('pagination');
		
		$config['base_url'] = G_WEB_PATH.'/admin/lottery/daikj/'.$type.'/page';
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

        $data['pagebar'] = $this->pagination->create_links();
        $p = intval($this->uri->segment(6));		//当前页数
        if(!$p){
        	$p = 1;
        }
        $page_size = $config['per_page'];
        $start = ($p-1) * $page_size;
        $categorys = $this->db->query("select * from go_goods where 1=1 $where order by `order` asc limit $start, $page_size")->result_array();
		$data['list'] = $categorys;
		$this->load->view('admin/lottery_notxs',$data);
	}
	//已开奖[非限时、限时]
	public function opened(){
		$type = $this->uri->segment(4);				//待开奖分类
		$catlist = $this->getAll('go_goods_cat','1=1');
		$last_catlist = array();
		foreach($catlist as $row){
			$last_catlist[$row['cateid']] = $row;
		}
		if(!$type){
			$type="notxs";
		}
		$data['curr'] = $type;
		$data['categorys']=$last_catlist;
		switch($type){
			case 'notxs':
			$where = " and status=0 and xsjx_time=0 and q_end_time>0";
			break;
			case 'xs':
			$where = " and status=0 and xsjx_time>0 and q_end_time>0";
			break;
		}	
		$all = $this->db->query("select * from go_goods where 1=1 $where order by `order` asc");
		$total = $all->num_rows();
		$this->load->library('pagination');
		
		$config['base_url'] = G_WEB_PATH.'/admin/lottery/opened/'.$type.'/page';
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

        $data['pagebar'] = $this->pagination->create_links();
        $p = intval($this->uri->segment(6));		//当前页数
        if(!$p){
        	$p = 1;
        }
        $page_size = $config['per_page'];
        $start = ($p-1) * $page_size;
        $categorys = $this->db->query("select * from go_goods where 1=1 $where order by `order` asc limit $start, $page_size")->result_array();
		$data['list'] = $categorys;
		$this->load->view('admin/lottery_opened',$data);
	}	
	
}
