<?php
    include 'config.php';
?>

<!DOCTYPE html>
<HTML>
<head>
    <title>Viewreport</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<style>
    body{
    background-image: url("feliphe-schiarolli-hes6nUC1MVc-unsplash.jpg");background-size:100%
    }

    .card {
        width: 220px;
        height: 220px;
        border-radius: 20px;    
    }

    .card-header {
        color: #fff;
    }

    .card .job {
    font-size: 100px;
    font-weight: 500;
    color: white;
    display: block;
    text-align: left;
    padding-top: 3px;
    font-size: 16px;
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
                            <a class="nav-link active" href="admin_page.php">Administrasi Kelas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="login.php">Login Admin</a>
                        </li>
                    </ul>
                </div>
            <?php endif ?>
        </div>
    </nav>
    
    <?php
        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "db_proyek";

        // Connect to database
        $connection = mysqli_connect($db_host, $db_username, $db_password, $db_name);

        
        $sql = "SELECT * FROM data_kelas";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<br>
            <div class='container container-custom mt-5' style='margin-left: 12em;'>
                <div class='row' id='result'>";
            while($row = mysqli_fetch_assoc($result)) {
                $warna = '';
                $randomNumber = rand(1,5);
                if ($randomNumber == 1){
                    $warna = 'success';
                }
                elseif($randomNumber == 2){
                    $warna = 'danger';
                }
                elseif($randomNumber == 3){
                    $warna = 'warning';
                }
                elseif($randomNumber == 4){
                    $warna = 'info';
                }
                else{
                    $warna = 'primary';
                }
                echo " <div class='col-md-2 my-3 mx-3'>
                            <div class='card bg-".$warna."' id='" . $row["id_kelas"]. "'>
                                <div class='card-header text-center fw-bold'>Kelas ". $row["nama_kelas"]. "</div>
                                <div class='card-body'>
                                    <p class='job'> Banyak barang dalam kelas : " . $row["jumlah_barang"]. "</p>
                                </div>
                                <div class='card-footer'>
                                    <a href='afterindex_page.php?id=". $row["id_kelas"] . "' class='btn btn-dark btn-sm '>Lihat Detail</a>
                                </div>
                            </div>
                        </div> ";
            }
            echo "</div></div>";
        } 
        else {
            echo " <div class='container'>
                        <div class='content-web my-5'>
                            <div <div class='col-md-10'>
                                <h1 class='text-white' style='background-color: #5C0C0C; width: 43%; padding: 15px;'>Tidak ada data barang.</h1>
                            </div>
                        </div>
                    </div>";
            
        }
        mysqli_close($connection);
    ?>
</body>
</html>