<?php
    include "config.php";

    if (!isset($_SESSION['login'])){
        header('Location: login.php');
        exit;
    }

    $msg = '';
    if(isset($_POST['add'])){
        $nama_kelas = $_POST['nama_kelas'];

        if($nama_kelas == ''){
            $_SESSION['alertEmpty'] = 'Nama kelas tidak boleh kosong!';
        }
        
        elseif($functions->cek_kelas($nama_kelas)){
            $_SESSION['alertCek'] = 'Kelas sudah ada!';
        }
        else{
            $insert = $functions->add_kelas('', $nama_kelas, 0);

            if($insert){
                $_SESSION['alertSuccess'] = 'Kelas berhasil ditambah!';
                // header('Location: admin_page.php');
            }
            else{
                $msg = 'Gagal menambahkan kelas!';
            }   
        }
    }

?>

<!-- HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Item administrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body{
            background-image: url("picture/kenny-eliason-zFSo6bnZJTw-unsplash.jpg");background-size:100%
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

        form {
        padding: 20px;
        border: 2px solid whitesmoke;
        background-color: #1d3b55;
        width: 400px;
        }

        label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 1.2em;
        }

        input[type=text], input[name=delete] {
        width: 100%;
        padding: 7px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        }

        input[type=text], input[name=submit] {
        width: 100%;
        padding: 7px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        }

        input[name=submit] {
        background-color: #444;
        color: #fff;
        font-weight: bold;
        font-size: 1.2em;
        padding: 8px;
        border-radius: 5px;
        }

        table, th, td {
            border: 2px solid;
        }

        th {
            background-color: #611D1D !important;
            border: 2px solid;
        }

        tr:nth-child(odd) {
            background-color: #1d3b55;
            border: 2px solid;
        }
        
        tr:nth-child(even) {
            background-color: #611D1D;
            border: 2px solid;
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
                        <a class="nav-link active" href="index.php">View Report</a>
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
            <div class="">
                <form action="" method="post">
                    <label for="nama_kelas"><h5 class="text-white fw-bold" style= "font-family: Georgia, serif;">Nama Kelas</h5></label>
                    <?php
                        if (isset($_SESSION['alertEmpty'])){
                            ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['alertEmpty']; ?></div>
                            <?php
                            unset($_SESSION['alertEmpty']);
                        }
                    ?>

                    <?php
                        if (isset($_SESSION['alertSuccess'])){
                            ?>
                                <div class="alert alert-success"><?php echo $_SESSION['alertSuccess']; ?></div>
                            <?php
                            unset($_SESSION['alertSuccess']);
                        }
                    ?>

                    <?php
                        if (isset($_SESSION['alertCek'])){
                            ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['alertCek']; ?></div>
                            <?php
                            unset($_SESSION['alertCek']);
                        }
                    ?>
                    <input type="text" class="form-control bg-dark text-white" name="nama_kelas" placeholder="Nama Kelas">
                    <button class="btn btn-lg form-control text-white" style="background-color: #611D1D;" name="add">Add</button>
                </form>
            </div>
           <br>
           <br>
            <h1 class="text-center text-white" 
                style= "font-family: Georgia, serif; background-color: #033E46; width: 250px; padding: 10px; margin-left: 530px; position: relative; border: 2px solid">Data Kelas
            </h1>
            <table class="table table-bordered text-white">
                <thead>
                    <tr class="text-center">
                        <th><b>ID Kelas</b></th>
                        <th><b>Nama Kelas</b></th>
                        <th><b>Jumlah Barang</b></th>
                        <th><b>Action</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM `data_kelas` ORDER BY id_kelas ASC";
                        $stmt = $connect->prepare($query);
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if($result)
                        {
                            foreach($result as $row){
                                ?>
                                <tr class="text-center">
                                    <td><?=$row['id_kelas'];?></td>
                                    <td><?=$row['nama_kelas'];?></td>
                                    <td><?=$row['jumlah_barang'];?></td>
                                    <td class="text-start" width = "27%">
                                        <a href="add_barang_kelas.php?id=<?=$row['id_kelas']?>" class="btn btn-warning text-center opacity-80">Tambah barang</a>
                                        <a href="edit_kelas.php?id=<?=$row['id_kelas']?>" class="btn btn-primary text-center opacity-80">Edit kelas</a>
                                        <a onclick="return confirm('Are you sure want to delete this record?');" 
                                        href="delete_kelas.php?id=<?=$row['id_kelas']?>" class="btn btn-danger text-center opacity-80">Delete</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        else{
                            ?>
                            <tr>
                                <td colspan = "5" class="text-center">Tidak ada data kelas.</td>
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