<?php
session_start();

$servername = "localhost";
$username = "eddiewei";
$password = "jjgogo0831";
$dbname = "ski_resort";

//現今大多使用PDO，安全性較佳
try {
    $db_host = new PDO(
        "mysql:host={$servername};dbname={$dbname};charset=utf8",
        $username, $password
    );
//    echo "資料庫連線成功<br>";
} catch (PDOException $e) {
    echo "資料庫連線失敗<br>";
    echo "Error: " . $e->getMessage();
    exit();
}
