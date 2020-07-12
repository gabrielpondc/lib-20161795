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
    <title>도서관||홈페이지</title>
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
		a{color:#ffffff}
    .box{
        z-index: 2;
        position:relative;
        width: 350px;
        border-radius: 5px;
        height: auto;
        background: rgba(53, 53, 53, 0.67);
        box-shadow: 0px 0px 5px #333333;
        top: 50%;
        left: 50%;
        margin-top: -5px;
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
                <li class="active"><a href="admin_index.php">홈페이지</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">서적 관리<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_book.php">모든 서적</a></li>
                        <li><a href="admin_book_add.php">서적 추가</a></li>
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
                        <li><a href="admin_reader_add.php">사용자 추가</a></li>
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

<div  style="position: relative;top: 25%">
<h3 style="text-align: center"><?php echo $userid;  ?> 호 관리자님，안녕하시니까?</h3><br/><br/><br/>
<div class="box">
<h4 style="text-align: center"><?php
    $sql="select count(*) a from book_info;";
    $res=mysqli_query($dbc,$sql);
    $result=mysqli_fetch_array($res);
    echo "도서관은 현재 도서를{$result['a']}권 보유";
    ?>
</h4>

<h4 style="text-align: center">
    <?php
    $sqla="select count(*) b from reader_card;";
    $resa=mysqli_query($dbc,$sqla);
    $resulta=mysqli_fetch_array($resa);
    echo "사용자는 {$resulta['b']}명 보유";
    ?>
</h4>
<h4 style="text-align: center"><?php
    $sql="select count(*) a from notice;";
    $res=mysqli_query($dbc,$sql);
    $result=mysqli_fetch_array($res);
    echo "발표된 공지상황은 {$result['a']}개 보유";
    ?>
</h4>
<h4 style="text-align: center"><?php
    $sql="select count(*) a from qna;";
    $res=mysqli_query($dbc,$sql);
    $result=mysqli_fetch_array($res);
    echo "지금 문의는 {$result['a']}개 보유";
    ?>
</h4>
<h5 style="text-align: center;color: #f94040"><?php
$sql="select count(*) b from qna where admin_id=0001;";
$res=mysqli_query($dbc,$sql);
$result=mysqli_fetch_array($res);
echo "미처리 문의는 {$result['b']}개 보유"; ?></h5>

<h4>오늘 생일 사용자</h4>
<table  width='100%' class="table">
 <div style="text-align: center">
    <tr>
        <th>사용자 번호</th>
        <th>성함</th>
        <th>생일</th>
        <th>이메일</th>

    </tr>
    <?php

        $sql="select reader_id,name,birth,email from reader_info where MONTH(birth) = MONTH(NOW()) and DAY(birth) = DAY(NOW());";


    $res=mysqli_query($dbc,$sql);
    foreach ($res as $row){
        echo "<tr>";
        echo "<td>{$row['reader_id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['birth']}</td>";
        echo "<td><a href=\"mailto:{$row['email']}\">{$row['email']}</a></td>";
        echo "</tr>";
    };
    ?>
</table>
</div>
</div>
</div>

</body>
</html>
