<?php
require_once("../../pdo_connect_jj.php");

if(!isset($_POST["name"])){
    echo "請輸入資料";
    exit;
}

$id=$_POST["id"];
$category_id=$_POST["category_id"];
$name=$_POST["name"];
$amount=$_POST["amount"];
$price=$_POST["price"];
$content=$_POST["content"];

//如果有檔案，那就更新新的圖片檔上去;如果沒有，就只更新其他資料
if($_FILES["file"]["error"]===0) {
//    $image=$_FILES["image"];
    $path_parts= pathinfo($_FILES["file"]["name"]);
    $ext = $path_parts["extension"];
    $file_name= time(). "." . $ext;
    move_uploaded_file($_FILES["file"]["tmp_name"], "product_images/".$file_name);
    try{
        $sql= "UPDATE product SET category_id=?, name=?, image=?, amount=?, price=?, content=? WHERE id=? ";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([$category_id, $name, $file_name, $amount, $price, $content, $id]);
        echo "修改成功<br>";
    }catch(PDOException $e){
        echo "修改失敗<br>";
        echo "Error: ".$e->getMessage();
        exit;
    }
}else{
    try{
        $sql= "UPDATE product SET category_id=?, name=?, amount=?, price=?, content=? WHERE id=? ";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([$category_id, $name, $amount, $price, $content, $id]);
        echo "修改成功<br>";
    }catch(PDOException $e){
        echo "修改失敗<br>";
        echo "Error: ".$e->getMessage();
        exit;
    }
}



$db_host = NULL ;
header("location: product.php");
