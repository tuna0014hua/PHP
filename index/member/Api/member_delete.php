<?php
require_once ("../../../pdo_connect_jj.php");
$id=$_POST["id"];

try {
    $sql="UPDATE member SET valid=0 WHERE id=?";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$id]);
    $data=[
        "status"=>1,
        "message"=>"刪除成功"
    ];


}catch (PDOException $e) {
    echo "修改失敗<br>";
    echo "Error: " . $e->getMessage();
    exit;
};


echo json_encode($data);
$db_host = NULL; //資料庫操作結束
header("location: member.php");
