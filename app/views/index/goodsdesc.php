<!DOCTYPE html>
<html>
<head><meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $key;?></title>
<meta content="app-id=518966501" name="apple-itunes-app" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link href="<?php echo ASSET_FONT;?>/css/mobile/comm.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ASSET_FONT;?>/css/mobile/goods.css" rel="stylesheet" type="text/css" />
<script src="<?php echo ASSET_FONT;?>/jquery190.js" language="javascript" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo ASSET_FONT;?>/css/mobile/top.css">
</head>
<body>
<div class="h5-1yyg-v1" id="loadingPicBlock">
    
<!-- 栏目页面顶部 -->


<!-- 内页顶部 -->
<header class="header">
<div class="n-header-wrap">
<div class="backbtn">
<a href="javascript:;" onclick="history.go(-1)" class="h-count white">
</a>
</div>
<div class="h-top-right ">
<a href="{WEB_PATH}/mobile/home" class="h-search white"></a>
</div>
<div class="n-h-tit"><h1 class="header-logo"><?php echo $key;?></h1></div>
</div>
</header>

    <input name="hidCodeID" type="hidden" id="hidCodeID" value="18101" />
    <input name="hidIsEnd" type="hidden" id="hidIsEnd" value="1" />

    <!-- 1元淘记录 -->
    <section id="buyRecordPage" class="goodsCon">
        <div id="divRecordList" class="recordCon z-minheight" style="display:block;margin-top:0">
            <?php echo $desc['content'];?>
        </div>
        
    </section>


</div>


