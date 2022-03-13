<?php
require_once("../../pdo_connect_jj.php");



if(!isset($_POST["category_id"])){
    echo "沒有帶入資料";
    exit();
}

// $name = $_POST["name"];
$category_id = $_POST["category_id"];

//先固定發文者為等級4的xxx，等登入功能完善後，再將登入資訊帶入
$member_id = $_SESSION["user"]["id"];

$subject = $_POST["subject"];
$content = $_POST["content"];
$now = date('Y-m-d H:i:s');
$valid = 1;


try {
    $sql = "INSERT INTO post (category_id, member_id, subject, content, created_at, valid)
        VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db_host -> prepare ($sql);
    $stmt -> execute ([$category_id, $member_id, $subject, $content, $now, $valid]);
    $id = $db_host -> lastInsertId(); //取得最新一筆資料的id
    echo "寫入成功<br>";
} catch (PDOException $e) {
    echo "寫入失敗<br>";
    echo "Error: " . $e -> getMessage ();
    exit;
}


$db_host = Null;
header ("location: post.php");


