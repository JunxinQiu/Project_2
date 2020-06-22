<?php
session_start();
require_once('config.php');


function upload()
{
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    echo $_FILES["file"]["size"];
    $extension = end($temp);     // 获取文件后缀名
    if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 102400)   // 小于 10 MB
        && in_array($extension, $allowedExts)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "错误：: " . $_FILES["file"]["error"] . "<br>";
        } else {
            echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
            echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
            echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
            echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";

            // 判断当前目录下的 upload 目录是否存在该文件
            // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
            if (file_exists("upload/" . $_FILES["file"]["name"])) {
                echo '<script>alert(" 该文件已经存在! ")</script>';
            } else {
                try {
                    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                    $iso = "";
                    $latitude = "";
                    $longitude = "";
                    $citycode = "";

                    if ($_POST['city'] != 'placeholder') {
                        $sql = 'SELECT Latitude,Longitude,GeoNameID,CountryCodeISO FROM geocities WHERE AsciiName=:city LIMIT 1';
                        $statement = $pdo->prepare($sql);
                        $statement->bindValue(':city', $_POST['city']);
                        $statement->execute();
                        $row = $statement->fetch();
                        $iso = $row['CountryCodeISO'];
                        $latitude = $row['Latitude'];
                        $longitude = $row['Longitude'];
                        $citycode = $row['GeoNameID'];
                    } else {
                        $sql = 'SELECT ISO FROM geocountries_regions WHERE CountryName=:countryname';
                        $statement = $pdo->prepare($sql);
                        $statement->bindValue(':countryname', $_POST['country']);
                        $statement->execute();
                        $row = $statement->fetch();
                        $iso = $row['ISO'];
                    }

                    $sql = 'INSERT INTO travelimage (Title,Description,Latitude,Longitude,CityCode,CountryCodeISO,UID,PATH,Content) VALUES (:title,:description,:latitude,:longitude,:citycode,:iso,:uid,:path,:content)';
                    $statement = $pdo->prepare($sql);
                    $statement->bindValue(':title', $_POST['title']);
                    $statement->bindValue(':description', $_POST['description']);
                    $statement->bindValue(':latitude', $latitude);
                    $statement->bindValue(':longitude', $longitude);
                    $statement->bindValue(':citycode', $citycode);
                    $statement->bindValue(':iso', $iso);
                    $statement->bindValue(':uid', $_SESSION['id']);
                    $statement->bindValue(':path', '../travel-images/large/' . $_FILES["file"]["name"]);
                    $statement->bindValue(':content', $_POST['content']);
                    $statement->execute();

                    if ($statement) {
                        move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
                        echo "文件存储在: " . "upload/" . $_FILES["file"]["name"];

                        header("location: login.php");
                    } else {
                        '<script>alert("文件上传失败")</script>';
                    }

                    $pdo = null;
                } catch (PDOException $e) {
                    '<script>alert("服务器又双挂了")</script>';
                }
            }
        }
    } else {
        echo '<script>alert("非法的文件格式")</script>';
    }
}


?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Upload</title>
    <link rel="stylesheet" type="text/css" href="/src/css/uploadimg.css">
    <link rel="stylesheet" type="text/css" href="/src/css/NavBar.css">
    <link rel="stylesheet" type="text/css" href="/src/css/footer.css">
</head>
<body>
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
                <a href="/src/php/browse.php">Browse</a>
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
                <li><a href="/src/php/myphotos.html"><img src="/src/img/icons/tupian.png" width="20" height="20">  <font color="white">My Photos</font></li></a>
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
    <form action="upload.php" method="post"><h3>选择图片</h3>
        <label for="ImagesUpload" id="ImgUpBtn" class="ImgUpBtnBox">
            <input type="file" accept="image/*" name="ImagesUpload" id="ImagesUpload" class="uploadHide">
        </label>
        <div class="ImagesUpload" id="img-preview"></div>
        <div id="removeBox"></div>
        <label><p>图片标题</p>
            <input type="text" name="title" class="title" required>
        </label>
        <label><p>图片描述</p>
            <textarea name="description" class="description" required></textarea>
        </label>
        <label><p>拍摄国家</p>
            <input type="text" name="country" class="country" required>
        </label>
        <label><p>拍摄城市</p>
            <input type="text" name="city" class="city" required>
        </label>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            upload();
        }
        ?>
        <input type="submit" class="submit" value="上传">
    </form>
</main>
<footer>
    <ul>
        <li>我Web课大概率要恰F，是时候准备重修了</li>
        <li>想不出什么骚话，告辞</li>
    </ul>
</footer>
<script src="../js/UIscript.js" rel="script" type="text/javascript"></script>
</body>
</html>