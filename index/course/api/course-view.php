<?php
require_once ("../../../pdo_connect_jj.php");
$id=$_POST["id"];

$sql="SELECT * FROM course WHERE id=? AND valid=1";
$stmt=$db_host->prepare($sql);
$stmt->execute([$id]);
$rows=$stmt->fetch();

$sqlAdv="SELECT * FROM advice WHERE course_id=? AND valid=1";
$stmtAdv=$db_host->prepare($sqlAdv);
$stmtAdv->execute([$id]);
$rowsAdv=$stmtAdv->fetchAll(PDO::FETCH_ASSOC);
//{[course1, product1],[course1, product2]....}

$sqlProd="SELECT * FROM product WHERE valid=1";
$stmtProd=$db_host->prepare($sqlProd);
$stmtProd->execute();
$rowsProd=$stmtProd->fetchAll(PDO::FETCH_ASSOC);
//{[productId, product],[productId, product]....}
$prodArr=[];
foreach($rowsProd as $valueProd){
    $prodArr[$valueProd["id"]]=$valueProd["name"];
}
$prodImgArr=[];
foreach($rowsProd as $valueProd){
    $prodImgArr[$valueProd["id"]]=$valueProd["image"];
}




if($stmt->rowCount()==0){
    $data=[
        "status"=>0,
        "message"=> "沒有資料",
    ];
}else{
    $data=[
        "status"=>1,
        "data"=> $rows,
        "productList"=> $prodArr,
        "productImg"=>$prodImgArr,
        "adviceData" =>$rowsAdv,
        "adviceCount"=>$stmtAdv->rowCount()
    ];
}

echo json_encode($data);

