<?php
function mysqli_conn($ip="192.168.88.129",$username='root',$password='123456',$database='test',$port=3306){
    $conn = mysqli_connect($ip,$username,$password,$database,$port);
    mysqli_query($conn,"set names utf8");
    return $conn;
}

function create_table(){
    $sql_user = "create table users(
        id int primary key auto_increment,
        username char(30) unique,
        password char(30),
        phone char(30),
        email char(50),
        sex char(6),
        images char(100),
        lv int(1) not null,
        state char(8) not null
    ) character set utf8;";
    $sql_client = "create table client(
        id int primary key auto_increment,
        clientname char(30),
        phone char(30),
        email char(50),
        sex char(6),
        mastername char(30)
    ) character set utf8;";
    $sql_admin = "insert into users values(1,'admin','123456','13111111111','111@qq.com','男','../assets/images/avatar.png',1,'enable');";
    $sql_admin_client = "insert into client values(1,'张三','13111111111','111@qq.com','男','admin');";
    exec_sql($sql_user);
    exec_sql($sql_admin);
    exec_sql($sql_client);
    exec_sql($sql_admin_client);
}

function exec_sql($sql){
    $conn = mysqli_conn();
    $re = mysqli_query($conn,$sql);
    return $re;
}
function insert_info($username,$password,$phone,$email,$sex){
    $default_img = '/StuSYS/assets/images/avatar/avatar.png';
    $sql = "insert into users values(default,'$username','$password','$phone','$email','$sex','$default_img',0,'enable');";
    $re = exec_sql($sql);
    if($re){
        return "succes";
    }else{
        return $re;
    }
}

function query_info($id=null,$username=null,$phone=null,$email=null,$type=null){
    switch($type){
        case "login":
            $sql = "select state from users where username = '$username';";
            $res = exec_sql($sql);
            $state_info = mysqli_fetch_row($res)[0];
            if($state_info=="enable"){
                $sql = "select password from users where username = '$username';";
                $res = exec_sql($sql);
                return mysqli_fetch_row($res);
            }elseif($state_info=="disable"){
                return "账户被封禁";
            }
        case "checkuserinfo_name":
            $sql = "select * from users where username = '$username';";
            $res = exec_sql($sql);
            return mysqli_fetch_row($res);
        case "checkuserinfo_id":
            $sql = "select * from users where id = '$id';";
            $res = exec_sql($sql);
            return mysqli_fetch_row($res);
        case "checkuserinfo_phone":
            $sql = "select * from users where phone = '$phone';";
            $res = exec_sql($sql);
            return mysqli_fetch_all($res);
        case "checkuserinfo_email":
            $sql = "select * from users where email = '$email';";
            $res = exec_sql($sql);
            return mysqli_fetch_all($res);
        case "find_all":
            $sql = "select * from users;";
            $res = exec_sql($sql);
            return mysqli_fetch_all($res);
    }
}

function del_info($str=null,$type){
    if($type=="id"){
        $query_sql = "select lv from users where id= $str ;";
    }elseif($type=="username"){
        $query_sql = "select lv from users where username= '$str' ;";
    }
    $user_lv = end(mysqli_fetch_row(exec_sql($query_sql)));
    if($user_lv==0){
        if($type=="id"){
            $query_sql = "select lv from where id= '$str' ;";
            
            $sql = "delete from users where id= '$str' ;";
        }elseif($type=="username"){
            $query_sql = "select lv from where username= '$str' ;";
            $sql = "delete from users where username= '$str' ;";
        }
        $info = exec_sql($sql);
        return $info;
    }else{
        return "暂无权限"; 
    }

}

function block_user($id,$type){
    $sql = "update users set state='$type' where id = '$id';";
    $info = exec_sql($sql);
    return $info;
}

function edit_userinfo($username,$password,$phone,$email,$sex,$state){
    $re_sql = "select * from users where username='$username';";
    $temp_info = mysqli_fetch_row(exec_sql($re_sql));
    if($temp_info){
        $sql = "update users set password='$password',phone='$phone',email='$email',sex='$sex',state='$state' where username='$username';";
        $temp_info =exec_sql($sql);
        return $temp_info;
    }
}

function edit_userinfo_user($username,$password,$phone,$email,$sex){
    $re_sql = "select * from users where username='$username';";
    $temp_info = mysqli_fetch_row(exec_sql($re_sql));
    if($temp_info){
        $sql = "update users set password='$password',phone='$phone',email='$email',sex='$sex' where username='$username';";
        $temp_info =exec_sql($sql);
        return $temp_info;
    }
}

function update_user_avatar($temp_id,$newstr){
    $sql = "update users set images='$newstr' where id = '$temp_id';";
    $info = exec_sql($sql);
    return $info;
}

//客户
function find_all_client($str){
    $sql = "select client.* from users,client WHERE users.username= client.mastername and client.mastername='$str';";
    $info = exec_sql($sql);
    return $info;
}
function find_one_client($id,$username,$phone,$email,$type){
    if($type=="id"){
        $sql = "select mastername from client where id='$id';";
    }elseif($type=="clientname"){
        $sql = "select mastername from client where clientname='$username';";
    }elseif($type=="all"){
        $sql = "select mastername from client where clientname='$username' and phone='$phone' and email='$email';";
    }
    $info = exec_sql($sql);
    return $info;
}
function del_clientinfo($id){
    $sql = "delete from client where id= '$id' ;";
    $info = exec_sql($sql);
    return $info;
}

function edit_client_info($temp_username,$username,$phone,$email,$sex){
    $re_sql = "select * from client where clientname='$temp_username';";
    $temp_info = mysqli_fetch_row(exec_sql($re_sql));
    if($temp_info){
        $sql = "update client set clientname='$username',phone='$phone',email='$email',sex='$sex' where clientname='$temp_username';";
        $temp_info =exec_sql($sql);
        return $temp_info;
    }
}

function add_client_info($username,$phone,$email,$sex,$mastername){
    $sql = "insert into client value(DEFAULT,'$username','$phone','$email','$sex','$mastername');";
    $temp_info =exec_sql($sql);
    return $temp_info;
}
?>