<?php
header("Content-Type:text/html;charset=UTF-8");
session_start();
$userid=$_SESSION['userid'];
include ('mysqli_connect.php');
$xgid=$_REQUEST['id'];
$tag=$_REQUEST['tag'];
$sqlb="select * from(select book_id,name,author,publish,ISBN,introduction,language,price,pubdate,book_info.class_id,class_name,pressmark,state from book_info,class_info where book_info.class_id=class_info.class_id) as a where book_id={$xgid};";
$resb=mysqli_query($dbc,$sqlb);
$resultb=mysqli_fetch_array($resb);
$sqlc="SELECT * from(select count(1) times,lend_list.book_id,name from book_info,lend_list where book_info.book_id=lend_list.book_id GROUP BY book_id) a where book_id={$xgid};";
$resc=mysqli_query($dbc,$sqlc);
$resultc=mysqli_fetch_array($resc);
$sqld="SELECT book_id,name,class_name,tag,COUNT(tag) from (select book_info.book_id,name,author,publish,language,class_name,tag from book_info,tags,class_info where tags.book_id=book_info.book_id and class_info.class_id=book_info.class_id  )b where book_id={$xgid} GROUP BY tag ORDER BY COUNT(tag) DESC limit 1,5;";
$resd=mysqli_query($dbc,$sqld);
$resultd=mysqli_fetch_array($resd);
?>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<head>
    <meta charset="UTF-8">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>
    <script src="/js/jquery-barcode.js"></script>
    <title>도서 정보|<?php echo $resultb['name']; ?></title>
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
        a:link{text-decoration: none;color: white}
        a:active{text-decoration:blink}
        a:hover{text-decoration:underline;color: #ff8bbb
        }
        a:visited{text-decoration: none;color: #95d7ff
        }

        .box{
            z-index: 2;
            position:absolute;
            width: 390px;
            border-radius: 5px;
            height: auto;
            background: rgba(53, 53, 53, 0.67);
            box-shadow: 0px 0px 5px #333333;
            top: 10%;
            left: 45%;
            margin-top: -1px;
            margin-left: -175px;
            transition: all 1s;
            -moz-transition: all 1s;
            /* Firefox 4 */-webkit-transition: all 1s;	/* Safari 和 Chrome */-o-transition: all 1s;	/* Opera */
            text-align: center;
            color: white;

        }

        .two{

            height:80px;
            /*	width:auto; border: 1px solid red;*/
            margin-top:20px;
            margin-left: 100%;


        }
        .tag-area>li{float:left;margin:0 15px 8px 0;background: rgba(244, 244, 244, 0.27);border-radius:100px;padding:0 12px;font-size:12px;border:1px solid #f4f4f4}  .s_tag .tag-area>li,.s_tag .tag-area>li>a{position:relative;height:22px;transition:all .3s}  .s_tag .tag-area>li>a{display:inline-block;color:#505050;line-height:22px;vertical-align:middle;z-index:10}  .s_tag .tag-area>li.hot1{border-color:#feb4cc}  .s_tag .tag-area>li.hot2{border-color:#f25d8e}  .s_tag .tag-area>li:hover{border-color:#00a1d6}  .s_tag .tag-area>li:hover>a{color:#00a1d6}  .s_tag .nothing{float:left;color:#99a2aa;font-size:12px;line-height:26px;margin-right:10px}  .s_tag .btn-add{float:left;width:23px;height:23px;border-radius:50%;background:#f4f5f7;position:relative;transition:all .3s;cursor:pointer}  .s_tag .btn-add span{position:absolute;background:#505050;transition:all .3s}  .s_tag .btn-add .one{left:6px;top:11px;width:12px;height:2px}  .s_tag .btn-add .two{left:11px;top:6px;width:2px;height:12px}  .s_tag .btn-add:hover{border-color:#00a1d6}  .s_tag .btn-add:hover span{background:#00a1d6}  .s_tag .ipt{float:left;width:158px;height:23px;border-radius:23px;background:#f4f5f7;border:1px solid #00a1d6;position:relative;opacity:1}  .s_tag .ipt.tag-add-enter-active,.s_tag .ipt.tag-add-leave-active{transition:all .5s}  .s_tag .ipt.tag-add-enter,.s_tag .ipt.tag-add-leave-to{opacity:0;width:23px}  .s_tag .ipt input{height:23px;line-height:23px;width:120px;padding:0 10px;font-size:12px;background:transparent;border:none;outline:none}  .s_tag .ipt.on{opacity:1;width:158px}  .s_tag .ipt a{position:absolute;width:10px;height:10px;background:url(//static.hdslb.com/images/base/icons.png) -539px -539px no-repeat;left:138px;top:6px}  .s_tag .ipt .tips{margin-top:5px;color:red}  .s_tag .btn-view-tag{margin-top:10px;color:#eceff3}  .s_tag .btn-view-tag a{color:#505050}  .s_tag .btn-view-tag a:hover{color:#00a1d6}  .s_tag .btn-view-tag span{margin:0 10px}
    </style>

</head>
<body>
<div  style="position: relative;top: 35%">
        <div class="box">

                <h3><?php echo $resultb['name']; ?></h3>

                <h5 style="text-align:center">저자:<?php echo $resultb['author'];?> |출판사:<?php echo $resultb["publish"];?>  </h5>
                <h5 style="text-align:center">구분:<?php echo $resultb['class_name'];?> |책장호:<?php echo $resultb["pressmark"];?>  </h5>
                <h4>소개</h4>
                <h4><?php echo $resultb['introduction']; ?></h4>
                <h5 style="text-align:center">ISBN:<?php echo $resultb['ISBN'];?> |값:<?php echo $resultb["price"];?>  </h5>
                <h5 style="text-align:center">언어:<?php echo $resultb['language'];?> |출판날짜:<?php echo $resultb["pubdate"];?>  </h5>
            <h5>TAGS:</h5><ul class="tag-area"style="list-style-type: none;display:inline;">
            <?php
            foreach ($resd as $row){
                echo "<li class=\".tag-area\" style='color: white'><a href='book_content.php?id={$xgid}&tag={$row['tag']}'>{$row['tag']}</a></li>";
            };
            ?>

            </ul>

            <table>
                    <th></th>
                    <th><div id="bcTarget3" style="width: auto" class="two" ></div></th>
                    <th></th>
                </table>
            <?php
                if($tag=="") echo"";
                    else{
                $sqlf="SELECT book_id,name,class_name,tag,author from (select book_info.book_id,name,author,publish,language,class_name,tag from book_info,tags,class_info where tags.book_id=book_info.book_id and class_info.class_id=book_info.class_id  )b  where tag='{$tag}'and book_id!='{$xgid}' group by name;";
                $resf=mysqli_query($dbc,$sqlf);
                $resultf=mysqli_fetch_array($resf);
                        if($resultf==0) echo"이 TAG상관 책이 없습니다";
                        else{
                echo "<table   id='resbook' class='table'>
             <tr>
            <th>제목</th>
            <th>저자</th>
            </tr>";
                foreach ($resf as $row){
                    echo "<tr>";
                    echo "<td><a href='book_content.php?id={$row['book_id']}'target=\"_blank\">{$row['name']}</a> </td>";
                    echo "<td>{$row['author']}</td>";
                    echo "</tr>";
                };
                        }
                    }
            ?>
                <script src="//cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>
                <script src="js/jquery-barcode.js"></script>

                <script>
                    $(function(){
                        $("#bcTarget3").barcode("<?php echo $resultb['book_id'];?>", "codabar", {
                            output: 'css',       //渲染方式 css/bmp/svg/canvas
                            bgColor: 'rgba(255,249,242,0)', //条码背景颜色
                            //color: '#fff',   //条码颜色
                            barWidth: 1,        //单条条码宽度
                            barHeight: 45,     //单体条码高度
                            //moduleSize: 40,   //条码大小
                            posX: 45,        //条码坐标X
                            posY: 100,         //条码坐标Y
                            showHRI: true,    //是否在条码下方显示内容
                            addQuietZone: true  //是否添加空白区（内边距）
                        });
                    })
                </script>
            </div>
    <script language="JavaScript">
        windows.addEventListener("resize",function (){
            .box.resize()
        })
    </script>
        </div>

    </form>





</body>
</html>
