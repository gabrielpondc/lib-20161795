<?php

session_start();
$userid=$_SESSION['userid'];
include ('mysqli_connect.php');
if ($userid) {
}else{
 echo "<script>
 alert('로그인 정보가 없습니다.다시 로그인해 주세요!')
</script>";
 echo "<a href='index.php'>로그인 화면에 접속하는 데 실패하면 클릭하세요~~</a>";
 header("Refresh:1;url=index.php");
}
$state=$_GET['id'];

if($state==1){
    $sql="update reader_card set card_state=0 where reader_id={$userid}";
    $res=mysqli_query($dbc,$sql);

    if($res==1)
    {
        echo"<script>alert('분실 성공！')</script>";
        echo "<script>window.location.href='reader_guashi.php'</script>";
    }
    else
    {
        echo"<script>alert('분실 실폐！')</script>";
        echo "<script>window.location.href='reader_guashi.php'</script>";
    }

}
else{

    $sqla="update reader_card set card_state=1 where reader_id={$userid}";
    $resa=mysqli_query($dbc,$sqla);

    if($resa==1)
    {
        echo"<script>alert('분실 취소 성공！')</script>";
        echo "<script>window.location.href='reader_guashi.php'</script>";
    }
    else
    {
        echo"<script>alert('분실 취소 실폐！관리자게 연락하시오')</script>";
        echo "<script>window.location.href='reader_guashi.php'</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

</body>
</html>
