<?php
require_once ("../../pdo_connect_jj.php");

if(!isset($_POST["name"])){
    echo "沒有帶入資料";
    exit();
}

$name=$_POST["name"];
$gender=$_POST["gender"];
$age=$_POST["age"];
$email=$_POST["email"];
$password=md5($_POST["password"]);
$spending=$_POST["spending"];
$point=$_POST["point"];
$level_id=$_POST["level_id"];
$now=date('Y-m-d H:i:s');
$valid=1;


if(empty($name) || empty($gender || empty($age) || empty($email) || empty($password) || empty($spending) || empty($point)|| empty($level_id))){
    echo("資料未填寫完成");
    exit;
}




try{
    $sqlInMem="INSERT INTO member(name, gender, age, email, password, spending, point, level_id, created_at, valid)
           VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInMem=$db_host->prepare($sqlInMem);
    $stmtInMem->execute(["$name", "$gender", "$age", "$email", "$password", "$spending", "$point", "$level_id", "$now", "$valid"]);
    $lastId=$db_host->lastInsertId();
    echo "會員新增成功";
}catch(PDOException $e){
    echo "新增失敗";
    echo "Error: ".$e->getMessage();
    exit();
}

$db_host = NULL;
header("location:member.php");





