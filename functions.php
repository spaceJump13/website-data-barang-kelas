<?php
    class functions{
        public $db;

        public function __construct($db = '')
        {
            $this->setConnect($db);
        }
    
        public function setConnect($db)
        {
            $this->db = $db;
        }

        public function cek_barang_kelas($id){
            $sql = "SELECT * FROM `data_barang` WHERE id_kelas = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindparam(':id', $id);
            $sql->execute();
            
            return $sql; 
        }

        public function add_barang($col, $col2, $col3, $col4){
            $sql = "INSERT INTO `data_barang` VALUES (:col, :col2, :col3, :col4)";
            $sql = $this->db->prepare($sql);
            $sql->bindparam(':col', $col);
            $sql->bindparam(':col2', $col2);
            $sql->bindparam(':col3', $col3);
            $sql->bindparam(':col4', $col4);
            $sql->execute();

            return $sql;
        }

        public function add_kelas($col, $col2, $col3){
            $sql = "INSERT INTO `data_kelas` VALUES (:col, :col2, :col3)";
            $sql = $this->db->prepare($sql);
            $sql->bindparam(':col', $col);
            $sql->bindparam(':col2', $col2);
            $sql->bindparam(':col3', $col3);
            $sql->execute();

            return $sql;
        }

        public function cek_kelas ($nama_kelas){
            $sql = "SELECT * FROM `data_kelas` WHERE nama_kelas = :nama_kelas";
            $sql = $this->db->prepare($sql);
            $sql->bindparam(':nama_kelas', $nama_kelas);
            $sql->execute();
            
            return $sql ->rowCount() > 0;
        }

        public function hitung_barang_kelas ($id){
            $count = "SELECT SUM(kuantitas) as total FROM data_barang WHERE id_kelas = :id";
            $count = $this->db->prepare($count);
            $count->bindparam(':id', $id);
            $count->execute();

            $result = $count->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        }

        public function delete_kelas($id){
            $sql = "DELETE FROM `data_kelas` WHERE id_kelas = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindparam(':id', $id);
            $sql->execute();

            return $sql;
        }

        public function delete_barang($id){
            $sql = "DELETE FROM `data_barang` WHERE id_barang = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindparam(':id', $id);
            $sql->execute();

            return $sql;
        }

        public function detail_barang_kelas($cari){
            if (empty($cari)){
                $sql = "SELECT * FROM `data_barang`";
            }
            else{
                $sql = "SELECT * FROM `data_barang` WHERE id_kelas = ?";
            }
            $sql = $this->db->prepare($sql);

            if (empty($cari)){
                $sql->execute();
            }
            else{
                $sql->execute([$cari]);
            }
            return $sql;
        }

        public function update_barang_kelas($id, $nama_barang, $kuantitas){
            $sql = "UPDATE `data_barang` SET nama_barang = :nama_barang, kuantitas = :kuantitas WHERE id_barang = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindparam(':id', $id);
            $sql->bindparam(':nama_barang', $nama_barang);
            $sql->bindparam(':kuantitas', $kuantitas);
            $sql->execute();

            return $sql;
        }

    }
?>