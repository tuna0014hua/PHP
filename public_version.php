<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public version</title>
    <?php require_once("css/css.php") ?>
</head>

<body>
    <?php require_once("main.php") ?>

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
                        <th scope="col">Name</th>
                        <th scope="col">Difficulty</th>
                        <th scope="col">Situation</th>
                        <th scope="col">Detail</th>
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
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>1</td>
                        <td>綠線</td>
                        <td>初級班</td>
                        <td>開放</td>
                        <td>良好</td>
                        <td class="text-center tdBTnEye">
                            <a class="btn" data-bs-toggle="modal" data-bs-target="#viewModal" href="#">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td class="text-center tdBTnEdit">
                            <a class="btn" data-bs-toggle="modal" data-bs-target="#editModal" href="#">
                                <i class="far fa-edit"></i>
                            </a>
                        </td>
                        <td class="text-center tdBTnDetele">
                            <a class="btn" data-bs-toggle="modal" data-bs-target="#deleteModal" href="#">
                                <i class="fas fa-trash-alt"></i>
                            </a >
                        </td>
                    </tr>
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
                            <form>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">ID:&nbsp;</label>
                                    <div class="col-sm-10 justify-content-center align-self-center">
                                        2
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Name:&nbsp;</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="difficulty" class="col-sm-2 col-form-label">Difficulty:&nbsp;</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="difficulty" name="difficulty">
                                    </div>
                                </div>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Situation:&nbsp;</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="situation" id="situation1" value="option1" checked>
                                            <label class="form-check-label" for="situation1">
                                                開放
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="situation" id="situation2" value="option2">
                                            <label class="form-check-label" for="situation2">
                                                關閉
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row mb-3">
                                    <label for="detail" class="col-sm-2 col-form-label">Detail:&nbsp;</label>
                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control" id="detail"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">確認</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                        </div>
                    </div>
                </div>
            </div> <!--add Modal end--->

            <!--View Modal--->
            <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title fw-bold" id="viewModalLabel">檢視</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">ID:&nbsp;</label>
                                    <div class="col-sm-10 justify-content-center align-self-center">
                                        1
                                    </div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="name" class="col-sm-2 col-form-label">Name:&nbsp;</label>
                                    <div class="col-sm-10 justify-content-center align-self-center">
                                        綠線
                                    </div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="difficulty" class="col-sm-2 col-form-label">Difficulty:&nbsp;</label>
                                    <div class="col-sm-10 justify-content-center align-self-center">
                                        初級班
                                    </div>
                                </div>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Situation:&nbsp;</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="situation" id="situation1" value="option1" checked>
                                            <label class="form-check-label" for="situation1">
                                                開放
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="detail" class="col-sm-2 col-form-label">Detail:&nbsp;</label>
                                    <div class="col-sm-10 justify-content-center align-self-center">
                                        良好
                                    </div>
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
                            <form>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">ID:&nbsp;</label>
                                    <div class="col-sm-10 justify-content-center align-self-center">
                                        1
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Name:&nbsp;</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" value="綠線">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="difficulty" class="col-sm-2 col-form-label">Difficulty:&nbsp;</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="difficulty" name="difficulty" value="初級班">
                                    </div>
                                </div>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Situation:&nbsp;</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="situation" id="situation1" value="option1" checked>
                                            <label class="form-check-label" for="situation1">
                                                開放
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="situation" id="situation2" value="option2">
                                            <label class="form-check-label" for="situation2">
                                                關閉
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row mb-3">
                                    <label for="detail" class="col-sm-2 col-form-label">Detail:&nbsp;</label>
                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control" id="detail">良好</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">確認</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
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
    <?php require_once("js/js.php") ?>
    <script>
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