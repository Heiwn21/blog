<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>密码修改</title>
<link rel="stylesheet" href="/public/css/admin/css/pintuer.css">
<link rel="stylesheet" href="/public/css/admin/css/admin.css">
<script src="/public/css/admin/js/jquery.js"></script>
<script src="/public/css/admin/js/pintuer.js"></script>
</head>
<body style="background: url(/public/css/index/index/images/templatemo_body.jpg) 0px 0px;"">
<div class="panel admin-panel" style="border-bottom: none;background: url(/public/css/index/index/images/templatemo_body.jpg) 0px 0px;">
  <div class="panel-head" style="border-bottom: none;background: url(/public/css/index/index/images/templatemo_body.jpg) 0px 0px;margin-top: 30px;padding-left:30px">
  <span style="color: red;font-size: 20px;font-weight: bold;"><a href="/index.php">首页</a></span>
  </div>
  <div class="panel-head" style="border-bottom: none;background: url(/public/css/index/index/images/templatemo_body.jpg) 0px 0px;"">
  <strong style="font-size: 16px;font-weight: bold;"><span class="icon-key" ></span> 修改密码</strong>
  </div>
  <div class="body-content" style="padding-left: 140px;font-size:16px;font-weight: bold;">
    <form method="post" class="form-x" action="/index.php?m=index&c=user&a=doEditPass" enctype='multipart/form-data'>
      <div class="form-group">
        <div class="label">
          <label for="sitename">博主账号：</label>
        </div>
        <div class="field">
          <label style="line-height:33px;">
           <?=$userInfo['username'];?>
          </label>
        </div>
      </div>   
      <div class="form-group">
        <div class="label">
          <label for="sitename">头像：</label>
        </div>
        <div class="field">
          <img src="<?=$userInfo['picture'];?>" height='60' width='60'>    
        </div>
      </div>          
      <div class="form-group">
        <div class="label">
          <label for="sitename">新密码：</label>
        </div>
        <div class="field">
          <input type="password" class="input w50" name="newpass" size="50" placeholder="请输入新密码" data-validate="required:请输入新密码,length#>=5:新密码不能小于5位" />         
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label for="sitename">确认新密码：</label>
        </div>
        <div class="field">
          <input type="password" class="input w50" name="renewpass" size="50" placeholder="请再次输入新密码" data-validate="required:请再次输入新密码,repeat#newpass:两次输入的密码不一致" />          
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
