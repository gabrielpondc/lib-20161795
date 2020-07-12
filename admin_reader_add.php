<?php
session_start();
$userid=$_SESSION['userid'];
include ('mysqli_connect.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>도서관 || 사용자 증가</title>
</head>
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
                <li class="dropdown">
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
                <li class="active" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">사용자 관리<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_reader.php">모든 사용자</a></li>
                        <li><a href="admin_reader_add.php">사용자 증가</a></li>
                    </ul>
                </li>
                <li><a href="admin_borrow_info.php">대출관리</a></li>
                <li><a href="admin_allinfo.php">도서관 정보</a> </li>
                <li><a href="admin_repass.php">암호 수정</a></li>
                <li><a href="index.php">로그아웃</a></li>
            </ul>
        </div>
    </div>
    </div>

</nav>
            <div style="position: relative;top: 25%">
                <div style="text-align: center">
                    <div class="panel panel-primary" style="background: rgba(255,255,255,0.5)">
                        <div class="panel-heading">
                            <h3 class="panel-title">사용자 추가</h3>
                        </div>
                        <div class="panel-body">
    <form  action="admin_reader_add.php" method="POST" style="text-align: center" class="bs-example bs-example-form" role="form">
        <div id="login">
            <div class="input-group"><span class="input-group-addon">사용자 번호</span><input name="nid" type="text" placeholder="사용자 번호 입력하시오" class="form-control"></div><br/>
            <div class="input-group"><span class="input-group-addon">사용자 성명</span><input name="nname" type="text" placeholder="성명 입력하시오" class="form-control"></div><br/>
            <div class="input-group"><span class="input-group-addon">성별 <select id="box2" select name="nsex"><option value="남">남</option><option value="여">여</option><option value="모름">모름</option></select></span></div><br/>
            <div class="input-group"><span class="input-group-addon">생일</span><input name="nbirth" type="date" placeholder="생일 입력하시오" class="form-control"></div><br/>
            <div class="input-group"><span class="input-group-addon">주소</span><input name="naddress" type="text" placeholder="주소 입력하시오" class="form-control"></div><br/>
            <div class="input-group"><span class="input-group-addon">휴데전화</span><input name="ntel" type="text" placeholder="전화 입력하시오" class="form-control"></div><br/>
            <div class="input-group"><span class="input-group-addon">이메일</span><input name="nmail" type="text" placeholder="이메일 입력하시오" class="form-control"></div><br/>
            <input type="submit" value="추가" class="btn btn-default">
            <input type="reset" value="리셋" class="btn btn-default">
        </div>
    </form>
                        </div>
                    </div>
                </div>
                </div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $salt="gujiakai";
    $de=111111;
    $pass=sha1(md5($de.md5($salt)));
    $nnid = $_POST["nid"];
    $nnam= $_POST["nname"];
    $nsex = $_POST["nsex"];
    $nbir= $_POST["nbirth"];
    $nadd= $_POST["naddress"];
    $nnte = $_POST["ntel"];
    $mail = $_POST["nmail"];
    $sqla="insert into reader_info VALUES ($nnid ,'{$nnam}','{$nsex}','{$nbir}','{$nadd}','{$nnte}','{$mail}')";
    $sqlb="insert into reader_card (reader_id,name,passwd) VALUES($nnid ,'{$nnam}','{$pass}');";
    $resa=mysqli_query($dbc,$sqla);
    $resb=mysqli_query($dbc,$sqlb);
    if($resa==1&&$resb==1)
    {
        echo "<script>alert('사용자 추가 성공! 초기 암호 111111')</script>";
        echo "<script>window.location.href='admin_reader.php'</script>";
    }
    else
    {
        echo "<script>alert('추가 실패! 다시 입력하십시오!');</script>";
    }
}
?>
</body>
</html>
