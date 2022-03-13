<?php
require_once("../../../pdo_connect_jj.php");
$id=$_POST["id"];  //course或product的訂單編號
$cate=$_POST["cate"];  //course或product的訂單編號
$orderId="";
function updateValid($db_host, $dbName, $id){
    $sql = "UPDATE $dbName SET valid=0 WHERE id=?";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$id]);
}
function getOrderId($db_host, $dbName, $id){
    $sqlOrder="SELECT * FROM $dbName WHERE id=?";  
    $stmtOrder = $db_host->prepare($sqlOrder);
    $stmtOrder->execute([$id]);
    $rowsOrder=$stmtOrder->fetchAll(PDO::FETCH_ASSOC);
    $orderId=$rowsOrder[0]["order_id"];
    return $orderId;
}
if($cate=="course"){
    try{
        updateValid($db_host, "order_course", $id);
        echo "課程修改成功<br>";
        $orderId=getOrderId($db_host, "order_course", $id);
        $data=[
            "cate"=>$cate,
          "message"=>"課程修改成功"
        ];
    }catch(PDOException $e){
        $data=[
            "message"=>"修改失敗"
        ];
        echo "修改失敗<br>";
        echo "Error: ".$e->getMessage();
        exit();
    }
}else if($cate=="product"){
    try{
        updateValid($db_host, "order_product", $id);
        echo "產品修改成功<br>";
        $orderId=getOrderId($db_host, "order_product", $id);
        $data=[
            "cate"=>$cate,
          "message"=>"產品修改成功"
        ];
    
    }catch(PDOException $e){
        $data=[
            "message"=>"修改失敗"
        ];
        echo "修改失敗<br>";
        echo "Error: ".$e->getMessage();
        exit();
    }
}
//取得商品跟價錢的關係
function getPrice($db_host, $dbName){
    $sql = "SELECT * FROM $dbName ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $arr=[];
    foreach($row as $value){
        $arr[$value["id"]]=$value["price"];
    }
    return $arr;
}
$courseArr=getPrice($db_host, "course");
$productArr=getPrice($db_host, "product");
//更新order資料庫的金額
function getTotalPrice($db_host, $dbName, $orderId, $arr, $idName){
    $totalPrice=0;
    $sql="SELECT * FROM $dbName WHERE order_id=? AND valid=1";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$orderId]);
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($stmt->rowCount()!=0){
        foreach($rows as $value){
            $totalPrice += $arr[$value["$idName"]]*$value["amount"];
        }    
    }
    return $totalPrice;    
}
$coursePrice=getTotalPrice($db_host, "order_course", $orderId, $courseArr, "course_id");
$productPrice=getTotalPrice($db_host, "order_product", $orderId, $productArr, "product_id");
$totalPrice=$coursePrice+$productPrice;
$sqlOrderUpdate= "UPDATE ordered SET consumption=? WHERE id=?";
$stmtOrderUpdate = $db_host->prepare($sqlOrderUpdate);
$stmtOrderUpdate->execute(["$totalPrice", "$orderId"]);
echo json_encode($data);