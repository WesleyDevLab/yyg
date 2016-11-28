<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Link extends AdminBase {
	public function index(){
	}
	/*商品分类列表*/
	public function lists(){
		$data['cat_list'] = $this->getCatList(2);
		$cateid=$this->uri->segment(4);				//分类类别：文章还是商品
		if(!intval($cateid)){
			$temp = array_values($data['cat_list']);			//重新构建数字索引,全球数组分页
			$data['cateid'] = $temp[0]['cateid'];
		}else{
			$data['cateid'] = $cateid;
		}
		$arr = $this->getChildCat($data['cateid']);
		$arr = array_unique($arr);
		$in_sql = "in (".implode(",",$arr).")";
			
		$data['list'] = $this->getAll('go_link', "cateid $in_sql", 'id, name, logo, url');
		$this->load->view('admin/link_list',$data);
	}
	/*商品分类添加、编辑*/
	public function addlink(){
		$info = array();
		$postInfo = $this->input->post('info');
		$cateid=$this->uri->segment(4);
		$is_edit = false;
		$msg = '添加';
		$res['list'] = $this->getCatList(2);		//所有分类
		if(intval($cateid)){
			$msg = '编辑';
			$is_edit = true;
			$cateinfo=$this->getRow('go_link', "id='".$cateid."'");		//获取分类信息
			if(!$cateinfo){$this->_message("没有这个链接");return false;}
			$res['row'] = $cateinfo;
		}
		if(isset($postInfo)){			//提交			
			$pic = htmlspecialchars($postInfo['pic']);
			$data = array(
			    'cateid' => intval($postInfo['cateid']),
			    'name' => htmlspecialchars($postInfo['name']),
			    'logo' => htmlspecialchars($postInfo['pic']),
			    'url' => htmlspecialchars($postInfo['url'])
			);
			if(!empty($pic)){
				$data['logo'] = $pic;
			}
			if($is_edit){			//编辑
				$data['id'] = $cateid;
				if($cateinfo['logo']){			//原来就有图片
					if(!empty($pic)){			
						unlink(ROOTPATH.$cateinfo['logo']);					
					}else{
						$data['logo'] = $cateinfo['logo'];	//防止无值，将原来的值贴上
					}					
				}
				$flag = $this->db->replace('go_link', $data);
			}else{
				//判断是否名字已存在				
				$flag = $this->db->insert('go_link', $data);
			}
			if($flag){			
				$this->_message("友情链接".$msg."成功!",G_WEB_PATH.'/admin/link/lists');
			}else{
				$this->_message("友情链接".$msg."失败!");
			}
		}else{
			$this->load->view('admin/link_add',$res);
		}
			
	}	

	
}
