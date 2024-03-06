<?php
session_start();

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "db_proyek";

// Connect to database
$connection = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if(isset($_POST['submit'])) {
 $item_name = $_POST['kelas_name'];
 
 // insert into database
 $sql = "INSERT INTO data_kelas (nama_kelas) VALUES ('$item_name')";
 $result = mysqli_query($connection, $sql);
 
 if($result) {
  echo "Item added successfully";
  header("Location: admin_page.php");
 }
 else {
  echo "Error adding item";
 }
}

if(isset($_POST['submitt'])) {
    $item_name = $_POST['item_name'];
    $item_value = $_POST['item_value'];
    
    // insert into database
    $sql2 = "INSERT INTO data_barang (nama_barang, kuantitas) VALUES ('$item_name', '$item_value')";
    $result = mysqli_query($connection, $sql2);
    
    if($result) {
     echo "Item added successfully";
     header("Location: add_item_page.php");
    }
    else {
     echo "Error adding item";
    }
   }

?>