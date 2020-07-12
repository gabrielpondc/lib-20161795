<?php
session_start();
$userid=$_SESSION['userid'];
include ('mysqli_connect.php');
$readerid=$_GET['id'];

$sqlb="select * from reader_info where reader_id={$readerid}";
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
    <title>도서관 || 사용자 정보 수정</title>
</head>
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
<body>
<div style="position: relative;top: 25%">
    <div style="text-align: center">
        <div class="panel panel-primary" style="background: rgba(255,255,255,0.56)">
            <div class="panel-heading">
                <h3 class="panel-title">사용자 정보 수정</h3>
            </div>
            <div class="panel-body">

    <form  action="admin_reader_edit.php?id=<?php echo $readerid; ?>" method="POST" style="text-align: center" class="bs-example bs-example-form" role="form">
        <div id="login">
            <div class="input-group"><span class="input-group-addon">사용자 번호</span><input name="nid" value="<?php echo $resultb['reader_id'] ;?>" type="text" placeholder="수정한 사용자 번호 입력하시오" class="form-control"></div><br/>
            <div class="input-group"><span class="input-group-addon">성명</span><input name="nname" value="<?php echo $resultb['name'] ;?>" type="text" placeholder="수정한 성명 입력하시오" class="form-control"></div><br/>
            <div class="input-group"><span class="input-group-addon">성별</span><input name="nsex" value="<?php echo $resultb['sex'] ;?>" type="text" placeholder="수정한 성별 입력하시오" class="form-control"></div><br/>
            <div class="input-group"><span class="input-group-addon">생일</span><input name="nbirth" value="<?php echo $resultb['birth'] ;?>" type="date" placeholder="수정한 생일 입력하시오" class="form-control"></div><br/>
            <div class="input-group"><span class="input-group-addon">주소</span><input name="naddress" value="<?php echo $resultb['address'] ;?>" type="text" placeholder="수정한 주소 입력하시오" class="form-control"></div><br/>
            <div class="input-group"><span class="input-group-addon">휴데전화</span><input name="ntel" value="<?php echo $resultb['telcode'] ;?>" type="text" placeholder="수정한 전화 입력하시오" class="form-control"></div><br/>
            <div class="input-group"><span class="input-group-addon">이메일</span><input name="nmail"value="<?php echo $resultb['email'] ;?>" type="text" placeholder="수정한 이메일 입력하시오" class="form-control"></div><br/>
                <input type="submit" value="확인" class="btn btn-default">
            <input type="reset" value="리셋" class="btn btn-default">
        </div>
            </div>
            </form>
        </div>
    </div>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    $readid=$_GET['id'];
    $nnid = $_POST["nid"];
    $nnam= $_POST["nname"];
    $nsex = $_POST["nsex"];
    $nbir= $_POST["nbirth"];
    $nadd= $_POST["naddress"];
    $nnte = $_POST["ntel"];
    $mail = $_POST["nmail"];
    $sqla="update reader_info set reader_id={$nnid},name='{$nnam}',sex='{$nsex}',
birth='{$nbir}',address='{$nadd}',telcode='{$nnte}',email='{$mail}'  where reader_id=$readid;";
    $resa=mysqli_query($dbc,$sqla);
    $sqlc="update reader_card set name='{$nnam}' where reader_id=$readid;";
    $resc=mysqli_query($dbc,$sqlc);
    $upimg=$_POST["upimg"];
    $PSize = filesize($upimg);
    $mysqlPicture = addslashes(fread(fopen($upimg, "r"), $PSize));
    if($resa==1)
    {
        echo "<script>alert('수정 성공！')</script>";
        echo "<script>window.location.href='admin_reader.php'</script>";
    }
    else
    {
        echo "<script>alert('수정 실폐！다시 입력하시오！');</script>";
    }
}
?>
</body>
</html>
