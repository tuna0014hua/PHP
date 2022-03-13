<?php
require_once("../../pdo_connect_jj.php");
$sql = "SELECT route.*, difficulty_id.name AS difficulty_name FROM route JOIN 
difficulty_id ON route.difficulty_id =difficulty_id.id where route.valid=1 order by route.id  ";
$stmt = $db_host->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$dataCount=$stmt->rowCount();
//var_dump($rows);
//
$sqlSituation= "SELECT * from situation";
$stmtSituation = $db_host->prepare($sqlSituation);
$stmtSituation->execute();
$rowSituation = $stmtSituation->fetchall(PDO::FETCH_ASSOC);
$situationArr=[];
foreach ($rowSituation as $row){
    $situationArr[$row["id"]]= $row["situation"];
}
$sqlDiff="SELECT * FROM difficulty_id";
$stmtDiff = $db_host->prepare($sqlDiff);
$stmtDiff->execute();
$rowsDiff = $stmtDiff->fetchAll(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route</title>
    <?php require_once("../../css.php") ?>
</head>

<body>
    <?php require_once("../../main.php") ?>

    <div class="right">
        <div class="container">
            <div class="row d-flex justify-content-center my-3">
<!--                <div class="col-lg-6 position-relative search">-->
<!--                    <i class="fas fa-search"></i>-->
<!--                    <input type="text" class="searchInput" placeholder="Search for names..">-->
<!--                </div>-->
                <div class="text-end ">
                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addMapModal" href="#">新增</a>
                </div>
            </div>

            <table id="table" class="table table-borderd" data-toggle="table">
                <thead class="thead">
                    <tr>
                        <th ><input type="checkbox"></th>
                        <th>路線編號:</th>
                        <th>路線名稱:</th>
                        <th>困難難度:</th>
                        <th>路況:</th>
                        <th>描述:</th>
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
                <?php foreach ($rows as $value): ?>
                    <tr>

                        <td><input type="checkbox"></td>
                        <td><?=$value["id"]?></td>
                        <td><?=$value["name"]?></td>
                        <td><?=$value["difficulty_name"]?></td>
                        <td><?=$situationArr[$value["situation_id"]]?></td>
                        <td><?=$value["detail"]?></td>
                        <td class="text-center tdBTnEye">
                            <a data-id="<?= $value["id"]?>" class="btn" id="view" data-bs-toggle="modal" data-bs-target="#viewMapModal" href="#">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td class="text-center tdBTnEdit">
                            <a  data-id="<?= $value["id"]?>" class="btn" id="edit"data-bs-toggle="modal" data-bs-target="#editMapModal" href="#">
                                <i class="far fa-edit"></i>
                            </a>
                        </td>
                        <td class="text-center tdBTnDetele">
                            <a  data-id="<?= $value["id"]?>" id="delete"  href="doDeleteRoute.php?id=<?php echo $value["id"]; ?>" class="btn" data-bs-toggle="modal" data-bs-target="#deleteModal" href="#">
                                <i class="fas fa-trash-alt"></i>
                            </a >
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!--addMap Modal--->
            <div class="modal fade" id="addMapModal" tabindex="-1" aria-labelledby="addMapModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title fw-bold" id="addMapModalLabel">新增</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="doInserRoute.php" method="post">
                                <div class="row mb-3 h-100 d-flex">

<!--                                    <label for="inputEmail3" class="col-sm-3 col-form-label">路線編號:&nbsp;</label>-->
<!--                                    <div class="col-sm-9 justify-content-center align-self-center">-->
<!--                                      1-->
<!--                                    </div>-->
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-3 col-form-label">路線名稱:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="difficulty" class="col-sm-3 col-form-label">困難難度:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="difficulty_id" id="">

                                            <?php foreach ($rowsDiff as $diff):?>
                                                <option value="<?=$diff["id"]?>"

                                                ><?=$diff["name"]?></option>
                                            <?php endforeach; ?>
                                        </select>



                                    </div>
                                </div>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-3 pt-0">路況:</legend>
                                    <div class="col-sm-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="situation_id" id="situation_id" value="1" checked>
                                            <label class="form-check-label" for="situation1">
                                                開放
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="situation_id" id="situation2" value="2">
                                            <label class="form-check-label" for="situation2">
                                                關閉
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row mb-3">
                                    <label for="detail" class="col-sm-3 col-form-label">描述:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" class="form-control" name="detail" id="detail"></textarea>
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
            </div> <!--addMap Modal end--->

            <!--ViewMap Modal--->
            <div class="modal fade" id="viewMapModal" tabindex="-1" aria-labelledby="viewMapModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title fw-bold" id="viewMapModalLabel">檢視</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">路線編號:&nbsp;</label>
                                    <div class="col-sm-9 justify-content-center align-self-center" id="viewId">
                                    </div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="name" class="col-sm-3 col-form-label">路線名稱:&nbsp;</label>
                                    <div class="col-sm-9 justify-content-center align-self-center" id="viewName">
                                    </div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="difficulty" class="col-sm-3 col-form-label">困難難度:&nbsp;</label>
                                    <div class="col-sm-9 justify-content-center align-self-center" id="viewDiff">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">路況:&nbsp;</label>
                                    <div class="col-sm-9 justify-content-center align-self-center" id="viewSituation">
                                    </div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="detail" class="col-sm-3 col-form-label">描述:&nbsp;</label>
                                    <div class="col-sm-9 justify-content-center align-self-center " id="viewDetail">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                                </div>
                            </form>
                        </div>    

                    </div>
                </div>
            </div> <!--ViewMap Modal end--->


            <!--EditMap Modal--->
            <div class="modal fade" id="editMapModal" tabindex="-1" aria-labelledby="editMapModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title fw-bold  text-white" id="editMapModalLabel">編輯</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="doUpdateRoute.php" method="post">
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">路線編號:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input  class="form-control" name="id" id="editId"  readonly>
                                    </div>


                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-3 col-form-label">路線名稱:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="editName" name="editName" value="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="difficulty" class="col-sm-3 col-form-label">困難難度:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <div class="col-sm-9">
                                            <select class="form-select" name="editDiff" id="editDiff">
                                                <option  value=''>---請選擇---</option>
                                                <?php foreach ($rowsDiff as $diff):?>
                                                    <option value="<?=$diff["id"]?>">
                                                        <?=$diff["name"]?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-3 pt-0">路況:&nbsp;</legend>
                                    <div class="col-sm-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="editSituation" id="editOpen" value="1" checked>
                                            <label class="form-check-label" for="situation1">
                                                開放
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="editSituation" id=editClose" value="2">
                                            <label class="form-check-label" for="situation2">
                                                關閉
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row mb-3">
                                    <label for="detail" class="col-sm-3 col-form-label">描述:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" class="form-control" name="editDetail" id="editDetail">良好</textarea>
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
            </div> <!--EditMap Modal end--->


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
                            <button type="submit" id="deleteDel" class="btn btn-primary px-3" data-bs-confirm="modal">確認</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                        </div>
                    </div>
                </div>
            </div> <!--Delete Modal end-->

        </div> <!-- Container end -->
    </div>

    <?php require_once("../../js.php") ?>
    <script>
        //view
        $("#target").on("click", "#view", function(e){
            e.stopPropagation();
            let id=$(this).data("id");
            // console.log(id);
            let formdata=new FormData();
            formdata.append("id", id);
            axios.post("api/route-view.php", formdata)
                .then(function(response){
                    console.log(response);
                    let data=response.data;
                    if(data.status==0) {
                        console.log("資料讀取錯誤");
                    }else{
                    $("#viewId").text(data.data["id"]);
                    $("#viewName").text(data.data["name"]);
                    $("#viewDiff").text(data.difficult);
                    $("#viewSituation").text(data.situation);
                    $("#viewDetail").text(data.data["detail"]);

                    }
                })

        });
        //edit
        $("#target").on("click", "#edit", function(e){
            e.stopPropagation();
            let id=$(this).data("id");
            // console.log(id);
            let formdata=new FormData();
            formdata.append("id", id);
            axios.post("api/route-view.php", formdata)
                .then(function(response){
                    console.log(response);
                    let data=response.data;
                    if(data.status==0) {
                        console.log("資料讀取錯誤");
                    }else{
                        $("#editId").val(data.data["id"]);
                        $("#editName").val(data.data["name"]);
                        $("#editDiff").val(data.data["difficult"]);
                        $("#editSituation").text(data.situation);
                        $("#editDetail").text(data.data["detail"]);

                    }
                })

        });
        $("#target").on("click","#delete",function (){
            let id=$(this).data("id");
            // console.log(id);
            $("#deleteDel").click(function (){
                let formdata=new FormData();
                formdata.append("id",id);
                axios.post("api/route-delete.php",formdata)
                    .then(function (response) {
                        window.location.reload();
                    })
            })
        })









        //add
        var addMapModal = new bootstrap.Modal(document.getElementById('addMapModal'), {
            keyboard: false
        })
        //view
        var viewMapModal = new bootstrap.Modal(document.getElementById('viewMapModal'), {
            keyboard: false
        })
        //edit
        var editMapModal = new bootstrap.Modal(document.getElementById('editMapModal'), {
            keyboard: false
        })
        //delete
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
            keyboard: false
        })
    </script>

</body>

</html>