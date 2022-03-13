<?php
require_once ("../../pdo_connect_jj.php");

$id = $_GET["id"];

$sql = "SELECT * FROM member WHERE valid=1 AND id=?";
$stmt = $db_host->prepare($sql);
$stmt->execute([$id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


try {
    $sql = "UPDATE member SET valid=0 WHERE id=?";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$id]);
    echo "修改成功<br>";

} catch (PDOException $e) {
    echo "修改失敗<br>";
    echo "Error: " . $e->getMessage();
    exit;
}
$db_host = NULL;
//header("location: member.php");
