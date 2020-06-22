<?php
session_start();
require_once('config.php');

function generate($result)
{
    $i = 0;
    while (($row = $result->fetch()) && $i < 18) {
        echo '<li class="thumbnail" title="' . $row['Title'] . '">
                <a href="details.php?imageid=' . $row['ImageID'] . '">
                    <div class="img-box">
                        <img src="../travel-images/small/' . $row['PATH'] . '" alt="图片" width="150" height="150">
                    </div>
                </a>
            </li>';
        $i++;
    }
}


function search_first()
{
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        if ($_SESSION['theme'] != "placeholder" && $_SESSION['theme'] != null && $_SESSION['country'] == "placeholder") {
            $sql = 'SELECT ImageID,PATH,Title FROM travelimage WHERE Content=:theme ORDER BY ImageID';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':theme', $_SESSION['theme']);
            $statement->execute();
            if (($_SESSION['sum'] = $statement->rowCount()) > 0) {
                generate($statement);
            } else {
                echo '<h4>筛选无结果</h4>';
            }
        } elseif (($_SESSION['theme'] == "placeholder" || $_SESSION['theme'] == null) && $_SESSION['country'] != "placeholder") {
            if ($_SESSION['city'] == "placeholder" || $_SESSION['city'] == null) {
                $sql = 'SELECT ImageID,PATH,Title FROM travelimage JOIN geocountries_regions ON travelimage.CountryCodeISO=geocountries_regions.ISO WHERE CountryName=:countryname ORDER BY ImageID';
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':countryname', $_SESSION['country']);
            } else {
                $sql = 'SELECT ImageID,PATH,Title FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE AsciiName LIKE :cityname ORDER BY ImageID';
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':cityname', "%" . $_SESSION['city'] . "%");
            }
            $statement->execute();
            if (($_SESSION['sum'] = $statement->rowCount()) > 0) {
                generate($statement);
            } else {
                echo '<h4>筛选无结果</h4>';
            }
        } elseif ($_SESSION['theme'] != "placeholder" && $_SESSION['theme'] != null && $_SESSION['country'] != "placeholder") {
            if ($_SESSION['city'] == "placeholder" || $_SESSION['city'] == null) {
                $sql = 'SELECT ImageID,PATH,Title FROM travelimage JOIN geocountries_regions ON travelimage.CountryCodeISO=geocountries_regions.ISO WHERE Content=:theme AND CountryName=:countryname ORDER BY ImageID';
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':countryname', $_SESSION['country']);
            } else {
                $sql = 'SELECT ImageID,PATH,Title FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE Content=:theme AND AsciiName LIKE :cityname ORDER BY ImageID';
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':cityname', "%" . $_SESSION['city'] . "%");
            }
            $statement->bindValue(':theme', $_SESSION['theme']);
            $statement->execute();
            if (($_SESSION['sum'] = $statement->rowCount()) > 0) {
                generate($statement);
            } else {
                echo '<h4>筛选无结果</h4>';
            }
        } else {
            echo '<h4>请选择筛选条件</h4>';
        }
        $pdo = null;
    } catch (PDOException $e) {
        $pdo = null;
        echo '<script>alert("无法连接到服务器")</script>';
    }
}

function search_again()
{
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        if ($_SESSION['theme'] != "placeholder" && $_SESSION['theme'] != null && $_SESSION['country'] == "placeholder") {
            $num = $_SESSION['page'] * 18;
            $sql = "SELECT ImageID,PATH,Title FROM travelimage WHERE Content=:theme ORDER BY ImageID LIMIT $num,18";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':theme', $_SESSION['theme']);
            $statement->execute();
            if ($statement->rowCount() > 0) {
                generate($statement);
            } else {
                echo '<h4>无结果</h4>';
            }
        } elseif (($_SESSION['theme'] == "placeholder" || $_SESSION['theme'] == null) && $_SESSION['country'] != "placeholder") {
            $num = $_SESSION['page'] * 18;
            if ($_SESSION['city'] == "placeholder" || $_SESSION['city'] == null) {
                $sql = "SELECT ImageID,PATH,Title FROM travelimage JOIN geocountries_regions ON travelimage.CountryCodeISO=geocountries_regions.ISO WHERE CountryName=:countryname ORDER BY ImageID LIMIT $num,18";
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':countryname', $_SESSION['country']);
            } else {
                $sql = "SELECT ImageID,PATH,Title FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE AsciiName LIKE :cityname ORDER BY ImageID LIMIT $num,18";
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':cityname', "%" . $_SESSION['city'] . "%");
            }
            $statement->execute();
            if ($statement->rowCount() > 0) {
                generate($statement);
            } else {
                echo '<h4>无结果</h4>';
            }
        } elseif ($_SESSION['theme'] != "placeholder" && $_SESSION['theme'] != null && $_SESSION['country'] != "placeholder") {
            $num = $_SESSION['page'] * 18;
            if ($_SESSION['city'] == "placeholder" || $_SESSION['city'] == null) {
                $sql = "SELECT ImageID,PATH,Title FROM travelimage JOIN geocountries_regions ON travelimage.CountryCodeISO=geocountries_regions.ISO WHERE Content=:theme AND CountryName=:countryname ORDER BY ImageID LIMIT $num,18";
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':countryname', $_SESSION['country']);
            } else {
                $sql = "SELECT ImageID,PATH,Title FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE Content=:theme AND AsciiName LIKE :cityname ORDER BY ImageID LIMIT $num,18";
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':cityname', "%" . $_SESSION['city'] . "%");
            }
            $statement->bindValue(':theme', $_SESSION['theme']);
            $statement->execute();
            if ($statement->rowCount() > 0) {
                generate($statement);
            } else {
                echo '<h4>无结果</h4>';
            }
        } else {
            echo '<h4>请选择筛选条件</h4>';
        }
        $pdo = null;
    } catch (PDOException $e) {
        $pdo = null;
        echo '<script>alert("连接服务器失败")</script>';
    }
}

function fuzzyQueryFirst()
{
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pattern = '/\b[a-zA-Z0-9]+\b/';
        preg_match_all($pattern, $_SESSION['title'], $res);
        $i = 0;
        $sql = 'SELECT ImageID,PATH,Title FROM travelimage WHERE Title LIKE "%' . $res[0][$i] . '%"';
        $i++;
        while ($i < count($res[0])) {
            $sql = $sql . 'UNION SELECT ImageID,PATH,Title FROM travelimage WHERE Title LIKE "%' . $res[0][$i] . '%"';
            $i++;
        }
        $statement=$pdo->query($sql);
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
        preg_match_all($pattern, $_SESSION['title'], $res);
        $i = 0;
        $sql = 'SELECT ImageID,PATH,Title FROM travelimage WHERE Title LIKE "%' . $res[0][$i] . '%"';
        $i++;
        while ($i < count($res[0])) {
            $sql = $sql . 'UNION SELECT ImageID,PATH,Title FROM travelimage WHERE Title LIKE "%' . $res[0][$i] . '%"';
            $i++;
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
        echo '<script>alert("连接服务器失败")</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Browse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/src/css/NavBar.css">
    <link rel="stylesheet" type="text/css" href="/src/css/footer.css">
    <link rel="stylesheet" type="text/css" href="/src/css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="/src/css/browse.css">
    <link rel="stylesheet" type="text/css" href="/src/css/fanye.css">
</head>
<body class="browse">
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

<aside id="sidebar" class="sidebar">
    <a href="javascript:toTop()" id="toTop"><span>︿</span><span>Top</span></a>
</aside>

<div class="browse_box">
    <aside class="search_nav">
        <div class="search_bar">
            <form method="post" action="browse.php">
                <input name="title" placeholder="请输入关键字" type="text" required>
                <input name="submit2" type="submit" value="搜索" class="button">
            </form>
        </div>
        <div class="search_list">
            <nav>
                <ul>
                    <li>热门内容快速浏览</li>
                    <li>
                        <a href="browse.php?theme=scenery&country=placeholder&city=placeholder&page=0&submit1=筛+选">自然风景</a>
                    </li>
                    <li><a href="browse.php?theme=city&country=placeholder&city=placeholder&page=0&submit1=筛+选">城市建筑</a>
                    </li>
                    <li>
                        <a href="browse.php?theme=people&country=placeholder&city=placeholder&page=0&submit1=筛+选">唯美人像</a>
                    </li>
                    <li>
                        <a href="browse.php?theme=animal&country=placeholder&city=placeholder&page=0&submit1=筛+选">自然动物</a>
                    </li>
                </ul>
            </nav>
            <nav>
                <ul>
                    <li>热门国家快速浏览</li>
                    <li><a href="browse.php?theme=placeholder&country=China&city=placeholder&page=0&submit1=筛+选">中国</a>
                    </li>
                    <li><a href="browse.php?theme=placeholder&country=Italy&city=placeholder&page=0&submit1=筛+选">意大利</a>
                    </li>
                    <li><a href="browse.php?theme=placeholder&country=Japan&city=placeholder&page=0&submit1=筛+选">日本</a>
                    </li>
                    <li>
                        <a href="browse.php?theme=placeholder&country=United+States&city=placeholder&page=0&submit1=筛+选">美国</a>
                    </li>
                </ul>
            </nav>
            <nav>
                <ul>
                    <li>热门城市快速浏览</li>
                    <li><a href="browse.php?theme=placeholder&country=China&city=Shanghai&page=0&submit1=筛+选">上海</a>
                    </li>
                    <li>
                        <a href="browse.php?theme=placeholder&country=United+States&city=New+York&page=0&submit1=筛+选">纽约</a>
                    </li>
                    <li><a href="browse.php?theme=placeholder&country=France&city=Paris&page=0&submit1=筛+选">巴黎</a></li>
                    <li>
                        <a href="browse.php?theme=placeholder&country=United+Kingdom&city=London&page=0&submit1=筛+选">伦敦</a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <main>
        <p>图库浏览</p>
        <form action="browse.php" class="selects" method="post">
            <select name="theme">
                <option value="placeholder" selected>按主题筛选</option>
                <option value="scenery">scenery</option>
                <option value="city">city</option>
                <option value="people">people</option>
                <option value="animal">animal</option>
                <option value="building">building</option>
                <option value="wonder">wonder</option>
                <option value="other">other</option>
            </select>
            <select name="country" id="country" onchange="addOption()">
                <option value="placeholder" selected>按国家筛选</option>
            </select>
            <select name="city" id="city"></select>
            <input name="submit1" type="submit" value="筛 选">
        </form>
        <ul>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit1'])) {
                $_SESSION['theme'] = $_POST['theme'];
                $_SESSION['country'] = $_POST['country'];
                $_SESSION['city'] = $_POST['city'];
                $_SESSION['request'] = 'submit1';
                $_SESSION['page'] = 0;
                $_SESSION['sum'] = 0;
                search_first();
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit2'])) {
                $_SESSION['title'] = $_POST['title'];
                $_SESSION['request'] = 'submit2';
                $_SESSION['page'] = 0;
                $_SESSION['sum'] = 0;
                fuzzyQueryFirst();
            }
            if (isset($_GET['submit1'])) {
                $_SESSION['request'] = 'submit1';
                if (isset($_GET['country'])) {
                    $_SESSION['country'] = $_GET['country'];
                }
                if (isset($_GET['city'])) {
                    $_SESSION['city'] = $_GET['city'];
                }
                if (isset($_GET['theme'])) {
                    $_SESSION['theme'] = $_GET['theme'];
                }
                if (isset($_GET['page'])) {
                    $_SESSION['page'] = $_GET['page'];
                    if ($_SESSION['page'] == 0) {
                        search_first();
                    } else {
                        search_again();
                    }
                } else {
                    search_first();
                }
            }
            if (isset($_GET['submit2'])) {
                $_SESSION['request'] = 'submit2';
                if (isset($_GET['title'])) {
                    $_SESSION['title'] = $_GET['title'];
                }
                if (isset($_GET['page'])) {
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
        </ul>
    </main>
</div>


<div id="pagination" class="pagination">
    <ul>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit1'])) {
            creatPageNumber();
        }

        if (isset($_GET['submit1'])) {
            creatPageNumber();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit2'])) {
            creatPageNumber();
        }

        if (isset($_GET['submit2'])) {
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
            if (isset($_GET['submit1']) || isset($_POST['submit1'])) {
                $url = "browse.php?page=" . $num;
                $url = $url . "&country=" . $_SESSION['country'];
                $url = $url . "&city=" . $_SESSION['city'];
                $url = $url . "&theme=" . $_SESSION['theme'];
                $url = $url . "&submit1=筛+选";
                return $url;
            } elseif (isset($_GET['submit2']) || isset($_POST['submit2'])) {
                $url = "browse.php?page=" . $num;
                $url = $url . "&title=" . $_SESSION['title'];
                $url = $url . "&submit2=搜索";
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

<script src="../js/UIscript.js" rel="script" type="text/javascript"></script>
</body>
</html>