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
  <div class="padding border-bottom">
    <button type="button" class="button border-yellow" onclick="window.location.href='#add'"><span class="icon-plus-square-o"></span> 添加分类</button>
  </div>
  <table class="table table-hover text-center">
    <tr>
      <th width="5%">  </th>
      <th width="15%">版块名称</th>
      <th width="10%">排序</th>
      <th width="10%">操作</th>
    </tr>
    <?php if(empty($data)):?>
      <tr><td colspan="4">无板块可浏览，快去添加一个吧！！</td></tr>
    <?php else: ?>
      <?php foreach($data as $key=>$value):?>
        <tr>
          <td>*</td>
          <td><?=$value['name'];?></td>
          <td><?=$value['orderby'];?></td>
          <td><div class="button-group"> <a class="button border-main" href="/index.php?m=admin&c=cate&a=cateedit&cid=<?=$value['cid'];?>"><span class="icon-edit"></span> 修改</a> <a class="button border-red" href="/index.php?m=admin&c=cate&a=del&cid=<?=$value['cid'];?>" onclick="javascript:return del();"><span class="icon-trash-o"></span> 删除</a> </div></td>
        </tr>
      <?php endforeach;?>
    <?php endif;?>
  </table>
</div>
<script type="text/javascript">
  function del() {
    var msg = "您真的确定要删除吗？\n\n请确认！";
    if (confirm(msg)==true){
      return true;
    }else{
      return false;
    }
  }
</script>
<div class="panel admin-panel margin-top">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>添加内容</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="/index.php?m=admin&c=cate&a=doAdd">
      <div class="form-group">
        <div class="label">
          <label>板块名称：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="name" required="true" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>排序：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="orderby" data-validate="number:排序必须为数字" required="true" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>
</body>
</html>