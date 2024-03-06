<?php
    include 'config.php';

    if (!isset($_SESSION['login'])){
        header('Location: login.php');
        exit;
    }
    $id_kelas = isset($_GET['id']) ? $_GET['id'] : ' ';
    $result = $functions->delete_kelas($id_kelas);
    header ('Location: admin_page.php');
?>