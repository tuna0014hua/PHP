<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"> -->
<link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">


<link rel="stylesheet" href="../../fontawesome/css/all.min.css">

<style>
    :root {
        --main-text-color: #ffffff;
        --main-color: #0B3D5F;
        --second-color: #257FBB;
    }

    /*==========共用區==========*/
    .cover-fit {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-picture {
        width: 200px;
    }

    /*==========header==========*/
    .main_header {
        width: 100%;
        height: 65px;
        background: var(--main-color);
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .logo h3,
    .txt h4 {
        margin-bottom: 0;
    }

    .logo i {
        margin-right: 10px;
    }

    .header_txt {
        color: var(--main-text-color);
    }

    .txt {
        width: calc(100% - 240px);
    }


    /*==========left==========*/
    .left {
        width: 57px;
        height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
        background: var(--second-color);
        position: fixed;
        transition: all 0.5s;
    }

    .left:hover {
        width: 200px;
    }

    .left:hover ul li {
        opacity: 1;
    }

    .left ul {
        padding-left: 0;
    }

    .left ul a {
        text-decoration: none;
        color: var(--main-text-color);
        font-size: 18px;
        border-bottom: 5px solid var(--main-text-color);
        text-align: center;
        display: flex;
        padding: 19px 10px;
        width: 200px;
    }

    .left a i {
        width: 50px;
        text-align: center;
        padding: 5px 15px 0 0;
        /* transition: all 1s; */
    }

    .left ul a:hover,
    .left li.active a {
        background: var(--main-text-color);
        border-bottom-color: var(--main-color);
        color: var(--main-color);
    }

    .left .logout {
        font-size: 18px;
        color: var(--main-text-color);
        text-decoration: none;
        transition: .4s;
        display: flex;
        padding: 15px 10px;
        width: 200px;
        transform: translate(0px, 50px);
    }

    .left .logout:hover {
        color: #FAFF00;
    }

    /*==========right==========*/
    .right {
        transition: all 0.5s;
        margin-left: 57px;
        margin-bottom: 3%;
    }

    .left:hover+.right {
        margin-left: 200px;
    }

    .card {
        width: 100%;
    }

    /*----------table-----------*/
    table.dataTable {
        border-collapse: collapse !important;
    }

    table.dataTable tbody td {
        vertical-align: middle;
    }
    
    .search i {
        position: absolute;
        left: 25px;
        top: 15px;
    }

    .searchInput {
        width: 50%;
        font-size: 14px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        transition: width .4s ease-in-out;
    }

    input[type=text]:focus {
        width: 100%;
    }

    .table {
        padding: 150px;
    }

    .table tr:hover {
        background: rgba(186, 186, 186, .4);
    }

    .thead {
        background: #BABABA;
    }

    .tdBTnEye .btn {
        color: #0dcaf0;
    }

    .tdBTnEye .btn:hover {
        background: #0dcaf0;
        color: #ffffff;
    }

    .tdBTnEdit .btn {
        color: #0d6efd;
    }

    .tdBTnEdit .btn:hover {
        background: #0d6efd;
        color: #ffffff;
    }

    .tdBTnDetele .btn {
        color: #dc3545;
    }

    .tdBTnDetele .btn:hover {
        background: #dc3545;
        color: #ffffff;
    }

    .pagination {
        justify-content: flex-end;
    }

    textarea {
        height: 150px;
        resize: none;
    }

   
</style>