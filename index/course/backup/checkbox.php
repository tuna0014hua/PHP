<style>
    .table tr.active {
        background: rgba(186, 186, 186, .4);
    }
</style>
<script>
//記得要有一個#checkAll的按鈕且要宣告delete modal
    //checkbox
    $("tbody :checkbox").click(function(){
        let checked=$(this).prop("checked")
        let dataCount=$("tbody tr").length;
        let checkedCount=$("tbody :checked").length
        if(checked){
            $(this).closest("tr").addClass("active")
        }else{
            $(this).closest("tr").removeClass("active")
        }
        if(dataCount==checkedCount){
            $("#checkAll").prop("checked", true)
        }else{
            $("#checkAll").prop("checked", false)
        }
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
        let ids=[];
        //取得所有被選取的id並存成陣列
        for(let i=0 ; i<checkedCount ; i++){
            let id=$("tbody :checkbox").eq(i).data("id")
            if($("tbody :checkbox").eq(i).prop("checked")){
                ids.push(id)
            }
        }
        //call delete api 分別將被選取id刪除
        ids.forEach(function(id){
            $("#confirmDel").click(function() {
                let formdata = new FormData();
                formdata.append("id", id);
                console.log(id);
                axios.post("api/course-delete.php", formdata)
                window.location.reload();
            })
        })
    })

var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
    keyboard: false
})

</script>