<?php
require_once ("../../../pdo_connect_jj.php");

$idP=$_POST["idP"];

$sql = "SELECT * FROM ordered WHERE valid=1 ORDER BY id DESC ";
$stmt = $db_host->prepare($sql);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($idP==null){
    $rowP["price"]=0;
}else{
    $sqlP = "SELECT * FROM product WHERE id=?";
    $stmtP = $db_host->prepare($sqlP);
    $stmtP->execute([$idP]);
    $rowP = $stmtP->fetch();
}
if($stmt->rowCount()==0){
    $data=[
        "status"=>0,
        "message"=>"沒有資料喔"
    ];
}else{
    $data=[
        "status"=>1,
        "dataP"=>$rowP
    ];

}
echo json_encode($data);