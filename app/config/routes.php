<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//路由1级分类里面的商品

$route['food/(:num)'] = "index/info/$1";
$route['food/drink/(:num)'] = "index/info/$1";
$route['food/mingsheng/(:num)'] = "index/info/$1";
$route['food/drinking/(:num)'] = "index/info/$1";
$route['food/snack/(:num)'] = "index/info/$1";

//虚拟卡币
$route['xnkb/(:num)'] = "index/info/$1";
$route['xnkb/qqb/(:num)'] = "index/info/$1";
$route['xnkb/hfcz/(:num)'] = "index/info/$1";
$route['xnkb/btb/(:num)'] = "index/info/$1";
$route['xnkb/yxdk/(:num)'] = "index/info/$1";

//玩具宠物
$route['wjcw/(:num)'] = "index/info/$1";
$route['wjcw/qwwj/(:num)'] = "index/info/$1";
$route['wjcw/yx/(:num)'] = "index/info/$1";
$route['wjcw/cwbb/(:num)'] = "index/info/$1";
$route['wjcw/xhzw/(:num)'] = "index/info/$1";

//服装饰品
$route['clothing/(:num)'] = "index/info/$1";
$route['clothing/sqnz/(:num)'] = "index/info/$1";
$route['clothing/ssnz/(:num)'] = "index/info/$1";
$route['clothing/cczb/(:num)'] = "index/info/$1";
$route['clothing/jpxb/(:num)'] = "index/info/$1";

//家居用品
$route['jjyp/(:num)'] = "index/info/$1";
$route['jjyp/ryp/(:num)'] = "index/info/$1";
$route['jjyp/byrs/(:num)'] = "index/info/$1";
$route['jjyp/jzzc/(:num)'] = "index/info/$1";
$route['jjyp/wjgj/(:num)'] = "index/info/$1";


$route['xnkb/(:num)'] = "index/info/$1";
//数码家电
$route['smjd/(:num)'] = "index/info/$1";
$route['smjd/shouji/(:num)'] = "index/info/$1";
$route['smjd/dnpj/(:num)'] = "index/info/$1";
$route['smjd/cfjd/(:num)'] = "index/info/$1";
$route['smjd/shjd/(:num)'] = "index/info/$1";


$route['hhqc/(:num)'] = "index/info/$1";
$route['hhqc/wxc/(:num)'] = "index/info/$1";
$route['hhqc/dxc/(:num)'] = "index/info/$1";
$route['hhqc/zdxc/(:num)'] = "index/info/$1";
$route['hhqc/zxc/(:num)'] = "index/info/$1";


//文艺体育
$route['wyty/(:num)'] = "index/info/$1";
$route['wyty/jkzl/(:num)'] = "index/info/$1";
$route['wyty/djly/(:num)'] = "index/info/$1";
$route['wyty/huwai/(:num)'] = "index/info/$1";
$route['wyty/tzsc/(:num)'] = "index/info/$1";


