<?php
//撈資料庫資料
require_once("../../../pdo_connect_jj.php");

$id = $_POST["id"];
$delAction = $_POST["delAction"];

if($delAction=="post") {
    //刪除文章
    try {
        $sqlPostDelete = "UPDATE post SET valid=0 WHERE id=?";
        $stmtPostDelete = $db_host -> prepare ($sqlPostDelete);
        $stmtPostDelete -> execute ([$id]);
        echo "修改成功<br>";

    } catch (PDOException $e) {
        echo "修改失敗<br>";
        echo "Error: " . $e -> getMessage ();
        exit;
    }


    //刪除留言
    try {
        $sqlReplyDelete = "UPDATE reply SET valid=0 WHERE post_id=?";
        $stmtReplyDelete = $db_host -> prepare ($sqlReplyDelete);
        $stmtReplyDelete -> execute ([$id]);
        echo "修改成功<br>";

    } catch (PDOException $e) {
        echo "修改失敗<br>";
        echo "Error: " . $e -> getMessage ();
        exit;
    }
}

if($delAction=="reply") {
    //刪除單筆留言
    try {
        $sqlReplyDelete = "UPDATE reply SET valid=0 WHERE id=?";
        $stmtReplyDelete = $db_host -> prepare ($sqlReplyDelete);
        $stmtReplyDelete -> execute ([$id]);
        echo "修改成功<br>";

    } catch (PDOException $e) {
        echo "修改失敗<br>";
        echo "Error: " . $e -> getMessage ();
        exit;
    }
}


// var_dump($rowsPostDetail);
// //將陣列資料轉換成JSON格式
echo json_encode($data);
$db_host = NULL;
?>
