<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>도서 삭제</title>
</head>
<body>

</body>
</html>
<?php
session_start();
$userid=$_SESSION['userid'];
include ('mysqli_connect.php');


$delid=$_GET['id'];
$sqla="select state a from book_info where book_id={$delid};";
$resa=mysqli_query($dbc,$sqla);
$resulta=mysqli_fetch_array($resa);

if($resulta['a']==1) {
    $sql = "delete  from book_info where book_id={$delid} ;";
    $res = mysqli_query($dbc, $sql);

    if ($res == 1) {
        echo "<script>alert('삭제 성공！')</script>";
        echo "<script>window.location.href='admin_book.php'</script>";
    }
    else {
        echo "삭제 실패！";
        echo "<script>window.location.href='admin_book.php'</script>";
    }
}
else {
    echo "<script>alert('이 도서를 삭제할 수 없습니다！')</script>";
    echo "<script>window.location.href='admin_book.php'</script>";
}

?>
