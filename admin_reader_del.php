<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
</body>
</html>
<?php
session_start();
$userid=$_SESSION['userid'];
if ($userid) {
}else{
 echo "<script>
 alert('로그인 정보가 없습니다.다시 로그인해 주세요!')
</script>";
 echo "<a href='index.php'>로그인 화면에 접속하는 데 실패하면 클릭하세요~~</a>";
 header("Refresh:1;url=index.php");
}
include ('mysqli_connect.php');
$delid=$_GET['id'];
$sqla="select count(*) a from lend_list where reader_id={$delid} and back_date is NULL;";
$resa=mysqli_query($dbc,$sqla);
$resulta=mysqli_fetch_array($resa);
if($resulta['a']==0) {
    $sqla = "delete  from reader_card where reader_id={$delid} ;";
    $sqlb = "delete  from reader_info where reader_id={$delid} ;";
    $resa = mysqli_query($dbc, $sqla);
    $resb = mysqli_query($dbc, $sqlb);
    if ($resa == 1 && $resb == 1) {
        echo "<script>alert('삭제 성공!')</script>";
        echo "<script>window.location.href='admin_reader.php'</script>";
    }
    else {
        echo "삭제 실폐!";
        echo "<script>window.location.href='admin_reader.php'</script>";
    }
}
else {
    echo "<script>alert('사용자 삭제할 수 없다！')</script>";
    echo "<script>window.location.href='admin_reader.php'</script>";
}

?>
