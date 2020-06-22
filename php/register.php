<?php
session_start();
require_once('config.php');
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>注册界⾯</title>
    <link rel="stylesheet" type="text/css" href="/src/css/NavBar.css">
    <link rel="stylesheet" type="text/css" href="/src/css/footer.css">
    <link rel="stylesheet" type="text/css" href="/src/css/home.css">
    <link rel="stylesheet" type="text/css" href="/src/css/login.css">
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
                <a href="/index.php" class="highlight">Home</a>
            </li>
            <li>
                <a href="/src/php/browse.php">Browse</a>
            </li>
            <li>
                <a href="/src/php/search.html">Search</a>
            </li>
        </ul>
    </div>
</div>

<div class="mainPart">
    <form action="../php/userRegister.php" method="post" onsubmit="return register();">
        <div>
            <p>
                <label>
                    <input type="text" placeholder="请输入您的名称" id="name" name="name">
                </label>
            </p>
            <p>
                <label>
                    <input type="email" placeholder="请输入您的邮箱" id="email" name="email" pattern="^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$">
                </label>
            </p>
            <p>
                <label>
                    <input class="input_box" name="password" type="password" placeholder="请输入您的密码" pattern="^[0-9A-Za-z]{8,16}$"
                </label>
            </p>
            <p>
                <label>
                    <input type="password" placeholder="请再次确认您的密码" id="password2">
                </label>
            </p>
            <p>
                <label>
                    <button type="submit">点我就能注册</button>
                </label>
            </p>


        </div>

    </form>
</div>

<!--页脚...-->
<footer>
    <ul>
        <li>我Web课大概率要恰F，是时候准备重修了</li>
        <li>想不出什么骚话，告辞</li>
    </ul>
</footer>

<script src="/src/js/jquery-3.3.1.min.js"></script>
<script src="../js/register.js"></script>
</body>
