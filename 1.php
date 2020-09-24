<?php
    $salt="gujiakai";
    $de=111111;
    $pass=sha1('e20871b5fa568c8b10c2363cbf51287a');
echo $pass;
header("Content-type:text/html;charset=utf-8");
// 测试PHP执行python代码
$a = 50000015;
$b = 8;
$c = 'Davidszhou的PHP操作带参数的python脚本并返回结果';
$d = urlencode($c);
unset($out);
$path="C:\Users\GabrielPondC\Desktop\web\library";
#$c = exec("python C:\\Users\\GabrielPondC\\Desktop\\dsrw.py",$out,$res);
echo "<br>";
echo "<br>";
echo"$c";
echo '外部程序运行是否成功:'.$res."(0代表成功,1代表失败)";

?>
