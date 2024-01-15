<?php
include "mysql_util.php";
include "session.php";
include_once "util.php";

if(empty($_SESSION['isLogin'])){
    header("Location:/StuSYS/login.php");
}
if(isset($_REQUEST['action'])){
    switch($_REQUEST['action']){
        case 'deluserinfo':
            if(checkuserinfo_func(null,$name = $_SESSION['login_user_info'])[0]!=$_POST['id']){
                if(!empty($_POST['id'])){
                    echo del_user_info($id = $_POST['id']);
                }else{
                    echo "禁止为空";
                }
            }else{
                echo "你要自杀！";
            }
            break;
        case 'blockuser':
            if(checkuserinfo_func(null,$name = $_SESSION['login_user_info'])[0]!=$_POST['id']){
                if(!empty($_POST['id'])){
                    echo block_user_info($_POST['id'],$_POST['type']);
                }else{
                    echo "禁止为空";
                }
            }else{
                echo "你要自杀！";
            }
            break;
        case 'editinfo':
            if(!empty($_POST['temp_username']) && !empty($_POST['password']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['state'])){
                if(verify_passwd($_REQUEST['password'])==1 && strlen($_REQUEST['password']) > 5 && strlen($_REQUEST['password']) < 19){
                    if(verify_email($_REQUEST['email'])==1){
                        if(verify_phone($_REQUEST['phone'])==1){
                            $info = edit_userinfo_func($_POST['temp_username'],$_POST['password'],$_POST['phone'],$_POST['email'],$_POST['sex'],$_POST['state']);
                            echo $info;
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
                echo "禁止为空";
            }
            break;
        case 'user_editinfo':
            if(!empty($_POST['temp_username']) && !empty($_POST['password']) && !empty($_POST['phone']) && !empty($_POST['email'])){
                if(verify_passwd($_REQUEST['password'])==1 && strlen($_REQUEST['password']) > 5 && strlen($_REQUEST['password']) < 19){
                    if(verify_email($_REQUEST['email'])==1){
                        if(verify_phone($_REQUEST['phone'])==1){
                            $reg_info = edit_userinfo_func_user($_POST['temp_username'],$_POST['password'],$_POST['phone'],$_POST['email'],$_POST['sex']);
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
                echo "禁止为空";
            }
            break;
        case 'search_info':
            if(!empty($_POST['temp_str']) && !empty($_POST['temp_type'])){
                $info = search_userinfo($_POST['temp_str'],$_POST['temp_type']);
                echo json_encode($info);
            }else{
                echo "禁止为空";
            }
            break;
        case 'removeclientinfo':
            if(!empty($_POST['temp_id'])){
                echo del_client_info($id = $_POST['temp_id']);
            }else{
                echo "禁止为空";
            }
            break;
        case 'editclientinfo':
            if(!empty($_POST['temp_username']) && !empty($_POST['username']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['sex'])){
                if(verify_email($_REQUEST['email'])==1){
                    if(verify_phone($_REQUEST['phone'])==1){
                        $info = edit_clientinfo_func($_POST['temp_username'],$_POST['username'],$_POST['phone'],$_POST['email'],$_POST['sex']);
                        echo $info;
                    }else{
                        echo "请输入合法的手机号";
                    }
                }else{
                    echo "请输入看起来合法的邮箱";
                }
            }else{
                echo "禁止为空";
            }
            break;
        case 'addclientinfo':
            if(!empty($_POST['username']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['sex'])){
                if(verify_email($_REQUEST['email'])==1){
                    if(verify_phone($_REQUEST['phone'])==1){
                        $info = add_clientinfo_func($_POST['username'],$_POST['phone'],$_POST['email'],$_POST['sex']);
                        echo $info;
                    }else{
                        echo "请输入合法的手机号";
                    }
                }else{
                    echo "请输入看起来合法的邮箱";
                }
            }else{
                echo "禁止为空";
            }
            break;
        default:
            break;
    }

}

function checkuserinfo_func($temp_id=null,$name=null,$temp_type='name'){
    if($temp_type=="name"){
        $info = query_info(null,$username=$name,null,null,$type="checkuserinfo_name");
    }elseif($temp_type=="tempid"){
        $info = query_info($id=$temp_id,null,null,null,$type="checkuserinfo_id");
    }
    return $info;
}

function find_all_user_info(){
    $info = query_info(null,null,null,null,"find_all");
    return $info;
}


function del_user_info($id=null,$username=null){
    if($id && $username==null){
        $info = del_info($id,"id");
        if($info == 1){
            return $id."已删除";
        }else{
            return $info;
        }
    }elseif($username && $id==null){
        $info = del_info($username,"username");
        if($info == 1){
            return $username."已删除";
        }else{
            return $info;
        }
    }else{
        return "请检查输入";
    }
    
}

function block_user_info($id,$type){
    if($type == "block"){
        $info = block_user($id,"disable");
    }elseif($type == "active"){
        $info = block_user($id,"enable");
    }
    return $info;
}

function edit_userinfo_func($username,$password,$phone,$email,$sex,$state){
    if(isset($username,$password,$phone,$email,$sex,$state)){
        $info = checkuserinfo_func(null,$_SESSION['login_user_info']);
        if($username == $_SESSION['login_user_info'] || $info[7] ==1 ){
            $info = edit_userinfo($username,$password,$phone,$email,$sex,$state);
            if($info==1){
                return "修改成功";
            }else{
                return "修改失败";
            }
        }else{
            return "暂无权限修改";
        }
    }else{
        return "禁止为空";
    }
}
function edit_userinfo_func_user($username,$password,$phone,$email,$sex){
    if(isset($username,$password,$phone,$email,$sex)){
        $info = checkuserinfo_func(null,$_SESSION['login_user_info']);
        if($username == $_SESSION['login_user_info'] || $info[7] ==1 ){
            $info = edit_userinfo_user($username,$password,$phone,$email,$sex);
            if($info==1){
                return "修改成功";
            }else{
                return "修改失败";
            }
        }else{
            return "暂无权限修改";
        }
    }else{
        return "禁止为空";
    }
}

function search_userinfo($temp_str,$temp_type){
    switch($temp_type){
        case 'id';
            $info = query_info($temp_str,null,null,null,'checkuserinfo_id');
            $info = [$info];
            break;
        case 'username';
            $info = query_info(null,$temp_str,null,null,'checkuserinfo_name');
            $info = [$info];
            break;
        case 'phone';
            $info = query_info(null,null,$temp_str,null,'checkuserinfo_phone');
            break;
        case 'email';
            $info = query_info(null,null,null,$temp_str,'checkuserinfo_email');
            break;
        default:
            break;
    }
    return $info;
}

function update_useravatar($temp_id,$newstr){
    $info = update_user_avatar($temp_id,$newstr);
    return $info;
}


//客户
function find_all_client_info($str){
    $info = find_all_client($str);
    return mysqli_fetch_all($info);
}

function del_client_info($id){
    $tmp = find_one_client($id,null,null,null,"id");
    $info = mysqli_fetch_row($tmp);
    if($info[0]==$_SESSION['login_user_info']){
        $info = del_clientinfo($id);
        if($info == 1){
            return "id:".$id."客户已删除";
        }else{
            return $info;
        }
    }else{
        return "无权删除其他用户的客户信息！"; 
    }
}

function edit_clientinfo_func($temp_username,$username,$phone,$email,$sex){
    $tmp = find_one_client(null,$temp_username,null,null,"clientname");
    $info = mysqli_fetch_row($tmp);
    if($info[0]==$_SESSION['login_user_info']){
        $info = edit_client_info($temp_username,$username,$phone,$email,$sex);
        if($info==1){
            return "修改成功";
        }else{
            return "修改失败";
        }
    }else{
        return "禁止越权修改！";
    }
}

function add_clientinfo_func($username,$phone,$email,$sex){
    $tmp = find_one_client(null,$username,$phone,$email,"all");
    $info = mysqli_fetch_row($tmp);
    if($info){
        return "用户已存在";
    }else{
        $info = add_client_info($username,$phone,$email,$sex,$_SESSION['login_user_info']);
        if($info==1){
            return "添加成功";
        }else{
            return "添加失败";
        }
    }
}

?>