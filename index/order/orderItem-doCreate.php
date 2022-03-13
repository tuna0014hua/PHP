<?php
require_once("../../pdo_connect_jj.php");
if($_POST["order_category"]!="course" && $_POST["order_category"]!="product"){
    echo "請選擇類別";
    exit;
}

$id=$_POST["order_id"];
$order_category=$_POST["order_category"];
$amount=$_POST["amount"];
$now=Date("Y-m-d H-i-s");
$valid=1;


function ifChoose($idName){
    if(!is_numeric($idName)){
        echo("請選擇商品");
        exit;
    }
}

if($amount<=0){
    echo "商品數量不可小於0";
    exit;
}


if(isset($_POST["course_id"])){
    $course_id=$_POST["course_id"];
    ifChoose($course_id);
    try{
        $sql="INSERT INTO order_course(order_id,  course_id, amount, created_at, valid)
            VALUES(?, ?, ?, ?, ?)";
        $stmt=$db_host->prepare($sql);
        $stmt->execute([$id, $course_id, $amount, $now, $valid]);
        echo "資料新增成功";

    }catch(PDOException $e){
        echo "新增失敗";
        echo "Error: ".$e->getMessage();
        exit();
    }
}

if(isset($_POST["product_id"])){
    $product_id=$_POST["product_id"];
    ifChoose($product_id);
    try{
        $sql="INSERT INTO order_product(order_id,  product_id, amount, created_at, valid)
            VALUES(?, ?, ?, ?, ?)";
        $stmt=$db_host->prepare($sql);
        $stmt->execute([$id, $product_id, $amount, $now, $valid]);
        echo "資料新增成功";
    }catch(PDOException $e){
        echo "新增失敗";
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
$stmtCoOrder->execute([$id]);
$rowsCoOrder=$stmtCoOrder->fetchAll(PDO::FETCH_ASSOC);
if ($stmtCoOrder->rowCount()!=0){
    foreach($rowsCoOrder as $valueCoOrder){
        $totalPrice += $courseArr[$valueCoOrder["course_id"]]*$valueCoOrder["amount"];
    }    
}
$sqlPrOrder="SELECT * FROM order_product WHERE order_id=? AND valid=1";
$stmtPrOrder = $db_host->prepare($sqlPrOrder);
$stmtPrOrder->execute([$id]);
$rowsPrOrder=$stmtPrOrder->fetchAll(PDO::FETCH_ASSOC);
if ($stmtPrOrder->rowCount()!=0){
    foreach($rowsPrOrder as $valuePrOrder){
        $totalPrice += $productArr[$valuePrOrder["product_id"]]*$valuePrOrder["amount"];
    }    
}

$sqlOrderUpdate= "UPDATE ordered SET consumption=? WHERE id=?";
$stmtOrderUpdate = $db_host->prepare($sqlOrderUpdate);
$stmtOrderUpdate->execute([$totalPrice, $id]);

//更新member消費額
//1.取得該order的member id
$sqlGetMemId="SELECT * FROM ordered WHERE id=? AND valid=1";
$stmtGetMemId = $db_host->prepare($sqlGetMemId);
$stmtGetMemId->execute([$id]);
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



$db_host = NULL;

header("location:order-view.php?id=".$id);