<?php
session_start();
require_once('config.php');

$_SESSION['title'] = null;
$_SESSION['description'] = null;

function generate($result)
{
    $i = 0;
    while (($row = $result->fetch()) && $i < 18) {
        echo '<li class="thumbnail" title="' . $row['Title'] . '">
                <a href="detail.php?imageid=' . $row['ImageID'] . '">
                    <div class="img-box">
                        <img src="../travel-images/small/' . $row['PATH'] . '" alt="pic">
                    </div>
                    <div><h3>' . $row['Title'] . '</h3>
                        <p>' . $row['Description'] . '</p>
                    </div>
                </a>
            </li>';
        $i++;
    }
}

function fuzzyQueryFirst()
{
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pattern = '/\b[a-zA-Z0-9]+\b/';
        if ($_POST['search_type'] == "search_by_title" || !empty($_GET['title'])) {
            preg_match_all($pattern, $_SESSION['title'], $res);
            $i = 0;
            $sql = 'SELECT ImageID,PATH,Title,Description FROM travelimage WHERE Title LIKE "%' . $res[0][$i] . '%"';
            $i++;
            while ($i < count($res[0])) {
                $sql = $sql . 'UNION SELECT ImageID,PATH,Title,Description FROM travelimage WHERE Title LIKE "%' . $res[0][$i] . '%"';
                $i++;
            }
        } elseif ($_POST['search_type'] == "search_by_description" || !empty($_GET['description'])) {
            preg_match_all($pattern, $_SESSION['description'], $res);
            $i = 0;
            $sql = 'SELECT ImageID,PATH,Title,Description FROM travelimage WHERE Description LIKE "%' . $res[0][$i] . '%"';
            $i++;
            while ($i < count($res[0])) {
                $sql = $sql . 'UNION SELECT ImageID,PATH,Title,Description FROM travelimage WHERE Description LIKE "%' . $res[0][$i] . '%"';
                $i++;
            }
        }
        $statement = $pdo->query($sql);
        if (($_SESSION['sum'] = $statement->rowCount()) > 0) {
            generate($statement);
        } else {
            echo '<h4>搜索无结果</h4>';
        }
        $pdo = null;
    } catch (PDOException $e) {
        $pdo = null;
        echo '<script>alert("错误：无法连接到服务器")</script>';
    }
}

function fuzzyQueryAgain()
{
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pattern = '/\b[a-zA-Z0-9]+\b/';
        if ($_POST['search_type'] == "search_by_title" || !empty($_GET['title'])) {
            preg_match_all($pattern, $_SESSION['title'], $res);
            $i = 0;
            $sql = 'SELECT ImageID,PATH,Title,Description FROM travelimage WHERE Title LIKE "%' . $res[0][$i] . '%"';
            $i++;
            while ($i < count($res[0])) {
                $sql = $sql . 'UNION SELECT ImageID,PATH,Title,Description FROM travelimage WHERE Title LIKE "%' . $res[0][$i] . '%"';
                $i++;
            }
        } elseif ($_POST['search_type'] == "search_by_description" || !empty($_GET['description'])) {
            preg_match_all($pattern, $_SESSION['description'], $res);
            $i = 0;
            $sql = 'SELECT ImageID,PATH,Title,Description FROM travelimage WHERE Description LIKE "%' . $res[0][$i] . '%"';
            $i++;
            while ($i < count($res[0])) {
                $sql = $sql . 'UNION SELECT ImageID,PATH,Title,Description FROM travelimage WHERE Description LIKE "%' . $res[0][$i] . '%"';
                $i++;
            }
        }
        $num = $_SESSION['page'] * 18;
        $sql = $sql . "LIMIT $num,18";
        $statement = $pdo->query($sql);
        if ($statement->rowCount() > 0) {
            generate($statement);
        } else {
            echo '<h4>搜索无结果</h4>';
        }
        $pdo = null;
    } catch (PDOException $e) {
        $pdo = null;
        echo '<script>alert("错误：无法连接到服务器")</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link rel="stylesheet" type="text/css" href="/src/css/NavBar.css">
    <link rel="stylesheet" type="text/css" href="/src/css/footer.css">
    <link rel="stylesheet" type="text/css" href="/src/css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="/src/css/fanye.css">
    <link rel="stylesheet" type="text/css" href="/src/css/image.css">
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
                <a href="/src/php/search.php"  class="highlight">Search</a>
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
</header>

<main>
    <form method="post" action="search.php">
        <h1>搜索</h1>
        <div class="search_box">
            <input type="radio" value="search_by_title" name="search_type" id="search_by_title" checked>
            <label for="search_by_title">按标题查询</label>
            <input type="search" name="title">
            <input type="radio" value="search_by_description" name="search_type" id="search_by_description">
            <label for="search_by_description">按描述查询</label>
            <textarea type="search" name="description"></textarea>
            <input type="submit" value="搜索" name="search" id="search">
        </div>
    </form>
    <section class="imgGroup">
        <?php
        if (isset($_GET['submit']) || $_SERVER["REQUEST_METHOD"] == "POST") {
            echo '<h2>结果</h2>';
        }
        ?>
        <ul>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['search_type'] == "search_by_title" && $_POST['title'] != "") {
                $_SESSION['title'] = $_POST['title'];
                $_SESSION['description'] = null;
                $_SESSION['page'] = 0;
                $_SESSION['sum'] = 0;
                fuzzyQueryFirst();
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['search_type'] == "search_by_description" && $_POST['description'] != "") {
                $_SESSION['title'] = null;
                $_SESSION['description'] = $_POST['description'];
                $_SESSION['page'] = 0;
                $_SESSION['sum'] = 0;
                fuzzyQueryFirst();
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo "<h4>请输入内容</h4>";
            }
            if (isset($_GET['title'])) {
                $_SESSION['title'] = $_GET['title'];
            }
            if (isset($_GET['description'])) {
                $_SESSION['description'] = $_GET['description'];
            }
            if (isset($_GET['submit'])) {
                if (isset($_GET['page']) && $_GET['page'] != "") {
                    $_SESSION['page'] = $_GET['page'];
                    if ($_SESSION['page'] == 0) {
                        fuzzyQueryFirst();
                    } else {
                        fuzzyQueryAgain();
                    }
                } else {
                    fuzzyQueryFirst();
                }
            }

            ?>
    </section>
</main>

<div id="pagination" class="pagination">
    <ul>
        <?php
        if (($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['description'] != "" || $_POST['title'] != "")) || isset($_GET['submit'])) {
            creatPageNumber();
        }

        function isActive($num)
        {
            if ($num == $_SESSION['page']) {
                return "active";
            } else {
                return "";
            }
        }

        function creatPageNumber()
        {
            $total = floor(($_SESSION['sum'] / 18) + 1);
            if ($total > 1 && $total < 6) {
                if ($_SESSION['page'] > 0) {
                    echo '<a href="' . changePage(0) . '">首页</a>
                <a href="' . changePage($_SESSION['page'] - 1) . '"><</a>';
                }
                for ($i = 0; $i < $total; $i++) {
                    echo '<a href="' . changePage($i) . '" class="' . isActive($i) . '">' . ($i + 1) . '</a>';
                }
                if ($_SESSION['page'] < $total - 1) {
                    echo '<a href="' . changePage($_SESSION['page'] + 1) . '"> > </a>';
                    echo '<a href="' . changePage($total - 1) . ' ">尾页</a>';
                }
            } elseif ($total > 5) {
                if ($_SESSION['page'] > 1) {
                    echo '<a href="' . changePage(0) . '">首页</a>
                <a href="' . changePage($_SESSION['page'] - 1) . '"> < </a>';
                }
                if ($_SESSION['page'] < 2) {
                    for ($i = 0; $i < 5; $i++) {
                        echo '<a href="' . changePage($i) . '" class="' . isActive($i) . '">' . ($i + 1) . '</a>';
                    }
                } else {
                    for ($i = $_SESSION['page'] - 2; $i <= $i = $_SESSION['page'] + 2; $i++) {
                        echo '<a href="' . changePage($i) . '" class="' . isActive($i) . '">' . ($i + 1) . '</a>';
                    }
                }
                if ($_SESSION['page'] < $total - 1) {
                    echo '<a href="' . changePage($_SESSION['page'] + 1) . '"> > </a>';
                    echo '<a href="' . changePage($total - 1) . ' ">尾页</a>';
                }
            }
        }

        function changePage($num)
        {
            if (isset($_GET['title']) || $_POST['search_type'] == "search_by_title") {
                $url = "search.php?page=" . $num;
                $url = $url . "&title=" . $_SESSION['title'];
                $url = $url . "&submit=搜索";
                return $url;
            } elseif (isset($_GET['description']) || $_POST['search_type'] == "search_by_description") {
                $url = "search.php?page=" . $num;
                $url = $url . "&description=" . $_SESSION['description'];
                $url = $url . "&submit=搜索";
                return $url;
            }
        }

        ?>
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