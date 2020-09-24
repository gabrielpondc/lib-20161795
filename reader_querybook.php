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
    <title>마이 도서관 || 도서 조회</title>
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        a:link{text-decoration: none;color: white}
        a:active{text-decoration:blink}
        a:hover{text-decoration:underline;color: red}
        a:visited{text-decoration: none;color: darkgray}
        #resbook{
            top:50%;

        }
        #query{

            text-align: center;
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
                <li><a href="reader_index.php">홈페이지</a></li>
                <li class="active"><a href="reader_querybook.php">도서 조회</a></li>
                <li ><a href="reader_borrow.php">마이 대출</a></li>
                <li><a href="reader_info.php">도서E-Card</a></li>
                <li><a href="reader_repass.php">암호 수정</a></li>
                <li><a href="reader_qna.php">문의하기</a></li>
                <li><a href="reader_guashi.php">분실신고</a></li>
                <li><a href="index.php">로그아웃</a></li>
            </ul>
        </div>
    </div>

</nav>
<h3 style="text-align: center"><?php echo $result['name'];  ?>님,안녕하십니까?</h3><br/>
<h4 style="text-align: center">도서 조회：</h4>


<form  action="reader_querybook.php" method="POST">
    <div id="query">
        <label ><input  name="bookquery" type="text" placeholder="도서 이름/번호 입력하시오" class="form-control"></label>
        <input type="submit" value="조회" class="btn btn-default">
    </div>
</form>
<div class="box">
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $gjc = $_POST["bookquery"];
    if($gjc=="") echo "<script>alert('조회 단어 공백을 두지 마십시오 ！')</script>";
    else{
        $sqla="SELECT book_id,name,class_name,tag,author,state from (select book_info.book_id,name,author,publish,language,class_name,tag,state from book_info,tags,class_info where tags.book_id=book_info.book_id and class_info.class_id=book_info.class_id)b where (tag like\"%{$gjc}%\" or book_id LIKE \"%{$gjc}%\" or name like \"%{$gjc}%\") group by name;";

        $resa=mysqli_query($dbc,$sqla);
        $jgs=mysqli_num_rows($resa);

        if($jgs==0)  echo "<script>alert('도서관 내에 이 책이 잠시 없다.！')</script>";
        else{
            echo "<table   id='resbook' class='table'>
    <tr>
           <th>번호</th>
        <th>제목</th>
        <th>저자</th>
        <th> 상태</th>
    </tr>";
            foreach ($resa as $row){
                echo "<tr>";
                echo "<td>{$row['book_id']}</td>";
                echo "<td><a href='book_content.php?id={$row['book_id']}'target=\"_blank\">{$row['name']}</a> </td>";
                echo "<td>{$row['author']}</td>";
                if($row['state']==1) echo "<td><img src=\"image/bookno.png\"></td>"; else if($row['state']==0) echo "<td><img src=\"image/boed.png\"></td>";else  echo "<td><img src=\"image/nos.png\"></td>";
                echo "</tr>";
            };
        };



        echo "</table>";



    }


}
?>
</div>
</body>
</html>