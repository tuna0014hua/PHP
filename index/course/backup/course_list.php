<?php
require_once("../../pdo_connect_jj.php");
$sqlCour="SELECT * FROM course";
$stmtCour=$db_host->prepare($sqlCour);
$stmtCour->execute();
$rowsCour=$stmtCour->fetchAll(PDO::FETCH_ASSOC);

$sqlDiff="SELECT * FROM difficulty_id";
$stmtDiff=$db_host->prepare($sqlDiff);
$stmtDiff->execute();
$rowsDiff=$stmtDiff->fetchAll(PDO::FETCH_ASSOC);
$diffArr=[];
foreach($rowsDiff as $valueDiff){
    $diffArr[$valueDiff["id"]]=$valueDiff["name"];
}

?>
<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public version</title>
    <?php require_once("../../css.php") ?>
</head>

<body>
    <?php require_once("../../main.php") ?>

    <div class="right">
        <div class="container">
            <div class="row d-flex justify-content-center my-5">
                <div class="col-lg-6 position-relative search">
                    <i class="fas fa-search"></i>
                    <input type="text" class="searchInput" placeholder="Search for names..">
                </div>
                <div class="text-end col-lg-6">
                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModal" href="#">新增</a>
                </div>
            </div>

            <table id="table" class="table table-borderd" data-toggle="table">
                <thead class="thead">
                    <tr>
                        <th scope="col"><input type="checkbox"></th>
                        <th scope="col">#</th>
                        <th scope="col">課程名稱</th>
                        <th scope="col">難易度</th>
                        <th scope="col">價格</th>
                        <th scope="col">人數上限</th>
                        <th scope="col" class="bg-info text-center">
                            <div class="text-white"><i class="fas fa-eye"></i></div>
                        </th>
                        <th scope="col" class="bg-primary text-center">
                            <div class="text-white"><i class="far fa-edit"></i></div>
                        </th>
                        <th scope="col" class="bg-danger text-center">
                            <div class="text-white"><i class="fas fa-trash-alt"></i></div>
                        </th>
                    </tr>
                </thead>
                <tbody id="target">
                <?php foreach($rowsCour as $value): ?>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><?= $value["id"]?></td>
                        <td><?= $value["name"]?></td>
                        <td><?= $diffArr[$value["difficulty_id"]]?></td>
                        <td><?= $value["price"]?></td>
                        <td><?= $value["stu_limit"]?></td>
                        <td class="text-center tdBTnEye">
                            <a data-id="<?=$value["id"]?>" id="view" class="btn" data-bs-toggle="modal" data-bs-target="#viewModal" href="#">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td class="text-center tdBTnEdit">
                            <a data-id="<?=$value["id"]?>" id="edit" class="btn" data-bs-toggle="modal" data-bs-target="#editModal" href="#">
                                <i class="far fa-edit"></i>
                            </a>
                        </td>
                        <td class="text-center tdBTnDetele">
                            <a data-id="<?=$value["id"]?>" id="delete" class="btn" data-bs-toggle="modal" data-bs-target="#deleteModal" href="#">
                                <i class="fas fa-trash-alt"></i>
                            </a >
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>

            <!--add Modal--->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title fw-bold" id="addModalLabel">新增</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="course-doCreate.php" method="post">
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">ID:</label>
                                    <div class="col-sm-9 justify-content-center align-self-center">
                                        可以讓系統自己帶嗎?
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-3 col-form-label">課程名稱:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="difficulty_id" class="col-sm-3 col-form-label">難易度:</label>
                                    <div class="col-sm-9">
                                        <select  class="form-select" name="difficulty_id" id="difficulty_id" required>
                                            <option value="請選擇難度">請選擇難度</option>
                                            <?php foreach($rowsDiff as $value):?>
                                                <option value="<?= $value["id"] ?>>"><?= $value["name"] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="price" class="col-sm-3 col-form-label">價格:</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="price" id="price" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="stu_limit" class="col-sm-3 col-form-label">人數上限:</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="stu_limit" id="stu_limit" required>
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
            </div> <!--add Modal end--->

            <!--View Modal--->
            <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewCourseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title fw-bold" id="viewCourseModalLabel">檢視</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">編號:&nbsp;</label>
                                    <div class="col-sm-9 justify-content-center align-self-center" id="viewId"></div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="name" class="col-sm-3 col-form-label">課程名稱:&nbsp;</label>
                                    <div class="col-sm-9 justify-content-center align-self-center" id="viewName"></div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="name" class="col-sm-3 col-form-label">難易度:&nbsp;</label>
                                    <div class="col-sm-9 justify-content-center align-self-center" id="viewDiff"></div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="name" class="col-sm-3 col-form-label">價格:&nbsp;</label>
                                    <div class="col-sm-9 justify-content-center align-self-center" id="viewPrice"></div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="name" class="col-sm-3 col-form-label">人數上限:&nbsp;</label>
                                    <div class="col-sm-9 justify-content-center align-self-center" id="viewLimit"></div>
                                </div>

                            </form>
                        </div>    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                        </div>
                    </div>
                </div>
            </div> <!--View Modal end--->


            <!--Edit Modal--->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title fw-bold  text-white" id="editModalLabel">編輯</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="course-doEdit.php" method="post">
                                <div class="row mb-3 h-100 d-flex">
                                    <div class="row mb-3">
                                        <label for="id" class="col-sm-3 col-form-label">ID:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="editId" name="id" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="name" class="col-sm-3 col-form-label">課程名稱:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="editName" name="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="difficulty_id" class="col-sm-3 col-form-label">難易度:</label>
                                        <div class="col-sm-9">
                                            <select  class="form-select" name="difficulty_id" id="editDiff" required>
                                                <option value="請選擇難度">請選擇難度</option>
                                                <?php foreach($rowsDiff as $value):?>
                                                    <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="price" class="col-sm-3 col-form-label">價格:</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="price" id="editPrice" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="stu_limit" class="col-sm-3 col-form-label">人數上限:</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="stu_limit" id="editLimit" required>
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
            </div> <!--Edit Modal end--->


            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                            <button type="button" class="btn btn-primary px-3" data-bs-confirm="modal">確認</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                        </div>
                    </div>
                </div>
            </div> <!--Delete Modal end-->

        </div> <!-- Container end -->
    </div>
    <?php require_once("../../js.php") ?>
    <script>
        $("#target").on("click", "#view", function(){
            let id=$(this).data("id");
            console.log(id);
            let formdata=new FormData();
            formdata.append("id", id);
            axios.post("api/course-view.php", formdata)
                .then(function(response){
                    let data=response.data;
                    if(data.status==0){
                        console.log("資料讀取錯誤");
                    }else {
                        $("#viewId").text(data.data["id"]);
                        $("#viewName").text(data.data["name"]);
                        $("#viewPrice").text(data.data["price"]);
                        $("#viewLimit").text(data.data["stu_limit"]);


                        let diffId = data.data["difficulty_id"];
                        console.log(diffId)
                        let formdataDiff = new FormData();
                        formdataDiff.append("diffId", diffId);
                        axios.post("api/course-view-difficulty.php", formdataDiff)
                            .then(function (responseDiff) {
                                let dataDiff=responseDiff.data
                                if(dataDiff.status==0){
                                    console.log("難易度讀取錯誤")
                                }else{
                                    $("#viewDiff").text(dataDiff.data["name"]);
                                }
                            })
                    }
                })
        });
        $("#target").on("click", "#edit", function(){
            let id=$(this).data("id");
            console.log(id);
            let formdata=new FormData();
            formdata.append("id", id);
            axios.post("api/course-view.php", formdata)
                .then(function(response){
                    let data=response.data;
                    if(data.status==0){
                        console.log("資料讀取錯誤");
                    }else {
                        $("#editId").val(data.data["id"]);
                        $("#editName").val(data.data["name"]);
                        $("#editPrice").val(data.data["price"]);
                        $("#editLimit").val(data.data["stu_limit"]);
                        $("#editDiff").val(data.data["difficulty_id"]);
                    }
                })
        })

            //add
        var addModal = new bootstrap.Modal(document.getElementById('addModal'), {
            keyboard: false
        })
        //view
        var viewModal = new bootstrap.Modal(document.getElementById('viewModal'), {
            keyboard: false
        })
        //edit
        var editModal = new bootstrap.Modal(document.getElementById('editModal'), {
            keyboard: false
        })
        //delete
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
            keyboard: false
        })
    </script>

</body>

</html>