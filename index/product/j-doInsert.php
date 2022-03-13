<?php
require_once ("../../pdo_connect_jj.php");
if (!isset($_POST["name"])){
    echo "請輸入資料";
    exit();
}
$name=$_POST["name"];
$category_id=$_POST["category_id"];
$amount=$_POST["amount"];
$price=$_POST["price"];
$content=$_POST["content"];
$now = date('Y-m-d H:i:s');
$valid=1;

if($_FILES["file"]["error"]===0){
    $path_parts= pathinfo($_FILES["file"]["name"]);
    $ext = $path_parts["extension"];
    $file_name= time(). "." . $ext;
    move_uploaded_file($_FILES["file"]["tmp_name"], "product_images/".$file_name);
}

try{
    $sql = "INSERT INTO product(category_id, name, image, amount, price, content, created_at, valid)
            VALUES (?,?,?,?,?,?,?,?) ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$category_id, $name, $file_name, $amount, $price, $content, $now, $valid]);
    $id=$db_host->lastInsertId(); //取得最新一筆資料的id
//    execute(譯:執行)裡面的陣列要對照到上面product有的東西
    echo "寫入成功<br>";
}catch (PDOException $e){
    echo "寫入失敗<br>";
    echo "Error: ".$e->getMessage();
    exit;
}

//用完之後關掉PDODO
$db_host = NULL ;
header("location: product.php");
