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
    <div class="panel-head"><strong class="icon-reorder"> 草稿列表</strong></div>
    <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
      <li><span style="font-size: 17px;font-weight: bold">共<span style="color:red"><?=$totalCounts;?></span>篇文章</span></li>
      </ul>
    </div>
    <table class="table table-hover text-center">
      <tr>
        <th width="50" style="text-align:left; padding-left:20px;"></th>
        <th>图片</th>
        <th>标题</th>
        <th>属性</th>
        <th>版块名称</th>
        <th width="10%">发表时间</th>
        <th width="310">操作</th>
      </tr>
      <form action="/index.php?m=admin&c=caogao&a=del" method="post">
      <volist name="list" id="vo">
      <?php if(empty($data)):?>
		<p>还没有草稿文章</p>
      <?php else: ?>
	  	<?php foreach($data as $key=>$value):?>
			<tr>
		        <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value="<?=$value['id'];?>"/></td>
		        <td width="10%"><img src="<?=$value['picture'];?>" alt="" width="70" height="50" /></td>
		        <td><div style="overflow:hidden;text-overflow:ellipsis;white-space: nowrap;height:30px;width:290px"><?=$value['title'];?></div></td>
		        <td><font color="#00CC99">草稿</font></td>
		        <td><?=$value['name'];?></td>
		        <td><?php echo date('Y-m-d H:i:s',$value['publishtime']);?></td>
		        <td><div class="button-group">
	         	 	<a style="font-size: 17px;font-weight: bold" href="/index.php?m=admin&c=lists&a=edit&id=<?=$value['id'];?>">修改</a>
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



//select跳页
function s_click(obj) {
	var num = 0;
	for (var i = 0; i < obj.options.length; i++) {
		if (obj.options[i].selected == true) {
		    num++;
		}
	}
		if (num == 1) {
		    var url = obj.options[obj.selectedIndex].value;
		    window.open(url,'_self'); //这里修改打开连接方式
		}
}

//批量复制
function changecopy(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){	
		var i = 0;
	    $("input[name='id[]']").each(function(){
	  		if (this.checked==true) {
				i++;
			}		
	    });
		if(i>1){ 
	    	alert("只能选择一条信息!");
			$(o).find("option:first").prop("selected","selected");
		}else{
		
			$("#listform").submit();		
		}	
	}
	else{
		alert("请选择要复制的内容!");
		$(o).find("option:first").prop("selected","selected");
		return false;
	}
}

</script>
</body>
</html>