<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- Datatables CDN -->
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>

<!-- axios CDN -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>


<script>
        $(document).ready(function() {
                // 側邊欄根據當前頁面反白對應按鈕
                $('#' + document.title).addClass("active")
                        .siblings().removeClass("active")

                //table         
                $('#table').DataTable({
                        "searching": true,  //搜尋功能, 預設是開啟
                        "columnDefs": [
                                { "orderable": false, "targets": [0, -1, -2, -3] }
                        ],
                        "order": [[1, 'desc']], //排序功能
                        "paging": true, //分頁功能, 預設是開啟                       
                        "lengthMenu": [10, 15,20], //改變筆數選單
                        "language": {
                                "processing": "處理中...",
                                "loadingRecords": "載入中...",
                                "lengthMenu": "顯示 _MENU_ 項結果",
                                "zeroRecords": "沒有符合的結果",
                                "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                                "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
                                "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                                "infoPostFix": "",
                                "search": "關鍵字搜尋:",
                                "paginate": {
                                        "first": "第一頁",
                                        "previous": "上一頁",
                                        "next": "下一頁",
                                        "last": "最後一頁"
                                }
                        }
                });
                $('.dataTables_length select').removeClass()
                        .css("margin-bottom", "20px"); //顯示頁數重排列     

                //點tr裡任一td，前面的input會直接便勾選(checkbox)
                $("#target").on("click", "tr", function(){
                        let checkBox = $(this).find(">td:first").children();
                        let isChecked = checkBox.attr("checked");
                        checkBox.attr("checked", !isChecked);
                });

                $("#tablereply").on("click", "tr", function(){
                        let checkBox = $(this).find(">td:first").children();
                        let isChecked = checkBox.attr("checked");
                        checkBox.attr("checked", !isChecked);
                });

        });
</script>