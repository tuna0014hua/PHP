<?php
require_once("../../pdo_connect_jj.php");
if(!isset($_POST["product_id"])){
    echo "沒有選擇商品";
    exit();
}

$courseId=$_POST["course_id"];
$productId=$_POST["product_id"];
$now=Date("Y-m-d H-i-s");
$valid=1;

if(!is_numeric($productId)){
    echo("請選擇產品");
    exit;
}

try{
    $sql="INSERT INTO advice(course_id,  product_id, created_at, valid)
           VALUES(?, ?, ?, ?)";
    $stmt=$db_host->prepare($sql);
    $stmt->execute(["$courseId", "$productId", "$now", "$valid"]);
    echo "資料新增成功";

}catch(PDOException $e){
    echo "新增失敗";
    echo "Error: ".$e->getMessage();
    exit();
}

$db_host = NULL;

header("location:advice.php?course_id=".$courseId);