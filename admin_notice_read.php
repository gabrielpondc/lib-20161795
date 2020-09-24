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
$xgid=$_GET['id'];
$sqlb="select noid,title,time,content,notice.nc_id,nc_name  from  notice,notice_class where noid={$xgid} and notice.nc_id=notice_class.nc_id";
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
    <title>공지|<?php echo $resultb['title']; ?></title>
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
            color:black;
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
<?php if ($_SERVER["REQUEST_METHOD"] == "POST")
{
$sql="select noid,title,time,content,nc_id,nc_name from notice,notice_class where notice.nc_id=notice_class.nc_id  ;";
}
else{
$sql=" ;";
}
$res=mysqli_query($dbc,$sql);
?>

<div  style="position: relative;top: 25%">
    <div style="text-align: center">
        <div class="panel panel-primary" style="background: rgba(255,255,255,0.6)">
            <div class="panel-heading">
                <h3 class="panel-title">공지상황</h3>
            </div>
            <div class="panel-body">
                <h3><?php echo $resultb['title']; ?></h3>
                <h5>시간:<?php echo $resultb['time'];?>  |  분류:<?php echo $resultb['nc_name'];?></h5>
        <br><?php echo $resultb['content']; ?><br>
              <br>  <a href="javascript:window.opener=null;window.open('','_self');window.history.go(-1);"><img src="image/shangyiye.png">지난 페이지</a>|<a href='admin_notice_del.php?id=<?php echo $resultb['noid'];?>'><img src="image/delete.png">삭제</a>|<a href='admin_notice_edit.php?id=<?php echo $resultb['noid'];?>'><img src="image/xiugai.png">수정</a>
            </div>
    </form>

            </div>
            </form>
        </div>
    </div>

</div>

</body>
</html>
