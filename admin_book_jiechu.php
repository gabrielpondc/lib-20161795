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
$bookid=$_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <title>도서관||도서 대여</title>
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <style>
            body{
                width: 100%;
                height: 100%;
                position: relative;
                background: linear-gradient(-45deg,#ee6654, #e71c6e, #2396d5, #23c5ab);
                background-size: 400% 400%;
                animation: moveBg 12s linear infinite;
                margin-left: auto;
                margin-right: auto;
                color:antiquewhite;
            }
            @keyframes moveBg{
                0%{
                    background-position: 0% 50%;
                }
                50%{
                    background-position: 100% 50%;
                }
                100%{
                    background-position: 0 50%;
                }
            }

    </style>

</head>
<body>
<div style="position: relative;top: 25%">
<div style="text-align: center">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">서적정보 수정</h3>
        </div>
        <div class="panel-body">
<form  action="admin_book_jiechu.php?tsid=<?php echo $bookid; ?>" method="POST" class="bs-example bs-example-form" role="form">
    <div id="login">
        <div class="input-group"><span class="input-group-addon">대출자</span><input  name="borrower" type="text" placeholder="사용자 번호 입력하시오" class="form-control"></div><br><br>
        <input type="submit" value="대출" class="btn btn-default">
    </div>
</form>
</div>
    </div>
</div>
</div>
</body>
</html>
<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $jctsid=$_GET['tsid'];
        $reid=$_POST['borrower'];
        $sqlc="select card_state from reader_card where reader_id={$reid}";
        $resc=mysqli_query($dbc,$sqlc);
        $resultc=mysqli_fetch_array($resc);
        if($resultc['card_state']==1){

            $sqla="insert into lend_list(book_id,reader_id,lend_date,borrow) values ({$jctsid},{$reid},NOW(),0);";
            $sqlb="UPDATE book_info set state=0 where book_id={$jctsid};";
            $resa=mysqli_query($dbc,$sqla);
            $resb=mysqli_query($dbc,$sqlb);
            if($resa==1 && $resb==1)
                echo"<script>alert('대출 성공！');window.location.href='admin_book.php'; </script>";
            else echo"<script>alert('대출 실폐！');window.location.href='admin_book.php'; </script>";
        }
       else echo"<script>alert('이 독자증은 분실되어 대출할 수 없다！');window.location.href='admin_book.php'; </script>";

    };

?>