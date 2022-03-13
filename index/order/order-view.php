<?php
require_once("../../pdo_connect_jj.php");
$id=$_GET["id"];
$sql = "SELECT * FROM ordered WHERE id=?";
$stmt = $db_host->prepare($sql);
$stmt->execute([$id]);
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlC = "SELECT * FROM course WHERE valid=1 ";
$stmtC = $db_host->prepare($sqlC);
$stmtC->execute();
$rowC = $stmtC->fetchAll(PDO::FETCH_ASSOC);
$courseArr=[];
foreach($rowC as $valueC){
    $courseArr[$valueC["id"]]=$valueC["name"];
}
$sqlP = "SELECT * FROM product WHERE valid=1";
$stmtP = $db_host->prepare($sqlP);
$stmtP->execute();
$rowP = $stmtP->fetchAll(PDO::FETCH_ASSOC);
$productArr=[];
foreach ($rowP as $valueP) {
    $productArr[$valueP["id"]] = $valueP["name"];
}

$sqlPC = "SELECT * FROM category_product ";
$stmtPC = $db_host->prepare($sqlPC);
$stmtPC->execute();
$rowPC = $stmtPC->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <!-- 訂單編號<?= $id ?>的商品 -->
    <?php require_once("../../css.php") ?>
</head>


<body>
<?php require_once("../../main.php") ?>

<div class="right">
    <div class="container">
        <div class="row d-flex justify-content-center my-3">
            <div class="col-lg-12 mb-2">
                <a class="btn btn-primary" href="order.php">回訂單</a>
            </div>
            <div class="text-end col-lg-12 mb-2">
                <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addOrderModal" href="#">新增</a>
                <a class="btn btn-danger mx-2" id="lotDel" data-bs-toggle="modal" data-bs-target="#deleteModal" href="#" >批量刪除</a>
            </div>
        </div>

            <table id="table" class="table table-borderd" data-toggle="table">
                <thead class="thead">
                    <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                        <th>訂單編號</th>
                        <th>商品類別</th>
                        <th>商品名稱</th>
                        <th>數量</th>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                   </tr>
            </table>

            <!--addOrder Modal--->
            <div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title fw-bold" id="addOrderModalLabel">新增</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="orderItem-doCreate.php" method="post" id="addForm">
                            <input name="order_id" value=<?=$id?> hidden>
                            <div class="firstChoose">
                                <div class="row mb-3 not">
                                    <label for="orderCategory" class="col-sm-3 col-form-label">商品類別:</label>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <select  class="form-select" name="order_category" id="orderCategory">
                                            <option value="請選擇商品類別">請選擇商品類別</option>
                                            <option value="course">課程體驗</option>
                                            <option value="product">裝備租賃</option>
                                        </select>
                                    </div>
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
            <!--addOrder Modal end--->

            <!--editOrder Modal--->
            <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title fw-bold  text-white" id="editOrderModalLabel">編輯</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form>
                        <input name="id" value=<?=$id?> hidden>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label">商品名稱:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="editName" name="name" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="amount" class="col-sm-3 col-form-label">數量:</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="amount" id="editAmount" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="confirmEdit" class="btn btn-primary">確認</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                    </div>
                </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--editOrder Modal end--->


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
            </div>
            <!--Delete Modal end-->

        </div> <!-- Container end -->
    </div>
    <?php require_once("../../js.php") ?>
    <script>
            //進入網頁讀取API資料動態新增表格內容
    $(document).ready(function() {
        let getUrlStr=location.href;
        let url=new URL(getUrlStr);
        let id=url.searchParams.get("id");
        let formdata = new FormData();
        formdata.append("id", id);
        axios.post("api/order-detail.php", formdata)
            .then(function (response) {
                data=response.data
                console.log(response)
                let content="";
                data.courseOrder.forEach(function(course){
                    content += `
                    <tr>
                    <td><input type="checkbox" data-id="${course.id}" data-cate="course"></td>
                    <td>${course.order_id} </td>
                    <td> 課程體驗 </td>
                    <td>${[data.courseName[course.course_id]]}</td>
                    <td>${course.amount}</td>
                    <td class="text-center tdBTnEdit">
                            <a data-id="${course.id}" data-cate="course" id="edit" class="btn" data-bs-toggle="modal" data-bs-target="#editOrderModal" href="#">
                                <i class="far fa-edit"></i>
                            </a>
                        </td>
                        <td class="text-center tdBTnDetele">
                        <a data-id="${course.id}" data-cate="course" id="delete" class="btn" data-bs-toggle="modal" data-bs-target="#deleteModal" href="#">
                            <i class="fas fa-trash-alt"></i>
                        </a >
                    </td>
                </tr>
                    `
                })
                data.productOrder.forEach(function(product) {
                    content += `
                    <tr>
                    <td><input type="checkbox" data-id="${product.id}" data-cate="product"></td>
                    <td>${product.order_id}</td>
                    <td> 裝備租賃</td>
                    <td>${[data.productName[product.product_id]]}</td>
                    <td>${product.amount}</td>
                    <td class="text-center tdBTnEdit">
                            <a data-id="${product.id}" data-cate="product" id="edit" class="btn" data-bs-toggle="modal" data-bs-target="#editOrderModal" href="#">
                                <i class="far fa-edit"></i>
                            </a>
                        </td>
                    <td class="text-center tdBTnDetele">
                        <a data-id="${product.id}" data-cate="product" id="delete" class="btn" data-bs-toggle="modal" data-bs-target="#deleteModal" href="#">
                            <i class="fas fa-trash-alt"></i>
                        </a >
                    </td>
                </tr>
                    `
                })
                    $("#target").empty().append(content);
            })
    })
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
            let dataToApi={};
            let j=0
            //取得所有被選取的id&cate並存成物件
            for(let i=0 ; i<checkedCount ; i++){
                if($("tbody :checkbox").eq(i).prop("checked")){
                    let id=$("tbody :checkbox").eq(i).data("id")
                    let cate=$("tbody :checkbox").eq(i).data("cate")
                    console.log(cate)
                    let obj=j
                    let a={}
                    a["id"]=id
                    a["cate"]=cate
                    dataToApi[obj]=a
                    j++
                }
            }
            console.log(dataToApi)
            let arr = Object.keys(dataToApi);
            let len = arr.length;

            //call delete api 分別將被選取id刪除
            $("#confirmDel").click(function() {
                for(let i=0; i<len; i++){
                    data=dataToApi[i]
                    let formdata = new FormData();
                    formdata.append("id", data.id);
                    formdata.append("cate", data.cate);
                    axios.post("api/singleDel.php", formdata)
                        .then(function (response) {
                            window.location.reload();
                        })
                }

            })
        })    
    // click edit event
    $("#target").on("click", "#edit", function(e){
        e.stopPropagation();
        let id=$(this).data("id");
        let cate=$(this).data("cate");
            let formdata = new FormData();
            formdata.append("id", id);
            formdata.append("cate", cate);
            axios.post("api/singleDetail.php", formdata)
            .then(function (response) {
                data=response.data
                itemName=""
                amount=data.orderDetail[0]["amount"]
                 if(cate=="course"){
                     console.log(data)
                    itemName=data.itemNameArr[data.orderDetail[0]["course_id"]]
                 }else{
                    itemName=data.itemNameArr[data.orderDetail[0]["product_id"]]
                 }
                $("#editName").val(itemName)
                $("#editAmount").val(amount)
        })
        $("#confirmEdit").click(function() {
            if($("#editAmount").val()<=0){
                alert("數量不可少於1");
                return;
            }
            let newAmount=$("#editAmount").val()
            let formdata2 = new FormData();
            formdata2.append("id", id);
            formdata2.append("cate", cate);
            formdata2.append("newAmount", newAmount)
            axios.post("api/singleEdit.php", formdata2)
            .then(function (response) {
                console.log(response.data)
            })
            window.location.reload();
        })
    })


    // click delete event
    $("#target").on("click", "#delete", function(e){
        e.stopPropagation();
        let id=$(this).data("id");
        let cate=$(this).data("cate");
        console.log(id)
        console.log(cate)
        $("#confirmDel").click(function() {
            let formdata = new FormData();
            formdata.append("id", id);
            formdata.append("cate", cate);
            axios.post("api/singleDel.php", formdata)
            .then(function (response) {
                window.location.reload();
            })

        })
    })

    //選擇課程/商品的類別後出現不同選項
    $("#orderCategory").change(function(){
        let cat= $("#orderCategory").val()
        console.log(cat)
        let amountHtml=`<div class="row mb-3 amountBox">
                       <label for="amount" class="col-sm-3 col-form-label">商品數量:</label>
                       <div class="col-sm-9 d-flex align-items-center">
                       <input type="number" class="form-control" value="1" id="amount" name="amount">
                       </div>
                        </div>`

        if(cat=="course"){
            let content=` <div class="row mb-3">
                          <label for="courseId" class="col-sm-3 col-form-label">課程名稱:</label>
                          <div class="col-sm-9">
                          <select  class="form-select" name="course_id" id="courseId">
                             <option value="請選擇課程">請選擇課程</option>
                               <?php foreach($rowC as $valueC):?>
                                 <option value="<?= $valueC["id"] ?>"><?= $valueC["name"] ?></option>
                               <?php endforeach ?>
                          </select>
                          </div>
                          </div>
                          ${amountHtml}`
            $(".firstChoose .row").not(".not").remove()
            $(".firstChoose").append(content)
        }else{
            let content=`                            <div class="row mb-3">
                                <label for="productCatId" class="col-sm-3 col-form-label">產品類別:</label>
                                <div class="col-sm-9">
                                    <select  class="form-select" name="product_cat_id" id="productCatId">
                                        <option value="請選擇產品類別">請選擇產品類別</option>
                                        <?php foreach($rowPC as $valuePC):?>
                                            <option value="<?= $valuePC["id"] ?>>"><?= $valuePC["name"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="productId" class="col-sm-3 col-form-label">產品名稱:</label>
                                <div class="col-sm-9">
                                    <select  class="form-select" name="product_id" id="productId">
                                        <option value="請選擇產品名稱">請選擇產品名稱</option>
                                    </select>
                                </div>
                            </div>
                            ${amountHtml}`
            $(".firstChoose .row").not(".not").remove()
            $(".firstChoose").append(content)
        }
    })

    //change the content of product list per selected category
    $(".firstChoose").on("change", "#productCatId", function(){
        let selCategory = $("#productCatId").val()
        $.ajax({
            method: "POST",
            url: "api/product-list.php",
            dataType: "json",
            data: {
                selCategory: selCategory
            },
        }).done(function( products ) {
            $("#productId").empty();
            let content = `<option value="請選擇產品">請選擇產品</option>`;
            products.forEach(function (product) {
                content += `
                             <option value="${product.id}">${product.name}</option>`
            });  //end of foreach
            $("#productId").append(content);
        })
    })


        //add
        var addOrderModal = new bootstrap.Modal(document.getElementById('addOrderModal'), {
            keyboard: false
        })
        //edit
        var editOrderModal = new bootstrap.Modal(document.getElementById('editOrderModal'), {
            keyboard: false
        })
        //delete
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
            keyboard: false
        })
    </script>

</body>

</html>