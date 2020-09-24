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
    <title>마이 도서관||개인정보</title>
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
            border: 2px solid #95d7ff;
            color: #95d7ff;
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
            background-size: 5000% 5000%;
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
        .two{

            height:80px;
            /*	width:auto; border: 1px solid red;*/
            margin-top:15px;
            margin-left: 60px;


        }
        .box{
            z-index: 2;
            position:absolute;
            width: 350px;
            border-radius: 5px;
            height: auto;
            background: rgba(181, 180, 191, 0.49);
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
            <a class="navbar-brand" href="#">마이 도서관</a>
        </div>
        <div>
            <div  id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li ><a href="reader_index.php">홈페이지</a></li>
                <li><a href="reader_querybook.php">도서 조회</a></li>
                <li ><a href="reader_borrow.php">마이 대출</a></li>
                <li class="active"><a href="reader_info.php">도서E-Card</a></li>
                <li><a href="reader_repass.php">암호 수정</a></li>
                <li><a href="reader_qna.php">문의하기</a></li>
                <li><a href="reader_guashi.php">분실신고</a></li>
                <li><a href="index.php">로그아웃</a></li>
            </ul>
        </div>
    </div>
    </div>
</nav>
    <?php



    $sqla="select * from reader_info where reader_id={$userid} ;";

    $resa=mysqli_query($dbc,$sqla);
    $resulta=mysqli_fetch_array($resa);
    ?>
<div  style="position: relative;top: 25%">
<div style="text-align: center">
    <div class="box">
        <h3>도서E-Card</h3>
        <a href="#" class="list-group-item"><?php echo "<p>사용자 번호:{$resulta['reader_id']}</p><br/>"; ?></a>
        <a href="#" class="list-group-item"><?php  echo "<p>성함:{$resulta['name']}</p><br/>";  ?></a>
        <a href="#" class="list-group-item"><?php    echo "<p>성별:{$resulta['sex']}</p><br/>"; ?></a>
        <a href="#" class="list-group-item"><?php echo "<p>생일:{$resulta['birth']}</p><br/>";  ?></a>
        <a href="#" class="list-group-item"><?php     echo "<p>주소:{$resulta['address']}</p><br/>";  ?></a>
        <a href="#" class="list-group-item"><?php    echo "<p>전화:{$resulta['telcode']}</p><br/>"; ?></a>
        <a href="#" class="list-group-item"><?php    echo "<p>이메일:{$resulta['email']}</p><br/>"; ?></a>
        <a href="#" class="list-group-item"><div id="bcTarget3" style="width: auto" class="two" ></div></a><br>
        <?php echo "  <button class=\"btn btn-border btn-round color-1 material-design\" data-color=\"#95d7ff\"onclick=\"location.href='reader_info_edit.php'\">수정</button>"; ?>
        <script src="//cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>
        <script src="js/jquery-barcode.js"></script>
        <script>
            $(function(){
                $("#bcTarget3").barcode("<?php echo $resulta['reader_id'];?>", "codabar", {
                    output: 'css',       //渲染方式 css/bmp/svg/canvas
                    bgColor: 'rgba(255,0,0,0)', //条码背景颜色
                    //color: '#00ff00',   //条码颜色
                    barWidth: 2,        //单条条码宽度
                    barHeight: 45,     //单体条码高度
                    // moduleSize: 10,   //条码大小
                    posX: 50,        //条码坐标X
                    posY: 100,         //条码坐标Y
                    showHRI: true,    //是否在条码下方显示内容
                    addQuietZone: false  //是否添加空白区（内边距）
                });
            })
        </script>
    </div>
</div>
</div>

</body>
</html>