<?php
$course_id=$_GET["course_id"];
require_once("../../pdo_connect_jj.php");
$sqlAdv="SELECT * FROM advice WHERE course_id=? AND valid=1";
$stmtAdv=$db_host->prepare($sqlAdv);
$stmtAdv->execute(["$course_id"]);
$rowsAdv=$stmtAdv->fetchAll(PDO::FETCH_ASSOC);

$sqlProd="SELECT * FROM product";
$stmtProd=$db_host->prepare($sqlProd);
$stmtProd->execute();
$rowsProd=$stmtProd->fetchAll(PDO::FETCH_ASSOC);
$prodArr=[];
foreach($rowsProd as $valueProd){
    $prodArr[$valueProd["id"]]=$valueProd["name"];
}
$prodCateIdArr=[];
foreach($rowsProd as $valueProdCatId){
    $prodCateIdArr[$valueProdCatId["id"]]=$valueProdCatId["category_id"];
}


$sqlCour="SELECT * FROM course";
$stmtCour=$db_host->prepare($sqlCour);
$stmtCour->execute();
$rowsCour=$stmtCour->fetchAll(PDO::FETCH_ASSOC);
$courArr=[];
foreach($rowsCour as $valueCour){
    $courArr[$valueCour["id"]]=$valueCour["name"];
}

$sqlProdCat="SELECT * FROM category_product";
$stmtProdCat=$db_host->prepare($sqlProdCat);
$stmtProdCat->execute();
$rowsProdCat=$stmtProdCat->fetchAll(PDO::FETCH_ASSOC);
$prodCatArr=[];
foreach($rowsProdCat as $valueProdCat){
    $prodCatArr[$valueProdCat["id"]]=$valueProdCat["name"];
}

?>

<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course</title>
    <!-- <?= $courArr[$course_id]?>的裝備建議 -->
    <?php require_once("../../css.php") ?>
</head>

<body>
<?php require_once("../../main.php") ?>

<div class="right">
    <div class="container">
        <div class="row d-flex justify-content-center my-3">
            <div class="col-lg-12 mb-2">
                <a class="btn btn-primary" href="course.php">回課程</a>
            </div>
            <div class="text-end col-12">
                <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addCourseModal" href="#">新增</a>
                <a class="btn btn-danger  mx-2" id="lotDel" data-bs-toggle="modal" data-bs-target="#deleteModal" href="#" >批量刪除</a>
            </div>
        </div>
        <table id="table" class="table table-borderd" data-toggle="table">
            <thead class="thead">
            <tr>
            <th><input type="checkbox" id="checkAll"></th>
                <th>#</th>
                <th>課程名稱</th>
                <th>產品類別</th>
                <th>產品名稱</th>
                <th scope="col" class="bg-danger text-center">
                    <div class="text-white"><i class="fas fa-trash-alt"></i></div>
                </th>
            </tr>
            </thead>
            <tbody id="target">
            <?php foreach($rowsAdv as $value): ?>
                <tr>
                    <td><input type="checkbox" data-id="<?=$value["id"]?>"></td>
                    <td><?= $value["id"]?></td>
                    <td><?= $courArr[$value["course_id"]]?></td>
                    <td><?= $prodCatArr[$prodCateIdArr[$value["product_id"]]]?></td>
                    <td><?= $prodArr[$value["product_id"]]?></td>
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
                        <form action="advice-doCreate.php" method="post">
                            <div class="row mb-3">
                                <label for="name" class="col-sm-3 col-form-label">課程名稱:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" value="<?= $courArr[$course_id]?>" readonly>
                                    <select  class="form-select" name="course_id" id="courseId" readonly hidden>
                                        <option value="<?=$course_id?>"><?= $courArr[$course_id]?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="categoryId" class="col-sm-3 col-form-label">產品類別:</label>
                                <div class="col-sm-9">
                                    <select  class="form-select" name="category_id" id="categoryId" required>
                                        <option value="請選擇類別">請選擇類別</option>
                                        <?php foreach($rowsProdCat as $value):?>
                                            <option value="<?= $value["id"] ?>>"><?= $value["name"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="productId" class="col-sm-3 col-form-label">產品項目:</label>
                                <div class="col-sm-9">
                                    <select  class="form-select" name="product_id" id="productId" required>
                                        <option value="請選擇產品">請選擇產品</option>
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
        </div> <!--add Modal end--->


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
                    axios.post("api/advice-delete.php", formdata)
                        .then(function (response) {
                            window.location.reload();
                        })
                })

            })
        })

    // click delete event
    $("#target").on("click", "#delete", function(e){
        e.stopPropagation();
        let id=$(this).data("id");
        console.log(id);
        $("#confirmDel").click(function() {
            let formdata = new FormData();
            formdata.append("id", id);
            console.log(id);
            axios.post("api/advice-delete.php", formdata)
                .then(function (response) {
                    window.location.reload();
                })
        })
    })

    //change the content of product list per selected category
    $("#categoryId").change(function(){
        let selCategory = $("#categoryId").val()
        // console.log(selCategory);
        $.ajax({
            method: "POST",
            url: "api/product-list.php",
            dataType: "json",
            data: {
                selCategory: selCategory
            },
        }).done(function( products ) {
                console.log(products);
                $("#productId").empty();
            let content = `<option value="請選擇產品">請選擇產品</option>`;
                products.forEach(function (product) {
                    content += `
                             <option value="${product.id}">${product.name}</option>`
                });  //end of foreach
                $("#productId").append(content);
            })
    })
    $("#productId").change(function() {
        console.log($("#categoryId").val());
        console.log($("#productId").val());
    })


        //add
    var addCourseModal = new bootstrap.Modal(document.getElementById('addCourseModal'), {
        keyboard: false
    })
    //delete
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
        keyboard: false
    })
</script>

</body>

</html>