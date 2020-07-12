<?php
session_start();
$userid=$_SESSION['userid'];
include ('mysqli_connect.php');

$sql="select name from reader_card where reader_id={$userid}";
$res=mysqli_query($dbc,$sql);
$result=mysqli_fetch_array($res);
$page = $_GET['p'];
if(!isset($page))
    $page=1;
$pageSize = 15;        //每页显示条数
$showPage = 5;        //页码显示格数
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <title>마이 도서관 || 마이 대출</title>
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .chaxun{}
        .chaxun a{padding:2px 8px;margin:2px;border:1px solid #ccc;text-decoration: none;}
        .chaxun span.currPage{background: #666;color: #fff;padding:4px 9px;margin:2px;}
        .chaxun span.disable{border:1px solid #ccc;color: #ccc;padding:2px 8px;margin:2px;}
        .chaxun table{margin-bottom: 30px;}
        .chaxun form{display: inline;}
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
                <li class="active"><a href="reader_borrow.php">마이 대출</a></li>
                <li><a href="reader_info.php">도서E-Card</a></li>
                <li><a href="reader_repass.php">암호 수정</a></li>
                <li><a href="reader_qna.php">문의하기</a></li>
                <li><a href="reader_guashi.php">분실신고</a></li>
                <li><a href="index.php">로그아웃</a></li>
            </ul>
        </div>
    </div>
    </div>
</nav>

<h3 style="text-align: center"><?php echo $result['name'];  ?>님，안녕하십니까?</h3><br/>
<h4 style="text-align: center">당신이 이미 빌려 보신 책의 목록은 다음과 같습니다.：</h4>
<div class="box">
<table  width='100%' class="table">
    <tr>
        <th>대출번호</th>
        <th>도서 번호</th>
        <th>도서 이름</th>
        <th>대출일자</th>
        <th>반납일자</th>
    </tr>
    <?php



    $sqla="select sernum,book_info.book_id,book_info.name,lend_date,back_date from lend_list,book_info where reader_id={$userid} and lend_list.book_id=book_info.book_id  limit ".($page-1)*$pageSize. ",". $pageSize;

    $resa=mysqli_query($dbc,$sqla);
    foreach ($resa as $row){
        echo "<tr>";
        echo "<td>{$row['sernum']}</td>";
        echo "<td>{$row['book_id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['lend_date']}</td>";
        echo "<td>{$row['back_date']}</td>";
        echo "</tr>";
    };
    echo "</table>";

    //获取总页数
    $total_sql = "select sernum,book_info.book_id,book_info.name,lend_date,back_date from lend_list,book_info where reader_id={$userid} and lend_list.book_id=book_info.book_id";
    $num = mysqli_query($dbc,$total_sql);
    $totalNum = mysqli_num_rows($num);
    $totalPages = ceil($totalNum/$pageSize);
    mysqli_close($dbc);

    //页码偏移
    $pageOffset = ($showPage-1)/2;
    echo "<div class=\"chaxun\" style=\"text-align: center\">";
    //页码条
    $page_ban = "";
    if($page>1){
        $page_ban .= "<a href='".$_SERVER['PHP_SELF']."?p=1'>처음</a>";
        $page_ban .= "<a href='".$_SERVER['PHP_SELF']."?p=".($page-1)."'><지난</a>";
    }else{
        $page_ban .= "<span class='disable'>처음</span>";
        $page_ban .= "<span class='disable'>지난</span>";
    }

    //初始化
    $start =1;
    $end = $totalPages;
    if($totalPages > $showPage){
        if($page > $pageOffset+1){
            $page_ban .= "...";
        }
        if($page > $pageOffset){
            $start = $page - $pageOffset;
            $end = $totalPages > $page+$pageOffset ? $page+$pageOffset:$totalPages;
        }else{
            $start=1;
            $end = $totalPages > $showPage ? $showPage : $totalPages;
        }
        if($page+$pageOffset > $totalPages){
            $start = $start - ($page+$pageOffset-$end);
        }
    }

    for ($i=$start; $i <= $end; $i++) {
        if($page == $i){
            $page_ban .= "<span class='currPage'>{$i}</span>";
        }else{
            $page_ban .= "<a href='".$_SERVER['PHP_SELF']."?p=".$i."'>{$i}</a>";
        }
    }

    //尾部省略...
    if($totalPages > $showPage && $totalPages > $page+$pageOffset){
        $page_ban .= "...";
    }

    if($page < $totalPages){
        $page_ban .= "<a href='".$_SERVER['PHP_SELF']."?p=".($page+1)."'>다음></a>";
        $page_ban .= "<a href='".$_SERVER['PHP_SELF']."?p=".($totalPages)."'>끝</a>";
    }else{
        $page_ban .= "<span class='disable'>다음</span>";
        $page_ban .= "<span class='disable'>끝</span>";
    }

    $page_ban .= "<form action='reader_borrow.php' method='get'>";
    $page_ban .= "  <br><br><input type='text' size='2' name='p'> 페이지에 간다";
    $page_ban .= " &nbsp&nbsp&nbsp&nbsp<input type='submit' value='확인' class=\"btn btn-default\">";
    $page_ban .= "<br><br> {$totalNum}개 정보，총{$totalPages}페이지 ";
    $page_ban .= "</form>";
    echo $page_ban;
    echo "</div>";
    ?>

</div>
</body>
</html>