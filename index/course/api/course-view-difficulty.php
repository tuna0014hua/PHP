<?php
require_once ("../../../pdo_connect_jj.php");
$diffId=$_POST["diffId"];

$sql="SELECT * FROM difficulty_id WHERE id=?";
$stmt=$db_host->prepare($sql);
$stmt->execute([$diffId]);
$rows=$stmt->fetch();

if($stmt->rowCount()==0){
    $data=[
        "status"=>0,
        "message"=> "沒有資料",
    ];
}else{
    $data=[
        "status"=>1,
        "data"=> $rows,
    ];
}

echo json_encode($data);

