<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course</title>
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
                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addCourseModal" href="#">新增</a>
                </div>
            </div>

            <table id="table" class="table table-borderd" data-toggle="table">
                <thead class="thead">
                    <tr>
                        <th scope="col"><input type="checkbox"></th>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Difficulty</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stu_limit</th>
                        <th scope="col">Time</th>
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
                        <td>初級班</td>
                        <td>綠線</td>
                        <td>$3000</td>
                        <td>10人</td>
                        <td>2021/09/05 00:00:00</td>
                        <td class="text-center tdBTnEye">
                            <a class="btn" data-bs-toggle="modal" data-bs-target="#viewCourseModal" href="#">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td class="text-center tdBTnEdit">
                            <a class="btn" data-bs-toggle="modal" data-bs-target="#editCourseModal" href="#">
                                <i class="far fa-edit"></i>
                            </a>
                        </td>
                        <td class="text-center tdBTnDetele">
                            <a class="btn" data-bs-toggle="modal" data-bs-target="#deleteModal" href="#">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
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
                                <div class="row mb-3">
                                    <label for="price" class="col-sm-2 col-form-label">Price:&nbsp;</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="price" name="Price">
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
            </div> <!--addCourse Modal end--->

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
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">ID:&nbsp;</label>
                                    <div class="col-sm-10 justify-content-center align-self-center">
                                        1
                                    </div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="name" class="col-sm-2 col-form-label">Name:&nbsp;</label>
                                    <div class="col-sm-10 justify-content-center align-self-center">
                                        初級班
                                    </div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="difficulty" class="col-sm-2 col-form-label">Difficulty:&nbsp;</label>
                                    <div class="col-sm-10 justify-content-center align-self-center">
                                        綠線
                                    </div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="price" class="col-sm-2 col-form-label">Price:&nbsp;</label>
                                    <div class="col-sm-10 justify-content-center align-self-center">
                                        $3000
                                    </div>
                                </div>
                                <div class="row mb-3 h-100 d-flex">
                                    <label for="time" class="col-sm-2 col-form-label">Time:&nbsp;</label>
                                    <div class="col-sm-10 justify-content-center align-self-center">
                                        2021/09/05 00:00:00
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
                                        <input type="text" class="form-control" id="name" name="name" value="初級班">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="difficulty" class="col-sm-2 col-form-label">Difficulty:&nbsp;</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="difficulty" name="difficulty" value="綠線">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="price" class="col-sm-2 col-form-label">Price:&nbsp;</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="price" name="Price" value="$3000">
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