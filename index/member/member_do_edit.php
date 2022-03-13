<?php
require_once("../../pdo_connect_jj.php");



$id = $_POST["id"];
$name = $_POST["name"];
$gender = $_POST["gender"];
$age = $_POST["age"];
$email = $_POST["email"];
$password = md5($_POST["password"]);
$spending = $_POST["spending"];
$point = $_POST["point"];
$level_id = $_POST["level_id"];
$now = date('Y-m-d H:i:s');

$valid = 1;



try{
    $sql = "UPDATE member SET name=?, gender=?, age=?, email=?, password=?, spending=?, point=?, level_id=?  WHERE id=?";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$name, $gender, $age, $email, $password, $spending, $point, $level_id, $id]);
    echo "更新成功<br>";

}catch(PDOException $e){
    echo "修改失敗<br>";
    echo "Error: ".$e->getMessage();
    exit;
}

$db_host= NULL;

header("location:member.php");
