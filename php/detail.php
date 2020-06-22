<?php
session_start();
require_once('config.php');
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <title>Detail</title>
    <link rel="stylesheet" type="text/css" href="/src/css/NavBar.css">
    <link rel="stylesheet" type="text/css" href="/src/css/footer.css">
    <link rel="stylesheet" type="text/css" href="/src/css/details.css">
</head>
<body>
<!--导航栏-->
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
                <a href="/index.php">Home</a>
            </li>
            <li>
                <a href="/src/php/browse.php" class="highlight">Browse</a>
            </li>
            <li>
                <a href="/src/php/search.php">Search</a>
            </li>
        </ul>
    </div>
    <?php
    if (isset($_SESSION['id'])) {
        echo '<div class="NavBar_right dropdown" id="userCenterNav">
        <span class="dropbtn" >个⼈中⼼<i class="fa fa-caret-down" aria-hidden="true"></i></span>
        <div class="dropdown-content">
            <ul>
                <li><a href="/src/php/upload.php"><img src="/src/img/icons/shangchuan.png" width="20" height="20">  <font color="white">Upload</font></li></a>
                <li><a href="/src/php/myphotos.php"><img src="/src/img/icons/tupian.png" width="20" height="20">  <font color="white">My Photos</font></li></a>
                <li><a href="/src/php/mycollections.php"><img src="/src/img/icons/shoucang.png" width="20" height="20">  <font color="white">My Collections</font></li></a>
                <li><a href="/index.php"><img src="/src/img/icons/gengduo.png" width="20" height="20">  <font color="white">Log Out</font></li></a>
            </ul>
        </div>
    </div>';
    } else {
        echo '<div class="NavBar_right dropdown" id="userCenterNav">
        <span class="dropbtn" ><a href="/src/php/login.php"><font color="grey">Log In<i class="fa fa-caret-down" aria-hidden="true"></font></i></a></span>
        </div>';
    }
    ?>
</div>

<main>
    <?php
    try {
        $pdo = new PDO('DBCONNSTRING', 'DBUSER', 'DBPASS');
        $sql = "select Content,Description,Title,PATH from travelimage where ImageID=:imageid";
        $result = $pdo->prepare($sql);
        $result->bindValue(':imageid', $_GET['imageid']);
        $result->execute();
        $figure = $result->fetch();
        $theme = $figure['Content'];
        $description = $figure['Description'];
        $title = $figure['Title'];
        $path=$figure['PATH'];

        $sql = "select UID from travelimage join travelimagefavor on travelimage.ImageID=travelimagefavor.ImageID where travelimage.ImageID=:imageid";
        $result = $pdo->prepare($sql);
        $result->bindValue(':imageid', $_GET['imageid']);
        $result->execute();
        $favor = $result->rowCount();
        $collected = false;
        while ($row = $result->fetch()) {
            if ($row['UID'] == $_SESSION['id']) {
                $collected = true;
            }
        }
        $collected = $collected ? "favor" : "";

        $sql = "select CountryName from travelimage join geocountries_regions on travelimage.CountryCodeISO=geocountries_regions.ISO where ImageID=:imageid";
        $result = $pdo->prepare($sql);
        $result->bindValue(':imageid', $_GET['imageid']);
        $result->execute();
        $figure = $result->fetch();
        $country = $figure['CountryName'];

        $sql = "select AsciiName from travelimage join geocities on travelimage.CityCode=geocities.GeoNameID where ImageID=:imageid";
        $result = $pdo->prepare($sql);
        $result->bindValue(':imageid', $_GET['imageid']);
        $result->execute();
        $figure = $result->fetch();
        $city = $figure['AsciiName'];
        echo '<h2>' . $title . '</h2>
        <figure>
        <img src="../travel-images/medium/' . $path . '" >
        <div class="content">
            <ul>
                <li>收藏人数</li>
                <li class="collection_number"><span>' . $favor . '</span><button onclick="alert(\'已收藏\')" class="' . $collected . '"></button></li>
            </ul>
            <ul>
                <li>图片信息</li>
                <li>主题:<span class="subject">' . $theme . '</span></li>
                <li>国家:<span class="country">' . $country . '</span> </li>
                <li>城市:<span class="city">' . $city . '</span> </li>
            </ul>
        </div>
    </figure>
    <article>
        <p>' . $description . '</p>
    </article>';
    } catch (PDOException $e) {
        echo '<script>alert("服务器错误！")</script>';
    }

    ?>
<footer>
    <ul>
        <li>我Web课大概率要恰F，是时候准备重修了</li>
        <li>想不出什么骚话，告辞</li>
    </ul>
</footer>
</body>
</html>