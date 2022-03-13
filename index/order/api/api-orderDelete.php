<?php
require_once ("../../../pdo_connect_jj.php");

$id=$_POST["id"];
$member=$_POST["member"];
$consumption=$_POST["consumption"];

try{
    $sql="UPDATE ordered SET valid=0 WHERE id=? ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$id]);
    $data=[
        "status"=>1,
        "message"=>"刪除成功"
    ];
}catch (PDOException $e){
//    echo "刪除失敗<br>";
    echo "Error: ".$e->getMessage();
    exit;
};

try{
    $sql="UPDATE order_product SET valid=0 WHERE order_id=? ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$id]);
    $data=[
        "status"=>1,
        "message"=>"刪除成功"
    ];
}catch (PDOException $e){
//    echo "刪除失敗<br>";
    echo "Error: ".$e->getMessage();
    exit;
};

try{
    $sql="UPDATE order_course SET valid=0 WHERE order_id=? ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$id]);
    $data=[
        "status"=>1,
        "message"=>"刪除成功"
    ];
}catch (PDOException $e){
//    echo "刪除失敗<br>";
    echo "Error: ".$e->getMessage();
    exit;
};

try{
    $sql= "SELECT * FROM member WHERE id=? AND VALID=1";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$member]);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
//    var_dump($row);
    $sqlU = "UPDATE member SET spending=? WHERE id=?";
    $stmtU = $db_host->prepare($sqlU);
    $stmtU->execute([$row["spending"]-$consumption, $member]);
    echo "寫入成功<br>";
}catch (PDOException $e){
    echo "寫入失敗<br>";
    echo "Error: ".$e->getMessage();
    exit;
}

echo json_encode($data);

$db_host = NULL ;

