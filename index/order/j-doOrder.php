<?php
require_once ("../../pdo_connect_jj.php");
if (!isset($_POST["amount"])){
    echo "請輸入資料";
    exit();
}
$id=$_POST["id"];
$member=$_POST["member"];
$course_id=$_POST["course_id"];
$product_id=$_POST["product_id"];
$amount=$_POST["amount"];
$consumption=$_POST["consumption"];
$now = date('Y-m-d H:i:s');
$valid=1;

try{
    $sql = "INSERT INTO ordered (member_id, consumption, created_at, valid)
            VALUES (?,?,?,?) ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$member, $consumption, $now, $valid]);
//    $id=$db_host->lastInsertId(); //取得最新一筆資料的id
//    execute(譯:執行)裡面的陣列要對照到上面product有的東西
    echo "寫入成功<br>";
}catch (PDOException $e){
    echo "寫入失敗<br>";
    echo "Error: ".$e->getMessage();
    exit;
}

$n=count($amount);
for( $i=0; $i<$n; $i++){
    try{
        $sql = "INSERT INTO order_product (order_id, product_id, amount, created_at, valid)
            VALUES (?,?,?,?,?) ";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([$id, $product_id[$i], $amount[$i], $now, $valid]);
//    $id=$db_host->lastInsertId(); //取得最新一筆資料的id
//    execute(譯:執行)裡面的陣列要對照到上面product有的東西
        echo "寫入成功<br>";
    }catch (PDOException $e){
        echo "寫入失敗<br>";
        echo "Error: ".$e->getMessage();
        exit;
    }
}


try{
    $sql = "INSERT INTO order_course (order_id, course_id, amount, created_at, valid)
            VALUES (?,?,?,?,?) ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$id, $course_id, 1, $now, $valid]);
//    $id=$db_host->lastInsertId(); //取得最新一筆資料的id
//    execute(譯:執行)裡面的陣列要對照到上面product有的東西
    echo "寫入成功<br>";
}catch (PDOException $e){
    echo "寫入失敗<br>";
    echo "Error: ".$e->getMessage();
    exit;
}

//某個會員消費之後，在會員管理的消費額度那邊也會更新:
try{
    $sql= "SELECT * FROM member WHERE id=? AND VALID=1";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([$member]);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($row);
    $sqlU = "UPDATE member SET spending=? WHERE id=?";
    $stmtU = $db_host->prepare($sqlU);
    $stmtU->execute([$row["spending"]+$consumption, $member]);
    echo "寫入成功<br>";
}catch (PDOException $e){
    echo "寫入失敗<br>";
    echo "Error: ".$e->getMessage();
    exit;
}




$db_host = NULL ;
header("location: order.php");