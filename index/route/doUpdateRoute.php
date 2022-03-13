<?php
require_once("../../pdo_connect_jj.php");
//if (!isset($_POST["id"])) {
//    echo "請輸入資料";
//    exit();
//}

$id=$_POST["id"];
$name=$_POST["editName"];
$difficulty_id=$_POST["editDiff"];
$situation_id=$_POST["editSituation"];
$detail=$_POST["editDetail"];
$valid=1;

if(empty($difficulty_id) || empty($situation_id) ){
    echo"請選擇難度&路況";

    header("refresh:2;url=route.php");
    exit();

}


try {
    $sql="UPDATE route SET name=?, difficulty_id=?, situation_id=?, detail=? WHERE id=?";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$name, $difficulty_id, $situation_id, $detail, $id]);
    echo "修改成功<br>";

}catch (PDOException $e) {
    echo "修改失敗<br>";
    echo "Error: " . $e->getMessage();
    exit;
}
$db_host = NULL;
header("location: route.php");
