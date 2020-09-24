<?php
session_start();
include ('mysqli_connect.php');
$userid=$_SESSION['userid'];
$sql="select name from reader_card where reader_id={$userid}";
$res=mysqli_query($dbc,$sql);
$result=mysqli_fetch_array($res);
if ($userid) {
}else{
 echo "<script>
 alert('로그인 정보가 없습니다.다시 로그인해 주세요!')
</script>";
 echo "<a href='index.php'>로그인 화면에 접속하는 데 실패하면 클릭하세요~~</a>";
 header("Refresh:1;url=index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <title>마이 도서관 || 암호수정</title>
    <link rel="stylesheet" media="screen" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body{
            width: 100%;
            height: 100%;
            position: relative;
            background: linear-gradient(-45deg,#ee6654, #e71c6e, #2396d5, #23c5ab);
            background-size: 1000% 1000%;
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
        .box{
            z-index: 2;
            position:absolute;
            width: 350px;
            border-radius: 5px;
            height: auto;
            background: rgba(53, 53, 53, 0.67);
            box-shadow: 0px 0px 5px #333333;
            top: 50%;
            left: 50%;
            margin-top: -200px;
            margin-left: -175px;
            transition: all 1s;
            -moz-transition: all 1s;
            /* Firefox 4 */-webkit-transition: all 1s;	/* Safari 和 Chrome */-o-transition: all 1s;	/* Opera */
            text-align: center;


        }
    </style>
</head>
<body>
<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container-fluid">
        <button type="button" class="navbar-toggle collapsed"
                data-toggle="collapse" data-target="#navbar"
                aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="navbar-header">
            <a class="navbar-brand" href="#">마이 도서관</a>
        </div>
        <div>
            <div  id="navbar" class="collapse navbar-collapse">
        <div>
            <ul class="nav navbar-nav">
                <li ><a href="reader_index.php">홈페이지</a></li>
                <li><a href="reader_querybook.php">도서 조회</a></li>
                <li ><a href="reader_borrow.php">마이 대출</a></li>
                <li><a href="reader_info.php">도서E-Card</a></li>
                <li class="active"><a href="reader_repass.php">암호 수정</a></li>
                <li><a href="reader_qna.php">문의하기</a></li>
                <li ><a href="reader_guashi.php">분실신고</a></li>
                <li><a href="index.php">로그아웃</a></li>
            </ul>
        </div>
    </div>
</nav>
<h3 style="text-align: center"><?php echo $result['name'];  ?>님，안녕하시닙까?</h3><br/>
<div  style="position: relative;top: 35%">


    <div style=" text-align: center ">
        <div class="box">
                <h3>비밀번호 수정</h3><br>

<form action="reader_repass.php" method="post"  style="text-align: center">
    <label><div class="login-center-input"><input type="password" name="pass1" placeholder="뉴 비미번호 입력하시오" class="form-control"><div class="login-center-input-text">뉴 비밀번호</div></div></label><br/><br/><br/>
    <label><div class="login-center-input"><input type="password" name="pass2" placeholder="뉴 비밀번호 확인 하시오" class="form-control"><div class="login-center-input-text">뉴 비밀번호 확인</div></div></label><br/><br/>
    <input type="submit" value="수정" class="btn btn-default">
    <input type="reset" value="리셋"  class="btn btn-default">
</form>
        </div>
    </div>
</div>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $salt="gujiakai";
    $passa = sha1(md5($_POST["pass1"].md5($salt)));
    $passb = sha1(md5($_POST["pass2"].md5($salt)));
if($passa==$passb){
    $sql="update reader_card set passwd='{$passa}' where reader_id={$userid}";
    $res=mysqli_query($dbc,$sql);
    if($res==1)
    {
        echo "<script>alert('수정 성공！다시 로그인하시오！！')</script>";
        echo "<script>window.location.href='index.php'</script>";
    }

}
else{
    echo "<script>alert('두번 입력한 비밀번호 다른다，다시 입력하시오！')</script>";

}

}


?>
</body>
</html>