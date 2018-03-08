<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$config['blogName'];?></title>
<meta name="keywords" content="clean blog post, 2-column, multi-level, comments, html css layout" />
<meta name="description" content="Clean Blog Post with multi-level commenting" />
<link href="/public/css/index/index/templatemo_style.css" rel="stylesheet" type="text/css" />
<script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
<script type='text/javascript' src='/public/ckeditor/ckeditor.js'></script>
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
        
        <div id="templatemo_sidebar">
    	
            <div id="templatemo_rss">
                <a name="ww">联系方式 ：<br>
                QQ:<?=$config['qq'];?><br/>
                邮箱:<?=$config['email'];?></a>
            </div> 
            <h4>板块</h4>
            <ul class="templatemo_list">
                <?php if(!empty($allCategory)):?>
                    <?php foreach($allCategory as $value):?>
                <li><a href="/index.php?cid=<?=$value['cid'];?>" target="_parent"><?=$value['name'];?></a></li>
                    <?php endforeach;?>
                <?php else: ?>
                    <p>还没有板块哦！</p>
                    <p>快联系博主添加吧！！</p>
                <?php endif;?>
            </ul>
            <h4>搜索</h4>
            <form method="post" action="/index.php?m=index&c=index&a=search">
                <input type="text" name="keywords" value="" required="true" >
                <input type="submit" value="搜索" style="margin-left: 10px">
            </form>
            <div class="cleaner_h40"></div>
            
        </div> <!-- end of templatemo_sidebar --> 
    
    </div> <!-- end of templatemo_left_column -->
    
    <div id="templatemo_right_column">
        
        <div id="templatemo_main">
           
            <div class="post_section">
            
                <span class="comment"><a href="fullpost.html"><?=$wenZhang['replycounts'];?></a></span>
            
                <h2><?=$wenZhang['title'];?></h2> 
                <div style="margin-left: 30px;float:right;">
                    <span><a href="/index.php?m=index&c=details&a=preDetails&id=<?=$wenZhang['id'];?>">上一篇</a></span> | 
                    <span><a href="/index.php?m=index&c=details&a=nextDetails&id=<?=$wenZhang['id'];?>">下一篇</a></span>
                </div>
    
                <?php echo date('Y-m-d H:i:s',$wenZhang['publishtime']);?> | <strong>板块:</strong> <a href="/index.php?cid=<?=$wenZhang['cid'];?>"><?=$category;?></a> | <strong>浏览量:</strong> <?=$wenZhang['hits'];?>
                <?php if(empty($_GET['page']) || $_GET['page']==1):?>
                    <a href="http://www.cssmoban.com/" target="_parent"><img src="<?=$wenZhang['picture'];?>" alt="image" /></a>
                    <?=$wenZhang['contents'];?>
                <?php endif;?>
		  </div>
            
            <div class="comment_tab">
           	    评论           </div>
            
      <div id="comment_section">
                <ol class="comments first_level">
                    <?php if(empty($reply)):?>
                        <div>还没有评论哦，快来添加一条吧！</div>
                    <?php else: ?>
                        <?php foreach($reply as $key=>$value):?>
                            <li>
                                <div class="comment_box commentbox1">
                                    <div class="gravatar">
                                        <img src="<?=$value['picture'];?>" alt="author" />
                                    </div>
                                    <div class="comment_text">
                                        <div class="comment_author"><?=$value['username'];?><span class="date"><?php echo date('Y-m-d H:i:s',$value['replytime']);?></span></div>
                                        <?php if($value['isdisplay']==1):?>
                                            <p><?=$value['contents'];?></p>
                                            <div class="reply"><a href="#huifu">回复</a></div>
                                        <?php else: ?>
                                            <p>该条评论已被博主屏蔽！！</p>
                                        <?php endif;?>
                                    </div>
                                    <div class="cleaner"></div>
                                </div>                        
                            </li>
                        <?php endforeach;?>
                    <?php endif;?>  
                    </ol>
                </div>
                <?php if(!empty($reply)):?>
                    <div style="margin-bottom:20px ">
                        <span><a href="<?=$allPages['first'];?>">首页</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span><a href="<?=$allPages['pre'];?>">上一页</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span><a href="<?=$allPages['next'];?>">下一页</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span><a href="<?=$allPages['last'];?>">尾页</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                <?php endif;?>
                <div id="comment_form">
                    <h3>添加评论</h3>
                    <?php if(empty($_SESSION['username'])):?>
                        <p>未登录，无法发表评论！！！</p>
                        <p>请&nbsp;&nbsp;<a href="index.php?m=index&c=User&a=login">登录</a> | <a href="index.php?m=index&c=User&a=register">注册</a></p>
                    <?php else: ?>
                        <form action="index.php?m=index&c=details&a=doReply" method="post">
                            <div class="form_row">
                                <label><strong>内容<a name='huifu'></a></strong></label>
                                <br />
                                <textarea name="replyContents" class='ckeditor' id='textarea' style="height:450px; border:1px solid #ddd;"></textarea>
                                <input type="hidden" name="id" value="<?=$wenZhang['id'];?>">
                            </div>
                            <input type="submit" name="Submit" value="回复" class="submit_btn" />
                        </form>
                    <?php endif;?>
                </div>
            
		</div> <!-- end of main -->
    
  <div class="cleaner"></div>
  </div> 
    <!-- end of templatemo_main -->
  <div class="cleaner_h20"></div>
  
  	<div id="templatemo_footer">
        Copyright © <?php echo date('Y');?> <a href="<?=$config['blogWeb'];?>"><?=$config['blogName'];?></a> | QQ : <?=$config['qq'];?> | Email : <?=$config['email'];?>
    </div>
  
    <div class="cleaner"></div>
</div> <!-- end of warpper -->

</body>
</html>