<?php
session_start();
$userid=$_SESSION['userid'];
include ('mysqli_connect.php');
$xgid=$_GET['id'];

$sqlb="select title,time,content,nc_id from notice where noid={$xgid}";
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
    <title>도서관 | | 공지 정보 수정</title>
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
        <div class="panel panel-primary" style="background: rgba(250,235,215,0.5)">
            <div class="panel-heading">
                <h3 class="panel-title">공지 정보 수정</h3>
            </div>
            <div class="panel-body">
                <form  action="admin_notice_edit.php?id=<?php echo $xgid; ?>"" method="POST" style="text-align: center" class="bs-example bs-example-form" role="form">
                <div id="login">

                    <div class="input-group"><span class="input-group-addon">제목</span><input name="nname" type="text" value="<?php echo $resultb['title']; ?>" class="form-control"></div><br/>
                    <div class="input-group"><span class="input-group-addon">시간</span><input name="ntime" type="text" value="<?php echo $resultb['time']; ?>" class="form-control"></div><br/>
                    <div class="input-group"><span class="input-group-addon">내용</span><textarea name="ncontent" rows="4" placeholder="내용 입력하시오" class="form-control" style="resize: none;"><?php echo $resultb['content']; ?></textarea></div><br/>
                    <div class="input-group"><span class="input-group-addon">구분<select id="box3" select name="nclass"><option value="1">공지</option><option value="2">광고</option><option value="3">이벤트</option><option value="4">뉴스</option></select></span> </div><br/>
                    <label><input type="submit" value="확인" class="btn btn-default"></label>
                    <label><input type="reset" value="리셋" class="btn btn-default"></label>
                </div>
                </form>

            </div>
            </form>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(function(){
        $("#box3").val(<?php echo $resultb['nc_id']; ?>);
    })

</script>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    $boid=$_GET['id'];
    $nname = $_POST["nname"];
    $ntime = $_POST["ntime"];
    $nco = $_POST["ncontent"];
    $nc = $_POST["nclass"];




    $sqla="update notice set title='{$nname}',time='{$ntime}',content='{$nco}',
nc_id='{$nc}' where noid=$boid;";
    $resa=mysqli_query($dbc,$sqla);


    if($resa==1)
    {

        echo "<script>alert('수정 성공！')</script>";
        echo "<script>window.location.href='admin_notice.php'</script>";

    }
    else
    {
        echo "<script>alert('수정 실패! 다시 입력해주세요!');</script>";

    }

}


?>
</body>
</html>
