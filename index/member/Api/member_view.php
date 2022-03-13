<?php
require_once ("../../../pdo_connect_jj.php");
$id=$_POST["id"];
//echo $id;
//$id=9;

$sql="SELECT * FROM member WHERE id=? AND valid=1";
$stmt=$db_host->prepare($sql);
$stmt->execute([$id]);
$rows=$stmt->fetch();
//var_dump($rows);

$sqlD="SELECT * FROM member_level ";
$stmtD=$db_host->prepare($sqlD);
$stmtD->execute();
$rowD=$stmtD->fetchAll();
$memLevArr=[];
foreach($rowD as $valueD) {
    $memLevArr[$valueD["id"]] = $valueD["name"];
};
$memLev= $memLevArr[$rows["level_id"]];



if($stmt->rowCount()==0){
    $data=[
        "status"=>0,
        "message"=> "沒有資料",
    ];
}else{
    $data=[
        "status"=>1,
        "data"=> $rows,
        "memLev"=>$memLev,
    ];
}

echo json_encode($data);
$db_host = Null;


