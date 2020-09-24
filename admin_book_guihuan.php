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
$bookid=$_GET['id'];
date_default_timezone_set("Asia/Seoul");
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <title>도서관 || 도서 반납</title>
        <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
    </body>
    </html>



<?php
$sqle="select sernum from  lend_list where book_id={$bookid} and borrow=0";
$rese=mysqli_query($dbc,$sqle);
$resulte=mysqli_fetch_array($rese);
$sqlc="UPDATE lend_list set back_date=NOW(),borrow=1 where sernum={$resulte['sernum']};";
$sqld="UPDATE book_info set state=1 where book_id={$bookid};";
$resc=mysqli_query($dbc,$sqlc);
$resd=mysqli_query($dbc,$sqld);
if($resc==1 && $resd==1)
    echo"<script>alert('반납 성공！');window.location.href='admin_book.php'; </script>";
else echo"<script>alert('반납 실폐！');window.location.href='admin_book.php'; </script>";
?>