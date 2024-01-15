<?
function verify_passwd($str){
    $pass_reg = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{6,18}/";
    $result = preg_match($pass_reg,$str);
    return $result;
}

function verify_email($str){
    $email_reg = "/^\w{1,63}@[a-zA-Z0-9-]{1,63}(\.[A-Za-z]{2,3}){1,2}$/";
    $result = preg_match($email_reg,$str);
    return $result;
}

function verify_phone($str){
    $phone_reg="/^(13[0-9]|14[01456879]|15[0-35-9]|16[2567]|17[0-8]|18[0-9]|19[0-35-9])\d{8}$/";
    $result = preg_match($phone_reg,$str);
    return $result;
}

?>