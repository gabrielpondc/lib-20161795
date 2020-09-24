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
$sqla="SELECT class_name,count(1) number from(select book_id,book_info.class_id,class_name from book_info,class_info where book_info.class_id=class_info.class_id ) as a GROUP BY class_name";
$resa=mysqli_query($dbc,$sqla);
$resulta=mysqli_fetch_array($resa);
$sqlb="SELECT * from(select count(1) times,lend_list.book_id,name from book_info,lend_list where book_info.book_id=lend_list.book_id GROUP BY book_id) a order by times desc limit 0,5";
$resb=mysqli_query($dbc,$sqlb);
$resultb=mysqli_fetch_array($resb);
$sqlc="select count(state=1 or null) t1,count(state=0 or null ) t2,count(state=2 or null) t3 from book_info";
$resc=mysqli_query($dbc,$sqlc);
$resultc=mysqli_fetch_array($resc);
$sqld="select world,count(1) times from wc GROUP BY world";
$resd=mysqli_query($dbc,$sqld);
$resultd=mysqli_fetch_array($resd);
$sqle="SELECT class_name,times from(select count(1) times,lend_list.book_id,name,class_name,book_info.class_id from book_info,lend_list,class_info where book_info.book_id=lend_list.book_id and book_info.class_id=class_info.class_id GROUP BY class_id) a order by times desc limit 0,5";
$rese=mysqli_query($dbc,$sqle);
$resulte=mysqli_fetch_array($rese);
$sqli="SELECT COUNT(1) count,DATE(lend_date) time from lend_list  GROUP BY DATE(lend_date) ORDER BY time";
$resi=mysqli_query($dbc,$sqli);
$resulti=mysqli_fetch_array($resi);
$sqlz="SELECT COUNT(1) count,DATE(back_date) time from lend_list where back_date is not null GROUP BY DATE(back_date) ORDER BY time";
$resz=mysqli_query($dbc,$sqlz);
$resultz=mysqli_fetch_array($resz);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <title>도서관 ||도서관 정보</title>
    <link rel="stylesheet" href="//cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts-gl/dist/echarts-gl.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts-stat/dist/ecStat.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts/dist/extension/dataTool.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts/map/js/china.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts/map/js/world.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts/dist/extension/bmap.min.js"></script>

    <style>
        body{
            width: 100%;
            height: 100%;
            position: relative;
            width: 100%;
            height: 100vh;
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
        #query{
            text-align: center;
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
                <li class="dropdown" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">공지 관리<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_notice.php">모든 공지</a></li>
                        <li><a href="admin_notice_add.php">공지 추가</a></li>
                    </ul>
                <li  ><a href="admin_qna.php">질문 관리</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">사용자 관리<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_reader.php">모든 사용자</a></li>
                        <li><a href="admin_reader_add.php">사용자 추가</a></li>
                    </ul>
                </li>
                <li><a href="admin_borrow_info.php">대출관리</a></li>
                <li class="active"><a href="admin_allinfo.php">도서관 정보</a> </li>
                <li><a href="admin_repass.php">암호 수정</a></li>
                <li><a href="index.php">로그아웃</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="box">
<h1 style="text-align: center"><strong>도서관 정보</strong></h1>

<div id="pt" style="height: 600px;width: auto"></div>
<br>
<div id="fam" style="height: 600px;width: auto"></div>
<br>
<div id="con" style="height: 600px;width: auto"></div>
<br>
    <div id="jiechu" style="height: 300px;width: auto"></div>
    <br>
    <div id="fanhuan" style="height: 300px;width: auto"></div>
    <br>
<h3 style="text-align: center">문의 단어 빈도</h3>
<div id="charts" style="height:300px;width:auto;"></div>
<div id="container" style="height: 600px;width: auto"></div>
</div>
    <script type="text/javascript">
    var dom = document.getElementById("pt");
    var cd = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            text: '보유 도서 종류',
            left: 'center',
            textStyle: {
                color: '#ccc'
            }
        },
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        toolbox: {
            show: false,
            feature: {
                mark: {show: true},
                dataView: {show: true, readOnly: false},
                magicType: {
                    show: true,
                    type: ['pie', 'funnel']
                },
                restore: {show: true},
                saveAsImage: {show: true}
            }
        },
        series: [
            {
                name: '분류',
                type: 'pie',
                radius: ["10%", "80%"],
                center: ['50%', '60%'],
                roseType: 'radius',
                label: {
                    show: false
                },
                emphasis: {
                    label: {
                        show: true
                    }
                },
                data: [
                    <?php
                    foreach ($resa as $row){
                        echo "{value: {$row['number']}, name:'{$row['class_name']}'},";
                    };
                    ?>
                ]
            }
        ]
    };

    if (option && typeof option === "object") {
        cd.setOption(option, true);
    }
    window.addEventListener('resize',function () {
        cd.resize()
    });
</script>
<script type="text/javascript">
    var dom = document.getElementById("fam");
    var ebt = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            text: '인기 책(대출 TOP5)',
            left: 'center',
            textStyle: {
                color: '#ccc'
            }
        },
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        legend: {
            show:false,
            orient: 'vertical',
            left: 'left',
            data: [ <?php
                foreach ($resa as $row){
                    echo "'{$row['class_name']}',";
                };
                ?>]
        },
        series: [
            {
                name: '인기',
                type: 'pie',
                radius: '55%',
                center: ['50%', '60%'],
                data: [
                    <?php
                    foreach ($resb as $row){
                        echo "{value: {$row['times']}, name:'{$row['name']}'},";
                    };
                    ?>
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    if (option && typeof option === "object") {
        ebt.setOption(option, true);
    }
    window.addEventListener('resize',function () {
        ebt.resize()
    });
</script>
<script type="text/javascript">
    var dom = document.getElementById("con");
    var bt = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            text: '도서 상대 정보',
            left: 'center',
            textStyle: {
                color: '#ccc'
            }
        },
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b}: {c} ({d}%)'
        },
        legend: {

            show:false,
            orient: 'vertical',
            left: 10,
            data: ['대출중', '상태 정보 없음', '대출가능']
        },
        series: [
            { color: ['#90B44B', '#ff4330','#707C74'],
                name: '대출 정보',
                type: 'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
                label: {
                    normal: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        show: true,
                        textStyle: {
                            fontSize: '30',
                            fontWeight: 'bold'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data: [
                    {value: <?php echo $resultc['t1']; ?>, name: '대출가능'},
                    {value: <?php echo $resultc['t2']; ?>, name: '대출중'},
                    {value: <?php echo $resultc['t3']; ?>, name: '상태 정보 없음'},
                ]
            }
        ]
    };
    ;
    if (option && typeof option === "object") {
        bt.setOption(option, true);
    }
    window.addEventListener('resize',function () {
        bt.resize()
    });
</script>

<script type="text/javascript" src="https://echarts.baidu.com/build/dist/echarts.js"></script>
<script type="text/javascript">
    function createRandomItemStyle(d) {
        d = d || Math.floor((Math.random() * 20) + 1);
        var colors = ['#ff715e','#759aa0','#e69d87','#8dc1a9','#ea7e53','#eedd78','#73a373','#73b9bc','#7289ab','#91ca8c','#f49f42','#8c6ac4','#ffee51'];
        if(d > colors.length) {
            d = 0;
        }
        return {
            normal: {
                color: colors[d]
            }
        };
    }
    require.config({
        paths: {
            echarts: "https://echarts.baidu.com/build/dist"
        }
    })
    require(["echarts/echarts", "echarts/chart/wordCloud"], function(ec) {
        option = {
            tooltip: {
                show: false
            },
            series: [{
                name: 'key',
                type: 'wordCloud',
                size: ['60%', '70%'],
                textRotation: [0,0],
                textPadding: 0,
                autoSize: {
                    enable: true,
                    minSize: 14
                },
                data: [ <?php
                    foreach ($resd as $row){
                        echo "{name:'{$row['world']}',value:{$row['times']}00,itemStyle: createRandomItemStyle()},";
                    };
                    ?>]
            }]
        };
        var dom = document.getElementById("charts");
        var ct = ec.init(dom);
        ct.setOption(option);
    });
    window.onresize = function(){
        ct.resize();
        //myChart1.resize();    //若有多个图表变动，可多写

    }
</script>
<script type="text/javascript">
    var dom = document.getElementById("container");
    var t = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            text: '독자 좋아하는 책 종류',
            left: 'center',
            textStyle: {
                color: '#ccc'
            }

        },
        tooltip: {
            show:false,
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c}%"
        },
        toolbox: {
            show: false,
            feature: {
                dataView: {readOnly: false},
                restore: {},
                saveAsImage: {}
            }
        },
        legend: {
            show: false,
            data: [<?php
                foreach ($rese as $row){
                    echo "'{$row['class_name']}',";
                };
                ?>]
        },

        series: [
            {
                name:'독자 좋아하는 책 종류',
                type:'funnel',
                left: '10%',
                top: 60,
                //x2: 80,
                bottom: 60,
                width: '80%',
                // height: {totalHeight} - y - y2,
                min: 0,
                max: 100,
                minSize: '0%',
                maxSize: '100%',
                sort: 'descending',
                gap: 2,
                label: {
                    show: true,
                    position: 'inside'
                },
                labelLine: {
                    length: 10,
                    lineStyle: {
                        width: 1,
                        type: 'solid'
                    }
                },
                itemStyle: {
                    borderColor: '#fff',
                    borderWidth: 1
                },
                emphasis: {
                    label: {
                        fontSize: 20
                    }
                },
                data: [
                    <?php
                    foreach ($rese as $row){
                        echo "{value: {$row['times']}, name:'{$row['class_name']}'},";
                    };
                    ?>
                ]
            }
        ]
    };
    ;
    if (option && typeof option === "object") {
        t.setOption(option, true);
    }
    window.addEventListener('resize',function () {
        t.resize()
    });
</script>
<script type="text/javascript">
    var dom = document.getElementById("jiechu");
    var my = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            text: '도서 대출 기록',
            left: 'center',
            textStyle: {
                color: '#ccc'
            }

        },
        textStyle:{

            color:'white'

        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            show:false,
            textStyle:{

                color:'white'

            },
            data: ['대출'],
            icon:"circle"
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: [<?php
                foreach ($resi as $row){
                    echo "'{$row['time']}',";
                };
                ?>]
        },
        yAxis: {
            splitLine :{    //网格线
                lineStyle:{
                    type:'dashed'    //设置网格线类型 dotted：虚线   solid:实线
                }},
            type: 'value'
        },
        grid: {
            bottom: '70px',
        },
        dataZoom: [{
            textStyle: {
                color: '#8392A5'
            },
            start:70,
            handleIcon: 'M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4v1.3h1.3v-1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7V23h6.6V24.4z M13.3,19.6H6.7v-1.4h6.6V19.6z',
            handleSize: '50%',
            left:"center",                           //组件离容器左侧的距离,'left', 'center', 'right','20%'
            top:"90%",                                //组件离容器上侧的距离,'top', 'middle', 'bottom','20%'
            right:"auto",                             //组件离容器右侧的距离,'20%'
            bottom:"auto",
            orient:"horizontal",
            dataBackground: {
                areaStyle: {
                    color: '#8392A5'
                },
                lineStyle: {
                    opacity: 0.8,
                    color: '#8392A5'
                }
            }
        }, {
            zoomOnMouseWheel:false,                   //如何触发缩放。可选值为：true：表示不按任何功能键，鼠标滚轮能触发缩放。false：表示鼠标滚轮不能触发缩放。'shift'：表示按住 shift 和鼠标滚轮能触发缩放。'ctrl'：表示按住 ctrl 和鼠标滚轮能触发缩放。'alt'：表示按住 alt 和鼠标滚轮能触发缩放。
            moveOnMouseMove:false,
            type: 'inside'
        }],
        series: [
            {
                name: '대출',
                type: 'bar',
                itemStyle: {
                    normal: {
                        color: "#fb776b",
                        lineStyle: {
                            color: "#fb776b",
                        }
                    }
                },
                data: [<?php
                    foreach ($resi as $row){
                        echo "{$row['count']},";
                    };
                    ?>]
            }
        ]
    };
    ;
    if (option && typeof option === "object") {
        my.setOption(option, true);
    }
    window.addEventListener('resize',function () {
        my.resize()
    });
</script>
<script type="text/javascript">
    var dom = document.getElementById("fanhuan");
    var zt = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            text: '도서 반납 기록',
            left: 'center',
            textStyle: {
                color: '#ccc'
            }

        },
        textStyle:{

            color:'white'

        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            show:false,
            textStyle:{

                color:'white'

            },
            data: ['반납'],
            icon:"circle"
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: [<?php
                foreach ($resz as $row){
                    echo "'{$row['time']}',";
                };
                ?>]
        },
        yAxis: {
            splitLine :{    //网格线
                lineStyle:{
                    type:'dashed'    //设置网格线类型 dotted：虚线   solid:实线
                }},
            type: 'value'
        },
        grid: {
            bottom: '70px',
        },
        dataZoom: [{
            textStyle: {
                color: '#8392A5'
            },
            start:70,
            handleIcon: 'M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4v1.3h1.3v-1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7V23h6.6V24.4z M13.3,19.6H6.7v-1.4h6.6V19.6z',
            handleSize: '50%',
            left:"center",                           //组件离容器左侧的距离,'left', 'center', 'right','20%'
            top:"90%",                                //组件离容器上侧的距离,'top', 'middle', 'bottom','20%'
            right:"auto",                             //组件离容器右侧的距离,'20%'
            bottom:"auto",
            orient:"horizontal",
            dataBackground: {
                areaStyle: {
                    color: '#8392A5'
                },
                lineStyle: {
                    opacity: 0.8,
                    color: '#8392A5'
                }
            }
        }, {
            zoomOnMouseWheel:false,                   //如何触发缩放。可选值为：true：表示不按任何功能键，鼠标滚轮能触发缩放。false：表示鼠标滚轮不能触发缩放。'shift'：表示按住 shift 和鼠标滚轮能触发缩放。'ctrl'：表示按住 ctrl 和鼠标滚轮能触发缩放。'alt'：表示按住 alt 和鼠标滚轮能触发缩放。
            moveOnMouseMove:false,
            type: 'inside'
        }],
        series: [
            {
                name: '반납',
                type: 'bar',
                itemStyle: {
                    normal: {
                        color: "#59c1da",
                        lineStyle: {
                            color: "#59c1da",
                        }
                    }
                },
                data: [<?php
                    foreach ($resz as $row){
                        echo "{$row['count']},";
                    };
                    ?>]
            }
        ]
    };
    ;
    if (option && typeof option === "object") {
        zt.setOption(option, true);
    }
    window.addEventListener('resize',function () {
        zt.resize()
    });
</script>
<script src="js/particles.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
