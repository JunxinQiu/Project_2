<?php
session_start();
require_once('config.php');

function generate($result)
{
    $i = 0;
    while (($row = $result->fetch()) && $i < 18) {
        echo '<li class="thumbnail" title="' . $row['Title'] . '">
                <a href="detail.php?imageid=' . $row['ImageID'] . '">
                    <div class="img-box">
                        <img src="../travel-images/small/' . $row['PATH'] . '" alt="图片">
                    </div>
                    <div><h3>' . $row['Title'] . '</h3>
                        <p>' . $row['Description'] . '</p>
                    </div>
                </a>
                <div class="editBox">
                     <a href="uncollect.php?imageid=' . $row['ImageID'] . '">取消收藏</a>
                </div>
            </li>';
        $i++;
    }
}

function generateFav()
{
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $sql = 'SELECT travelimagefavor.ImageID,PATH,Title,Description FROM travelimagefavor JOIN travelimage ON travelimage.ImageID=travelimagefavor.ImageID WHERE travelimagefavor.UID=:id';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $_SESSION['id']);
        $statement->execute();
        if (($_SESSION['sum'] = $statement->rowCount()) > 0) {
            generate($statement);
        } else {
            echo '<h4>您还没有收藏的图片</h4>';
        }
    }catch (PDOException $e){
        echo '<h4>服务器连接错误</h4>';
    }
}
?>


<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>MyCollection</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/src/css/NavBar.css">
    <link rel="stylesheet" type="text/css" href="/src/css/footer.css">
    <link rel="stylesheet" type="text/css" href="/src/css/search.css">
    <link rel="stylesheet" type="text/css" href="/src/css/browse.css">
    <link rel="stylesheet" type="text/css" href="/src/css/fanye.css">
    <link rel="stylesheet" type="text/css" href="/src/css/image.css">
</head>
<body>
<header class="mainImg">
    <div class="NavBar">
        <!--logo-->
        <div>
            <a href="/index.php">
                <img src="/src/img/icons/githublogo.png" alt="logo">
            </a>
        </div>
        <div class="NavBar_left">
            <ul>
                <li>
                    <a href="/index.php" >Home</a>
                </li>
                <li>
                    <a href="/src/php/browse.php" class="highlight">Browse</a>
                </li>
                <li>
                    <a href="/src/php/search.php">Search</a>
                </li>
            </ul>
        </div>
       <div class="NavBar_right dropdown" id="userCenterNav">
        <span class="dropbtn" >个⼈中⼼<i class="fa fa-caret-down" aria-hidden="true"></i></span>
        <div class="dropdown-content">
            <ul>
                <li><a href="/src/php/upload.php"><img src="/src/img/icons/shangchuan.png" width="20" height="20">  <font color="white">Upload</font></li></a>
                <li><a href="/src/php/myphotos.php"><img src="/src/img/icons/tupian.png" width="20" height="20">  <font color="white">My Photos</font></li></a>
                <li><a href="/src/php/mycollection.php"><img src="/src/img/icons/shoucang.png" width="20" height="20">  <font color="white">My Collections</font></li></a>
                <li><a href="/index.php"><img src="/src/img/icons/gengduo.png" width="20" height="20">  <font color="white">Log Out</font></li></a>
            </ul>
        </div>
    </div>
</header>


<main>
    <h2>我的收藏</h2>
    <section class="imgGroup">
        <ul>
            <li class="thumbnail">
                <a href="detail.php">
                    <div class="img-box">
                        <img src="../img/travel-images/small/5855174537.jpg" alt="图片">
                    </div>
                    <div><h3>Title</h3>
                        <p>Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.</p>
                        <form>
                            <input type="button" value="删除" name="delete" onclick="alert('已删除')">
                        </form>
                    </div>
                </a>
            </li>
            <li class="thumbnail">
                <a href="detail.php">
                    <div class="img-box">
                        <img src="../img/travel-images/small/6114850721.jpg" alt="图片">
                    </div>
                    <div><h3>Title</h3>
                        <p>Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.
                        </p>
                        <form>
                            <input type="button" value="删除" name="delete" onclick="alert('已删除')">
                        </form>
                    </div>
                </a>
            </li>
            <li class="thumbnail">
                <a href="detail.php">
                    <div class="img-box">
                        <img src="../img/travel-images/small/8710247776.jpg" alt="图片">
                    </div>
                    <div><h3>Title</h3>
                        <p>Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.</p>
                        <form>
                            <input type="button" value="删除" name="delete" onclick="alert('已删除')">
                        </form>
                    </div>
                </a>
            </li>
            <li class="thumbnail">
                <a href="detail.php">
                    <div class="img-box">
                        <img src="../img/travel-images/small/9493997865.jpg" alt="图片">
                    </div>
                    <div><h3>Title</h3>
                        <p>Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.</p>
                        <form>
                            <input type="button" value="删除" name="delete" onclick="alert('已删除')">
                        </form>
                    </div>
                </a>
            </li>
            <li class="thumbnail">
                <a href="detail.php">
                    <div class="img-box">
                        <img src="../img/travel-images/small/222222.jpg" alt="图片">
                    </div>
                    <div><h3>Title</h3>
                        <p>Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.</p>
                        <form>
                            <input type="button" value="删除" name="delete" onclick="alert('已删除')">
                        </form>
                    </div>
                </a>
            </li>
            <li class="thumbnail">
                <a href="detail.php">
                    <div class="img-box">
                        <img src="../img/travel-images/small/8645912379.jpg" alt="图片">
                    </div>
                    <div><h3>Title</h3>
                        <p>Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.</p>
                        <form>
                            <input type="button" value="删除" name="delete" onclick="alert('已删除')">
                        </form>
                    </div>
                </a>
            </li>
            <li class="thumbnail">
                <a href="details.php">
                    <div class="img-box">
                        <img src="../img/travel-images/small/6592317633.jpg" alt="图片">
                    </div>
                    <div><h3>Title</h3>
                        <p>Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.</p>
                        <form>
                            <input type="button" value="删除" name="delete" onclick="alert('已删除')">
                        </form>
                    </div>
                </a>
            </li>
            <li class="thumbnail">
                <a href="detail.php">
                    <div class="img-box">
                        <img src="../img/travel-images/small/6115548152.jpg" alt="图片">
                    </div>
                    <div><h3>Title</h3>
                        <p>Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.Making a html page is so hard that I burst into tears when the ddl is approaching. In order to finish the pj on time, I have to stay up very very very very late which means I can't get enough sleep and that is killing me. I hate myself.
                        </p>
                        <form>
                            <input type="button" value="删除" name="delete" onclick="alert('已删除')">
                        </form>
                    </div>
                </a>
            </li>
        </ul>
    </section>
</main>

<div id="pagination" class="pagination">
    <ul>
        <li>首页</li>
        <li><</li>
        <li class="active">1</li>
        <li>2</li>
        <li>3</li>
        <li>4</li>
        <li>5</li>
        <li>></li>
        <li>尾页</li>
    </ul>
</div>

<footer>
    <ul>
        <li>我Web课大概率要恰F，是时候准备重修了</li>
        <li>想不出什么骚话，告辞</li>
    </ul>
</footer>
</body>
</html>