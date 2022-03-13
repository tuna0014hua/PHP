<?php
require_once("../../../pdo_connect_jj.php");
$id=$_POST["id"];

try{
    $sql = "UPDATE course SET valid=0 WHERE id=?";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$id]);
    echo "修改成功<br>";
    $data=[
      "message"=>"修改成功"
    ];

}catch(PDOException $e){
    $data=[
        "message"=>"修改失敗"
    ];
    echo "修改失敗<br>";
    echo "Error: ".$e->getMessage();
    exit();
}

$db_host= NULL;

echo json_encode($data);


