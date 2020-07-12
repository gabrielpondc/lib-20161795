<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>

</body>
</html>
<?php
include ('mysqli_connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $salt="gujiakai";
    $acco = $_POST["account"];
    $pw = sha1(md5($_POST["pass"].md5($salt)));
}
$adsql="select * from admin where admin_id={$acco} and password='{$pw}'";
$adres=mysqli_query($dbc,$adsql);
$resql="select * from reader_card where reader_id={$acco} and passwd='{$pw}'";
$reres=mysqli_query($dbc,$resql);
if(mysqli_num_rows($adres)==1 ){
    session_start();
    $_SESSION['userid']=$acco;
    echo "<script>window.location='admin_index.php'</script>";

}
else if(mysqli_num_rows($reres)==1){

    session_start();
    $_SESSION['userid']=$acco;
    echo "<script>window.location='reader_index.php'</script>";
}
else
{
    echo "<script>alert('사용자 아이디 또는 암호가 잘못되었으므로 다시 입력하십시오');window.location='index.php'
   ;</script>";

}


?>