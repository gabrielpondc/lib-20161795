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
    <title>도서관 ||질문하기</title>
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        a:link{text-decoration: none;color: whitesmoke}
        a:active{text-decoration:blink}
        a:hover{text-decoration:underline;color: red}
        a:visited{text-decoration: none;color: whitesmoke}
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
            width: 100%;
            border-radius: 5px;
            height: auto;
            background: rgba(53, 53, 53, 0.67);
            box-shadow: 0px 0px 5px #333333;

            transition: all 1s;
            -moz-transition: all 1s;
            /* Firefox 4 */-webkit-transition: all 1s;	/* Safari 和 Chrome */-o-transition: all 1s;	/* Opera */
            text-align: center;


        }
        #query{
            text-align: right;
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
            <div  id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li ><a href="reader_index.php">홈페이지</a></li>
                    <li><a href="reader_querybook.php">도서 조회</a></li>
                    <li ><a href="reader_borrow.php">마이 대출</a></li>
                    <li><a href="reader_info.php">도서E-Card</a></li>
                    <li><a href="reader_repass.php">암호 수정</a></li>
                    <li class="active"><a href="reader_qna.php">문의하기</a></li>
                    <li><a href="reader_guashi.php">분실신고</a></li>
                    <li><a href="index.php">로그아웃</a></li>
                </ul>
            </div>
        </div>

</nav>

<h2 style="text-align: center">나의 질문</h2>
<form  id="query"><input type="button" value="add +" class="btn btn-default" onclick="window.location.href='reader_qna_add.php'"/>
</form>
<div class="box">
<table  width=100% class="table" style="text-align: center">
    <tr style="text-align: center">
        <th>질문번호</th>
        <th>제목</th>
        <th>시간</th>
        <th>대답자</th>
    </tr>
    <?php
    $sql="SELECT * from(select qna.reader_id,qna_id,title,push_time,question,answer,name,admin_name  from  reader_info,qna,admin where qna.reader_id=reader_info.reader_id and qna.admin_id=admin.admin_id )a where reader_id={$userid};";
    $res=mysqli_query($dbc,$sql);
    foreach ($res as $row){
        echo "<tr style='text-align: center'>";
        echo "<td>{$row['qna_id']}</td>";
        echo "<td><a href='#' data-toggle=\"modal\" data-target=\"#modal-switch{$row['qna_id']}\">{$row['title']}</a></td>";
        echo "<td>{$row['push_time']}</td>";
        echo "<td>{$row['admin_name']}</td>";
        echo "</tr>";
    };
    ?>
</table>
</div>
<?php
$sql="SELECT * from(select qna.reader_id,qna_id,title,push_time,question,answer,name,admin_name  from  reader_info,qna,admin where qna.reader_id=reader_info.reader_id and qna.admin_id=admin.admin_id )a where reader_id={$userid};";
$res=mysqli_query($dbc,$sql);
foreach ($res as $row){
    echo"<div style=\"text-align: center\">";
    echo "<div id=\"modal-switch{$row['qna_id']}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modal-switch-label\" class=\"modal fade\"style='color: black'>";
    echo "<div class=\"modal-dialog\">";
    echo " <div class=\"modal-content\">";
    echo " <div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<button type=\"button\" data-dismiss=\"modal\" class=\"close\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>";
    echo "<div id=\"modal-switch-label\" class=\"modal-title\">{$row['title']}</div>";
    echo "</div>";
    echo "<div class=\"modal-body\">";
    echo "시간:{$row['push_time']}|질문자:{$row['name']} <br>";
    echo "<h3 >Question</h3>";
    echo "<h4>{$row['question']}</h4>";
    echo "<h3>Answer | 대답자:{$row['admin_name']} </h3>";
    echo "<h4>{$row['answer']}</h4>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
};
?>

</body>
</html>