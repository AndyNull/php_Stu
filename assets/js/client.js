//客户
//删除客户信息
function del_client_info(){
    var boxs = document.getElementsByName("client_opt_box");
    for(i=0;i<boxs.length;i++){
        if(boxs[i].checked==true){
            $.post("./utils/db.php",{'action':'removeclientinfo','temp_id':boxs[i].value},function(data){
                alert(data);
                // location.reload();
                get_client_info();
            });
            // alert(boxs[i].value);
        }
    }
  }
  //客户信息选择事件
  function opt_client_all(str){
    var boxs = document.getElementsByName("client_opt_box");
    if(str == "reelection"){
        for(i=0;i<boxs.length;i++){
            if(boxs[i].checked == false){
                boxs[i].checked = true;
            }else{
                boxs[i].checked = false;
            }
        }
    }else if(str == "all"){
        if($('#opt_client_all').text() == "全选"){
            for(i=0;i<boxs.length;i++){
                boxs[i].checked = true;
                $('#opt_client_all').text("取消");
            }
        }else if($('#opt_client_all').text() == "取消"){
            for(i=0;i<boxs.length;i++){
                boxs[i].checked = false;
                $('#opt_client_all').text("全选");
            }
        }
    }
  }
 
  //客户信息修改
  function edit_clientinfo(str){
    $('#client_info_sub_btn').removeAttr('onclick');
    $('#client_info_sub_btn').attr('onclick',"sub_edit_client_info()");
    $('#client_info_head_h2').html('<h2 id="client_info_head_h2">修改<span id="client_info_head_span"></span>客户数据</h2>');
    $('#client_info_sub_btn').text("提交修改");
    $(".pop_client_div").css('display','block');
    $(".parent").css('filter','blur(30px)');
    $("#client_info_head_span").text($("#"+str+"01").text());
    $("#client_username").val($("#"+str+"01").text());
    $("#client_phone").val($("#"+str+"02").text());
    $("#client_email").val($("#"+str+"03").text());
    $("#client_sex").val($("#"+str+"04").text());
  }
  
  $("#user_info_close_btn").click(function(){
    $(".pop_client_div").css('display','none');
    $('.parent').css('filter','');
  });
  //提交修改客户信息
  function sub_edit_client_info(){
    username = $("#client_username").val();
    phone = $("#client_phone").val();
    email = $("#client_email").val();
    sex = $("#client_sex").val();
    temp_username = $("#client_info_head_span").text();
    $.post("./utils/db.php",{'action':'editclientinfo','temp_username':temp_username,'username':username,'phone':phone,'email':email,'sex':sex},function(data){
        alert(data);
        if(data == "修改成功"){
            get_client_info();
            $(".pop_client_div").css('display','none');
            $('.parent').css('filter','');
        }
    })
  }
  //客户信息添加
  function add_client_info(){
    $(".pop_client_div").css('display','block');
    $(".parent").css('filter','blur(30px)');
    $('#client_info_sub_btn').removeAttr('onclick');
    $('#client_info_sub_btn').attr('onclick',"sub_add_client_info()");
    $('#client_info_head_h2').text("正在添加客户信息");
    $('#client_info_sub_btn').text("添加客户");
  }
  //客户信息提交
  function sub_add_client_info(){
    username = $("#client_username").val();
    phone = $("#client_phone").val();
    email = $("#client_email").val();
    sex = $("#client_sex").val();
    $.post("./utils/db.php",{'action':'addclientinfo','username':username,'phone':phone,'email':email,'sex':sex},function(data){
        alert(data);
        if(data == "添加成功"){
            get_client_info();
            $("#client_username").val("");
            $("#client_phone").val("");
            $("#client_email").val("");
            $("#client_sex").val("");
            $(".pop_client_div").css('display','none');
            $('.parent').css('filter','');
        }
    })
  }