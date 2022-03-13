<?php
require_once("../../pdo_connect_jj.php");

$sqlMem = "SELECT * FROM member WHERE valid=1";
$stmtMem = $db_host->prepare($sqlMem);
$stmtMem->execute();
$rowsMem = $stmtMem->fetchAll(PDO::FETCH_ASSOC);

$sqlMemLV = "SELECT * FROM member_level";
$stmtMemLV = $db_host->prepare($sqlMemLV);
$stmtMemLV->execute();
$rowsMemLV = $stmtMemLV->fetchAll(PDO::FETCH_ASSOC);
$memLVArr = [];
foreach ($rowsMemLV as $valueMemLV) {
    $memLVArr[$valueMemLV["id"]] = $valueMemLV["name"];


}

?>
<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member</title>
    <?php require_once("../../css.php"); ?>


</head>

<body>
<?php require_once("../../main.php") ?>

<div class="right">
    <div class="container">
        <div class="row d-flex justify-content-center my-3">
<!--            <div class="col-lg-6 position-relative search">-->
<!--                <i class="fas fa-search"></i>-->
<!--                <input type="text" class="searchInput" placeholder="Search for names..">-->
<!--            </div>-->
            <div class="text-end ">
                <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addMemberModal" type="submit"
                   href="#">新增</a>
            </div>
        </div>

        <table id="table" class="table table-borderd" data-toggle="table">
            <thead class="thead">
            <tr>
                <th><input type="checkbox"></th>
                <th>#</th>
                <th>會員名稱</th>
                <th>性別</th>
                <th>年齡</th>
                <th>電子信箱</th>
<!--                <th>密碼</th>-->
                <th>消費金額</th>
                <th>點數</th>
                <th>會員等級</th>
                <th>建立日期</th>
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
            <?php foreach ($rowsMem as $value): ?>
                <tr>
                    <td><input type="checkbox" data-id="<?= $value["id"] ?>"></td>
                    <td><?= $value["id"] ?></td>
                    <td><?= $value["name"] ?></td>
                    <td><?= $value["gender"] ?></td>
                    <td><?= $value["age"] ?></td>
                    <td><?= $value["email"] ?></td>
<!--                    <td>--><?//= $value["password"] ?><!--</td>-->
                    <td><?= $value["spending"] ?></td>
                    <td><?= $value["point"] ?></td>
                    <td><?= $memLVArr[$value["level_id"]] ?></td>
                    <td><?= $value["created_at"] ?></td>
                    <td class="text-center tdBTnEye">
                        <a data-id="<?= $value["id"] ?>" class="btn viewMember" data-bs-toggle="modal"
                           data-bs-target="#viewMemberModal" href="#">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                    <td class="text-center tdBTnEdit">
                        <a data-id="<?= $value["id"] ?>" class="btn editMemberModal" data-bs-toggle="modal"
                           data-bs-target="#editMemberModal" href="#">
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                    <td class="text-center tdBTnDetele">
                        <a data-id="<?= $value["id"] ?>" id="delete" class="btn deleteMemberModal" data-bs-toggle="modal"
                           data-bs-target="#deleteMemberModal" href="#">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

        <!--addMember Modal--->
        <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title fw-bold" id="addMemberModal">新增會員</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="member_do_insert.php" method="post">
                            <div class="row mb-3">
                                <label for="name" class="col-sm-3 col-form-label">會員名稱:&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>

                            <fieldset class="row mb-3">
                                <legend class="col-form-label col-sm-3 pt-0">性別:&nbsp;</legend>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="Gender1"
                                               value="男" checked>
                                        <label class="form-check-label" for="Gender1">
                                            男
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="Gender2"
                                               value="女">
                                        <label class="form-check-label" for="Gender2">
                                            女
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="age" class="col-sm-3 col-form-label">年齡:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="age" name="age" min="1" max="200"
                                               required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-3 col-form-label">電子信箱:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-sm-3 col-form-label">密碼:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="password" name="password"
                                               required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="spending" class="col-sm-3 col-form-label">消費金額:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="spending" name="spending" min="0"
                                               required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="point" class="col-sm-3 col-form-label">點數:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="point" name="point" min="0"
                                               required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Level" class="col-sm-3 col-form-label">會員等級:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="level_id" id="">
                                            <?php foreach ($rowsMemLV as $value): ?>
                                                <option value="<?= $value["id"] ?>>"><?= $value["name"] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                            </fieldset>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">確認</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div> <!--addMember Modal end--->

    <!--ViewMember Modal--->
    <div class="modal fade" id="viewMemberModal" tabindex="-1" aria-labelledby="viewMemberModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title fw-bold" id="viewMemberModal">檢視</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-2 h-100 d-flex">
                            <label for="ID" class="col-sm-3 col-form-label">編號:&nbsp;</label>
                            <div class="col-sm-9 justify-content-center align-self-center" id="member_ID"></div>
                        </div>
                        <div class="row mb-2 h-100 d-flex">
                            <label for="name" class="col-sm-3 col-form-label">會員名稱:&nbsp;</label>
                            <div class="col-sm-9 justify-content-center align-self-center" id="member_name"></div>
                        </div>
                        <div class="row mb-3 h-100 d-flex">
                            <label for="gender" class="col-sm-3 col-form-label">性別:&nbsp;</label>
                            <div class="col-sm-9 justify-content-center align-self-center" id="member_gender"></div>
                        </div>
                        <div class="row mb-3 h-100 d-flex">
                            <label for="age" class="col-sm-3 col-form-label">年齡:&nbsp;</label>
                            <div class="col-sm-9 justify-content-center align-self-center" id="member_age"></div>
                        </div>
                        <div class="row mb-3 h-100 d-flex">
                            <label for="email" class="col-sm-3 col-form-label">電子信箱:&nbsp;</label>
                            <div class="col-sm-9 justify-content-center align-self-center" id="member_email"></div>
                        </div>
                        <div class="row mb-3 h-100 d-flex">
                            <label for="password" class="col-sm-3 col-form-label">密碼:&nbsp;</label>
                            <div class="col-sm-9 justify-content-center align-self-center" id="member_password"></div>
                        </div>
                        <div class="row mb-3 h-100 d-flex">
                            <label for="spending" class="col-sm-3 col-form-label">消費金額:&nbsp;</label>
                            <div class="col-sm-9 justify-content-center align-self-center" id="member_spending"></div>
                        </div>
                        <div class="row mb-3 h-100 d-flex">
                            <label for="point" class="col-sm-3 col-form-label">點數:&nbsp;</label>
                            <div class="col-sm-9 justify-content-center align-self-center" id="member_point"></div>
                        </div>
                        <div class="row mb-3 h-100 d-flex">
                            <label for="member_level" class="col-sm-3 col-form-label">會員等級:&nbsp;</label>
                            <div class="col-sm-9 justify-content-center align-self-center"
                                 id="member_member_level"></div>
                        </div>
<!--                        <div class="row mb-1 h-100 d-flex">-->
<!--                            <label for="created_at" class="col-sm-3 col-form-label">建立日期:&nbsp;</label>-->
<!--                            <div class="col-sm-12 justify-content-center align-self-center px-2"-->
<!--                                 id="member_created_at"></div>-->
<!--                        </div>-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div> <!--ViewMember Modal end--->


    <!--EditMember Modal--->
    <div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title fw-bold  text-white" id="editMemberModal">編輯</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="member_do_edit.php" method="post">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">ID:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_ID" name="id" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">會員名稱:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">性別:</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="edit_gender" name="gender" required>
                                    <option value="男">男</option>
                                    <option value="女">女</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label  class="col-sm-3 col-form-label">年齡:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_age" name="age" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label  class="col-sm-3 col-form-label">電子信箱:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_email" name="email" required>
                            </div>
                        </div>
<!--                        <div class="row mb-3">-->
<!--                            <label class="col-sm-3 col-form-label">密碼:</label>-->
<!--                            <div class="col-sm-9">-->
<!--                                <input type="text" class="form-control" id="edit_password" name="password" readonly>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">消費金額:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_spending" name="spending" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="point" class="col-sm-3 col-form-label">點數:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_point" name="point" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">會員等級:</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="edit_member_level" name="level_id" required>

                                    <?php foreach ($rowsMemLV as $values): ?>
                                        <option value="<?= $values["id"] ?>"> <?= $values["name"] ?> </option>
                                    <?php endforeach ?>
                                </select>
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
    </div> <!--EditMember Modal end--->


    <!-- DeleteMember Modal -->
    <div class="modal fade" id="deleteMemberModal" tabindex="-1" aria-labelledby="deleteMemberModal"
         aria-hidden="true">
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
                    <button type="submit" id="DeleteMember" class="btn btn-primary px-3" data-bs-confirm="modal">確認</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div> <!--DeleteMember Modal end-->

</div> <!-- Container end -->
</div>
<?php require_once("../../js.php") ?>

<!--<script src="https://unpkg.com/axios/dist/axios.min.js"></script>-->

<script>
    //add
    var addMemberModal = new bootstrap.Modal(document.getElementById('addMemberModal'), {
        keyboard: false
    })
    //view
    var viewMemberModal = new bootstrap.Modal(document.getElementById('viewMemberModal'), {
        keyboard: false
    });

    $("#target").on("click", ".viewMember", function (e) {
        e.stopPropagation();
        let id = $(this).data("id");
        console.log(id);
        let formdata = new FormData();
        formdata.append("id", id);
        axios.post("api/member_view.php", formdata)
            .then(function (response) {
                // console.log(response);
                let data = response.data;
                // data = Object.keys(data);
                if (data.status == 1) {
                    $("#member_ID").text(data.data["id"]);
                    $("#member_name").text(data.data.name);
                    $("#member_gender").text(data.data.gender);
                    $("#member_age").text(data.data.age);
                    $("#member_email").text(data.data.email);
                    $("#member_password").text(data.data.password);
                    $("#member_spending").text(data.data.spending);
                    $("#member_point").text(data.data.point);
                    $("#member_member_level").text(data["memLev"]);
                    $("#member_created_at").text(data.data.time);
                } else {
                    console.log("檢視失敗");

                }
            })
    });

    var editMemberModal = new bootstrap.Modal(document.getElementById('editMemberModal'), {
                    keyboard: false
                });
    $("#target").on("click", ".editMemberModal", function (e) {
        e.stopPropagation();
        let id = $(this).data("id");
        console.log(id);
        let formdata = new FormData();
        formdata.append("id", id);
        axios.post("api/member_view.php", formdata)
            .then(function (response) {
                console.log(response);
                let data = response.data;
                // data = Object.keys(data);
                if (data.status == 1) {

                    console.log(data)
                    $("#edit_ID").val(data.data["id"]);
                    $("#edit_name").val(data.data["name"]);
                    $("#edit_gender").val(data.data["gender"]);
                    $("#edit_age").val(data.data["age"]);
                    $("#edit_email").val(data.data["email"]);
                    $("#edit_password").val(data.data["password"]);
                    $("#edit_spending").val(data.data["spending"]);
                    $("#edit_point").val(data.data["point"]);
                    $("#edit_member_level").val(data.data["level_id"]);
                    $("#edit_created_at").val(data.data["time"]);
                }

            })
    });

                //delete
    var deleteMemberModal = new bootstrap.Modal(document.getElementById('deleteMemberModal'), {
                    keyboard: false
                })

      $("#target").on("click","#delete",function (){
        let id=$(this).data("id");
        // console.log(id);
        $("#DeleteMember").click(function (){
            let formdata=new FormData();
            formdata.append("id",id);
            axios.post("api/member_delete.php",formdata)
            window.location.reload();
        })
    })


</script>

</body>

</html>