<?php
require_once("../../pdo_connect_jj.php");

if(!isset($_POST["name"])){
    echo "沒有帶入資料喔";
    exit();
}


//$id=$_POST["id"];
$name=$_POST["name"];
$difficulty_id=$_POST["difficulty_id"];
$situation_id=$_POST["situation_id"];
$detail=$_POST["detail"];
$valid=1;


if(empty($name) || empty($difficulty_id) || empty($situation_id) ){
    echo("資料未填寫完成");
    exit;
}

//exit();
try{
    $sqlRoute="INSERT INTO route ( name,difficulty_id,situation_id,detail,valid)
           VALUES(?, ?, ?, ?, ?)";
    $stmtRoute=$db_host->prepare($sqlRoute);
    $stmtRoute->execute(["$name", "$difficulty_id", "$situation_id", "$detail", "$valid"]);
//    $lastId=$db_host->lastInsertId();
    echo "資料新增成功";
}catch(PDOException $e){
    echo "新增失敗";
    echo "Error: ".$e->getMessage();
    exit();
}

header("location: route.php");

$db_host->close(); //資料庫操作結束

