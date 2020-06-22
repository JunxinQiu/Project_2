<?php
require_once('config.php');
$name = $_POST['name'];
$password = $_POST['password1'];
$email = $_POST['email'];
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO traveluser (Email, UserName,Pass) VALUES ('".$email."','".$name."','".$password."')";
    $result = $pdo->query($sql);
    $pdo = null;
    header("Location: http://localhost:63330/src/php/login.php");
}catch (PDOException $e) {//异常处理
    die( $e->getMessage() );
}