<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
</head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css" />
    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
      $('layui-layer-btn0').click(function(){
         alert('test');
      })
    </script>
<body style="background-color:rgb(242,242,242)";>
     
        <div id="form_container2" style="padding-top: 25px;">
          <h2>Full Your shipping Information</h2>
          <label>Your Phone Number:</label><input type="text" class="form-control" value="admin"  placeholder="Phone Number" id="regist_account"/>
          <label>Address1:</label><input type="password" class="form-control" placeholder="Address1" id="regist_password1" />
          <label>Address2:</label><input type="password" class="form-control" placeholder="Address2" id="regist_password2" />
          <label>City:</label><input type="text" class="form-control" placeholder="City" id="regist_phone" />
          <!-- <label>Country</label><input type="text" class="form-control" placeholder="验证码" id="regist_vcode" /> -->
          <!--<button id="getVCode" type="button" class="btn btn-success" >获取验证码</button>-->
          <!-- <label>States</label><input id="getVCode" type="button" class="btn btn-success" value="点击发送验证码" onclick="sendCode(this)" /> -->
          <!-- <label>States</label><input type="text" class="form-control" placeholder="验证码" id="regist_vcode" /> -->
           <label>Country:</label><input type="password" class="form-control" placeholder="Country" id="regist_password2" />
          <label>States:</label><input type="text" class="form-control" placeholder="States" id="regist_phone" />

    </div>

</body>
</html>