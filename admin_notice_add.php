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
?>
<!DOCTYPE html>
<html lang="kr">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>도서관 || 공지 추가</title>
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
        <div>
            <ul class="nav navbar-nav">
                <li ><a href="admin_index.php">홈페이지</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">서적 관리<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_book.php">모든 서적</a></li>
                        <li><a href="admin_book_add.php">서적 증가</a></li>
                    </ul>
                <li class="active" class="dropdown" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">공지 관리<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_notice.php">모든 공지</a></li>
                        <li><a href="admin_notice_add.php">공지 추가</a></li>
                    </ul>
                <li  ><a href="admin_qna.php">질문 관리</a></li>
                </li>
                </li>
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
                <li><a href="admin_repass.php">암호 수정</a></li>
                <li><a href="index.php">로그아웃</a></li>
            </ul>
        </div>
    </div>
        </div>
    </div>

</nav>

<div  style="position: relative;top: 25%">
    <div style="text-align: center">
        <div class="panel panel-primary" style="background: rgba(255,255,255,0.51)">
            <div class="panel-heading">
                <h3 class="panel-title">공지 증가</h3>
            </div>
            <div class="panel-body">
                <form  action="admin_notice_add.php" method="POST" style="text-align: center" class="bs-example bs-example-form" role="form">
                    <div id="login">
                        <div class="input-group"><span class="input-group-addon">제목</span><input name="nname" type="text" placeholder="제목 입력하시오" class="form-control"></div><br/>
                        <div class="input-group"><span class="input-group-addon">시간</span><input name="ntime" type="text" value="<?php echo $showtime=date("Y-m-d H:i:s");?>" class="form-control"></div><br/>
                        <div class="input-group"><span class="input-group-addon">내용</span><textarea name="ncontent" rows="4" placeholder="내용 입력하시오" class="form-control" style="resize: none;"></textarea></div><br/>
                        <div class="input-group"><span class="input-group-addon">구분<select id="box" select name="nclass"><option value="1">공지</option><option value="2">광고</option><option value="3">이벤트</option><option value="4">뉴스</option></select></span> </div><br/>

                        <label><input type="submit" value="추가" class="btn btn-default"></label>
                        <label><input type="reset" value="리셋" class="btn btn-default"></label>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nnam = $_POST["nname"];
        $nt = $_POST["ntime"];
        $nco = $_POST["ncontent"];
        $nc = $_POST["nclass"];




        $sqla="insert into notice VALUES (NULL ,'{$nnam}','{$nt}','{$nco}',{$nc})";
        $resa=mysqli_query($dbc,$sqla);


        if($resa==1)
        {
            echo "<script>alert('추가 성공！')</script>";
            echo "<script>window.location.href='admin_notice.php'</script>";
        }
        else
        {
            echo "<script>alert('추가 실패! 다시 입력해주세요！');</script>";
        }
    }
    ?>
</body>
</html>
