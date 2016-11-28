<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  
  <head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <link rel="Shortcut Icon" href="favicon.ico">
    <link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
    <link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/index.css" type="text/css">
    <script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo G_PLUGIN_PATH; ?>/layer/layer.min.js"></script>
    <script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/global.js"></script>
    <title>云购后台管理系统功能加强版</title>
    <script type="text/javascript">var ready = 1;
      var kj_width;
      var kj_height;
      var header_height = 100;
      var R_label;
      var R_label_one = "当前位置: 系统设置 >";

      function left(init) {
        var left = document.getElementById("left");
        var leftlist = left.getElementsByTagName("ul");

        for (var k = 0; k < leftlist.length; k++) {
          leftlist[k].style.display = "none";
        }
        document.getElementById(init).style.display = "block";
      }

      function secBoard(elementID, n, init, r_lable) {

        var elem = document.getElementById(elementID);
        var elemlist = elem.getElementsByTagName("li");
        for (var i = 0; i < elemlist.length; i++) {
          elemlist[i].className = "normal";
        }
        elemlist[n].className = "current";
        R_label_one = "当前位置: " + r_lable + " >";
        R_label.text(R_label_one);
        left(init);
      }

      function set_div() {
        kj_width = $(window).width();
        kj_height = $(window).height();
        if (kj_width < 1000) {
          kj_width = 1000;
        }
        if (kj_height < 500) {
          kj_height = 500;
        }

        $("#header").css('width', kj_width);
        $("#header").css('height', header_height);
        $("#left").css('height', kj_height - header_height);
        $("#right").css('height', kj_height - header_height);
        $("#left").css('top', header_height);
        $("#right").css('top', header_height);

        $("#left").css('width', 180);
        $("#right").css('width', kj_width - 182);
        $("#right").css('left', 182);

        $("#right_iframe").css('width', kj_width - 206);
        $("#right_iframe").css('height', kj_height - 148);

        $("#iframe_src").css('width', kj_width - 208);
        $("#iframe_src").css('height', kj_height - 150);

        $("#off_on").css('height', kj_height - 180);

        var nav = $("#nav");
        nav.css("left", (kj_width - nav.get(0).offsetWidth) / 2);
        nav.css("top", 61);
      }

      $(document).ready(function() {
        set_div();
        $("#off_on").click(function() {
          if ($(this).attr('val') == 'open') {
            $(this).attr('val', 'exit');
            $("#right").css('width', kj_width);
            $("#right").css('left', 1);
            $("#right_iframe").css('width', kj_width - 25);
            $("iframe").css('width', kj_width - 27);
          } else {
            $(this).attr('val', 'open');
            $("#right").css('width', kj_width - 182);
            $("#right").css('left', 182);
            $("#right_iframe").css('width', kj_width - 206);
            $("iframe").css('width', kj_width - 208);
          }
        });

        left('setting');
        $(".left_date a").click(function() {
          $(".left_date li").removeClass("set");
          $(this).parent().addClass("set");
          R_label.text(R_label_one + ' ' + $(this).text() + ' >');
          $("#iframe_src").attr("src", $(this).attr("src"));
        });
        $("#iframe_src").attr("src", "/admin/goods/admin_index");
        R_label = $("#R_label");
        $('body').bind('contextmenu',
        function() {
          return false;
        });
        $('body').bind("selectstart",
        function() {
          return false;
        });

      });

      function api_off_on_open(key) {
        if (key == 'open') {
          $("#off_on").attr('val', 'exit');
          $("#right").css('width', kj_width);
          $("#right").css('left', 1);
          $("#right_iframe").css('width', kj_width - 25);
          $("iframe").css('width', kj_width - 27);
        } else {
          $("#off_on").attr('val', 'open');
          $("#right").css('width', kj_width - 182);
          $("#right").css('left', 182);
          $("#right_iframe").css('width', kj_width - 206);
          $("iframe").css('width', kj_width - 208);
        }
      }</script>
    <style>.header_case{ position:absolute; right:10px; top:10px; color:#fff} .header_case a{ padding-left:5px} .header_case a:hover{ color:#fff; } .left_date a{color:#444;} .left_date{overflow:hidden;} .left_date ul{ margin:0px; padding:0px;} .left_date li{line-height:25px; height:25px; margin:0px 10px; margin-left:15px; overflow:hidden;} .left_date li a{ display:block;text-indent:5px; overflow:hidden} .left_date li a:hover{ background-color:#d3e8f2;text-decoration:none;border-radius:3px;} .left_date .set a{background-color:#d3e8f2;border-radius:3px; font-weight:bold} .head{ border-bottom:1px solid #c5e8f1; color:#2a8bbb; font-weight:bold; margin-bottom:10px;}</style></head>
  
  <body onResize="set_div();">
    <div id="header">
      <div class="logo"></div>
      <div class="header_case">欢迎您：
        <a href="javascript:;" title="">[超级管理员]</a>
        <a href="/user/out" title="退出">[退出]</a>
        <a href="" title="网站首页" target="_blank">网站首页</a>
        <button style="width:0px;height:0px;" onClick="document.location.hash='hello'"></button>
      </div>
      <div class="nav" id="nav">
        <ul>
          <li class="current">
            <a href="#" onClick="secBoard('nav',0,'setting','系统设置');">系统设置</a></li>
          <li class="normal">
            <a href="#" onClick="secBoard('nav',1,'content','内容管理');">内容管理</a></li>
          <li class="normal">
            <a href="#" onClick="secBoard('nav',2,'shop','商品管理');">商品管理</a></li>
          <li class="normal">
            <a href="#" onClick="secBoard('nav',3,'user','用户管理');">用户管理</a></li>
          <li class="normal">
            <a href="#" onClick="secBoard('nav',4,'template','界面管理');">界面管理</a></li>
        </ul>
      </div>
    </div>
    <!--header end-->
    <div id="left">
      <ul class="left_date" id="setting">
      </ul>
      <ul class="left_date" id="content">
        <li class="head">文章管理</li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/article/add">添加文章</a></li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/article/lists">文章列表</a></li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/cate/lists/1">文章分类</a></li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/link/lists">友情链接</a></li>
      </ul>
      <ul class="left_date" id="shop">
        <li class="head">商品管理</li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/goods/goods_add">添加新商品</a></li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/goods/goods_list">商品列表</a></li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/cate/lists">商品分类</a></li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/brand/lists">品牌管理</a></li>

        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/lottery/daikj">待开奖</a></li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/lottery/opened">已开奖</a></li>
      </ul>
      <ul class="left_date" id="user">   
        <li class="head">用户管理</li>
        <li><span></span><a href="javascript:void(0);" src="<?php echo G_WEB_PATH; ?>/admin/member/lists">会员列表</a></li>     

        <li><span></span><a href="javascript:void(0);" src="<?php echo G_WEB_PATH; ?>/admin/member/addmem">添加会员</a></li>           

        <li><span></span><a href="javascript:void(0);" src="<?php echo G_WEB_PATH; ?>/admin/member/recharge/cz">充值记录</a></li>

        <li><span></span><a href="javascript:void(0);" src="<?php echo G_WEB_PATH; ?>/admin/member/recharge/xf">消费记录</a></li>
        
        <li><span></span><a href="javascript:void(0);" src="<?php echo G_WEB_PATH; ?>/admin/membercount/collect">用户收藏</a></li>
        
        <li><span></span><a href="javascript:void(0);" src="<?php echo G_WEB_PATH; ?>/admin/membercount/feedback">问题反馈</a></li>
        
        
      </ul>
      <ul class="left_date" id="template">
        <li class="head">界面管理</li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/slide/lists">PC首页Banner管理</a>
        </li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/slide/lists/1">Mobile首页Banner管理</a>
        </li>
        <li>
          <span></span>
          <a href="javascript:void(0);" src="/admin/slide/menu">微信菜单管理</a>
        </li>

      </ul>
    </div>
    <!--left end-->
    <div id="right">
      <div class="right_top">
        <ul class="R_label" id="R_label">当前位置: 系统设置 > 后台主页 ></ul>
        <ul class="R_btn">
          <a href="javascript:;" onClick="btn_iframef5();" class="system_button">
            <span>刷新框架</span></a>
          <a href="javascript:;" onClick="btn_checkbom('/api/plugin/get/bom');" class="system_button">
            <span>检查BOM</span></a>
          <a href="javascript:;" onClick="btn_map('/index/map');" class="system_button">
            <span>后台地图</span></a>
        </ul>
      </div>
      <div class="right_left">
        <a href="#" val="open" title="全屏" id="off_on">全屏</a></div>
      <div id="right_iframe">
        <iframe id="iframe_src" name="iframe" class="iframe" frameborder="no" border="1" marginwidth="0" marginheight="0" src="" scrolling="auto" allowtransparency="yes" style="width:100%; height:100%"></iframe>
      </div>
    </div>
    <!--right end-->
    <div style="display: none">
      <a href="http://www.1ytb.cc/">源码分享</a></div>
  </body>

</html>