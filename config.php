<?php
session_start();
    try
    {
    $connect = new PDO('mysql:host=localhost;dbname=db_proyek', 'root', '');
    $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    }
    catch (PDOException $e){
        die ('Tidak dapat terhubung ke database');
    }

    require_once 'functions.php';
    $functions = new functions($connect);

    $check_data = "SELECT * FROM data_admin";
    $check_data = $connect->prepare($check_data);
    $check_data->execute();
    $fetch_data = $check_data->fetch(PDO::FETCH_ASSOC);
?>