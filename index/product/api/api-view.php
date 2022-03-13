<?php
require_once ("../../../pdo_connect_jj.php");
$id=$_POST["id"];

//類別資料
$sql = "SELECT * FROM category_product";
$stmt = $db_host->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$categoryArr=[];
foreach ($rows as $values){
    $categoryArr[$values["id"]]=$values["name"];
}

//產品資料
$sqlP="SELECT * FROM product WHERE id=? AND valid=1";
$stmtP=$db_host->prepare($sqlP);
$stmtP->execute([$id]);
$rowsP=$stmtP->fetch();

//類別名稱
$category=$categoryArr[$rowsP["category_id"]];

//圖片資料
$sqlImg = "SELECT * FROM product_image WHERE product_id=?";
$stmtImg = $db_host->prepare($sqlImg);
$stmtImg->execute([$id]);
$row_img = $stmtImg->fetchAll(PDO::FETCH_ASSOC);
$imageArr=[];
foreach ($row_img as $value1){
    array_push($imageArr, $value1["image_name"]);
}


if($stmt->rowCount()==0){
    $data=[
        "status"=>0,
        "message"=>"沒有資料喔"
    ];
}else{
    $data=[
        "status"=>1,
        "data"=>$rowsP,
        "category"=>$category,
        "img"=>$imageArr
    ];
}
echo json_encode($data);
