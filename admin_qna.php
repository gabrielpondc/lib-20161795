<?php
session_start();
$userid=$_SESSION['userid'];
include ('mysqli_connect.php');
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
    <title>도서관 ||질문 관리</title>
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
                <li  class="dropdown" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">공지 관리<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_notice.php">모든 공지</a></li>
                        <li><a href="admin_notice_add.php">공지 추가</a></li>

                    </ul>
                <li class="active" ><a href="admin_qna.php">질문 관리</a></li>
                </li>
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
<h1 style="text-align: center"><strong>모든 질문</strong></h1>
<form  id="query" action="admin_qna.php" method="POST">
    <div id="query">
        <input type="submit" value="미처리문의조회" class="btn btn-default">
    </div>
</form>
</form>

<table  width='100%' class="table table-hover">
    <tr>
        <th>번호</th>
        <th>질문자</th>
        <th>제목</th>
        <th>시간</th>
        <th>대답자</th>
        <th>사젝</th>
    </tr>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
    $gjc = 0001;

        $sql="select qna_id,title,push_time,question,answer,name,admin_name  from  reader_info,qna,admin where qna.reader_id=reader_info.reader_id and qna.admin_id=admin.admin_id and ( admin_name like '%{$gjc}%' or qna.admin_id like '%0001%') ";

    }
    else{
        $sql="select qna_id,title,push_time,question,answer,name,admin_name  from  reader_info,qna,admin where qna.reader_id=reader_info.reader_id and qna.admin_id=admin.admin_id limit ".($page-1)*$pageSize. ",". $pageSize;
    }


    $res=mysqli_query($dbc,$sql);
    foreach ($res as $row){
        echo "<tr>";
        echo "<td>{$row['qna_id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td><a target='_top' href='admin_qna_read.php?id={$row['qna_id']}'>{$row['title']}</a></td>";
        echo "<td>{$row['push_time']}</td>";
        echo "<td>{$row['admin_name']}</td>";
        echo "<td><a href='admin_qna_del.php?id={$row['qna_id']}'><img src='image/delete.png'></a></td>";
        echo "</tr>";

    };
    echo "</table>";
    $total_sql = "SELECT * FROM qna";
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

    $page_ban .= "<form action='admin_qna.php' method='get'>";
    $page_ban .= "  <br><br><input type='text' size='2' name='p'> 페이지에 간다";
    $page_ban .= " &nbsp&nbsp&nbsp&nbsp<input type='submit' value='확인' class=\"btn btn-default\">";
    $page_ban .= "<br><br> {$totalNum}개 정보，총{$totalPages}페이지 ";
    $page_ban .= "</form>";
    echo $page_ban;
    echo "</div>";
    ?>

</body>
</html>