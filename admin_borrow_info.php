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
date_default_timezone_set("Asia/Seoul");
$page = $_GET['p'];
if(!isset($page))
    $page=1;
$pageSize = 10;        //每页显示条数
$showPage = 5;        //页码显示格数
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <title>도서관||대출 정보</title>
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
            height:auto;

        }
        #query{
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
                <li> <li class="active"><a href="admin_borrow_info.php">대출관리</a></li>
                <li><a href="admin_allinfo.php">도서관 정보</a> </li>
                <li><a href="admin_repass.php">암호 수정</a></li>
                <li><a href="index.php">로그아웃</a></li>
            </ul>
        </div>
    </div>
    </div>
</nav><h1 style="text-align: center"><strong>대출관리</strong></h1>
<form  id="query" action="admin_borrow_info.php" method="POST">
    <div id="query">
        <label ><input  name="bookquery" type="text" placeholder="도서명, 도서번호 또는 독자증호 입력" class="form-control"></label>
        <input type="submit" value="조회" class="btn btn-default">
    </div>
</form>

<table  width='100%' class="table table-responsive">
    <tr>
        <th>대출 일련번호</th>
        <th>도서 번호</th>
        <th>도서명</th>
        <th>독자호</th>
        <th>대여일기</th>
        <th>대환일기</th>
        <th>실환일기</th>
        <th>반납상태</th>
        <th>초기여부</th>
    </tr>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $gjc = $_POST["bookquery"];

        $sql="select sernum,lend_list.book_id,name,reader_id,lend_date,DATE_ADD(lend_date,INTERVAL 1 MONTH) AS yhrq,back_date
from book_info,lend_list
where book_info.book_id=lend_list.book_id and ( name like '%{$gjc}%'or reader_id like '%{$gjc}% 'or lend_list.book_id like '%{$gjc}%' ) ;";
    }
    else{
        $sql="select sernum,lend_list.book_id,name,reader_id,lend_date,DATE_ADD(lend_date,INTERVAL 1 MONTH) AS yhrq,back_date,borrow
from book_info,lend_list
where book_info.book_id=lend_list.book_id limit ".($page-1)*$pageSize. ",". $pageSize;
    }


    $res=mysqli_query($dbc,$sql);
    foreach ($res as $row){
        echo "<tr>";
        echo "<td>{$row['sernum']}</td>";
        echo "<td>{$row['book_id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['reader_id']}</td>";
        echo "<td>{$row['lend_date']}</td>";
        echo "<td>{$row['yhrq']}</td>";
        echo "<td>{$row['back_date']}</td>";
        echo "<td>"; if($row['back_date']!=null) echo"<img src=\"image/yes.png\"></td>";else echo "<img src=\"image/no.png\"></td>";
        echo "<td>"; if(date("Y-m-d")>$row['yhrq']&&$row['borrow']==0||$row['back_date']>$row['yhrq']) echo"<img src=\"image/over.png\"></td>";else echo "<img src=\"image/overna.png\"></td>";
        echo "</tr>";

    };
    echo "</table>";

    //获取总页数
    $total_sql = "SELECT * FROM lend_list";
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

    $page_ban .= "<form action='admin_reader.php' method='get'>";
    $page_ban .= "  <br><br><input type='text' size='2' name='p'> 페이지에 간다";
    $page_ban .= " &nbsp&nbsp&nbsp&nbsp<input type='submit' value='확인' class=\"btn btn-default\">";
    $page_ban .= "<br><br> {$totalNum}개 정보，총{$totalPages}페이지 ";
    $page_ban .= "</form>";
    echo $page_ban;
    echo "</div>";
    ?>



</body>
</html>



