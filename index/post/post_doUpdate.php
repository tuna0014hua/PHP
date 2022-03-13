<?php
require_once("../../pdo_connect_jj.php");

// if(!isset($_POST["author"])){
//     echo "沒有帶入資料";
//     exit();
// } else {
//     echo "有帶入作者";
//     exit();
// }
// echo ($_POST["category_id"]);

// $name = $_POST["name"];
$post_id = $_POST["id"];
$category_id = $_POST["category_id"];
$author = $_POST["author"];
$subject = $_POST["subject"];
$content = $_POST["content"];


try {
    $sql = "UPDATE post SET category_id=?, member_id=(SELECT member.id FROM member WHERE member.name = ?), subject=?, content=? WHERE id=?";
    $stmt = $db_host -> prepare ($sql);
    $stmt -> execute ([$category_id, $author, $subject, $content, $post_id]);
    echo "修改成功<br>";

} catch (PDOException $e) {
    echo "修改失敗<br>";
    echo "Error: " . $e -> getMessage ();
    exit;
}

$db_host = NULL;
header("location: post.php");

?>



