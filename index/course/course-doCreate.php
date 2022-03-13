<?php
require_once("../../pdo_connect_jj.php");
if(!isset($_POST["name"])){
    echo "no data received";
    exit();
}

$name=$_POST["name"];
$difficulty_id=$_POST["difficulty_id"];
$price=$_POST["price"];
$stu_limit=$_POST["stu_limit"];
$now=Date("Y-m-d H-i-s");
$valid=1;

if(empty($name) || empty($price) || empty($stu_limit)){
    echo("資料未填寫完成");
    exit;
}
if( !is_numeric($difficulty_id)){
    echo("請選擇難度");
    exit;
}


try{
    $sqlInCour="INSERT INTO course(name, difficulty_id, price, stu_limit, created_at, valid)
           VALUES(?, ?, ?, ?, ?, ?)";
    $stmtInCour=$db_host->prepare($sqlInCour);
    $stmtInCour->execute(["$name", "$difficulty_id", "$price", "$stu_limit", "$now", "$valid"]);
    $lastId=$db_host->lastInsertId();
    echo "資料新增成功";
}catch(PDOException $e){
    echo "新增失敗";
    echo "Error: ".$e->getMessage();
    exit();
}

$db_host = NULL;
header("location:course.php");