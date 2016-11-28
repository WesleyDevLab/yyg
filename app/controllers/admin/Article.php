<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends AdminBase {
	public function index(){
		exit;
	}
	//文章列表
	public function lists(){
		$cateid=intval($this->uri->segment(4));
		$catlist = $this->getAll('go_goods_cat','type=1');
		$last_catlist = array();
		foreach($catlist as $row){
			$last_catlist[$row['cateid']] = $row;
		}
		$res['categorys']=$last_catlist;		
		$list_where = '';
		if(!$cateid){
			$list_where = "1";
		}else{
			$list_where = "`cateid` = '$cateid'";
		}
		if(isset($_POST['sososubmit'])){			
			$posttime1 = !empty($_POST['posttime1']) ? $_POST['posttime1'] : NULL;
			$posttime2 = !empty($_POST['posttime2']) ? $_POST['posttime2'] : NULL;			
			$sotype = $_POST['sotype'];
			$sosotext = $_POST['sosotext'];			
			if($posttime1 && $posttime2){
				if($posttime2 < $posttime1)_message("结束时间不能小于开始时间");
				$list_where = "`posttime` > '$posttime1' AND `posttime` < '$posttime2'";
			}
			if($posttime1 && empty($posttime2)){				
				$list_where = "`posttime` > '$posttime1'";
			}
			if($posttime2 && empty($posttime1)){				
				$list_where = "`posttime` < '$posttime2'";
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
			}else{
				if(!$list_where) $list_where='1';					
			}		
		}		

		$num=20;
		if($list_where){
			$list_where = "status=0 and $list_where";
		}
		$total=$this->db->query("SELECT * FROM `go_article` WHERE $list_where")->num_rows();
		$this->load->library('pagination');
		if($cateid!='page'){
			$config['base_url'] = G_WEB_PATH.'/admin/article/lists/'.$cateid.'/page';
		}else{
			$config['base_url'] = G_WEB_PATH.'/admin/article/lists/page';
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
        	
		$p = intval($this->uri->segment(5));		//当前页数
        if(!$p){
        	$p=1;
        }
        $page_size = $config['per_page'];
        $start = ($p-1) * $page_size;
		$res['shoplist']=$this->db->query("SELECT * FROM `go_article` WHERE  $list_where limit $start, $page_size")->result_array();
		$this->load->view('admin/article_list',$res);
	}	
	/*商品分类添加、编辑*/
	public function add(){
		$res['cat_list'] = $this->getCatList(1);	//获取分类
		$id=$this->uri->segment(4);
		$submit = $this->input->post('dosubmit');
		$is_edit = false;
		$msg = '添加';
		$data = array();
		if(intval($id)){			//是编辑模式
			$msg = '编辑';
			$is_edit = true;
			$res['row'] = $this->getRow("go_article","id='".$id."'");
		}
		$res['is_edit'] = $is_edit;		
		$res['msg'] = $msg;
		//print_r($this->input->post());exit;		
		if(isset($submit)){
			$cateid = intval($this->input->post('cateid'));
			$title = htmlspecialchars($this->input->post('title'));
			$thumb = htmlspecialchars($this->input->post('thumg'));
			$picarr = htmlspecialchars($this->input->post('picarr'));
			
			if(!$cateid){$this->_message("请选择分类");return false;}
			if(!$title){$this->_message("标题不能为空");return false;}
			//if(!$thumb && !$is_edit){$this->_message("缩略图不能为空");return false;}

			$temp = $this->input->post('posttime');		
			if($temp != ''){	
				$xsjx_time = strtotime($temp) ? strtotime($temp) : time();
			}else{
				$xsjx_time = date('Y-m-d H:i:s');
			}			 			
			$data = array(
			    'cateid' => intval($this->input->post('cateid')),
			    'title' => htmlspecialchars($this->input->post('title')),
			    'author' => htmlspecialchars($this->input->post('author')),
			    'keywords' => htmlspecialchars($this->input->post('keywords')),
			    'description' => htmlspecialchars($this->input->post('description')),
			    'content' => stripslashes($this->input->post('content')),
			    'posttime' => $xsjx_time,
			    'hit' => intval($this->input->post('hit')),
			    'sort' => intval($this->input->post('sort'))
			);
			if(!empty($thumb)){
				$data['thumb'] = $thumb;
			}
			if(!empty($picarr)){
				$data['picarr'] = $picarr;
			}				
			if($is_edit){			//编辑
				$data['id'] = $id;
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
				$flag = $this->db->replace('go_article', $data);
			}else{
				$data = (isset($data2)) ? array_merge($data,$data2) : $data;
				//判断是否名字已存在				
				$flag = $this->db->insert('go_article', $data);
			}
			if($flag){			
				$this->_message("文章".$msg."成功!",G_WEB_PATH.'/admin/article/lists');
			}else{
				$this->_message("文章".$msg."失败!");
			}
			return false;									
		}	
		$this->load->view('admin/article_add',$res);
	}
	

	
}
