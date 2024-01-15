/*后台*/
function get_search_p(){
    $.ajax({
        type:'get',
        url:'admin_search.php',
        success:function(data){
            $("#userinfo").html(data);
        }
    })
  }
  
  function get_home_p(){
    $.ajax({
        type:'get',
        url:'./index.php',
        success:function(data){
            $('body').html(data);
        }
    })
  }
  
  function opt_all(str){
    var boxs = document.getElementsByName("opt_box");
    if(str == "reelection"){
        for(i=0;i<boxs.length;i++){
            if(boxs[i].checked == false){
                boxs[i].checked = true;
                // document.getElementById("opt_all").innerText="反选";
            }else{
                boxs[i].checked = false;
            }
        }
    }else if(str == "all"){
        if($('#opt_all').text() == "全选"){
            for(i=0;i<boxs.length;i++){
                boxs[i].checked = true;
                $('#opt_all').text("取消");
            }
        }else if($('#opt_all').text() == "取消"){
            for(i=0;i<boxs.length;i++){
                boxs[i].checked = false;
                $('#opt_all').text("全选");
            }
        }
    }
  }
  function del_info(){
    var boxs = document.getElementsByName("opt_box");
    for(i=0;i<boxs.length;i++){
        if(boxs[i].checked==true){
            $.post("../utils/db.php",{'action':'deluserinfo','id':boxs[i].value},function(data){
                popUp('default',data);
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });
            // alert(boxs[i].value);
        }
    }
  }
  function block_user(type){
    var boxs = document.getElementsByName("opt_box");
    for(i=0;i<boxs.length;i++){
        if(boxs[i].checked==true){
            $.post("../utils/db.php",{'action':'blockuser','id':boxs[i].value,'type':type},function(data){
                if(data=="1"){
                    data = "操作成功";
                }
                popUp('default',data);
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });
        }
    }
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
  
  
  function search_block_user(type){
    var boxs = document.getElementsByName("opt_box");
    for(i=0;i<boxs.length;i++){
        if(boxs[i].checked==true){
            $.post("../utils/db.php",{'action':'blockuser','id':boxs[i].value,'type':type},function(data){
                search_info();
            });
        }
    }
  }
  
  function search_del_info(){
    var boxs = document.getElementsByName("opt_box");
    for(i=0;i<boxs.length;i++){
        if(boxs[i].checked==true){
            $.post("../utils/db.php",{'action':'deluserinfo','id':boxs[i].value},function(data){
                search_info();;
            });
            // alert(boxs[i].value);
        }
    }
  }
  //管理提交修改用户信息
  function sub_edit_user_info(){
    passwd = $("#passwd").val();
    phone = $("#phone").val();
    email = $("#email").val();
    sex = $("#sex").val();
    radio_value = document.getElementsByName('state');
    for(i=0;i<2;i++){
        if(radio_value[i].checked){
            state = radio_value[i].value;
        }
    }
    $.post("../utils/db.php",{'action':'editinfo','temp_username':$("#user_info_head_span").text(),'password':passwd,'phone':phone,'email':email,'sex':sex,'state':state},function(data){
        if(data == "修改成功"){
            location.reload();
        }
    })
  }
  //管理搜索用户信息
  function search_info(){
    if($('#find_str').val() == ""){
        $('#find_str').attr('placeholder','请输入关键词,禁止为空！');
        document.getElementById("find_str").select();
    }else{
        boxs = document.getElementsByName("find_type_btn");
        for(i=0;i<boxs.length;i++){
            if(boxs[i].checked){
            type = boxs[i].value;
            }
        }
        $.post('../utils/db.php',{'action':'search_info','temp_str':$('#find_str').val(),'temp_type':type},function(data){
            result=JSON.parse(data);
            // alert(result.length);
            $(".find_info_show_div").html('<div id="btn_div"><button id="opt_all" onclick="opt_all(\'all\')">全选</button><button onclick="opt_all(\'reelection\')">反选</button><button onclick="search_del_info()">删除所选</button><button onclick="search_block_user(\'block\')">封禁所选</button><button onclick="search_block_user(\'active\')">解禁所选</button></div><div id="info_table_div"><div class="info_table_head" style="position: sticky; top: 0;"><div>选择</div><div>id</div><div>用户名</div><div>密码</div><div>电话</div><div>邮箱</div><div>性别</div><div>头像</div><div>等级</div><div>状态</div><div>操作</div></div></div>');
            for(i=0;i<result.length;i++){
                $("#info_table_div").append('<div class="info_table_centent" id="info'+result[i][0]+'"><div><input type="checkbox" name="opt_box" value="'+result[i][0]+'"></div></div>');
                for(j=0;j<result[i].length;j++){
                    if(j==6){
                        result[i][j]="*********";
                    }
                    $(".info_table_centent").eq(i).append('<div id="info'+result[i][0]+'0'+j+'">'+result[i][j]+'</div>');
                }
                $(".info_table_centent").eq(i).append('<div><button onclick="edit_user_info(\'info'+result[i][0]+'\')" >编辑</button></div>');
            }
            // $(".find_info_show_div").append();
        })
    }
  }
  