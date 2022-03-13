<?php
require_once ("../../../pdo_connect_jj.php");
$content=$_POST["content"];
echo $content;

$sql="SELECT * FROM course WHERE name LIKE ? OR price LIKE ? AND valid=1";
$stmt=$db_host->prepare($sql);
$stmt->execute(["%$content%", "%$content%"]);
$rows=$stmt->fetchALL(PDO::FETCH_ASSOC);

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
