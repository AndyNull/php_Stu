<?php
include "mysql_util.php";
include "session.php";
include_once "util.php";
$vcode = @strtolower($_SESSION['vcode']);
if(isset($_REQUEST['action'])){
    switch($_REQUEST['action']){
        case 'checktable':
            if(!empty($_REQUEST['verifycode'])&&(strtolower($_REQUEST['verifycode']) == $vcode)){
                check_tables();
                unset($_SESSION['vcode']);
            }else{
                unset($_SESSION['vcode']);
                echo "验证码错误！";
            }
            break;
        case 'login':
            if(!empty($_REQUEST['verifycode'])&&(strtolower($_REQUEST['verifycode']) == $vcode)){
                unset($_SESSION['vcode']);
                if(!empty($_REQUEST['username'])&&!empty($_REQUEST['password'])){
                    echo login_func($_REQUEST['username'],$_REQUEST['password']);
                }else{
                    echo "禁止为空！";
                }
            }else{
                // echo $_SESSION['vcode']."ABC";
                // echo $_REQUEST['verifycode'];
                unset($_SESSION['vcode']);
                die("验证码错误！");
            }
            break;
        case 'register':
            if(!empty($_REQUEST['verifycode'])&&(strtolower($_REQUEST['verifycode']) == $vcode)){
                unset($_SESSION['vcode']);
                if(!empty($_REQUEST['username']) && !empty($_REQUEST['password']) && !empty($_REQUEST['phone']) && !empty($_REQUEST['email'])){
                    if(verify_passwd($_REQUEST['password'])==1 && strlen($_REQUEST['password']) > 5 && strlen($_REQUEST['password']) < 19){
                        if(verify_email($_REQUEST['email'])==1){
                            if(verify_phone($_REQUEST['phone'])==1){
                                $reg_info = register_func($_REQUEST['username'],$_REQUEST['password'],$_REQUEST['phone'],$_REQUEST['email'],$_REQUEST['sex']);
                                echo $reg_info;
                            }else{
                                echo "请输入合法的手机号";
                            }
                        }else{
                            echo "请输入看起来合法的邮箱";
                        }
                    }else{
                        echo "密码请同时包含6-18位英文大小写及数字！";
                    }
                }else{
                    echo "禁止必填选项为空";
                }
            }else{
                unset($_SESSION['vcode']);
                echo "验证码错误！";
            }
            break;
        
        case 'checkuserinfo':
            //检测注册是否重名
            if($_REQUEST['temp_type'] == 'tempid'){
                // echo checkuserinfo_func($temp_id=$_REQUEST['temp_id'],null,$temp_type=$_REQUEST['temp_type']);
                echo checkuserinfo_func($temp_id=$_REQUEST['temp_id'],null,$temp_type=$_REQUEST['temp_type']);
            }elseif($_REQUEST['temp_type'] == 'name'){
                echo checkuserinfo_func(null,$name =$_REQUEST['name']);
            }
            break;
    }
}

function check_tables(){
    $re = exec_sql("select * from users");
    $re_c = exec_sql("select * from client");
    if($re == "" && $re_c == ""){
        create_table();
        echo "初始化成功！";
    }else{
        echo "已存在初始化数据";
    }
}
function login_func($name,$password){
    $info = query_info(null,$username=$name,null,null,$type="login");
    if($info[0] == $password && $password != null){
        $_SESSION['login_user_info'] = $name;
        $_SESSION['isLogin'] = true;
        return "登录成功";
        // header("location:user_info.php");
    }elseif($info == "账户被封禁"){
        return $info;
    }
    else{
        return "登录失败";
    }
}

function register_func($username,$password,$phone,$email,$sex){
    $reg_info = insert_info($username,$password,$phone,$email,$sex);
    return $reg_info;
}

function checkuserinfo_func($temp_id=null,$name=null,$temp_type='name'){
    if($temp_type=="name"){
        $info = query_info(null,$username=$name,null,null,$type="checkuserinfo_name");
    }elseif($temp_type=="tempid"){
        $info = query_info($id=$temp_id,null,null,null,$type="checkuserinfo_id");
    }
    return $info;
}

?>