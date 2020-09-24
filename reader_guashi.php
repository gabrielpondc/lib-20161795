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
$sql="select name from reader_card where reader_id={$userid}";
$res=mysqli_query($dbc,$sql);
$result=mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <title>마이 도서관 || 분실신고</title>
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            outline: none;
        }


        .btn {
            border: none;
            color: white;
            overflow: hidden;
            margin: 1rem;
            padding: 0;
            text-transform: uppercase;
            width: 150px;
            height: 40px;
        }
        .btn.color-1 {
            background-color: #426fc5;
        }
        .btn.color-2 {
            background-color: #00897b;
        }
        .btn.color-3 {
            background-color: #f6774f;
        }
        .btn.color-4 {
            background-color: #e94043;
        }

        .btn-border.color-1 {
            background-color: transparent;
            border: 2px solid #426fc5;
            color: #426fc5;
        }
        .btn-border.color-2 {
            background-color: transparent;
            border: 2px solid #00897b;
            color: #00897b;
        }
        .btn-border.color-3 {
            background-color: transparent;
            border: 2px solid #f6774f;
            color: #f6774f;
        }
        .btn-border.color-4 {
            background-color: transparent;
            border: 2px solid #e94043;
            color: #e94043;
        }

        .btn-round {
            border-radius: 10em;
        }

        .material-design {
            position: relative;
        }
        .material-design canvas {
            opacity: 0.25;
            position: absolute;
            top: 0;
            left: 0;
        }


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
            margin-top: -5px;
            margin-left: -175px;
            transition: all 1s;
            -moz-transition: all 1s;
            /* Firefox 4 */-webkit-transition: all 1s;	/* Safari 和 Chrome */-o-transition: all 1s;	/* Opera */
            text-align: center;


        }
    </style>
    <script src="js/prefixfree.min.js"></script>

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
            <ul class="nav navbar-nav">
                <li ><a href="reader_index.php">홈페이지</a></li>
                <li><a href="reader_querybook.php">도서 조회</a></li>
                <li ><a href="reader_borrow.php">마이 대출</a></li>
                <li><a href="reader_info.php">도서E-Card</a></li>
                <li><a href="reader_repass.php">암호 수정</a></li>
                <li><a href="reader_qna.php">문의하기</a></li>
                <li class="active"><a href="reader_guashi.php">분실신고</a></li>
                <li><a href="index.php">로그아웃</a></li>
            </ul>
        </div>
    </div>
    </div>
</nav>

<h3 style="text-align: center"><?php echo $result['name'];  ?>님，안녕하십니까?</h3><br/>
<div  style="position: relative;top: 25%">
    <div class="box">
<h4 style="text-align: center">당신 사용 상태는：<br/>
<?php


$sqla="select card_state from reader_card where reader_id={$userid} ;";

$resa=mysqli_query($dbc,$sqla);
$resulta=mysqli_fetch_array($resa);
if($resulta['card_state']==0) echo "<br/><img src=\"image/gua.png\"><br/>  <button class=\"btn btn-round color-2 material-design\" data-color=\"#ffffff\" onclick=\"location.href='reader_guashi_do.php?id=0'\">분실 취소</button>";
else echo "<br/><img src=\"image/normal.png\"><br/>  <button class=\"btn btn-round color-4 material-design\" data-color=\"#ffffff\"onclick=\"location.href='reader_guashi_do.php?id=1'\">분실하기</button>";

?>
    <script src="js/prefixfree.min.js"></script>

</h4>
    </div>
</div>
</body>
</html>