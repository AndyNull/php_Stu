<?
include "./utils/session.php";
if(!empty($_SESSION['login_user_info']) && !empty($_SESSION['isLogin'])){
  echo "<script>alert('请勿重复登录！请先退出！');window.location.href='./index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>用户管理</title>
  </head>
  <script>
    $("body").ready(function(){
      $(".video_pop").show()
      $("#myVideo").get(0).play();
    });
  </script>
  <body id="login_page">
    <div class="video_pop">
      <div class="myvideo_div">
        <video id="myVideo" src="./assets/images/bg.mp4" style="width:99.9%;height:80%" loop autoplay con></video>
        <div class="btng">
          <button id="sayyes_btn" >已习得真传</button><button id="sayno_btn">摆烂躺平</button>
        </div>
      </div>
    </div>
    <script>
      var video = document.getElementById("myVideo");
      video.play();
      $('#sayyes_btn').click(function(){
        document.getElementById('myVideo').removeAttribute('loop');
        $('#sayyes_btn').text('学习中...');
        document.getElementById('myVideo').addEventListener('ended',function(){
          $('#sayyes_btn').text('撒花结业！');
          setTimeout(() => {
           $('#myVideo').get(0).pause();$('.video_pop').hide();
          }, 800);
        })
      });
      $("#sayno_btn").click(function(){
        $('#myVideo').get(0).pause();$('.video_pop').hide();
      });
      $("#sayno_btn").mouseover(function(){
        $("#sayno_btn").text("真的不学习吗");
        // document.getElementById('myVideo').setAttribute('controls','controls');
        // $('#myVideo').attr('controls');
        $("#sayno_btn").css("position","absolute");
        $("#sayno_btn").css("top",Math.floor(Math.random()*640));
        $("#sayno_btn").css("left",Math.floor(Math.random()*1300));
      });
    </script>
    <div id="login_div">
      <label for="login_username"><span>用户名：</span><input type="text" id="login_username" placeholder="请输入用户名"></label>
      <label for="login_passwd"><span>密码：</span><input type="password" id="login_passwd" placeholder="请输入密码"></label>
      <label for="login_verifycode"><span>验证码：</span><input type="text" id="login_verifycode" placeholder="请输入验证码"></label>
      <img class="verifycode" src="./utils/verify_code.php" style="width: 120px;margin-top:20px" onclick="change_verifycode()"><a onclick="change_verifycode()"> 看不清,换一张</a>
      <div class="btng">
        <button onclick="login()">确认登录</button>
        <button onclick="switchlogin_reg('reg')">前往注册</button>
      </div>
      <p id="login_Info"></p>
    </div>
    
    <div style="display: none;" id="reg_div">
      <label for="reg_username"><span>用户名(*)：</span><input type="text" id="reg_username" placeholder="请输入用户名" onblur="check_userinfo()"></label><b style="position: fixed;" name="check_info"></b>
      <label for="reg_passwd"><span>密码(*)：</span><input type="password" id="reg_passwd" placeholder="请输入密码" onblur="check_passwdinfo()"></label><b style="position: fixed;" id="check_passwd"></b>
      <label for="reg_phone"><span>手机(*)：</span><input type="tel" id="reg_phone" placeholder="请输入手机"></label>
      <label for="reg_email"><span>邮箱(*)：</span><input type="email" id="reg_email" placeholder="请输入邮箱"></label>
      <label for="reg_sex"><span>性别：</span><input type="text" id="reg_sex" placeholder="请输入性别"></label>
      <label for="reg_verifycode"><span>验证码：</span><input type="text" id="reg_verifycode" placeholder="请输入验证码"></label>
      <img class="verifycode" src="./utils/verify_code.php" style="width: 120px;margin-top:20px" onclick="change_verifycode()"><a onclick="change_verifycode()"> 看不清,换一张</a>
      <div class="btng">
        <button onclick="register()" id="reg_btn">确认注册</button>
        <button onclick="switchlogin_reg('login')">前往登录</button>
        <button onclick="check_table()">初始化</button>
      </div>
      <p id="reg_Info"></p>
    </div>

    <script>
      function change_verifycode(){
        $('.verifycode').attr('src','./utils/verify_code.php')
      }
    </script>
  </body>
</html>