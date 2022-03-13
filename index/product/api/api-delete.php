<?php
require_once("../../../pdo_connect_jj.php");

$id=$_POST["id"];
//$id=3;

try{
    $sql="UPDATE product SET valid=0 WHERE id=?";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$id]);
    $data=[
        "status"=>1,
        "message"=>"刪除成功"
    ];
//    echo "刪除成功<br>";

} catch (PDOException $e){
//    echo "刪除失敗<br>";
    echo "Error: ".$e->getMessage();
    exit;
}

echo json_encode($data);

$db_host = NULL ;
//header("location: product.php");