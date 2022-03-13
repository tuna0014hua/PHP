<?php
require_once("../../pdo_connect_jj.php");

//view
$sql = "SELECT post.*, category_post.name AS 'category', member.name AS 'author', COUNT(reply.id) AS 'comments'
FROM `post` 
JOIN category_post ON post.category_id = category_post.id 
JOIN member ON post.member_id = member.id
LEFT JOIN reply ON post.id = (SELECT reply.post_id WHERE reply.valid = 1)
WHERE post.valid = 1
GROUP BY post.id
ORDER BY post.id";

$stmt = $db_host->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// session_destroy();

//add category_post
$sqlCategory = "SELECT * FROM category_post"; 
$stmtCategory = $db_host->prepare($sqlCategory);
$stmtCategory->execute();
$rowsCategory = $stmtCategory->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Post</title>
    <?php require_once("../../css.php") ?>
    <?php require_once("post_css.php") ?>
</head>

<body>
    <?php require_once("../../main.php") ?>

    <div class="right">
        <div class="container">
            <div class="row d-flex justify-content-center my-3">
                <!-- <div class="col-lg-6 position-relative search">
                    <i class="fas fa-search"></i>
                    <input type="text" class="searchInput" placeholder="Search for names..">
                </div> -->
                <div class="text-end">
                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addPostModal" type="submit" href="#">新增</a>                                  
                </div>
            </div>

            <table id="table" class="table table-borderd" data-toggle="table">
                <thead class="thead">
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>#</th>
                        <th>文章類別</th>
                        <th>作者</th>
                        <th>文章標題</th>
                        <th>時間</th>
                        <th>留言數</th>
                        <th class="bg-info text-center">
                            <div class="text-white"><i class="fas fa-eye"></i></div>
                        </th>
                        <th class="bg-primary text-center">
                            <div class="text-white"><i class="far fa-edit"></i></div>
                        </th>
                        <th class="bg-danger text-center">
                            <div class="text-white"><i class="fas fa-trash-alt"></i></div>
                        </th>
                    </tr>
                </thead>
                <tbody id="target">
                    <?php foreach ($rows as $value) : ?>
                        <tr>
                            <td><input type="checkbox"  data-id=<?=$value["id"]?>></td>
                            <td><?= $value["id"] ?></td>
                            <td><?= $value["category"] ?></td>
                            <td><?= $value["author"] ?></td>
                            <td><?= $value["subject"] ?></td>
                            <td><?= $value["created_at"] ?></td>
                            <td><?= $value["comments"] ?></td>
                            <td class="text-center tdBTnEye">
                                <a class="btn viewPost" data-id=<?= $value["id"] ?> data-bs-toggle="modal" data-bs-target="#viewPostModal" href="#">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td class="text-center tdBTnEdit">
                                <a class="btn editPost" data-id=<?= $value["id"] ?> data-bs-toggle="modal" data-bs-target="#editPostModal" href="#">
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center tdBTnDetele">
                                <a class="btn deletePost" data-bs-toggle="modal" data-id=<?= $value["id"]?> data-bs-target="#deletePostModal" href="#">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!--AddPost Modal--->
            <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title fw-bold" id="addPostModalLabel">新增</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="postInsertForm" action="post_doInsert.php" method="post">
                                <!--member需帶當前登入者帳號-->
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="member" class="col-sm-3 col-form-label">作者:&nbsp;</label>
                                    <!-- 登入後自動帶session資料 Jgogo => \<\?=$_SESSION["name"]\?\> for member_name  -->
                                    <div class="col-sm-9 justify-content-center align-self-center" name="member_id" id="member_id">
                                        <?= ($_SESSION["user"]["name"]); ?>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">類別:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" aria-label="Default select category" class="form-control" id="" name="category_id">
                                            <?php foreach ($rowsCategory as $value) : ?>
                                                <option value="<?= $value["id"] ?>">
                                                    <?= $value["name"] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">主題:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="postInsert_Subject" name="subject" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="content" class="col-sm-3 col-form-label">內容:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" class="form-control article" id="postInsert_Content" name="content" required></textarea>
                                    </div>
                                </div>         
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">確認</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="addPostClose">關閉</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--addPost Modal end--->

            <!--ViewPost Modal--->
            <div class="modal fade" id="viewPostModal" tabindex="-1" aria-labelledby="viewPostModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title fw-bold" id="viewPostModalLabel">檢視</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row mb-2 h-100 d-flex">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">序號:&nbsp;</label>
                                    <div id="post_id" class="col-sm-9 justify-content-center align-self-center"></div>
                                </div>
                                <hr />
                                <div class="row mb-2 h-100 d-flex">
                                    <label for="category" class="col-sm-3 col-form-label">類別:&nbsp;</label>
                                    <div id="post_category" class="col-sm-9 justify-content-center align-self-center"></div>
                                </div>
                                <hr />
                                <!--member需帶當前登入者帳號-->
                                <div class="row mb-2 h-100 d-flex">
                                    <label for="member" class="col-sm-3 col-form-label">作者:&nbsp;</label>
                                    <div id="post_author" class="col-sm-9 justify-content-center align-self-center"></div>
                                </div>
                                <hr />
                                <div class="row mb-2 h-100 d-flex">
                                    <label for="subject" class="col-sm-3 col-form-label">主題:&nbsp;</label>
                                    <div id="post_subject" class="col-sm-9 justify-content-center align-self-center"></div>
                                </div>
                                <hr />
                                <div class="row mb-2 h-100 d-flex">
                                    <label for="content" class="col-sm-3 col-form-label">內容:&nbsp;</label>
                                    <pre id="post_content" class="col-sm-9 justify-content-center align-self-center lh-lg" contenteditable="true" style="white-space: pre-wrap; text-align: justify; text-indent: 20px;"></pre>
                                </div>
                                <hr />
                            </form>
                            <!-- 新增留言 -->
                            <form action="post_doReplyInsert.php" method="post">
                                <div class="row mb-2 h-100 d-flex">
                                    <label for="content" class="col-sm-3 col-form-label">新增留言:&nbsp;</label>  
                                     <div class="col-sm-8"> 
                                         <input id="inputPostID" type="hidden" name="postID">
                                         <!-- value = "當前的登入者" -->
                                         <input type="hidden" name="memberID" value="<?= ($_SESSION["user"]["id"]); ?>">
                                        <input type="text" id="" class="form-control d-inline" name="comment" required>
                                    </div>   
                                    <button type="submit" class="btn addReply d-inline col-sm-1"><i class="fas fa-plus"></i></button>
                                </div>
                            </form>

                            <hr />

                            <!-- reply view+delete -->
                            <div>
                                <table id="tablereply" class="table table-borderd table-fixed" data-toggle="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox"></th>
                                            <th>#</th>
                                            <th>會員名稱</th>
                                            <th>留言</th>
                                            <th>時間</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="targetReply" class="replyOverflow">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--ViewPost Modal end--->

            <!--EditPost Modal--->
            <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title fw-bold  text-white" id="editPostModalLabel">編輯</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="post_doUpdate.php" method="post">
                                <!--member需帶當前登入者帳號-->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">序號:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="edit_id" class="form-control" name="id" readonly="readonly">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">會員名稱:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="edit_author" class="form-control" name="author" readonly="readonly">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">類別:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <select id="edit_category" class="form-select" aria-label="Default select category" class="form-control" name="category_id">
                                            <?php foreach ($rowsCategory as $value) : ?>
                                                <option value="<?= $value["id"] ?>">
                                                    <?= $value["name"] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">主題:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="edit_subject" class="form-control" name="subject">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">內容:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" id="edit_content" class="form-control article" name="content"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">確認</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--EditPost Modal end--->


            <!-- Delete Modal -->
            <div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center fw-bold fs-5">
                            你確定要刪除你辛苦建立的資料嗎?!?!
                        </div>
                        <div class="modal-footer">
                            <!-- data-bs-confirm 需確認用法-->
                            <button type="button" class="btn btn-primary px-3" id="confirmDeletePost">確認</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Delete Modal end-->
                
            <!--Delete Reply Modal-->
            <div class="modal fade" id="deleteReplyModal" tabindex="-1" aria-labelledby="deleteReplyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center fw-bold fs-5">
                            你確定要刪除你辛苦建立的資料嗎?!?!
                        </div>
                        <div class="modal-footer">
                            <!-- data-bs-confirm 需確認用法-->
                            <button type="button" class="btn btn-primary px-3" id="confirmDeleteReply" >確認</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                        </div>
                    </div>
                </div>
            </div> <!--Delete Reply Modal end-->
            
        </div> <!-- Container end -->
    </div>
    <?php require_once("../../js.php") ?>

    <!-- SweetAlert CDN -->
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    
    
    <script>
        //add
        var addPostModal = new bootstrap.Modal(document.getElementById('addPostModal'), {
            keyboard: false
        });
        // 此處控制輸入彈跳視窗在關閉後會清空所有欄位(主題、文章內容)
        $("#addPostModal").on("hidden.bs.modal", function (e) {
            $("#postInsert_Subject").val("");
            $("#postInsert_Content").val("");
        });
        

        //view
        var viewPostModal = new bootstrap.Modal(document.getElementById('viewPostModal'), {
            keyboard: false
        });
       

        $("#target").on("click", ".viewPost", function(e){
            e.stopPropagation();
            let id = $(this).data("id");
            // console.log(id)

            let formdata = new FormData();
            formdata.append("id", id);
            axios.post('api/post_reply_view.php', formdata) 
                .then(function (response) {
                    // console.log(response);
                    let data = response.data;
                    // console.log(data);
                    // console.log(Object.keys(data).length);
                    $("#post_id").text(data.post.id);
                    $("#post_category").text(data.post.category);
                    $("#post_author").text(data.post.author);
                    $("#post_subject").text(data.post.subject);
                    $("#post_content").text(data.post.content);                    

                    // reply
                    //先初始化datatables樣式
                    $("#tablereply").dataTable().fnDestroy();

                    //文章相對應的留言 新增留言
                    $("#inputPostID").val(data.post.id);

                    //清除datatables裡的內容
                    $("#targetReply").html("");
                    
                    //物件裡key數量有幾項，決定文章是否有留言
                    if(Object.keys(data).length === 3) {
                        let i = 1;
                        let j = 1;
                        let replys = data.reply;
                        $("#tablereply").dataTable({
                            "data": replys,
                            "columns": [
                                { "data": null, "render": function ( data, type, row ) {
                                    return '<input type="checkbox">';
                                    }, "width": "5%"
                                },
                                { "data": null, "render": function ( data, type, row ) {
                                    return i++;
                                    }, "width": "6%" },
                                { "data": "author", "width": "15%" },
                                { "data": "reply", "width": "47%" },
                                { "data": "created_at", "width": "21%" },
                                { "data": null, "render": function ( replys, type, row ) {
                                    return ` <a class="btn deleteReply"  data-bs-toggle="modal"  data-bs-target="#deleteReplyModal" data-id="` + replys.id + `" href="#">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>`;
                                    }, "width": "5%"
                                }
                            ],
                            "autoWidth": false,
                            "columnDefs": [
                                {
                                    "targets": [0, -1],
                                    "orderable": false
                                },
                                { "className": " tdBTnDetele", "targets": 5 }
                            ],
                            "order": [
                                    [1, 'desc']
                            ], //排序功能
                            "searching": false, //搜尋功能, 預設是開啟
                            "paging": false, //分頁功能, 預設是開啟
                            
                            "language": {
                                    "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                            }
                        });

                        // Table 生成後，透過jquery事後調整各td寬度(可更改td_width陣列中的各個寬度比達到調整效果)
                        let td_width = ["5%", "6%", "17%", "50%", "18%", "5%"];
                        for (let i = 0; i < 6; i++) {
                            $('#tablereply td:nth-child(' + (i+1) +')').each(function() {
                                $(this).css("width", td_width[i]);
                            });
                        }

                        // 設定刪除留言按鈕的功能

                        // $(".deleteReply").click(function() {
                        //     let id = $(this).data("id");
                        //     // console.log(id);
                        //     // swal({
                        //     //         title: "是否刪除?",
                        //     //         icon: "warning",
                        //     //         // buttons: true,
                        //     //         dangerMode: true,                           
                        //     //         buttons: ['取消', '確認']
                        //     // });
                        // })
                    }
                })
                .catch(function (error) {
                        console.log(error);
                })
        });  

        //edit
        var editPostModal = new bootstrap.Modal(document.getElementById('editPostModal'), {
            keyboard: false
        });
        $("#target").on("click", ".editPost", function(e){
            e.stopPropagation();
            let id = $(this).data("id");
            // console.log(id)

            let formdata = new FormData();
            formdata.append("id", id);
            axios.post('api/post_reply_view.php', formdata) 
                .then(function (response) {
                    // console.log(response);
                    let data = response.data;
                    console.log(data);
                    // console.log(Object.keys(data).length);
                    $("#edit_id").val(data.post.id);
                    $("#edit_author").val(data.post.author);
                    $("#edit_category > option[value='"+ data.post.category_id +"']").attr("selected", "selected");
                    $("#edit_subject").val(data.post.subject);
                    $("#edit_content").val(data.post.content);
                })
                .catch(function (error) {
                        console.log(error);
                })
        }); 


        //delete_post
        var deletePostModal = new bootstrap.Modal(document.getElementById('deletePostModal'), {
            keyboard: false
        });
        var deleteReplyModal = new bootstrap.Modal(document.getElementById('deleteReplyModal'), {
            keyboard: false
        });
        $("#target").on("click", ".deletePost", function(){
            let id = $(this).data("id");
            // console.log(id)

            $("#confirmDeletePost").click(function(){
                let formdata = new FormData();
                formdata.append("id", id);
                formdata.append("delAction", "post");
                // console.log(id);
                axios.post('api/post_reply_delete.php', formdata).then(function(response){
                    // alert("成功刪除文章！");
                    window.location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                });
            });
        });

        //delete_reply
        
        $("#targetReply").on("click", ".deleteReply", function(){
            let id = $(this).data("id");
            // console.log(id)

            $("#confirmDeleteReply").click(function(){
                let formdata = new FormData();
                formdata.append("id", id);
                formdata.append("delAction", "reply");
                // console.log(id);
                axios.post('api/post_reply_delete.php', formdata).then(function(response){
                    // alert("成功刪除留言！");
                    window.location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                });
            });
        }); 
        
    </script>
</body>

</html>