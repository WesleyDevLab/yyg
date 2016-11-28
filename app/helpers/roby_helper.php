<?php
/*
 * Created on 2016年9月19日
 * author:roby
 * email:zdwroby@gmail.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('test'))
{
	function test()
	{
		return "test";
	}
}

if ( ! function_exists('cat_list'))
{
	function cat_list(){
		//$res = get_instance()->db->query("select * from go_member where 1=1");
		$cache= get_instance()->cache;
		$cache->memcached->save('foo', 'bar', 10);
		$res = $cache->memcached->get('foo');		
		return $res;		
	}
}
if ( ! function_exists('short_time'))
{
	/**
	*	短时间显示, 几分钟前,几秒前...
	**/


	function short_time($time = 0,$test=''){
		if(empty($time)){return $test;}
		$time = substr($time,0,10);
		$ttime = time() - $time;
		if($ttime <= 0 || $ttime < 60){
			return '几秒前';
		}
		if($ttime > 60 && $ttime <120){
			return '1分钟前';
		}

		$i = floor($ttime / 60);							//分
		$h = floor($ttime / 60 / 60);						//时
		$d = floor($ttime / 86400);							//天
		$m = floor($ttime / 2592000);						//月
		$y = floor($ttime / 60 / 60 / 24 / 365);			//年
		if($i < 30){
			return $i.'分钟前';
		}
		if($i > 30 && $i < 60){
			return '一小时内';
		}
		if($h>=1 && $h < 24){
			return $h.'小时前';
		}
		if($d>=1 && $d < 30){
			return $d.'天前';
		}
		if($m>=1 && $m < 12){
			return $m.'个月前';
		}
		if($y){
			return $y.'年前';
		}
		return "";

	}
}

?>
