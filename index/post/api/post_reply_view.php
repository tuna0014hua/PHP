<?php
//撈資料庫資料
require_once("../../../pdo_connect_jj.php");
$id = $_POST["id"];

//檢視單一文章
$sqlPostDetail = "SELECT post.*, category_post.name AS 'category', member.name AS 'author'
FROM post
JOIN category_post ON post.category_id = category_post.id 
JOIN member ON post.member_id = member.id
WHERE post.valid = 1 AND post.id = ?";

$stmtPostDetail = $db_host -> prepare($sqlPostDetail);
$stmtPostDetail -> execute([$id]);
$rowsPostDetail = $stmtPostDetail -> fetchAll(PDO::FETCH_ASSOC);

//檢視文章內的留言
$sqlPostReply = "SELECT reply.*, member.name AS 'author' 
FROM reply
JOIN member ON reply.member_id = member.id
WHERE reply.post_id = ? AND reply.valid = 1";

$stmtPostReply = $db_host -> prepare($sqlPostReply);
$stmtPostReply -> execute([$id]);
$rowsPostReply = $stmtPostReply -> fetchAll(PDO::FETCH_ASSOC);


//檢視單一文章
if($stmtPostDetail->rowCount()===0) {
    //資料不存在作法
    $data=[
        "status"=>0,
        "message"=>"沒有資料"
    ];
//    echo json_encode($data);
} else {
    if($stmtPostReply -> rowCount() === 0 ) {
        $data=[
            "status"=>1,
            "post"=>$rowsPostDetail[0]
        ];
    } else {
        $data=[
            "status"=>1,
            "post"=>$rowsPostDetail[0],
            "reply"=>$rowsPostReply
        ];
    }
    
}


// var_dump($rowsPostDetail);
// //將陣列資料轉換成JSON格式
echo json_encode($data);
$db_host = NULL;
?>
