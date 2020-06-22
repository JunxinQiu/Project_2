<?php
session_start();
require_once('src/php/config.php');
//刷新的功能
function generate($result)
{
    while ($result->rowCount() > 0 && $row = $result->fetch()) {
        echo '<li class="thumbnail" title="' . $row['Title'] . '">
                <a href="src/html/detail.php?imageid=' . $row['ImageID'] . '">
                    <div class="img-box">
                        <img src="src/travel-images/small/' . $row['PATH'] . '" alt="pic" width="240" height="240">
                    </div>
                    <div><h3>' . $row['Title'] . '</h3>
                        <p>' . $row['Description'] . '</p>
                    </div>
                </a>
            </li>';
    }
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="src/css/NavBar.css">
    <link rel="stylesheet" type="text/css" href="src/css/footer.css">
    <link rel="stylesheet" type="text/css" href="src/css/home.css">

</head>
<body>
<!--导航栏-->
<div class="NavBar">
    <!--logo-->
    <div>
        <a href="index.php">
            <img src="src/img/icons/githublogo.png" alt="logo">
        </a>
    </div>

    <div class="NavBar_left">
        <ul>
            <li>
                <a href="index.php" class="highlight">Home</a>
            </li>
            <li>
                <a href="./src/php/browse.php">Browse</a>
            </li>
            <li>
                <a href="./src/php/search.php">Search</a>
            </li>
        </ul>
    </div>
    <?php
    if (isset($_SESSION['id'])) {
        echo '<div class="NavBar_right dropdown" id="userCenterNav">
        <span class="dropbtn" >个⼈中⼼<i class="fa fa-caret-down" aria-hidden="true"></i></span>
        <div class="dropdown-content">
            <ul>
                <li><a href="/src/php/upload.php"><img src="src/img/icons/shangchuan.png" width="20" height="20">  <font color="white">Upload</font></li></a>
                <li><a href="/src/php/myphotos.php"><img src="src/img/icons/tupian.png" width="20" height="20">  <font color="white">My Photos</font></li></a>
                <li><a href="/src/php/mycollections.php"><img src="src/img/icons/shoucang.png" width="20" height="20">  <font color="white">My Collections</font></li></a>
                <li><a href="/index.php"><img src="src/img/icons/gengduo.png" width="20" height="20">  <font color="white">Log Out</font></li></a>
            </ul>
        </div>
    </div>';
    } else {
        echo '<div class="NavBar_right dropdown" id="userCenterNav">
        <span class="dropbtn" ><a href="src/php/login.php"><font color="grey">Log In<i class="fa fa-caret-down" aria-hidden="true"></font></i></a></span>
        </div>';
    }
    ?>
</div>

<!--头图-->
<div class="scale">
    <img src="src/img/travelimages/normal/medium/9494282329.jpg" alt="头图">
</div>

<!--图⽚展示-->
<div>
    <!--第一行-->
    <div class="container-1">

        <div class="container-1-1">
            <div>
                <a href="/src/php/detail.php" id="img1">
                    <img src="src/img/travelimages/normal/medium/1.jpg" alt="pic" width="240px" height="240px">
                </a>
            </div>
            <div class="textOneRow textBox">
                <h3 id="title1">title</h3>
                <p id="describe1">我要写不完pj了啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊。 </p>
            </div>
        </div>

        <div class="container-1-2">
            <div>
                <a href="./src/php/detail.php" id="img2">
                    <img src="src/img/travelimages/normal/medium/2.jpg" alt="pic" width="240px" height="240px">
                </a>
            </div>
            <div class="textOneRow textBox">
                <h3 id="title2">title</h3>
                <p id="describe2">我要写不完pj了啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊。 </p>
            </div>
        </div>

        <div class="container-1-3">
            <a href="/src/php/detail.php" id="img3">
                <img src="src/img/travelimages/normal/medium/3.jpg" alt="pic" width="240px" height="240px">
            </a>
            <div class="textOneRow textBox">
                <h3 id="title3">title</h3>
                <p id="describe3">我要写不完pj了啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊。 </p>
            </div>
        </div>

        <div class="clear"></div>
    </div>

    <div class="container-1">
        <div class="container-2-1">
            <a href="/src/php/detail.php" id="img4">
                <img src="src/img/travelimages/normal/medium/4.jpg" alt="pic" width="240px" height="240px">
            </a>
            <div class="textOneRow textBox">
                <h3 id="title4">title</h3>
                <p id="describe4">我要写不完pj了啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊。</p>
            </div>
        </div>
        <div class="container-2-1">
            <a href="/src/php/detail.php" id="img5">
                <img src="src/img/travelimages/normal/medium/5.jpg" alt="pic" width="240px" height="240px">
            </a>
            <div class="textOneRow textBox">
                <h3 id="title5">title</h3>
                <p id="describe5">我要写不完pj了啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊。</p>
            </div>
        </div>
        <div class="container-2-1">
            <a href="/src/php/detail.php" id="img6">
                <img src="src/img/travelimages/normal/medium/6.jpg" alt="pic" width="240px" height="240px">
            </a>
            <div class="textOneRow textBox">
                <h3 id="title6">title</h3>
                <p id="describe6">我要写不完pj了啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊。 </p>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<br><br><br><br><br><br>

<footer>
    <ul>
        <li>我Web课大概率要恰F，是时候准备重修了</li>
        <li>想不出什么骚话，告辞</li>
    </ul>
</footer>

<!--button-->
<div>
    <div class="refresh" onclick="alert('图片已刷新')"><img src="src/img/icons/shuaxin.png" alt="..." style=width:50px;>
    </div>
    <div>
        <div class="toTop" id="toTop"><img src="src/img/icons/1.png" alt="..." >
            <script type="text/javascript">
                toTop.onclick = function(){
                    document.body.scrollTop = document.documentElement.scrollTop = 0;
                }
            </script>
        </div>

</body>
<script src="../js/jquery-3.3.1.min.js"></script>

