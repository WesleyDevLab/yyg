<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends AdminBase {
	public function index(){

	}
	/*品牌列表*/
	public function lists(){
		$all = $this->db->query("select cateid,name,sort,pic,url from go_goods_brand where status=0");
		$total = $all->num_rows();
		$this->load->library('pagination');
		
		$config['base_url'] = G_WEB_PATH.'/admin/brand/lists/page';
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
        $p = intval($this->uri->segment(5));		//当前页数
        if(!$p){
        	$p=1;
        }        
        $page_size = $config['per_page'];
        $start = ($p-1) * $page_size;
        $categorys = $this->db->query("select b.id,b.cateid,b.name,b.sort,b.pic,b.url,c.name as catname from go_goods_brand as b left join go_goods_cat as c on (b.cateid=c.cateid and b.status=c.status) where b.status=0 order by b.sort desc limit $start, $page_size")->result_array();
		$data['list'] = $categorys;
		$this->load->view('admin/goods_brand_list',$data);
	}
	/*商品分类添加、编辑*/
	public function addbrand(){
		$info = array();
		$postInfo = $this->input->post('info');
		$id=$this->uri->segment(4);
		$is_edit = false;
		$data = array();
		$msg = '添加';
		$data['list'] = $this->getCatList();		//商品分类
		if(intval($id)){
			$msg = '编辑';
			$is_edit = true;
			$cateinfo=$this->getRow('go_goods_brand', "id='".$id."'");		//获取品牌信息
			if(!$cateinfo)$this->_message("没有这个品牌或者已经删除");			
			$data['row'] = $cateinfo;
		}
		if(isset($postInfo)){			//提交			
			$data = array(
				'cateid' => intval($postInfo['cateid']),
			    'sort' => intval($postInfo['sort']),
			    'name' => htmlspecialchars($postInfo['name']),
			    'url' => htmlspecialchars($postInfo['url'])
			);
			$pic = htmlspecialchars($postInfo['pic']);
			if(!empty($pic)){
				$data['pic'] = $pic;
			}			
			if($is_edit){			//编辑
				$data['id'] = $id;
				if($cateinfo['pic']){			//原来就有图片
					if(!empty($pic)){			
						unlink(ROOTPATH.$cateinfo['pic']);					
					}else{
						$data['pic'] = $cateinfo['pic'];
					}					
				}				
				$flag = $this->db->replace('go_goods_brand', $data);
			}else{
				//判断是否名字已存在				
				$data['createtime'] = date('Y-m-d H:i:s'); 
				$flag = $this->db->insert('go_goods_brand', $data);
			}			
			
			if($flag){			
				$this->_message("品牌".$msg."成功!",G_WEB_PATH.'/admin/brand/lists');
			}else{
				$this->_message("品牌".$msg."失败!");
			}
		}else{
			$this->load->view('admin/goods_brand_add',$data);
		}
			
	}	

	
}
