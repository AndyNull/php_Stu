<?php
#设置时间
date_default_timezone_set("PRC");
#获取文件相关参数
$name = $_FILES['filename']['name'];
$type = $_FILES['filename']['type'];
$tmp_name = $_FILES['filename']['tmp_name'];
$size = $_FILES['filename']['size'];
$temp_id = $_POST['temp_id'];
include './db.php';
#设置后缀允许白名单
$type_arr = ['image/jpeg','image/png','image/jpeg','image/gif'];
if(!in_array($type,$type_arr)){
    die("不允许当前文件类型");
}

#获取文件扩展
$newfilename = date("ymdHis").rand(100,999).".".end(explode(".",$name));
update_avatar($newfilename,$tmp_name,$temp_id);

function update_avatar($newfilename,$tmp_name,$temp_id){
    $dir = "/opt/lampp/htdocs";
    $newstr = "/StuSYS/assets/images/avatar/$newfilename";
    move_uploaded_file($tmp_name,$dir.$newstr);
    if(file_exists($dir.$newstr)){
        $imgurl = search_userinfo($temp_id,'id')[0][6];
        del_avatar($dir.$imgurl);
        $info = update_useravatar($temp_id,$newstr);
        if($info == 1){
            echo "success";
        }
    }else{
        echo "fail";
    }
}
function del_avatar($filename){
    @unlink($filename);
}




// // @unlink("../assets/images/$name");
// echo file_write(file_read($tmp_name,$size),$name);

// function file_read($tmp_name,$size){
//     $f = fopen($tmp_name,"r");
//     $info = fread($f,$size);
//     return $info;
// }

// function file_write($strs,$name){
//     $f = fopen("../assets/images/$name","w");
//     fwrite($f,$strs);
//     if(!file_exists("../assets/images/$name")){
//         return "fail";
//     }else{
//         return "succes";
//     }
// }

?>