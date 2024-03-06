<?php
    include 'config.php';

    $id_kelas = isset($_GET['id']) ? $_GET['id'] : ' ';

    $check_data = "SELECT * FROM data_kelas WHERE id_kelas = :id_kelas";
    $check_data = $connect->prepare($check_data);
    $check_data->bindparam(':id_kelas' , $id_kelas);
    $check_data->execute();
    $fetch_data = $check_data->fetch(PDO::FETCH_ASSOC);

    $get_nama_kelas = $fetch_data['nama_kelas'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Latest compiled and minified CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <title>edit_kelas</title>

    <style>
        body{
            background-image: url("changbok-ko-F8t2VGnI47I-unsplash.jpg");background-size:100%
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
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Viewreport</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if (!empty($_SESSION['login'])): ?>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Back</a>
                    </li>
                </ul>
            </div>
        <?php else: ?>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Back</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">Login Admin</a>
                    </li>
                </ul>
            </div>
        <?php endif ?>
    </div>
</nav>
<br>
<div class="container my-5">
    <?php if ($check_data->rowCount() <= 0): ?>
        <h1 class="text-center">Kelas <?=$nama_kelas;?></h1>
        <b>Data tidak ditemukan.</b>

    <?php else: ?>
        <div class = "row">
            <div class ="col-md-12">

                <?php if ($functions->cek_barang_kelas($id_kelas)->rowCount() <= 0): ?>
                    <h1 class="text-white" style="background-color: #5C0C0C; width: 43%; padding: 15px;">Tidak ada barang di kelas ini.</h1>

                <?php else: ?>
                    <h1 class="text-center text-white"><u>Data Barang Kelas <?=$get_nama_kelas;?></u></h1>
                    <table class="table table-dark table-bordered">
                        <thead>
                            <tr>
                                <th><b>ID Barang</b></th>
                                <th><b>Nama Barang</b></th>
                                <th><b>Kuantitas</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `data_barang` WHERE id_kelas = :id_kelas";
                            $sql = $connect->prepare($sql);
                            $sql->bindparam(':id_kelas', $id_kelas);
                            $sql->execute();
                            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row){
                                ?>
                                <tr>
                                    <td><?=$row['id_barang'];?></td>
                                    <td><?=$row['nama_barang'];?></td>
                                    <td><?=$row['kuantitas'];?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php endif ?>
            </div>
        </div>
    <?php endif ?>
</div>
</body>
</html>