<?php
// 应用公共文件
use think\Session;
//判断是否登录
function check_login_common(){
    if (!Session::get('user_id')){
        Session::delete('err_msg');
        return false;
    }
    return true;
}

function succeed_msg($message='操作成功'){
    $result['statusCode']="200";
    $result['closeCurrent']="true";
    $result['message']=$message;
    return json_encode($result);
}

function error_msg($message='操作失败'){
    $result['statusCode']="300";
    $result['closeCurrent']="false";
    $result['message']=$message;
    return json_encode($result);
}

function verifyCodeImg($width=120,$height=40,$size=20){
    $az = array('q', 'w', 'r', 't', 'y', 'p', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'th', 'wr');
    $aa = array('a', 'e', 'u','7','8','6','5','4');
    $len = rand(4,6);
    $str = '';

    for ($i = 2; $i <= $len; $i++) {
        if ($i % 2 == 0) {
            $c = strtoupper($az[rand(0, 19)]);
            $str = $str . $c;
        } else {
            $c = strtoupper($aa[rand(0, 7)]);
            $str = $str . $c;
        }
    }
    // put it to session
    $_SESSION['c'] = $str;

    // create the image
    //       $fn = PREFIX . '/htdocs/static/res/wbg' . rand(1,5) . '.png';
//        $im = imagecreatefrompng($fn);
    $im = imagecreatetruecolor($width, $height);
    $color = imagecolorallocate($im, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
    imagefilledrectangle($im,0,$height,$width,0,$color);

    // create some colors
    $fg = imagecolorallocate($im, 240, 240, 230);
    $bg = imagecolorallocate($im, 120, 140, 190);
    $bbg = imagecolorallocate($im, 20, 40, 40);

    $fonts = array(0 => 'zt', 1 => 'cgn', 2 => 'carbon', 3=>'Tuffy', 4=>'luixisbi');
    $font = PREFIX . '/htdocs/static/fonts/' . $fonts[rand(0,3)] . '.ttf';

    // add some shadow to the text
    $x = rand(10, 30);

    // add the text
    imagettftext($im, $size, 0, $x+2, 32, $bg, $font, $str);
    imagettftext($im, $size, 0, $x+1, 31, $bg, $font, $str);
    imagettftext($im, $size, 0, $x-1, 29, $bg, $font, $str);
    imagettftext($im, $size, 0, $x-2, 28, $bbg, $font, $str);
    imagettftext($im, $size, 0, $x, 30, $fg, $font, $str);

    for($i=0; $i<5; ++$i){
        $x = rand(0, 100);
        $y = rand(0, 40);
        $x1 = rand(0, 100);
        $y1 = rand(0, 40);
        imageline($im, $x, $y, $x1, $y1, $bbg);
    }

    imagepng($im);
}