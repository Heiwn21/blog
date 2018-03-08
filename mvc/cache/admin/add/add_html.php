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
<script type='text/javascript' src='/public/ckeditor/ckeditor.js'></script>
</head>
<body>
<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>发表文章</strong></div>
  <div class="body-content">
    <form method="post" name="f" class="form-x" action="" enctype='multipart/form-data'>  
      <div class="form-group">
        <div class="label">
          <label>标题：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="" name="title" data-validate="required:请输入标题" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>图片：</label>
        </div>
        <div class="field">
          <input type="file" name="header" />       
        </div>
      </div>     
      
      <if condition="$iscid eq 1">
        <div class="form-group">
          <div class="label">
            <label>选择版块：</label>
          </div>
          <div class="field">
            <select name="cid" class="input w50">
            <?php if(empty($allCategory)):?>
              <option value="">无板块可选择</option>
            <?php else: ?>
                <option value="">请选择版块</option>
                <?php foreach($allCategory as $value):?>
                  <option value="<?=$value['cid'];?>"><?=$value['name'];?></option>
                <?php endforeach;?>
            <?php endif;?>
            </select>
            <div class="tips"></div>
          </div>
        </div>
      </if>
      <div class="form-group">
        <div class="label">
          <label>内容：</label>
        </div>
        <div class="field">
          <textarea name="contents" class='ckeditor' id='textarea' style="height:450px; border:1px solid #ddd;"></textarea>
          <div class="tips"></div>
        </div>
      </div>
     
      <div class="clear"></div>
      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o" type="submit" onclick="javascript:document.f.action='/index.php?m=admin&c=add&a=doAdd';document.f.submit();"> 提交</button>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <button class="button bg-main icon-check-square-o" type="submit" onclick="javascript:document.f.action='/index.php?m=admin&c=caogao&a=doAdd';document.f.submit();"> 存入草稿箱</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body></html>