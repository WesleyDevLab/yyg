<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slide extends AdminBase {
	public function index(){
		exit;
	}
	/*手机幻灯片*/
	public function lists(){
		$type=intval($this->uri->segment(4));		//幻灯片分类
		$res['type'] = $type;		
		$res['lists']=$this->getAll('go_slide',"type='".$type."'",'id,img,title,link,color,type');
		$this->load->view('admin/slide',$res);
	}
	public function add(){
		$type=$this->uri->segment(4);
		$id=$this->uri->segment(5);
		$is_edit = false;
		$msg = '添加';
		$data = array();
		if(intval($id)){			//是编辑模式
			$msg = '编辑';
			$is_edit = true;
			$res['row'] = $this->getRow("go_slide","id='".$id."'");
		}
		$res['is_edit'] = $is_edit;		
		$res['msg'] = $msg;
		$submit = $this->input->post('submit');
		if(isset($submit)){
			$pic = htmlspecialchars($this->input->post('img'));
			if(!$pic && !$is_edit){$this->_message("幻灯片图片不能为空");return false;}
			$data = array(
				'title' => htmlspecialchars($this->input->post('title')),
				'link' => htmlspecialchars($this->input->post('link')),
				'color' => htmlspecialchars($this->input->post('color')),
				'type' => $type
			);
			if(!empty($pic)){
				$data['img'] = $pic;
			}			
			if($is_edit){			//编辑,要删除原来的图片
				$data['id'] = $id;
				if($res['row']['img']){			//原来就有图片
					if(!empty($pic)){			
						unlink(ROOTPATH.$res['row']['img']);					
					}else{
						$data['img'] = $res['row']['img'];
					}					
				}				
				$flag = $this->db->replace('go_slide', $data);
			}else{
				//判断是否名字已存在				
				$flag = $this->db->insert('go_slide', $data);
			}
			if($flag){			
				$this->_message("幻灯片".$msg."成功!",G_WEB_PATH.'/admin/slide/lists/'.$type);
			}else{
				$this->_message("幻灯片".$msg."失败!");
			}							
		}else{
			$this->load->view('admin/slide_add',$res);	
		}
	}
	public function delete(){
		$id=intval($this->uri->segment(4));
		if($id){
			$old_row = $this->getRow("go_slide","id='".$id."'");
			unlink(ROOTPATH.$old_row['img']);		 
			$flag = $this->db->delete('go_slide', array('id' => $id)); 
			if($flag){			
				$this->_message("删除成功",G_WEB_PATH.'/admin/slide/wap');
			}else{
				$this->_message("删除失败");
			}			
		}
	}
	/****************微信菜单设置********************/

	public function menu(){
	if (isset($_POST['tijiao'])) {
	    // 因为菜单最多有3个，所以进行循环
	    for($i=0;$i<3;$i++){
	          // 指定下标
	        $button=  "button_".$i;
	        $sub_button="sub_button_".$i."_0";
	        $type="type_".$i;
	        $urlkey="urlkey_".$i;  
            // 如果有子菜单
            if(trim($_POST[$sub_button])!==""){
                for($j=0;$j<5;$j++){
                  $sub_button="sub_button_{$i}_{$j}";
                  $type="type_{$i}_{$j}";
                  $urlkey="urlkey_{$i}_{$j}";  
                    if(trim($_POST[$sub_button])!==""){
                        $menuarr['button'][$i]['name']=$_POST[$button];
                          if($_POST[$type]=="key"){
                               $menuarr['button'][$i]['sub_button'][$j]['type']="click";
                               $menuarr['button'][$i]['sub_button'][$j]['name']=$_POST[$sub_button];
                               $menuarr['button'][$i]['sub_button'][$j]['key']=$_POST[$urlkey];
                           }else if($_POST[$type]=="url"){
                                $menuarr['button'][$i]['sub_button'][$j]['type']="view";
                                $menuarr['button'][$i]['sub_button'][$j]['name']=$_POST[$sub_button];
                                $menuarr['button'][$i]['sub_button'][$j]['url']=$_POST[$urlkey];
                           }
                    }
            	}
            }else{            
                if(trim($_POST[$button])!==""){
                    if($_POST[$type]=="key"){
                       $menuarr['button'][$i]['type']="click";
                       $menuarr['button'][$i]['name']=$_POST[$button];
                       $menuarr['button'][$i]['key']=$_POST[$urlkey];
                     }else if($_POST[$type]=="url"){
                        $menuarr['button'][$i]['type']="view";
                        $menuarr['button'][$i]['name']=$_POST[$button];
                        $menuarr['button'][$i]['url']=$_POST[$urlkey];
                     }
                }
            }

	    }
        // 对数组进行转json格式
        $post=my_json_encode($menuarr);

        /*
        $wechat= $this->db->query("select * from `go_wechat_config` where id = 1")->row_array();
        // 获取token
        $token= get_tokens($wechat['appid'],$wechat['appsecret']);
        //提交内容
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$token}"; //查询地址
        $result = $this->https_request($url, $post);
        */

		require_once(ROOTPATH.'/app/libraries/Wechatclass.php');
		$this->wechat = new Wechatclass();
		$result = $this->wechat->createMenu($post);
		$result = json_decode($result,true);
		$token = $this->wechat->getAccessToken();
        if($result['errmsg'] == 'ok'){
            // 保存数据库
            $this->db->Query("UPDATE `go_wechat_config` SET `menu`='$post' WHERE (`id`= 1)");
            $this->db->Query("UPDATE `go_wechat_config` SET `access_token`='$token' WHERE (`id`= 1)");
            $this->_message("菜单设置成功");
            return false;
        }else{
            $this->_message("菜单设置失败");
            return false;
        }
    }
    $wechat= $this->db->query("select * from `go_wechat_config` where id = 1")->row_array();
    $we = json_decode($wechat['menu'],true);
    $we = $we['button'];
    $data['we'] = $we;
    $this->load->view('admin/menu',$data);	
    }
	
		
}