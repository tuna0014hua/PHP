<?php
require_once("../../pdo_connect_jj.php");

$id=$_GET["id"];

try{
    $sql="UPDATE product SET valid=0 WHERE id=?";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$id]);
    echo "刪除成功<br>";

} catch (PDOException $e){
    echo "刪除失敗<br>";
    echo "Error: ".$e->getMessage();
    exit;
}

$db_host = NULL ;
header("location: j-product-list.php");