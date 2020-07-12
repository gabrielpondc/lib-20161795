<?php
session_start();
$userid=$_SESSION['userid'];
include ('mysqli_connect.php');
$xgid=$_GET['id'];
$sqlb="select title,push_time,answer,admin_id,reader_id,question,answer from qna where qna_id={$xgid}";
$resb=mysqli_query($dbc,$sqlb);
$resultb=mysqli_fetch_array($resb);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php echo $resultb['reader_id']; ?>의질문 대답학기</title>
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

    </style>
</head>

<body>
<div  style="position: relative;top: 25%">
    <div style="text-align: center">
        <div class="panel panel-primary" style="background: rgba(255,255,255,0.51)">
            <div class="panel-heading">
                <h3 class="panel-title"> 질문 대답학기</h3>
            </div>
            <div class="panel-body">
    <form  action="admin_qna_edit.php?id=<?php echo $xgid; ?>"" method="POST" style="text-align: center" class="bs-example bs-example-form" role="form">
    <div id="login">

        <div class="input-group"><span class="input-group-addon">제목</span><input name="ntitle" type="text" value="<?php echo $resultb['title']; ?>" class="form-control"></div><br/>
        <div class="input-group"><span class="input-group-addon">대답하는 관리자</span><input name="admin" type="text" value="<?php echo $userid;?>" class="form-control" readonly="true" /></div><br/>
        <div class="input-group"><span class="input-group-addon">질문시간</span><input name="ntime" type="text" value="<?php echo $resultb['push_time']; ?>" class="form-control"readonly="true"></div><br/>
        <div class="input-group"><span class="input-group-addon">문의내용</span><textarea name="nquestion" rows="4" placeholder="내용 입력하시오" class="form-control" style="resize: none;"><?php echo $resultb['question']; ?></textarea></div><br/>
        <div class="input-group"><span class="input-group-addon">대답내용</span><textarea name="nanswer" rows="4" placeholder="내용 입력하시오" class="form-control" style="resize: none;"><?php echo $resultb['answer']; ?></textarea></div><br/>
        <label><input type="submit" value="확인" class="btn btn-default"></label>
        <label><input type="reset" value="리셋" class="btn btn-default"></label>
        </div>
    </form>

            </div>
            </form>
        </div>
    </div>

</div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    $boid=$_GET['id'];
    $nadmin = $_POST["admin"];
    $ntitle = $_POST["ntitle"];
    $nquestion = $_POST["nquestion"];
    $nanswer = $_POST["nanswer"];




    $sqla="update qna set title='{$ntitle}',admin_id='{$nadmin}',question='{$nquestion}',answer='{$nanswer}' where qna_id=$boid;";
    $resa=mysqli_query($dbc,$sqla);


    if($resa==1)
    {

        echo "<script>alert('수정 성공！')</script>";
        echo "<script>window.location.href='admin_qna.php'</script>";

    }
    else
    {
        echo "<script>alert('수정 실패! 다시 입력해주세요!');</script>";

    }

}


?>
</body>
</html>
