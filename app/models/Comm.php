<?php
//与数据库有关的  工具类  模型操作
class Comm extends CI_Model {
    public function __construct(){
        // Call the CI_Model constructor
        parent::__construct();
    }
	//生成日志数据库
	public function debug( $info,$level='info'){
	    if(empty($info)){
	        return;
	    }
		$info = str_replace('"', '', $info);
		$info = str_replace("'", '', $info);
		$sql = 'insert into go_wx_debug (level, info, mtime) values( "'.$level.'", \''.$info.'\', "'.date('Y-m-d h:i:s').'")';
		$this->db->query($sql);
	}
	  



}