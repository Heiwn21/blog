<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>网站信息</title>  
    <link rel="stylesheet" href="/public/css/admin/css/pintuer.css">
    <link rel="stylesheet" href="/public/css/admin/css/admin.css">
    <script src="/public/css/admin/js/jquery.js"></script>
    <script src="/public/css/admin/js/pintuer.js"></script>  
</head>
<body>
<div class="panel admin-panel">
  <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 博客信息</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="/index.php?m=admin&c=index&a=doInfo">
      <div class="form-group">
        <div class="label">
          <label>博客名称：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="blogName" value="<?=$config['blogName'];?>" required="true" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>博客域名：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="blogWeb" value="<?=$config['blogWeb'];?>" required="true"/>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>博客个性签名：</label>
        </div>
        <div class="field">
          <input class="input" type="text" name="blogSignature" value="<?=$config['blogSignature'];?>" required="true">
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>QQ：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="qq" value="<?=$config['qq'];?>" required="true"/>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>Email：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="email" value="<?=$config['email'];?>" required="true"/>
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
</body></html>