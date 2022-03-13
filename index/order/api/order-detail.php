<?php
require_once("../../../pdo_connect_jj.php");
$id=$_POST["id"];

//搜索訂單編號4的訂購課程
$sqlCO = "SELECT * FROM order_course WHERE order_id=? AND valid=1";
$stmtCO = $db_host->prepare($sqlCO);
$stmtCO->execute([$id]);
$rowCO = $stmtCO->fetchAll(PDO::FETCH_ASSOC);
//[["id"=>1,"order_id"=>4,"course_id"=>1],[2,4,2]..]
//print_r($rowCO);  //1

//搜索訂單編號4的訂購商品
$sqlPO = "SELECT * FROM order_product WHERE order_id=? AND valid=1";
$stmtPO = $db_host->prepare($sqlPO);
$stmtPO->execute([$id]);
$rowPO = $stmtPO->fetchAll(PDO::FETCH_ASSOC);
//print_r($rowPO);


//course Name
$sqlC = "SELECT * FROM course ";
$stmtC = $db_host->prepare($sqlC);
$stmtC->execute();
$rowC = $stmtC->fetchAll(PDO::FETCH_ASSOC);
$courseArr=[];
foreach($rowC as $valueC){
    $courseArr[$valueC["id"]]=$valueC["name"];
}

//Product Name
$sqlP = "SELECT * FROM product ";
$stmtP = $db_host->prepare($sqlP);
$stmtP->execute();
$rowP = $stmtP->fetchAll(PDO::FETCH_ASSOC);
$productArr=[];
foreach ($rowP as $valueP) {
    $productArr[$valueP["id"]] = $valueP["name"];
}

$data=[
    "courseOrder"=>$rowCO,
    "productOrder"=>$rowPO,
    "courseName"=>$courseArr,
    "productName"=>$productArr,
];

echo json_encode($data);