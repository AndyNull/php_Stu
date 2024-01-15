<?
include "../utils/db.php";
if(!$_SESSION['isLogin'] || empty($_SESSION['login_user_info']) || checkuserinfo_func(null,$name = $_SESSION['login_user_info'])[7] != 1){
    header("Location:../index.php");
}

$info = find_all_user_info();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../assets/js/jquery-3.4.1.js"></script>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/master-script.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>管理页面</title>
</head>
<body>
    <div class="pop_div">
        <div class="user_info_div">
            <div class="user_info_div_head">
                <h2>修改<span id="user_info_head_span"></span>用户数据</h2>
            </div>
            <div class="user_info_edit_div">
                <label for="passwd"><span>密码：</span><input type="current-password" id="passwd" placeholder="请输入密码"></label>
                <label for="phone"><span>手机：</span><input type="tel" id="phone" placeholder="请输入手机" ></label>
                <label for="email"><span>邮箱：</span><input type="email" id="email" placeholder="请输入邮箱"></label>
                <label for="sex"><span>性别：</span><input type="text" id="sex" placeholder="请输入性别"></label>
                <!-- <label for="state"><span>状态：</span><input type="text" id="state" placeholder="请输入状态" ></label> -->
                <label><span>状态：</span><input type="radio" style="width: 20px;" class="states" name="state" value="disable"><span>封禁</span><input type="radio" style="width: 20px;" class="states" name="state" value="enable"><span>激活</span></label>
                <div class="btng"><button onclick="sub_edit_user_info()">提交修改</button><button id="user_info_close_btn">关闭窗口</button></div>
            </div>
        </div>
    </div>
    <div class="parent">
        <div id=user_menu>
            <div id="avatar_div"><img src="<? echo checkuserinfo_func(null,$_SESSION['login_user_info'])[6]; ?>" alt=""></div>
            <button onclick="get_home_p()">所有信息</button>
            <button onclick="get_search_p()">搜索信息</button>
            <button onclick="window.location.href='../index.php'">个人中心</button>
            <button onclick="login_out()">退出登录</button>
        </div>
        <div id="userinfo">
            <div id="welcome_div"><span><? echo "欢迎法外狂徒：".$_SESSION['login_user_info'] ?></span></div>
            <div id="btn_div"><button id="opt_all" onclick="opt_all('all')">全选</button><button onclick="opt_all('reelection')">反选</button><button onclick="del_info()">删除所选</button><button onclick="block_user('block')">封禁所选</button><button onclick="block_user('active')">解禁所选</button></div>
            <div id="info_table_div">
                <?  
                    $str_list = ['选择','id','用户名','密码','电话','邮箱','性别','头像','等级','状态','操作'];
                    echo "<div class='info_table_head' style='position: sticky; top: 0;'>";
                    for($i=0;$i<count($str_list);$i++){
                        echo "<div>".$str_list[$i]."</div>";
                    }
                    echo "</div>";
                    for($i=0;$i<count($info);$i++){
                        echo "<div class='info_table_centent' id='info".$info[$i][0]."'><div><input type='checkbox'name='opt_box' value='".$info[$i][0]."'></div>";
                        for($j=0;$j<count($info[$i]);$j++){
                            if($j==6){
                                $info[$i][$j]="*********";
                            }
                            echo "<div id='info".$info[$i][0]."0".$j."'>".$info[$i][$j]."</div>";
                        }
                        echo "<div><button onclick='edit_user_info(\"info".$info[$i][0]."\")'>编辑</button></div></div>";
                    }
                ?>
            </div>
        </div>
    </div>
    <script>
        $("#user_info_close_btn").click(function(){
            $(".pop_div").css('display','none');
            $('.parent').css('filter','');
        });
        function edit_user_info(str){
            if(!checke_manger(str)){
                popUp('warning', '<svg t="1699239223520" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2670" width="32" height="32"><path d="M800.5 512c0 159.3-129.1 288.5-288.5 288.5-99.6 0-187.4-50.4-239.2-127.2-31.1-46-49.3-101.5-49.3-161.3 0-159.3 129.1-288.5 288.5-288.5S800.5 352.7 800.5 512z" fill="#FC355D" p-id="2671"></path><path d="M556.9 512l60.9-60.9c12.4-12.4 12.4-32.5 0-44.9-12.4-12.4-32.5-12.4-44.9 0L512 467.1l-60.9-60.9c-12.4-12.4-32.5-12.4-44.9 0-12.4 12.4-12.4 32.5 0 44.9l60.9 60.9-60.9 60.9c-12.4 12.4-12.4 32.5 0 44.9 6.2 6.2 14.3 9.3 22.5 9.3s16.3-3.1 22.5-9.3l60.9-60.9 60.9 60.9c6.2 6.2 14.3 9.3 22.5 9.3 8.1 0 16.3-3.1 22.5-9.3 12.4-12.4 12.4-32.5 0-44.9L556.9 512z" fill="#FFFFFF" p-id="2672"></path></svg>本是同根生，相煎何太急！');
            }else{
                $(".pop_div").css('display','block');
                $(".parent").css('filter','blur(30px)');
                $("#user_info_head_span").text($("#"+str+"01").text());
                $("#passwd").val($("#"+str+"02").text());
                $("#phone").val($("#"+str+"03").text());
                $("#email").val($("#"+str+"04").text());
                $("#sex").val($("#"+str+"05").text());
                $("input[name=state][value='"+$("#"+str+"08").text()+"']").attr('checked',true);
            }
        
            // $.post('./utils/db.php',{'action':'checkuserinfo','temp_id':$str,'temp_type':'tempid'},function(data){
            //     alert(data);
            // });
        }
        function checke_manger(str){
            if($("#"+str+"01").text() != "<? echo $_SESSION['login_user_info']; ?>" && $("#"+str+"07").text() == "1"){
                return false;
            }else{
                return true;
            }
        }
    </script>
</body>
</html>