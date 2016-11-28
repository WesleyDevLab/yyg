<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


 /*
 *	80 and 443
 *  roby
 */
 
 define("G_CHARSET", 'utf-8');
define("ROOTPATH", $_SERVER['DOCUMENT_ROOT']);
define('G_HTTP',isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://');
define('G_HTTP_HOST', (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''));
define("G_WEB_PATH",dirname(G_HTTP.G_HTTP_HOST.$_SERVER['SCRIPT_NAME']));
define("G_PLUGIN_PATH",G_WEB_PATH.'/statics/plugin');
define("G_UPLOAD_PATH",G_WEB_PATH.'/statics/uploads');
define('G_GLOBAL_STYLE',G_PLUGIN_PATH.'/style');
define('ASSET_BAK',G_WEB_PATH.'/statics/background');
define('ASSET_FONT',G_WEB_PATH.'/statics/foreground');

/*****************图片处理配置*********************************/
/*图片上传配置*/
define("ADMIN_UPLOAD_DIR", '/statics/uploads/sucai/');
define("ADMIN_WATER", '/statics/uploads/water/defalut.jpg');     //水印模板
define("ADMIN_UPLOAD_MAX_SIZE",1100000);        //2M

/*图片类型*/


/* 缩略图相关常量定义 */
define("IMAGE_THUMB_SCALE",1) ;         //常量，标识缩略图等比例缩放类型
define("IMAGE_THUMB_FILLED",2);         //常量，标识缩略图缩放后填充类型
define("IMAGE_THUMB_CENTER",3);         //常量，标识缩略图居中裁剪类型
define("IMAGE_THUMB_NORTHWEST",4);      //常量，标识缩略图左上角裁剪类型
define("IMAGE_THUMB_SOUTHEAST",5);      //常量，标识缩略图右下角裁剪类型
define("IMAGE_THUMB_FIXED",6);          //常量，标识缩略图固定尺寸缩放类型

/* 水印相关常量定义 */
define("IMAGE_WATER_NORTHWEST",1);      //常量，标识左上角水印
define("IMAGE_WATER_NORTH",2);          //常量，标识上居中水印
define("IMAGE_WATER_NORTHEAST",3);      //常量，标识右上角水印
define("IMAGE_WATER_WEST",4);           //常量，标识左居中水印
define("IMAGE_WATER_CENTER",5);         //常量，标识居中水印
define("IMAGE_WATER_EAST",6);           //常量，标识右居中水印
define("IMAGE_WATER_SOUTHWEST",7);      //常量，标识左下角水印
define("IMAGE_WATER_SOUTH",8);          //常量，标识下居中水印
define("IMAGE_WATER_SOUTHEAST",9);      //常量，标识右下角水印

//直播间
define("ROOM",'https://www.douyu.com/1191019');      //直播间地址
define('MAXQISHU',65535);
define('MAXXINYUAN',5000);

// 银联支付
define('MECHETID',802440355110502);
define('CZSONG',10);

//奖励机制 
define('SONG_PHONECODE_YB',0);	//手机认证完善资料奖励元宝
define('SONG_PHONECODE_JY',0);	//手机认证完善资料奖励经验
define('SONG_CZ',10);			//充值
define('SONG_ZC',5);			//注册
define('SONG_INVITE',1);		//邀请
define('SONG_SHARE',1);			//分享朋友圈
