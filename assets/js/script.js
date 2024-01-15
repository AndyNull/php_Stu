/*index*/
function check_userinfo(){
  $user = document.getElementById("reg_username").value;
  if($user){
    xhr = new XMLHttpRequest();
    xhr.open("get","./utils/login_db.php?action=checkuserinfo&temp_type=name&name="+$user);
    xhr.onreadystatechange=function(){
      if(xhr.readyState==4 && xhr.status<400){
        // alert(2);
        cont = xhr.responseText;
        if(cont){
          document.getElementsByName("check_info")[0].innerText="用户名已存在";
          document.getElementById("reg_btn").disabled=true;
          document.getElementById("reg_username").select();
        }else{
          document.getElementsByName("check_info")[0].innerText="当前用户名可以注册";
          document.getElementById("reg_btn").disabled=false;
        }
      }
    }
    xhr.send();
  }else{
    document.getElementsByName("check_info")[0].innerText="用户名禁止为空";
    document.getElementById("reg_btn").disabled=true;
    document.getElementById("reg_username").select();
  }
}
function switchlogin_reg(str){
  if(str=="reg"){
    $('#login_div').hide();
    $('#reg_div').show();
  }else if(str=="login"){
    $('#login_div').show();
    $('#reg_div').hide();
  }
}
function register(){
  username = $('#reg_username').val();
  sex = $('#reg_sex').val();
  phone = $('#reg_phone').val();
  passwd = $('#reg_passwd').val();
  email = $('#reg_email').val();
  // data = "action=register&usrname="+username+"&password="+passwd+"&phone="+phone+"&sex="+sex;
  // xhr = new XMLHttpRequest();
  // xhr.open("post","./db.php");
  // xhr.setRequestHeader("Content-Type","application/x-www-from-urlencoded");
  // xhr.onreadystatechange=function(){
  //   if(xhr.readyState==4 && xhr.status <400){
  //     cont = xhr.responseText;
  //     alert(xhr.responseText);
  //   }
  // }
  // xhr.send(data);
  $.ajax({
    type:"POST",
    url:"./utils/login_db.php",
    data:{
      'action':'register',
      'username':username,
      'password':passwd,
      'email':email,
      'sex':sex,
      'phone':phone,
      'verifycode':$('#reg_verifycode').val(),
    },
    success:function(data){
      change_verifycode();
      // $('#reg_Info').text(data);
      if(data=="succes"){
        popUp('default','注册成功，前往登录！');
        // $('#reg_Info').text("注册成功，前往登录！");
        location.reload();
        setTimeout(() => {
          $('#login_div').show();
          $('#reg_div').hide();
        }, 1000);
      }else{
        popUp('default',data);
        // $('#reg_Info').text(data);
      }
    }
  })

}
function login(){
  username = $('#login_username').val();
  passwd = $('#login_passwd').val();
  if(username=="" || passwd ==""){
    popUp('default','禁止为空...');
    // $('#login_Info').text('禁止为空')
    $('#login_username').select();
  }else{
    $.ajax({
      type:'POST',
      url:'./utils/login_db.php',
      data:{
        'action':'login',
        'username':username,
        'password':passwd,
        'verifycode':$('#login_verifycode').val()
      },
      beforeSend:function(){
        // $('#login_Info').text('登录中...')
        popUp('default','登录中...');
        change_verifycode();
      },
      success:function(data){
        popUp('default',data);
        // $('#login_Info').text(data);
        if(data == "登录成功"){
          window.location.href = "index.php";
          // to_user()
        }
      }
    });  
  }
}

// function to_user(){
//   $.ajax({
//     type:'get',
//     url:'./index.php',
//     success:function(data){
//       $('body').html(data);
//     }
//   })
// }
function check_table(){
  $.ajax({
      type:'POST',
      url:'./utils/login_db.php',
      data:{'action':'checktable','verifycode':$('#reg_verifycode').val()},
      beforeSend:function(){
        popUp('default','checking...');
        change_verifycode();
        // $('#reg_Info').text('checking...');
      },
      success:function(data){
        popUp('default',data);
        // $('#reg_Info').text(data);
      }
  });
}

function check_passwdinfo(){
  str = $('#reg_passwd').val();
  if(5<str.length && str.length<19){
    reg = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{6,18}/;
    if(reg.test(str)){
      $("#check_passwd").text("满足");
      document.getElementById("reg_btn").disabled=false;
    }else{
      $("#check_passwd").text("密码请包含大小写字母和数字");
      document.getElementById("reg_btn").disabled=true;
      document.getElementById("reg_passwd").select();
    }

  }else{
    $("#check_passwd").text("密码长度请在6-18位");
    document.getElementById("reg_btn").disabled=true;
    document.getElementById("reg_passwd").select();
  }
}

function switch_edit_show(str){
  if(str=="show"){
    $('#user_edit_info').hide();
    $('#client_info_div').hide();
    $('#userinfo').show();
  }else if(str=="edit"){
    $('#user_edit_info').show();
    $('#userinfo').hide();
    $('#client_info_div').hide();
  }
}

function login_out(){
  $.post("/StuSYS/logout.php",{'logout':true},function(data){
      location.href="/StuSYS/login.php";
  })
}
function show_img_div(){
  $(".pop_div").css('display','block');
  $(".parent").css('filter','blur(30px)');
}
function get_client_info(){
  $.ajax({
      type:'get',
      url:'client_info.php',
      success:function(data){
          $("#userinfo").hide();
          $("#user_edit_info").hide();
          $("#client_info_div").show();
          $("#client_info_div").html(data);
      }
  })
}


//消息弹窗提示测试
function popUp(type, content, duration = 1000) {
  // 创建容器元素
  let popContainer = document.createElement('div');
  popContainer.className = 'pop-container';

  // 添加内容元素
  let popContent = document.createElement('div');
  popContent.className = 'pop-content';
  popContainer.appendChild(popContent);

  // 设置内容和样式
  popContent.innerHTML = content;
  switch (type) {
    case 'success':
      popContent.classList.add('pop-success');
      break;
    case 'warning':
      popContent.classList.add('pop-warning');
      break;
    default:
      popContent.classList.add('pop-message');
      break;
  }

  // 添加到文档中
  document.body.appendChild(popContainer);

  // 移除提示框
  setTimeout(() => {
    document.body.removeChild(popContainer);
  }, duration);
}


  
function sub_user_info(){
  passwd = $("#passwd").val();
  phone = $("#phone").val();
  email = $("#email").val();
  sex = $("#sex").val();
  $.post("./utils/db.php",{'action':'user_editinfo','temp_username':$("#user_info_span").text(),'password':passwd,'phone':phone,'email':email,'sex':sex},function(data){
      alert(data);
      if(data == "修改成功"){
          location.reload();
      }
  })
}