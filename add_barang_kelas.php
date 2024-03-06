<?php
    include 'config.php';

    if (!isset($_SESSION['login'])){
        header('Location: login.php');
        exit;
    }
    $id_kelas = isset($_GET['id']) ? $_GET['id'] : ' ';

    $check_data = "SELECT * FROM data_kelas WHERE id_kelas = :id_kelas";
    $check_data = $connect->prepare($check_data);
    $check_data->bindparam(':id_kelas' , $id_kelas);
    $check_data->execute();
    $fetch_data = $check_data->fetch(PDO::FETCH_ASSOC);

    $get_id_kelas = $fetch_data['id_kelas'];

    if($check_data->rowCount() > 0)
        $nama_kelas = $fetch_data['nama_kelas'];

    if (isset($_POST['add'])){
        $nama_barang = $_POST['nama_barang'];
        $kuantitas = $_POST['kuantitas'];

        if ($kuantitas <= 0){
            $_SESSION['alertCek'] = 'Jumlah barang tidak sesuai!';
        }
        else{
            $insert = $functions->add_barang('', $nama_barang, $kuantitas, $id_kelas);

            if ($insert){
                $_SESSION['alertSuccess'] = 'Barang berhasil ditambah!';
                // header('Location: add_barang_kelas.php?id='.$id_kelas.'&msg=berhasil');
                $count = $functions->hitung_barang_kelas($get_id_kelas);
    
                $update_kelas = "UPDATE data_kelas SET jumlah_barang = $count WHERE id_kelas = :get_id_kelas";
                $update_kelas = $connect->prepare($update_kelas);
                $update_kelas->bindparam(':get_id_kelas' , $get_id_kelas);
                $update_kelas->execute();
            }
            else{
                $msg= 'Data gagal ditambahkan!';
            }
        }
    }
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
        .form-add{
            border: 4px solid white; 
            background-color: #083B56; 
            padding: 35px;
            padding-top: 25px;
            
        }
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
<br>
<div class="container my-5">
    <?php if ($check_data->rowCount() <= 0): ?>
        <h1 class="text-center">Kelas <?=$nama_kelas;?></h1>
        <b>Data tidak ditemukan.</b>

    <?php else: ?>
        <div class="row">
            <div class="col-md-5 form-add"> 
                <form action="" method="POST">
                    <h1 class="text-center text-white">Kelas <?=$nama_kelas;?></h1>
                    <?php
                        if (isset($_SESSION['alertCek'])){
                            ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['alertCek']; ?></div>
                            <?php
                            unset($_SESSION['alertCek']);
                        }
                        
                        elseif (isset($_SESSION['alertSuccess'])){
                            ?>
                                <div class="alert alert-success"><?php echo $_SESSION['alertSuccess']; ?></div>
                            <?php
                            unset($_SESSION['alertSuccess']);
                        }
                    ?>
                        <label for="nama_barang"><h5 class="text-white">Nama Barang</h5></label>
                        <input type="text" class="form-control bg-dark text-white " name="nama_barang" placeholder="Nama Barang"required>

                        <label for="kuantitas"><h5 class="text-white">Kuantitas</h5></label>
                        <input type="number" class="form-control bg-dark text-white" name="kuantitas" placeholder="Jumlah" required>
                        <br>
                        <button class="btn btn-lg form-control text-white" style="background-color: #611D1D;" name="add">Add</button>
                </form>
            </div>
        </div>
        <br>
        <br>
        <div class = "row">
            <div class ="col-md-12">
                <?php if ($functions->cek_barang_kelas($id_kelas)->rowCount() <= 0): ?>
                    <h3 class="text-white" style="background-color: #5C0C0C; width: 31%; padding: 15px;">Tidak ada barang di kelas ini.</h3>

                <?php else: ?>
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