<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//用户操作：问题反馈及收藏
class MemberCount extends AdminBase {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('roby');	
	}	
	/*
		显示会员
		根据第四个参数显示不同类型会员
		@def 		默认会员
		@del 		删除会员
		@noreg 		未认证会员
		@b_qq 		QQ绑定会员
		@b_weibo 	微博绑定会员
		@b_taobao 	淘宝绑定会员
		@day_new	今日新增
		@day_shop	今日消费		
					....
		第五个参数排序字段
		uid,money,time,jingyan,score
					....
		第六个参数排序类型
		desc,asc
					....		
	*/
	/*用户收藏*/
	public function collect(){
		//查找会员
		$where = $order = $where_list = $where_all = $where_p = '';
        $p = intval($this->input->get('per_page'));		//当前页数
        if(!$p){
        	$p=1;
        }
		$act =  htmlspecialchars(trim($this->input->get('act')));
		if($act=='form'){
			$p = 1;
		}
		$where_p .= "?p=".$p;
		$username=htmlspecialchars(trim($this->input->get('username') ));
		if($username){
			$data['username'] = $username;
			$where .= " and username like '%".$username."%'";
			$where_p.="&username=".$username;
		}
		$good_type=intval(trim($this->input->get('good_type')));
		if($good_type){
			$data['good_type'] = $good_type;
			$where_list = " and good_type=$good_type";
			$where_p.="&good_type=".$good_type;
		}
		/*
		$email=htmlspecialchars(trim($_POST['email']));
		if($email){
			$where .= " and m.email like '%".$email."%'";
		}
		*/
		$good_name = htmlspecialchars(trim($this->input->get('good_name')));
		if($good_name){
			$data['good_name'] = $good_name;
			$where .= " and good_name like '%".$good_name."%'";
			$where_p.="&good_name=".$good_name;
		}
		$posttime1 = $this->input->get('posttime1');
		$posttime2 = $this->input->get('posttime2');

		$data['posttime1'] = $posttime1;
		$data['posttime2'] = $posttime2;
		$where_p.="&posttime1=".$posttime1."&posttime2=".$posttime2;	
				
		if($posttime1 && $posttime2){
			if($posttime2 < $posttime1){$this->_message("结束时间不能小于开始时间");return false;}			
			$where .= " and collect_date >= '".$posttime1."' AND collect_date <= '".$posttime2."'";
		}
		if($posttime1 && empty($posttime2)){				
			$where .= " and collect_date >= '".$posttime1."'";
		}
		if($posttime2 && empty($posttime1)){				
			$where .= " and collect_date <= '".$posttime2."'";
		}
		if(empty($posttime1) && empty($posttime2)){				
			$where .= false;
		}

		if(empty($where_list)){
			$where_list .= "order by collect_date desc";
		}			
		$all= $this->db->query("select * from go_collect where 1=1 $where $where_list");
		$data['p'] = $p;
		$total = $all->num_rows();
		$this->load->library('pagination');
		$where .= $order;
		$config['base_url'] = G_WEB_PATH.'/admin/membercount/collect'.$where_p;
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
		$config['cur_tag_open'] = '<li><span class="red">';
		$config['cur_tag_close'] = '</span></li>';	
		$config['page_query_string'] = TRUE;					
		$this->pagination->initialize($config);

        $data['pagebar'] = $this->pagination->create_links();       
        $page_size = $config['per_page'];
        $start = ($p-1) * $page_size;
		
        $data['list'] = $this->db->query("select * from go_collect where 1=1 $where $where_list limit $start, $page_size")->result_array();
		//print_r($data['list']);
		$this->load->view('admin/member_collect',$data);

	}

	/*用户收藏*/
	public function feedback(){
		//查找会员
		$where = $order = $where_list = $where_all = $where_p = '';
        $p = intval($this->input->get('per_page'));		//当前页数
        if(!$p){
        	$p=1;
        }
		$act =  htmlspecialchars(trim($this->input->get('act')));
		if($act=='form'){
			$p = 1;
		}
		$where_p .= "?p=".$p;
		$username=htmlspecialchars(trim($this->input->get('username') ));
		if($username){
			$data['username'] = $username;
			$where .= " and username like '%".$username."%'";
			$where_p.="&username=".$username;
		}

		/*
		$email=htmlspecialchars(trim($_POST['email']));
		if($email){
			$where .= " and m.email like '%".$email."%'";
		}
		*/
		$good_name = htmlspecialchars(trim($this->input->get('good_name')));
		if($good_name){
			$data['good_name'] = $good_name;
			$where .= " and contact like '%".$good_name."%'";
			$where_p.="&contact=".$good_name;
		}
		$posttime1 = $this->input->get('posttime1');
		$posttime2 = $this->input->get('posttime2');

		$data['posttime1'] = $posttime1;
		$data['posttime2'] = $posttime2;
		$where_p.="&posttime1=".$posttime1."&posttime2=".$posttime2;	
				
		if($posttime1 && $posttime2){
			if($posttime2 < $posttime1){$this->_message("结束时间不能小于开始时间");return false;}			
			$where .= " and feed_date >= '".$posttime1."' AND feed_date <= '".$posttime2."'";
		}
		if($posttime1 && empty($posttime2)){				
			$where .= " and feed_date >= '".$posttime1."'";
		}
		if($posttime2 && empty($posttime1)){				
			$where .= " and feed_date <= '".$posttime2."'";
		}
		if(empty($posttime1) && empty($posttime2)){				
			$where .= false;
		}

		if(empty($where_list)){
			$where_list .= "order by feed_date desc";
		}			
		$all= $this->db->query("select * from go_feedback where 1=1 $where $where_list");
		$data['p'] = $p;
		$total = $all->num_rows();
		$this->load->library('pagination');
		$where .= $order;
		$config['base_url'] = G_WEB_PATH.'/admin/membercount/feedback'.$where_p;
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
		$config['cur_tag_open'] = '<li><span class="red">';
		$config['cur_tag_close'] = '</span></li>';	
		$config['page_query_string'] = TRUE;					
		$this->pagination->initialize($config);

        $data['pagebar'] = $this->pagination->create_links();       
        $page_size = $config['per_page'];
        $start = ($p-1) * $page_size;
		
        $data['list'] = $this->db->query("select * from go_feedback where 1=1 $where $where_list limit $start, $page_size")->result_array();
		//print_r($data['list']);
		$this->load->view('admin/member_feedback',$data);

	}


}