<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    header('Content-Type: application/json');

    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $select_data = $functions->detail_barang_kelas($search);

    $fetch_data = [];
    if ($select_data->rowCount() > 0)
    {
        while($row = $select_data->fetch())
        {
            $fetch_data[] = [
                'id_barang' => $row['id_barang'],
                'nama_barang' => $row['nama_barang'],
                'kuantitas' => $row['kuantitas']
            ];
        }
    }

    echo json_encode($fetch_data);
}

?>