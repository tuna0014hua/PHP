<?php
require_once("../../../pdo_connect_jj.php");
$id=$_POST["id"];  //course或product的訂單編號
$cate=$_POST["cate"];  //course或product的訂單編號
$orderId="";
if($cate=="course"){
    try{
        $sql = "UPDATE order_course SET valid=0 WHERE id=?";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([$id]);
        echo "課程修改成功<br>";
        $sqlOrder="SELECT * FROM order_course WHERE id=?";  
        $stmtOrder = $db_host->prepare($sqlOrder);
        $stmtOrder->execute([$id]);
        $rowsOrder=$stmtOrder->fetchAll(PDO::FETCH_ASSOC);
        $orderId=$rowsOrder[0]["order_id"];

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
        $sql = "UPDATE order_product SET valid=0 WHERE id=?";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([$id]);
        echo "產品修改成功<br>";
        $sqlOrder="SELECT * FROM order_product WHERE id=?";  
        $stmtOrder = $db_host->prepare($sqlOrder);
        $stmtOrder->execute([$id]);
        $rowsOrder=$stmtOrder->fetchAll(PDO::FETCH_ASSOC);
        $orderId=$rowsOrder[0]["order_id"];

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
$sqlC = "SELECT * FROM course ";
$stmtC = $db_host->prepare($sqlC);
$stmtC->execute();
$rowC = $stmtC->fetchAll(PDO::FETCH_ASSOC);
$courseArr=[];
foreach($rowC as $valueC){
    $courseArr[$valueC["id"]]=$valueC["price"];
}
$sqlP = "SELECT * FROM product ";
$stmtP = $db_host->prepare($sqlP);
$stmtP->execute();
$rowP = $stmtP->fetchAll(PDO::FETCH_ASSOC);
$productArr=[];
foreach ($rowP as $valueP) {
    $productArr[$valueP["id"]] = $valueP["price"];
}
//更新order資料庫的金額
$totalPrice=0;
$sqlCoOrder="SELECT * FROM order_course WHERE order_id=? AND valid=1";
$stmtCoOrder = $db_host->prepare($sqlCoOrder);
$stmtCoOrder->execute([$orderId]);
$rowsCoOrder=$stmtCoOrder->fetchAll(PDO::FETCH_ASSOC);
if ($stmtCoOrder->rowCount()!=0){
    foreach($rowsCoOrder as $valueCoOrder){
        $totalPrice += $courseArr[$valueCoOrder["course_id"]]*$valueCoOrder["amount"];
    }    
}
$sqlPrOrder="SELECT * FROM order_product WHERE order_id=? AND valid=1";
$stmtPrOrder = $db_host->prepare($sqlPrOrder);
$stmtPrOrder->execute([$orderId]);
$rowsPrOrder=$stmtPrOrder->fetchAll(PDO::FETCH_ASSOC);
if ($stmtPrOrder->rowCount()!=0){
    foreach($rowsPrOrder as $valuePrOrder){
        $totalPrice += $productArr[$valuePrOrder["product_id"]]*$valuePrOrder["amount"];
    }    
}
$sqlOrderUpdate= "UPDATE ordered SET consumption=? WHERE id=?";
$stmtOrderUpdate = $db_host->prepare($sqlOrderUpdate);
$stmtOrderUpdate->execute(["$totalPrice", "$orderId"]);

//更新member消費額
//1.取得該order的member id
$sqlGetMemId="SELECT * FROM ordered WHERE id=?";
$stmtGetMemId = $db_host->prepare($sqlGetMemId);
$stmtGetMemId->execute([$orderId]);
$rowsGetMemId=$stmtGetMemId->fetch();
$memberId=$rowsGetMemId["member_id"];
//2.取得會員所有訂單的金額
$totalSpend=0;
$sqlGetMemSpend="SELECT * FROM ordered WHERE member_id=? AND valid=1";
$stmtGetMemSpend = $db_host->prepare($sqlGetMemSpend);
$stmtGetMemSpend->execute([$memberId]);
$rowsGetMemSpend=$stmtGetMemSpend->fetchAll(PDO::FETCH_ASSOC);
foreach($rowsGetMemSpend as $value){
    $totalSpend += $value["consumption"];
}
//3.更新會員花費
$sqlsSpendUpdate= "UPDATE member SET spending=? WHERE id=?";
$stmtSpendUpdate = $db_host->prepare($sqlsSpendUpdate);
$stmtSpendUpdate->execute([$totalSpend, $memberId]);

echo json_encode($data);