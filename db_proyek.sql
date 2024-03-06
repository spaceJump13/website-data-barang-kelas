-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Des 2022 pada 11.05
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_proyek`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_admin`
--

CREATE TABLE IF NOT EXISTS `data_admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(20) NOT NULL,
  PRIMARY KEY(`id_admin`)
)  Engine=InnoDB CHARSET=utf8mb4 AUTO_INCREMENT=1;

--
-- Dumping data untuk tabel `data_admin`
--

INSERT INTO `data_admin` VALUES ('', 'sad123', '1234', 'Kevin Sadino');
INSERT INTO `data_admin` VALUES ('', 'bos123', 'boss', 'Bos Gue');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_barang`
--

CREATE TABLE IF NOT EXISTS `data_barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(30) NOT NULL,
  `kuantitas` int(20) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  PRIMARY KEY(`id_barang`)
   FOREIGN KEY (`id_kelas`)
        REFERENCES `data_kelas` (`id_kelas`)
            ON DELETE CASCADE
) Engine=InnoDB CHARSET=utf8mb4 AUTO_INCREMENT=1;

--
-- Dumping data untuk tabel `data_barang`
--

INSERT INTO `data_barang` VALUES ('', 'Meja', 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_kelas`
--

CREATE TABLE IF NOT EXISTS `data_kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(30) NOT NULL,
  `jumlah_barang` int(255) NOT NULL,
  PRIMARY KEY(`id_kelas`)
) Engine=InnoDB CHARSET=utf8mb4 AUTO_INCREMENT=1;

--
-- Dumping data untuk tabel `data_kelas`
--

INSERT INTO `data_kelas` VALUES ('', 'A1', 0);
