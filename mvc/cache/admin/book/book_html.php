<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="/public/css/admin/css/pintuer.css">
<link rel="stylesheet" href="/public/css/admin/css/admin.css">
<script src="/public/css/admin/js/jquery.js"></script>
<script src="/public/css/admin/js/pintuer.js"></script>
</head>
<body>
  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 内容列表</strong></div>
    <div><span style="font-size: 17px;font-weight: bold">共<span style="color:red"><?=$totalCounts;?></span>条评论</span></div>
    <table class="table table-hover text-center">
      <tr>
        <th width="50" style="text-align:left; padding-left:20px;"></th>
        <th style="width: 80px">用户名</th>
        <th style="width: 250px">文章标题</th>
        <th style="width: 600px">评论内容</th>
        <th style="width: 110px">属性</th>
        <th style="width: 300px">评论时间</th>
        <th style="width: 300px">操作</th>
      </tr>
      <form action="/index.php?m=admin&c=book&a=del" method="post">
      <volist name="list" id="vo">
      <?php if(empty($data)):?>
		<tr><td colspan="7"><p>还没有评论</p></td></tr>
      <?php else: ?>
	  	<?php foreach($data as $key=>$value):?>
			<tr>
		        <td ><input type="checkbox" name="rid[]" value="<?=$value['rid'];?>"/></td>
		        <td><?=$value['username'];?></td>
		        <td><?=$value['title'];?></td>
		        <td><?=$value['contents'];?></td>
		        
		        <td>
		        	<font color="#00CC99">
						<?php if($value['istop']==1 && $value['isdisplay']==1):?>
							置顶/<br/>
							展示
						<?php elseif($value['istop']==1 && $value['isdisplay']==0):?>
							置顶/<br/>
							评论
						<?php elseif($value['istop']==0 && $value['isdisplay']==0):?>
							未置顶/<br/>
							评论
						<?php elseif($value['istop']==0 && $value['isdisplay']==1):?>
							未置顶/<br/>
							展示
						<?php endif;?>
		        	</font>
		        </td>
		        <td><?php echo date('Y-m-d H:i:s',$value['replytime']);?></td>
		        <td><div class="button-group">
	         	 	 &nbsp;&nbsp;
			        <a style="font-size: 17px;font-weight: bold" href="/index.php?m=admin&c=book&a=isTop&rid=<?=$value['rid'];?>">置顶</a>
			        <?php if($value['isdisplay']==1):?> 
						&nbsp;&nbsp;
	         	 		<a style="font-size: 17px;font-weight: bold" href="/index.php?m=admin&c=book&a=isDisplay&dis=0&rid=<?=$value['rid'];?>">屏蔽</a>
			        <?php else: ?>
						&nbsp;&nbsp;
          				<a style="font-size: 17px;font-weight: bold" href="/index.php?m=admin&c=book&a=isDisplay&dis=1&rid=<?=$value['rid'];?>">展示</a>
			        <?php endif;?>
         	 	</div></td>
	        </tr>
	  	<?php endforeach;?>
      <?php endif;?>
      <tr>
        <td colspan="7" style="text-align:left;padding-left:20px;"><input type="submit" value="删除" class="button border-red icon-trash-o"></td>
      </tr>
      </form>
      <tr>
        <td colspan="8"><div class="pagelist"> <a href="<?=$allPages['first'];?>">首页</a> <a href="<?=$allPages['pre'];?>">上一页</a><a href="<?=$allPages['next'];?>">下一页</a><a href="<?=$allPages['last'];?>">尾页</a> </div></td>
      </tr>
    </table>
  </div>
<script type="text/javascript">

//搜索
function changesearch(){	
		
}

</script>
</body>
</html>