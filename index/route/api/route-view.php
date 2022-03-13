<?php
require_once ("../../../pdo_connect_jj.php");
$id=$_POST["id"];
//$id=5;
$sql="SELECT * FROM route WHERE id=? AND valid=1";
$stmt=$db_host->prepare($sql);
$stmt->execute([$id]);
$rows=$stmt->fetch();
//var_dump($rows);

$sqlD="SELECT * FROM difficulty_id ";
$stmtD=$db_host->prepare($sqlD);
$stmtD->execute();
$rowD=$stmtD->fetchAll();
$diffArr=[];
foreach($rowD as $valueD) {
    $diffArr[$valueD["id"]] = $valueD["name"];
};
$difficult= $diffArr[$rows["difficulty_id"]];

$sqlS="SELECT * FROM situation";
$stmtS=$db_host->prepare($sqlS);
$stmtS->execute();
$rowS=$stmtS->fetchAll();
$situationArr=[];
foreach($rowS as $valueS) {
    $situationArr[$valueS["id"]] = $valueS["situation"];
};
$situation= $situationArr[$rows["situation_id"]];






if($stmt->rowCount()==0){
    $data=[
        "status"=>0,
        "message"=> "沒有資料",
    ];
}else{
    $data=[
        "status"=>1,
        "data"=> $rows,
        "difficult"=>$difficult,
        "situation"=>$situation
    ];
}

echo json_encode($data);

