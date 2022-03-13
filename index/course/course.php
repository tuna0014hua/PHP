<?php
require_once("../../pdo_connect_jj.php");

$sqlCour="SELECT * FROM course WHERE valid=1";
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
    <title>Course</title>
    <style>
        .search_target{
            background: yellow;
        }
    </style>
    <?php require_once("../../css.php") ?>
</head>

<body>
    <?php require_once("../../main.php") ?>

    <div class="right">
        <div class="container">
            <div class="row d-flex justify-content-center my-3">
                <div class="text-end">
                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addCourseModal" href="#">新增</a>
                    <a class="btn btn-danger mx-2" id="lotDel" data-bs-toggle="modal" data-bs-target="#deleteModal" href="#" >批量刪除</a>
                </div>
            </div>

            <table id="table" class="table table-borderd" data-toggle="table">
                <thead class="thead">
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>#</th>
                    <th>課程名稱</th>
                    <th>難易度</th>
                    <th>價格</th>
                    <th>人數上限</th>
                    <th>推薦裝備&nbsp;<i class="far fa-edit"></i></th>
                    <th class="bg-info text-center">
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
                        <td><input type="checkbox" data-id="<?=$value["id"]?>"></td>
                        <td><?= $value["id"]?></td>
                        <td><?= $value["name"]?></td>
                        <td><?= $diffArr[$value["difficulty_id"]]?></td>
                        <td>$<?= $value["price"]?></td>
                        <td><?= $value["stu_limit"]?></td>
                        <td><a id="linkToAdvice" href="advice.php?course_id=<?= $value["id"] ?>" style="text-decoration:none">共
                                <?php
                                $sqlProd="SELECT * FROM advice WHERE course_id=? AND valid=1";
                                $stmtProd=$db_host->prepare($sqlProd);
                                $stmtProd->execute([$value["id"]]);
                                echo $stmtProd->rowCount();
                                ?> 筆
                            </a></td>
                        <td class="text-center tdBTnEye">
                            <a data-id="<?=$value["id"]?>" id="view" class="btn" data-bs-toggle="modal" data-bs-target="#viewCourseModal" href="#">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td class="text-center tdBTnEdit">
                            <a data-id="<?=$value["id"]?>" id="edit" class="btn" data-bs-toggle="modal" data-bs-target="#editCourseModal" href="#">
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

            <!--addCourse Modal--->
            <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title fw-bold" id="addCourseModalLabel">新增</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="course-doCreate.php" method="post">
<!--                                <div class="row mb-3 h-100 d-flex">-->
<!--                                    <label for="inputEmail3" class="col-sm-3 col-form-label">ID:&nbsp;</label>-->
<!--                                    <div class="col-sm-9 justify-content-center align-self-center">-->
<!--                                        可以讓系統自己帶嗎?-->
<!--                                    </div>-->
<!--                                </div>-->
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
                                                <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
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

            <!--viewCourse Modal--->
            <div class="modal fade" id="viewCourseModal" tabindex="-1" aria-labelledby="viewCourseModalLabel" aria-hidden="true">
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
                                <hr>
                                <div class="row mb-1 h-100 d-flex">
                                    <label for="advice" class="col-sm-3 col-form-label">推薦裝備:&nbsp;</label>
                                    <div class="col-sm-12 justify-content-center align-self-center px-2" id="viewAdvice">
                                        <ul class="d-flex list-unstyled flex-wrap ps-1" id="adviceList">
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                        </div>
                    </div>
                </div>
            </div> <!--viewCourse Modal end--->

            <!--editCourse Modal--->
            <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title fw-bold  text-white" id="editCourseModalLabel">編輯</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="course-doEdit.php" method="post">
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="id" class="col-sm-3 col-form-label">ID:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="editId" name="id" readonly>
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
            </div> <!--editCourse Modal end--->

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
                            <button type="button" class="btn btn-primary px-3" id="confirmDel" data-bs-confirm="modal">確認</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                        </div>
                    </div>
                </div>
            </div> <!--Delete Modal end-->

        </div> <!-- Container end -->
    </div>
    <?php require_once("../../js.php") ?>
    <script>

        //checkbox
        //判斷是否全選以同步th的checkbox
        function ifAllChecked(){
            let dataCount=$("tbody tr").length;
            let checkedCount=$("tbody :checked").length
            if(dataCount==checkedCount){
                $("#checkAll").prop("checked", true)
            }else{
                $("#checkAll").prop("checked", false)
            }
        }
        // checkbox tr事件
        $("tbody tr").on("click", "#linkToAdvice", function(e){
            e.stopPropagation();
        })
        $("tbody").on("click", "tr", function(){
            let checked=$(this).find(":checkbox").prop("checked")
            if(checked){
                $(this).find(":checkbox").prop("checked", false)
                $(this).closest("tr").removeClass("active")
            }else{
                $(this).find(":checkbox").prop("checked", true)
                $(this).closest("tr").addClass("active")
            }
            ifAllChecked()
            })
        //checkbox checkbox事件
        $("tbody").on("click", ":checkbox", function(e){
            e.stopPropagation();
            let checked=$(this).prop("checked")
            ifAllChecked()
        })
        //點thead checkbox的事件
        $("#checkAll").click(function(){
            let status=$(this).prop("checked")
            $("tbody :checkbox").prop("checked", status)   //讓tbody的checkbox跟checkall同步
            if(status){
                $("tbody tr").addClass("active")
            }else{
                $("tbody tr").removeClass("active")
            }
        })
        //delete the selected items
        $("#lotDel").click(function(){
            let checkedCount=$("tbody :checkbox").length
            let ids=[];
            //取得所有被選取的id並存成陣列
            for(let i=0 ; i<checkedCount ; i++){
                let id=$("tbody :checkbox").eq(i).data("id")
                if($("tbody :checkbox").eq(i).prop("checked")){
                    ids.push(id)
                }
            }
            //call delete api 分別將被選取id刪除
                $("#confirmDel").click(function() {
                    ids.forEach(function(id){
                    let formdata = new FormData();
                    formdata.append("id", id);
                    console.log(id);
                    axios.post("api/course-delete.php", formdata)
                        .then(function (response) {
                            window.location.reload();
                        })
                })
            })
        })

        //click view btn event
        $("#target").on("click", "#view", function(e){
            e.stopPropagation();
            let id=$(this).data("id");
            console.log(id);
            //call api by assigned course id
            let formdata=new FormData();
            formdata.append("id", id);
            axios.post("api/course-view.php", formdata)
                .then(function(response){
                    let data=response.data;
                    console.log(data);
                    if(data.status==0){
                        console.log("資料讀取錯誤");
                    }else {
                        $("#adviceList").empty()
                        $("#viewId").text(data.data["id"]);
                        $("#viewName").text(data.data["name"]);
                        $("#viewPrice").text(data.data["price"]);
                        $("#viewLimit").text(data.data["stu_limit"]);
                        //建議裝備內容
                        if(data.adviceCount===0){
                            $("#adviceList").text("無建議產品");
                        }else{
                            let adContent=""
                            let path= "../product/product_images/"
                            data.adviceData.forEach(function(advice){
                                // console.log(advice)
                                adContent += `
                            <li class="card pt-1 m-1 d-flex justify-content-center align-items-center" style="width:105px">
                            <div style="width:100px ; height: 100px; border-radius: 3px" class="overflow-hidden">
                               <img class="cover-fit" src="${path}${data.productImg[advice.product_id]}">
                            </div>
                            ${data.productList[advice.product_id]}
                            </li>
                            `
                            })
                            $("#adviceList").append(adContent);
                        }

                        //call another api by difficulty_id to observe the name
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

        //click edit btn event
        $("#target").on("click", "#edit", function(e){
            e.stopPropagation();
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

        //click delete btn event
        $("#target").on("click", "#delete", function(e){
            e.stopPropagation();
            let id=$(this).data("id");
            console.log(id);
            $("#confirmDel").click(function() {
                let formdata = new FormData();
                formdata.append("id", id);
                console.log(id);
                axios.post("api/course-delete.php", formdata)
                    .then(function (response) {
                        window.location.reload();
                    })
            })
        })
        //add
        var addCourseModal = new bootstrap.Modal(document.getElementById('addCourseModal'), {
            keyboard: false
        })
        //view
        var viewCourseModal = new bootstrap.Modal(document.getElementById('viewCourseModal'), {
            keyboard: false
        })
        //edit
        var editCourseModal = new bootstrap.Modal(document.getElementById('editCourseModal'), {
            keyboard: false
        })
        //delete
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
            keyboard: false
        })
    </script>

</body>

</html>