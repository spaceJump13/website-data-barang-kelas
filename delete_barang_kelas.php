<?php
    include 'config.php';

    if (!isset($_SESSION['login'])){
        header('Location: login.php');
        exit;
    }
    $id_barang = isset($_GET['id_barang']) ? $_GET['id_barang'] : ' ';

    $check_data = "SELECT * FROM data_barang WHERE id_barang = :id_barang";
    $check_data = $connect->prepare($check_data);
    $check_data->bindparam(':id_barang' , $id_barang);
    $check_data->execute();
    $fetch_data = $check_data->fetch(PDO::FETCH_ASSOC);
    $get_id_kelas = $fetch_data['id_kelas'];

    $result = $functions->delete_barang($id_barang);

    if($result){
        $count = $functions->hitung_barang_kelas($get_id_kelas); // return jumlah barang di kelas setelah delete

        $update_kelas = "UPDATE data_kelas SET jumlah_barang = $count WHERE id_kelas = :get_id_kelas";
        $update_kelas = $connect->prepare($update_kelas);
        $update_kelas->bindparam(':get_id_kelas' , $get_id_kelas);
        $update_kelas->execute();
        header ('Location: admin_page.php');
    }
    else{
        echo 'Data gagal dihapus';
    }

?>