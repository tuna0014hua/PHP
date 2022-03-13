<?php
require_once("../../pdo_connect_jj.php");



if(!isset($_POST["comment"])){
    echo "沒有帶入資料";
    exit();
}
$postID = $_POST["postID"];
$memberID = $_POST["memberID"];
$comment = $_POST["comment"];
$now = date('Y-m-d H:i:s');
$valid = 1;

if(empty($comment)){
    echo("資料未填寫完成");
    exit;
}

try {
    $sql = "INSERT INTO reply (post_id, member_id, reply, created_at, valid)
        VALUES (?, ?, ?, ?, ?)";
    $stmt = $db_host -> prepare ($sql);
    $stmt -> execute ([$postID, $memberID, $comment, $now, $valid]);
    $id = $db_host -> lastInsertId(); //取得最新一筆資料的id
    echo "寫入成功<br>";
} catch (PDOException $e) {
    echo "寫入失敗<br>";
    echo "Error: " . $e -> getMessage ();
    exit;
}


$db_host = Null;
header ("location: post.php");


