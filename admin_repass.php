<?php
session_start();
include ('mysqli_connect.php');
$userid=$_SESSION['userid'];
if ($userid) {
}else{
 echo "<script>
 alert('로그인 정보가 없습니다.다시 로그인해 주세요!')
</script>";
 echo "<a href='index.php'>로그인 화면에 접속하는 데 실패하면 클릭하세요~~</a>";
 header("Refresh:1;url=index.php");
}
$sql="select name from reader_card where reader_id={$userid}";
$res=mysqli_query($dbc,$sql);
$result=mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <title>도서관 || 관리자 비밀번호 수정</title>
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
        .box{
            z-index: 2;
            position:absolute;
            width: 350px;
            border-radius: 5px;
            height: 250px;
            background: rgba(53, 53, 53, 0.67);
            box-shadow: 0px 0px 5px #333333;
            top: 50%;
            left: 50%;
            margin-top: -140px;
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
            <a class="navbar-brand" href="#">도서관 관리 시스템</a>
        </div>
        <div>
            <div  id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li ><a href="admin_index.php">홈페이지</a></li>
                <li class="dropdown" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">서적 관리<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_book.php">모든 서적</a></li>
                        <li><a href="admin_book_add.php">서적 증가</a></li>
                    </ul>
                </li>
                <li class="dropdown" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">공지 관리<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_notice.php">모든 공지</a></li>
                        <li><a href="admin_notice_add.php">공지 추가</a></li>
                    </ul>
                <li  ><a href="admin_qna.php">질문 관리</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">사용자 관리<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_reader.php">모든 사용자</a></li>
                        <li><a href="admin_reader_add.php">사용자 증가</a></li>
                    </ul>
                </li>
                <li><a href="admin_borrow_info.php">대출관리</a></li>
                <li><a href="admin_allinfo.php">도서관 정보</a> </li>
                <li><li class="active"><a href="admin_repass.php">암호 수정</a></li>
                <li><a href="index.php">로그아웃</a></li>
            </ul>
        </div>
    </div>
    </div>

</nav>
<h3 style="text-align: center"><?php echo $userid;  ?>호 관리자，안녕하시니까?</h3><br/>
<div  style="position: relative;top: 25%">
    <div style=" text-align: center ">
        <div class="box">
                <h3>비밀번호 수정</h3><br>

<form action="admin_repass.php" method="post"  style="text-align: center">
    <label><div class="login-center-input"><input type="password" name="pass1" placeholder="뉴 비미번호 입력하시오" class="form-control"><div class="login-center-input-text">뉴 비밀번호</div></div></label><br/><br/><br/>
    <label><div class="login-center-input"><input type="password" name="pass2" placeholder="뉴 비밀번호 확인 하시오" class="form-control"><div class="login-center-input-text">뉴 비밀번호 확인</div></div></label><br/><br/>
    <input type="submit" value="확인" class="btn btn-default">
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
        $sql="update admin set password='{$passa}' where admin_id={$userid}";
        $res=mysqli_query($dbc,$sql);
        if($res==1)
        {
            echo "<script>alert('수정 성공！다시 로그인하시오！')</script>";
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