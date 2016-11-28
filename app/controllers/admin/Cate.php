<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cate extends AdminBase {
	public function index(){
	}
	/*商品分类列表*/
	public function lists(){
		$type=intval($this->uri->segment(4));		//分类类别：文章还是商品
		$data['type'] = $type;
		$catlist = $this->getCatList($type);
		$total = count($catlist);
		$this->load->library('pagination');
		
		$config['base_url'] = G_WEB_PATH.'/admin/cate/lists/'.$type.'/page';
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
        	$p=1;
        }
        $page_size = $config['per_page'];
        $start = ($p-1) * $page_size;
        $data['list'] = array();
        $temp = array_values($catlist);		//重新构建数字索引,全球数组分页
        for($i=$start;$i<$start+$page_size;$i++){
        	if(isset($temp[$i])){
        		$data['list'][$i] = $temp[$i];
        	}       	
        }
        $all_list = $this->db->query("select cateid,parentid,name,sort,pic,url from go_goods_cat where status=0 and type=$type order by sort desc")->result_array();
		$last_catlist = array();
		if($all_list){
			foreach($all_list as $row){
				$last_catlist[$row['cateid']] = $row;
			}
			$data['all_list'] = $last_catlist;			
		}

		$this->load->view('admin/goods_cat_list',$data);
	}
	/*商品分类添加、编辑*/
	public function addcate(){
		$type=intval($this->uri->segment(4));		//分类类别：文章还是商品
		$res['type'] = $type;
		$info = array();
		$postInfo = $this->input->post('info');
		$cateid=$this->uri->segment(5);
		$is_edit = false;
		$msg = '添加';
		$res['list'] = $this->getCatList($type);		//商品分类
		if(intval($cateid)){
			$msg = '编辑';
			$is_edit = true;
			$cateinfo=$this->getRow('go_goods_cat', "cateid='".$cateid."'");		//获取分类信息
			if(!$cateinfo)$this->_message("没有这个分类");
			$res['info']=unserialize($cateinfo['info']);			
			$res['row'] = $cateinfo;
		}
		if(isset($postInfo)){			//提交			
			$setting=array (				
				'meta_title' => htmlspecialchars($postInfo['meta_title']),
				'meta_keywords' =>htmlspecialchars($postInfo['meta_keywords']),
				'meta_description' => htmlspecialchars($postInfo['meta_description']),
			);		
			$setting=serialize($setting);
			$pic = htmlspecialchars($postInfo['pic']);
			$data = array(
			    'parentid' => intval($postInfo['parentid']),
			    'sort' => intval($postInfo['sort']),
			    'name' => htmlspecialchars($postInfo['name']),
			    'catdir' => htmlspecialchars($postInfo['catdir']),
			    'url' => htmlspecialchars($postInfo['url']),
			    'info' => $setting,
			    'type' => $type,
			    'description' => htmlspecialchars($postInfo['description']),
			);
			if(!empty($pic)){
				$data['pic'] = $pic;
			}
			if($is_edit){			//编辑
				$data['cateid'] = $cateid;
				if($cateinfo['pic']){			//原来就有图片
					if(!empty($pic)){			
						unlink(ROOTPATH.$cateinfo['pic']);					
					}else{
						$data['pic'] = $cateinfo['pic'];	//防止无值，将原来的值贴上
					}					
				}

				$flag = $this->db->replace('go_goods_cat', $data);
			}else{
				//判断是否名字已存在				
				$data['createtime'] = date('Y-m-d H:i:s'); 
				$flag = $this->db->insert('go_goods_cat', $data);
			}			
			
			if($flag){			
				$this->_message("分类".$msg."成功!",G_WEB_PATH.'/admin/cate/lists/'.$type);
			}else{
				$this->_message("分类".$msg."失败!");
			}
		}else{
			$this->load->view('admin/goods_cat_add',$res);
		}
			
	}	

	
}
