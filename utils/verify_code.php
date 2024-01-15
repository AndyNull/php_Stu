<?
    session_start();
    // unset($_SESSION['vcode']);
    get_vcode();
    function get_vcode($vlen=4,$width=80,$height=25){
        header("content-type:image/png");
        $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHUJKLMNOPQRSTUVWXYZ0123456789';
        $vcode = substr(str_shuffle($char),0,$vlen);
        $_SESSION['vcode'] = $vcode;
        $image = imagecreate($width,$height);
        imagecolorallocate($image,200,200,100);

        $color = imagecolorallocate($image,0,0,0);
        imagestring($image,5,20,5,$vcode,$color);

        for($i=0;$i<50;$i++){
           imagesetpixel($image,rand(0,$width),rand(0,$height),$color);
        }
        imagepng($image);
        imagedestroy($image);
    }


?>