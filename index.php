<?
include "./utils/db.php";
$username = $_SESSION['login_user_info'];
$info = checkuserinfo_func(null,$username);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/jquery-3.4.1.js"></script>
    <script src="./assets/js/script.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Document</title>
</head>
<script src="./assets/js/hook.js"></script>
<style>
    table tr:nth-child(odd){
        background-color: #F5F5F5;
    }
</style>
<body>
    <div class="parent">
        <div id="user_menu">
            <button onclick="switch_edit_show('show')">个人信息</button>
            <button onclick="switch_edit_show('edit')">修改信息</button>
            <button onclick="get_client_info()">客户信息</button>
            <?
             if($info[7]==1){
                echo "<button onclick=\"window.location.href='./admin/index.php'\">管理面板</button>";
             }
            ?>
            <button onclick="login_out()">退出登录</button>
        </div>
        <div id="userinfo">
            <div id="welcome_div"><span><? echo "欢迎法外狂徒：".$username ?></span></div>
            <div id="avatar_div"><img onclick="show_img_div()" src="<? echo $info[6]; ?>" alt="点击修改头像"></div>
            <?  
                echo '<table>';
                $str_list = ['id','用户名','密码','电话','邮箱','性别'];
                
                for($i=0;$i<count($str_list);$i++){
                    echo "<tr><td>$str_list[$i]</td><td>$info[$i]</td></tr>";
                }
                echo "</table>";
            ?>
        </div>
        
        <div id="user_edit_info" style="display: none;">
            <div id="welcome_div"><span><? echo "正在修改法外狂徒：<span id='user_info_span'>".$username."</span> 的信息" ?></span></div>
            <?  
                echo '<table>';
                $str_list = ['密码','电话','邮箱','性别'];
                $en_list = ['passwd','phone','email','sex'];
                
                for($i=0;$i<count($str_list);$i++){
                    echo "<tr><td>$str_list[$i]</td><td><input id='$en_list[$i]' style='width:99%;height:98%;border:none;color:red;background-color:transparent;' value='".$info[($i+2)]."'></td></tr>";
                }
                echo "</table>";
            ?>
            <div class="btng"><button onclick="sub_user_info()">提交修改</button></div>
        </div>
        <div id="client_info_div" style="display: none;">
            <div id="welcome_div"><span><? echo "欢迎法外狂徒：".$username ?></span></div>
        </div>
    </div>
    
    <div class="pop_div">
        <div class="user_info_div">
            <div class="user_info_div_head">
                <h2>修改<span id="user_info_head_span"></span>用户头像</h2>
            </div>
            <div class="user_info_edit_div">
                <div id="avatar_div"><img src="<? echo $info[6]; ?>"></div>
                <div style="margin: 10px auto;"><input type="file" name="avatar_input" id="avatar_input"></div>
                <div class="btng"><button onclick="sub_avatar_input()">提交修改</button><button id="user_info_close_btn">关闭窗口</button></div>
            </div>
        </div>
    </div>
    <div class="pop_client_div">
        <div class="user_info_div">
            <div class="user_info_div_head">
                <h2 id="client_info_head_h2">修改<span id="client_info_head_span"></span>客户数据</h2>
            </div>
            <div class="user_info_edit_div">
                <label for="client_username"><span>用户名：</span><input type="text" id="client_username" placeholder="请输入用户名"></label>
                <label for="client_phone"><span>手机：</span><input type="tel" id="client_phone" placeholder="请输入手机" ></label>
                <label for="client_email"><span>邮箱：</span><input type="email" id="client_email" placeholder="请输入邮箱"></label>
                <label for="client_sex"><span>性别：</span><input type="text" id="client_sex" placeholder="请输入性别"></label>
                <div class="btng"><button id="client_info_sub_btn" onclick="sub_edit_client_info()">提交修改</button><button id="client_info_close_btn">关闭窗口</button></div>
            </div>
        </div>
    </div>

    <script>
        $("#user_info_close_btn").click(function(){
            $(".pop_div").css('display','none');
            $('.parent').css('filter','');
        });
        $("#client_info_close_btn").click(function(){
            $(".pop_client_div").css('display','none');
            $('.parent').css('filter','');
        });
        function sub_avatar_input(){
        formdata = new FormData();
        avatar_file = document.getElementById('avatar_input');
        fileobj = avatar_file.files[0];
        formdata.append('filename',fileobj);
        formdata.append('temp_id',<? echo $info[0] ?>);
        $.ajax({
            type:'post',
            url:'./utils/fileupload.php',
            data:formdata,
            async:false,
            processData:false,
            contentType:false,
            success:function(data){
                if(data=='success'){
                    location.href = 'index.php';
                }
            }
        })
        }
    </script>
</body>
</html>