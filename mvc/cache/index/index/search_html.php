<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$config['blogName'];?></title>
<meta name="keywords" content="clean blog template, html css layout" />
<meta name="description" content="Clean Blog Template is provided by templatemo.com" />
<link href="/public/css/index/index/templatemo_style.css" rel="stylesheet" type="text/css" />
<link href="/public/css/index/index/s3slider.css" rel="stylesheet" type="text/css" />
<!-- JavaScripts-->
<script type="text/javascript" src="/public/css/index/index/js/jquery.js"></script>
<script type="text/javascript" src="/public/css/index/index/js/s3Slider.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#slider').s3Slider({
            timeOut: 1600
        });
    });
</script>
<script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
<script>tpwidget("init", {
    "flavor": "bubble",
    "location": "WX4FBXXFKE4F",
    "geolocation": "disabled",
    "position": "top-right",
    "margin": "30px 10px",
    "language": "zh-chs",
    "unit": "c",
    "theme": "chameleon",
    "uid": "U8AA46A7F7",
    "hash": "0054e3eea254e5a4c1984ece7f2cb95c"
});
tpwidget("show");</script>

</head>
<body>
<div id="templatemo_wrapper">
	<div id="templatemo_menu">      
        <ul>
            <li><a href="index.php" class="current">首页</a></li>
            <?php if(empty($_SESSION['username'])):?>
                <li><a href="/index.php?m=index&c=User&a=login">登录</a></li>
                <li><a href="/index.php?m=index&c=User&a=register">注册</a></li>
            <?php else: ?>
                <li><a href="/index.php?m=index&c=User&a=goOut">退出</a></li>
                <?php if($_SESSION['flage']==1):?>
                    <li><a href="/index.php?m=admin&c=index&a=index">后台管理</a></li>
                <?php endif;?>
            <?php endif;?>

        </ul>	
    </div> <!-- end of templatemo_menu -->
    <div id="templatemo_left_column">
        <div id="templatemo_header">
            <div id="site_title">
                <h1><a href="/index.php" target="_parent"><?=$config['blogName'];?><span><?=$config['blogSignature'];?></span></a></h1>
            </div><!-- end of site_title -->
        </div> <!-- end of header -->  
    </div> <!-- end of templatemo_left_column -->
    <div id="templatemo_right_column">
        <div style="height: 30px"></div>
        <h4>搜索</h4>
        <form method="post" action="/index.php?m=index&c=index&a=search">
            <input type="text" name="keywords" value="" required="true" style="display: block;width:400px;height: 40px ;float: left">
            <button type="submit" style="display: block;width:54px;height: 44px;background-color: #b7d0fd;border-style: groove;border-radius:61px 65px;float: left;margin-left: 20px"><span style="font-size: 16px;font-weight: bold;">搜索</span></button>
        </form>
        <div id="templatemo_main">
            <?php if(empty($data)):?>
                <div style="border: 3px solid black;border-style: groove;border-radius:61px 65px;text-align: center;height: 100px;line-height: 100px;font-size: 16px;font-weight: bold;">
                   未找到所匹配的文章哦！重新输入或者去&nbsp;&nbsp;<a href="http://www.baidu.com">百度一下</a>&nbsp;&nbsp;哦！
                </div>
            <?php else: ?>
                <div style="font-size: 16px;font-weight: bold;">共<span style="color: red"><?=$total;?></span>条记录</div>
                <?php foreach($data as $value):?>
                    <div class="post_section">
                        <span class="comment"><?=$value['replycounts'];?></span>
                        <h2><a href="/index.php?m=index&c=details&a=detailsInfo&id=<?=$value['id'];?>&hit=1"><?=$value['title'];?></a></h2>
                        <?php echo date('Y-m-d H:i:s',$value['publishtime']);?> |  <strong>浏览量:</strong> <?=$value['hits'];?>
                        <img src="<?=$value['picture'];?>" alt="<?=$value['title'];?>" />
                        <div style="overflow:hidden;text-overflow:ellipsis;white-space: nowrap;height:60px;width:430px"><?=$value['contents'];?></div>
                      <a href="/index.php?m=index&c=details&a=detailsInfo&id=<?=$value['id'];?>&hit=1">阅读全文...</a>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
		</div>
    <div class="cleaner"></div>
        <?php if(!empty($data)):?>
            <div>
                <span><a href="<?php echo $allPages['first'] . '&keywords=' . $keywords;?>">首页</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><a href="<?php echo $allPages['pre'] . '&keywords=' . $keywords;?>">上一页</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><a href="<?php echo $allPages['next'] . '&keywords=' . $keywords;?>">下一页</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><a href="<?php echo $allPages['last'] . '&keywords=' . $keywords;?>">尾页</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        <?php endif;?>
    </div>
    <div class="cleaner"></div> 
    <!-- end of templatemo_main -->
    <div class="cleaner_h20"></div>
  	<div id="templatemo_footer">
        Copyright © <?php echo date('Y');?> <a href="<?=$config['blogWeb'];?>"><?=$config['blogName'];?></a> | QQ : <?=$config['qq'];?> | Email : <?=$config['email'];?>
    </div>
    <div class="cleaner"></div>
</div> <!-- end of warpper -->
</body>
</html>