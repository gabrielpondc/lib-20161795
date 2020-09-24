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
$sqla="select noid,title,time,content,notice.nc_id,nc_name  from  notice,notice_class where notice.nc_id=notice_class.nc_id order by time desc ;";
$resa=mysqli_query($dbc,$sqla);
$resulta=mysqli_fetch_array($resa);
$sqlf="SELECT tag,class_id from(select count(1) tag_time,lend_list.reader_id,lend_list.book_id,tag,name,class_id from book_info,lend_list,tags where reader_id=$userid and lend_list.book_id=tags.book_id and book_info.book_id=lend_list.book_id GROUP BY tag ORDER BY tag_time LIMIT 0,10 ) a ORDER BY rand() LIMIT 1;";
$resf=mysqli_query($dbc,$sqlf);
$resultf=mysqli_fetch_array($resf);

date_default_timezone_set("Asia/Seoul");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <title>마이 도서관</title>
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        a:link{text-decoration: none;color: white}
        a:active{text-decoration:blink}
        a:hover{text-decoration:underline;color: red}
        a:visited{text-decoration: none;color: darkgray}
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
            overflow: auto;
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
        #gonggao{
            position: absolute;
            left: 30%;
            top: 50%;

        }
        * {
            margin: 0px;
            padding: 0px;            /*  去掉所有标签的marign和padding的值  */
        }
        ul {
            list-style: none;           /*  去掉ul标签默认的点样式  */
        }
        #mar {
            width: auto;
            -moz-border-radius: 1px;      /* Gecko browsers */
            -webkit-border-radius: 1px;   /* Webkit browsers */
            text-align: center;               /* 让新闻内容靠左 */
        }
        #marBox {
            height: 24px;//可改为24，则只显示一条;
            width: auto;
            overflow: hidden;    /*  这个一定要加，超出的内容部分要隐藏，免得撑高中间部分 */
        }
        #mar ul li {
            height: 24px;
        }
        #mar ul li a {
            width: auto;
            display: block;
            overflow: hidden;
            text-indent: 15px;
            height: 24px;
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
            margin-top: -0.1px;
            margin-left: -175px;
            transition: all 1s;
            -moz-transition: all 1s;
            /* Firefox 4 */-webkit-transition: all 1s;	/* Safari 和 Chrome */-o-transition: all 1s;	/* Opera */
            text-align: center;
            color: white;

        }
    </style>
</head>
<body>
<body>
<nav class="navbar navbar-default navbar-static-top " role="navigation">
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
                <li class="active"><a href="reader_index.php">홈페이지</a></li>
                <li><a href="reader_querybook.php">도서 조회</a></li>
                <li ><a href="reader_borrow.php">마이 대출</a></li>
                <li><a href="reader_info.php">도서E-Card</a></li>
                <li><a href="reader_repass.php">암호 수정</a></li>
                <li><a href="reader_qna.php">문의하기</a></li>
                <li><a href="reader_guashi.php">분실신고</a></li>
                <li><a href="index.php">로그아웃</a></li>
            </div>
            </ul>
        </div>
    </div>

</nav>

</h4>

    <br/><br/><h3 style="text-align: center"><?php echo $result['name'];  ?> 님,안녕하십니까?</h3><br/>
       <div style="text-align: center;width: auto">
        <div  id="mar">
            <div  id="marBox">
                <ul>
                    <?php
                    foreach ($resa as $row){
                        echo "<li><a href='#' data-toggle=\"modal\" data-target=\"#modal-switch{$row['noid']}\">[{$row['nc_name']}] {$row['title']}</a></li>";
                    };
                    ?>
                </ul>
            </div>
        </div>

        </div>
        <!-- 公告结束 -->

<?php
foreach ($resa as $row){
    echo"<div style=\"text-align: center\">";
    echo "<div id=\"modal-switch{$row['noid']}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modal-switch-label\" class=\"modal fade\"style='color: black'>";
    echo "<div class=\"modal-dialog\">";
    echo " <div class=\"modal-content\">";
    echo " <div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<button type=\"button\" data-dismiss=\"modal\" class=\"close\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>";
    echo "<div id=\"modal-switch-label\" class=\"modal-title\">[{$row['nc_name']}] {$row['title']}</div>";
    echo "</div>";
    echo "<div class=\"modal-body\">";
    echo "시간:{$row['time']}<br>";
    echo "{$row['content']}";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
};
?>
<script type="text/javascript">
    var aera=document.getElementById("marBox");
    aera.innerHTML+=aera.innerHTML;//实现无缝滚动，克隆自身
    aera.scrollTop=0;//初始值
    var iLiHeight=24;//行间距，可改为48，则两行显示
    var timer;//定时器
    var speed=50;
    var delay=3000;
    function startMove(){
        aera.scrollTop++;
        timer=setInterval('scrollUp()',speed)
    }
    function scrollUp(){
        //aera.scrollTop++;
        if (aera.scrollTop%iLiHeight==0) {
            clearInterval(timer);
            setTimeout('startMove()',delay);
        } else{
            aera.scrollTop++;
            if (aera.scrollTop>=aera.scrollHeight/2) {
                aera.scrollTop=0;
            }
        }
    }
    setTimeout("startMove()",delay);

</script>
	<h4 style="text-align: center; color:white">
		<?php
        $sqlx="select * from reader_info where MONTH(birth) = MONTH(NOW()) and DAY(birth) = DAY(NOW()) and reader_id={$userid}";
        $resx=mysqli_query($dbc,$sqlx);
        $resultx=mysqli_fetch_array($resx);
		if($resultx==0)
        echo "<img src='image/sunny.png'>Have a nice day";
		else echo "<img src='image/birthdaycake.png'>Happy birthday</script>";
        ?>
    </h4>
   
   <h4 style="text-align: center"><?php
        $sqla="select count(*) a from lend_list where reader_id={$userid} and back_date is NULL;";

        $resa=mysqli_query($dbc,$sqla);
        $resulta=mysqli_fetch_array($resa);
        echo "당신 지금 까지 빌려한 책은 {$resulta['a']}권입니다";
        ?>
    </h4>
    <h4 style="text-align: center">
        <?php
        $sqlb="select DATE_ADD(lend_date,INTERVAL 1 MONTH) AS yhrq from lend_list where reader_id={$userid} and back_date is NULL;";
        $counta=0;
        $resb=mysqli_query($dbc,$sqlb);

        foreach ($resb as $row){
            if(strtotime(date("y-m-d"))>strtotime($row['yhrq'])) $counta++;
        };

        if($counta==0) echo "지금까지 초기한 미반납 책은 없다";
        else echo "{$counta}권 책은 초기했습니다.실시간 반납하시오";


        ?></h4><br>

<div class="box" style="position: relative;top: 25%">
<h4 style="text-align: center;">도서 추천</h4>
<h5 style="text-align: center;">
    <?php
    $sqlg="SELECT book_id,name,class_name,tag,author,state from (select book_info.book_id,name,author,publish,language,class_name,tag,state,book_info.class_id from book_info,tags,class_info where tags.book_id=book_info.book_id and class_info.class_id=book_info.class_id and state=1 )b where (tag like '%{$resultf['tag']}%' or b.class_id={$resultf['class_id']} or  b.author={$resultf['class_id']} ) group by name ORDER BY rand() limit 0,5;";
    $resg=mysqli_query($dbc,$sqlg);
    $resultg=mysqli_fetch_array($resg);
    if($resultg==0)
        echo "당신 대출 역사 없습니다.좋아하는 책은 비려 봅시다";
    else foreach ($resg as $row){
        echo"<a href=\"book_content.php?id={$row['book_id']}\"target=\"_blank\">[{$row['class_name']}]   {$row['name']}</a><br><br>";
    };
    ?>
</h5>
</div>
</body>


</html>
