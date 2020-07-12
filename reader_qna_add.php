<?php
session_start();
$userid=$_SESSION['userid'];
include ('mysqli_connect.php');
$readerid=$_GET['id']
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>도서관 || 질문 추가</title>
</head>
<style>
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

</style>
<body>
<div style="text-align: center">
    <div style="text-align: center">
        <div class="panel panel-primary"style="background:rgba(255,255,255,0.51) ">
            <div class="panel-heading">
                <h3 class="panel-title">질문 증가</h3>
            </div>
            <div class="panel-body">
                        <form  action="reader_qna_add.php" method="POST" style="text-align: center" class="bs-example bs-example-form" role="form">
                            <div id="login">
                                <div class="input-group"><span class="input-group-addon">제목</span><input name="ntitle" type="text" placeholder="제목 입력하시오" class="form-control"></div><br/>
                                <div class="input-group"><span class="input-group-addon"><?php echo $showtime=date("Y-m-d H:i:s");?> </span></div><br/>
                                <div class="input-group"><span class="input-group-addon">문의내용</span><textarea name="ncontent" rows="10" placeholder="내용 입력하시오" class="form-control" style="resize: none;"></textarea></div><br/>

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
    $nti = $_POST["ntitle"];
    $nt =$showtime=date("Y-m-d H:i:s");
    $nco = $_POST["ncontent"];
    $isd=$userid;
    $nanswer="아직 대답이 없다";
    $nadmin="0001";


    $sqla="insert into qna VALUES (NULL ,'{$nti}','{$nt}','{$nco}','{$nanswer}',{$isd},'{$nadmin}' )";
    $resa=mysqli_query($dbc,$sqla);


    if($resa==1)
    {

        echo "<script>alert('추가 성공！')</script>";
        echo "<script>window.location.href='reader_qna.php'</script>";

    }
    else
    {
        echo "<script>alert('추가 실패! 다시 입력해주세요！');</script>";

    }

}

?>
</body>
</html>
