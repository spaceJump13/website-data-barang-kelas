<?php
    include 'config.php';
    if (!isset($_SESSION['login'])){
        header('Location: login.php');
        exit;
    }
    $id_barang = isset($_GET['id_barang']) ? $_GET['id_barang'] : ' ';

    $check_data = "SELECT * FROM `data_barang` WHERE id_barang = ?";
    $check_data = $connect->prepare($check_data);
    $check_data->execute([ $id_barang ]);
    $fetch_data = $check_data->fetch(PDO::FETCH_ASSOC);

    $get_id_kelas = $fetch_data['id_kelas'];

    if(isset($_POST['edit'])){
        $nama_barang = $_POST['nama_barang'];
        $kuantitas = $_POST['kuantitas'];

        if ($kuantitas <= 0){
            $_SESSION['alertCek'] = 'Jumlah barang tidak sesuai!';
        }
        else{
            $update = $functions->update_barang_kelas($id_barang, $nama_barang, $kuantitas);

            if ($update){
                $count = $functions->hitung_barang_kelas($get_id_kelas);

                $update_kelas = "UPDATE data_kelas SET jumlah_barang = $count WHERE id_kelas = :get_id_kelas";
                $update_kelas = $connect->prepare($update_kelas);
                $update_kelas->bindparam(':get_id_kelas' , $get_id_kelas);
                $update_kelas->execute();
                header ('Location: admin_page.php');
            }
            else{
                echo 'Data gagal dihapus';
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang Kelas</title>
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
    </style>
</head>
<body>
<div class="container my-5">
    <div class="content-web my-5">
    <div class="row">
        <div class="col-sm-6">
            <div class="card bg-dark" style="border: 4px dashed orange">
                <div class="card-body">
                    <h1 class="card-title text-white">Update Barang</h1>
                    <div class="text-white">
                        <b>ID Barang</b>: <?=$fetch_data['id_barang']?><br/>
                        <b>Nama Barang</b>: <?=$fetch_data['nama_barang']?><br/>
                        <b>Kuantitas</b>: <?=$fetch_data['kuantitas']?><br/>
                        <b>ID Kelas</b>: <?=$fetch_data['id_kelas']?><br/><br/>
                        <?php
                            if (isset($_SESSION['alertCek'])){
                                ?>
                                    <div class="alert alert-danger"><?php echo $_SESSION['alertCek']; ?></div>
                                <?php
                                unset($_SESSION['alertCek']);
                            }
                        ?>
                        <form action="" method="POST">
                            <label for="nama_barang"><h5>Nama Barang</h5></label>
                            <input type="text" class="form-control" name="nama_barang" value="<?=$fetch_data['nama_barang'];?>"placeholder="Nama Barang"required>

                            <label for="kuantitas"><h5>Kuantitas</h5></label>
                            <input type="number" class="form-control" name="kuantitas" value="<?=$fetch_data['kuantitas'];?>" placeholder="Jumlah" required>
                            <br>
                            <button class="btn btn-warning btn-lg form-control" name="edit">Edit</button>
                        </form>
                    </div>
                    <br>
                    <a href="admin_page.php" class="btn btn-danger">&laquo; Batalkan</a>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</div>
</body>
</html>