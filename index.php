<?php
session_start();
if(isset($_SESSION['userid']))
{
    unset($_SESSION['userid']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>도서관</title>
  <meta name="description" content="particles.js is a lightweight JavaScript library for creating particles.">

  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" media="screen" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/reset.css"/>
</head>
<body>

<div id="particles-js">
 <form  action="login_check.php" method="POST" class="bs-example bs-example-form" role="form">
                <div id="login">
		<div class="login">
			<div class="login-top" style="color: white">
				도서관 | 로그인
			</div>
			<div class="login-center clearfix">
				<div class="login-center-img"><img src="img/name.png"/></div>
				<div class="login-center-input">
					<input  name="account" type="text" placeholder="아이디  입력" class="form-control"onfocus="this.placeholder=''" onblur="this.placeholder='사용자 아이디\아이디  입력'"/>
					<div class="login-center-input-text">아이디</div>
				</div>
			</div>
			<div class="login-center clearfix">
				<div class="login-center-img"><img src="img/password.png"/></div>
				<div class="login-center-input">
					<input  name="pass" type="password" placeholder="비밀번호 입력" class="form-control"onfocus="this.placeholder=''" onblur="this.placeholder='비밀번호 입력'"/>
					<div class="login-center-input-text">비밀번호</div>
				</div>
			</div>
            <div style="text-align: center"> <input type="submit" value="로그인" class="btn btn-info">
                <input type="reset" value="리셋" class="btn btn-info"></div>
		</div>
		<div class="sk-rotating-plane"></div>
</div>
        </div>
    </form>
<!-- scripts -->
<script src="js/particles.min.js"></script>
<script src="js/app.js"></script>
<script type="text/javascript">
	function hasClass(elem, cls) {
	  cls = cls || '';
	  if (cls.replace(/\s/g, '').length == 0) return false; //当cls没有参数时，返回false
	  return new RegExp(' ' + cls + ' ').test(' ' + elem.className + ' ');
	}
	 
	function addClass(ele, cls) {
	  if (!hasClass(ele, cls)) {
	    ele.className = ele.className == '' ? cls : ele.className + ' ' + cls;
	  }
	}
	 
	function removeClass(ele, cls) {
	  if (hasClass(ele, cls)) {
	    var newClass = ' ' + ele.className.replace(/[\t\r\n]/g, '') + ' ';
	    while (newClass.indexOf(' ' + cls + ' ') >= 0) {
	      newClass = newClass.replace(' ' + cls + ' ', ' ');
	    }
	    ele.className = newClass.replace(/^\s+|\s+$/g, '');
	  }
	}
</script>
</body>
</html>