<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>공지 삭제</title>
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
$sqla="select count(*) a from qna where qna_id={$delid};";
$resa=mysqli_query($dbc,$sqla);
$resulta=mysqli_fetch_array($resa);

if($resulta['a']==1) {
    $sql = "delete  from qna where qna_id={$delid} ;";
    $res = mysqli_query($dbc, $sql);

    if ($res == 1) {
        echo "<script>alert('삭제 성공！')</script>";
        echo "<script>window.location.href='admin_qna.php'</script>";
    }
    else {
        echo "삭제 실패！";
        echo "<script>window.location.href='admin_qna.php'</script>";
    }
}
else {
    echo "<script>alert('이 질문를 삭제할 수 없습니다！')</script>";
    echo "<script>window.location.href='admin_qna.php'</script>";
}

?>
