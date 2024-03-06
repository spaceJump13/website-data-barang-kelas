<?php
    include 'config.php';

    if (!isset($_SESSION['login'])){
        header('Location: login.php');
        exit;
    }
    $id_kelas = isset($_GET['id']) ? $_GET['id'] : ' ';

    $check_data = "SELECT * FROM `data_kelas` WHERE id_kelas = ?";
    $check_data = $connect->prepare($check_data);
    $check_data->execute([ $id_kelas ]);
    $fetch_data = $check_data->fetch(PDO::FETCH_ASSOC);

    // $check_data = "SELECT * FROM data_kelas WHERE id_kelas = :id_kelas";
    // $check_data = $connect->prepare($check_data);
    // $check_data->bindparam(':id_kelas' , $id_kelas);
    // $check_data->execute();
    // $fetch_data = $check_data->fetch(PDO::FETCH_ASSOC);

    $nama_kelas = $fetch_data['nama_kelas'];
    
?>
<!-- HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Item administrasi</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <style>
        body{
            background-image: url("feliphe-schiarolli-hes6nUC1MVc-unsplash.jpg");background-size:100%
        }
        .nav-link{
            position: relative;
            text-transform: uppercase;
            border-radius: 10px;
            border: none;
            font-size: 17px;
            font-weight: 600;
        }
        .nav-link:hover{
            background-color: #820808;
            border: 2px solid white;

        }
    </style>
</style>

</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Administrasi Kelas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_page.php">Kelas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="container">
    <div class="content-web my-5">
        <div class="col-md-4">
            <h2 class="text-center text-dark fw-bold" style= "font-family: Georgia, serif; background-color: #DAB32E">Data Barang Kelas <?=$nama_kelas;?></h2>
        </div>
            <table class="table table-dark table-bordered">
                <thead>
                    <tr class="text-center">
                        <th><b>ID Barang</b></th>
                        <th><b>Nama Barang</b></th>
                        <th><b>Kuantitas</b></th>
                        <th><b>Action</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM `data_barang` WHERE id_kelas = :id_kelas";
                        $stmt = $connect->prepare($query);
                        $stmt->bindparam(':id_kelas' , $id_kelas);
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if($result)
                        {
                            foreach($result as $row){
                                ?>
                                <tr class="text-center">
                                    <td><?=$row['id_barang'];?></td>
                                    <td><?=$row['nama_barang'];?></td>
                                    <td><?=$row['kuantitas'];?></td>
                                    <td class="text-start">
                                        <a href="edit_barang_kelas.php?id_barang=<?=$row['id_barang']?>" class="btn btn-primary text-center">Edit Barang</a>
                                        <a onclick="return confirm('Are you sure want to delete this record?');" 
                                        href="delete_barang_kelas.php?id_barang=<?=$row['id_barang']?>" class="btn btn-danger text-center">Delete</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        else{
                            ?>
                            <tr>
                                <td colspan = "5" class="text-center">Tidak ada barang dalam kelas ini.</td>
                            </tr>
                            <?php
                        }
                    ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>