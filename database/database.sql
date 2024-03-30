-- phpMyAdmin SQL Dump

-- version 5.2.0

-- https://www.phpmyadmin.net/

--

-- Host: 127.0.0.1

-- Generation Time: Jul 23, 2023 at 10:54 PM

-- Server version: 10.4.27-MariaDB

-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */

;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */

;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */

;

/*!40101 SET NAMES utf8mb4 */

;

--

-- Database: `fuzzy-interference`

CREATE DATABASE IF NOT EXISTS `fuzzy-interference`;

USE `fuzzy-interference` ;

--

-- --------------------------------------------------------


-- Dumping data for table `iso`


CREATE
OR
REPLACE
TABLE
    `gayabelajar` (
        `id` int(11) NOT NULL,
        `kriteria` varchar(255) NULL,
        `sub-kriteria` varchar(255) NULL,
        `skor` int(255) NOT NULL,
        `kode` varchar(255) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--

-- Dumping data for table `iso`

--

INSERT INTO
    `gayabelajar` (
        `id`,
        `kriteria`,
        `sub-kriteria`,
        `skor`,
        `kode`
    )
VALUES (
        1,
        'Visual',
        NULL,
        30,
        'V'
    ), (
        2,
        'Auditori',
        NULL,
        35,
        'A'
    ), (
        3,
        'Kinestetik',
        NULL,
        30,
        'K'

    );

-- --------------------------------------------------------

--

-- Table structure for table `kuisioner`

--

CREATE
OR
REPLACE
TABLE
    `kuisioner` (
        `id` int(11) NOT NULL,
        `nama` varchar(255) NOT NULL,
        `jenjang_sekolah` varchar(255) NOT NULL,
        `V_1` int(11) NOT NULL,
        `V_2` int(11) NOT NULL,
        `V_3` int(11) NOT NULL,
        `V_4` int(11) NOT NULL,
        `V_5` int(11) NOT NULL,
        `V_6` int(11) NOT NULL,
        `V_7` int(11) NOT NULL,
        `V_8` int(11) NOT NULL,
        `V_9` int(11) NOT NULL,
        `V_10` int(11) NOT NULL,
        `V_11` int(11) NOT NULL,
        `V_12` int(11) NOT NULL,
        `A_1` int(11) NOT NULL,
        `A_2` int(11) NOT NULL,
        `A_3` int(11) NOT NULL,
        `A_4` int(11) NOT NULL,
        `A_5` int(11) NOT NULL,
        `A_6` int(11) NOT NULL,
        `A_7` int(11) NOT NULL,
        `A_8` int(11) NOT NULL,
        `A_9` int(11) NOT NULL,
        `A_10` int(11) NOT NULL,
        `A_11` int(11) NOT NULL,
        `A_12` int(11) NOT NULL,
        `K_1` int(11) NOT NULL,
        `K_2` int(11) NOT NULL,
        `K_3` int(11) NOT NULL,
        `K_4` int(11) NOT NULL,
        `K_5` int(11) NOT NULL,
        `K_6` int(11) NOT NULL,
        `K_7` int(11) NOT NULL,
        `K_8` int(11) NOT NULL,
        `K_9` int(11) NOT NULL,
        `K_10` int(11) NOT NULL,
        `K_11` int(11) NOT NULL,
        `K_12` int(11) NOT NULL,
        `V` int(11) NOT NULL,
        `A` int(11) NOT NULL,
        `K` int(11) NOT NULL,
        `HASIL_V` int(11) NOT NULL,
        `HASIL_A` int(11) NOT NULL,
        `HASIL_K` int(11) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------

--

-- Table structure for table `pertanyaan`

--

CREATE
OR
REPLACE
TABLE
    `pertanyaan` (
        `kode` varchar(11) NOT NULL,
        `pertanyaan` text NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--

-- Dumping data for table `pertanyaan`

--

INSERT INTO
    `pertanyaan` (`kode`, `pertanyaan`)
VALUES (
        'V_1',
        'Jika saya mengerjakan sesuatu, saya selalu membaca instruksinya terlebih dahulu.'
    ), (
        'V_2',
        'Saya lebih suka membaca daripada mendengarkan ceramah.'
    ), (
        'V_3',
        'Saya selalu dapat menunjukkan arah Utara dan Selatan dimanapun saya berada.'
    ), (
        'V_4',
        'Saya suka menulis surat atau buku harian.'
    ), (
        'V_5',
        'Ketika mendengar orang lain berbicara, saya biasanya membuat gambaran dalam pikiran saya dari apa yang mereka katakan.'
    ), (
        'V_6',
        'Saat melihat objek dalam bentuk gambar, saya dengan mudah dapat mengenali objek yang sama meskipun posisi objek itu diputar atau diubah.'
    ), (
        'V_7',
        'Saat mengingat suatu pengalaman, saya seringkali melihat pengalaman itu dalam bentuk gambar dipikiran saya.'
    ), (
        'V_8',
        'Saya sering mencoret – coret kertas saat berbicara di telepon atau dalam suatu pertemuan.'
    ), (
        'V_9',
        'Saya lebih suka membacakan cerita daripada mendengarkan cerita.'
    ), (
        'V_10',
        'Saya dapat dengan cepat melakukan penjumlahan dan perkalian dalam pikiran saya.'
    ), (
        'V_11',
        'Saya suka mengeja dan saya pikir saya pintar mengeja kata – kata.'
    ), (
        'V_12',
        'Saya suka mencatat perintah atau instruksi yang disampaikan kepada saya.'
    ), (
        'A_1',
        'Saya lebih suka mendengarkan informasi yang ada di kaset daripada membaca buku.'
    ), (
        'A_2',
        'Disaat saya sendiri, saya biasanya memainkan musik atau lagu atau nyanyian.'
    ), (
        'A_3',
        'Saat saya berbicara, saya suka mengatakan, “saya mendengar Anda, itu terdengar bagus”.'
    ), (
        'A_4',
        'Saya tahu hampir semua kata – kata dari lagu yang saya dengar.'
    ), (
        'A_5',
        'Mudah sekali bagi saya untuk mengobrol dalam waktu yang lama dengan teman saya saat berbicara di telepon.'
    ), (
        'A_6',
        'Tanpa musik hidup amat membosankan.'
    ), (
        'A_7',
        'Saya sangat senang berkumpul, biasanya dapat dengan mudah berbicara dengan siapa saja.'
    ), (
        'A_8',
        'Saat mengingat suatu pengalaman, saya seringkali mendengar suara dan berbicara pada diri saya mengenai pengalaman itu.'
    ), (
        'A_9',
        'Saya lebih suka seni musik daripada seni lukis.'
    ), (
        'A_10',
        'Saya lebih suka berbicara daripada menulis.'
    ), (
        'A_11',
        'Saya akan sangat terganggu apabila ada orang berbicara pada saat saya sedang menonton televisi.'
    ), (
        'A_12',
        'Saya dapat mengingat dengan mudah apa yang dikatakan orang.'
    ), (
        'K_1',
        'Saya lebih suka berolahraga daripada membaca buku.'
    ), (
        'K_2',
        'Ruangan belajar, meja belajar, kamar tidur atau rumah saya biasanya berantakan atau tidak teratur.'
    ), (
        'K_3',
        'Saya suka merancang, mengerjakan dan membuat sesuatu dengan kedua tangan saya.'
    ), (
        'K_4',
        'Saya suka olahraga dan saya rasa saya adalah olahragawan yang baik.'
    ), (
        'K_5',
        'Saya biasanya mengatakan, “saya rasa, saya perlu menemukan pijakan atas hal ini, atau saya ingin bisa menangani hal ini”.'
    ), (
        'K_6',
        'Saat mengingat suatu pengalaman, saya seringkali ingat bagaimana perasaan saya terhadap pengalaman itu.'
    ), (
        'K_7',
        'Saya lebih suka melakukan contoh peragaan daripada membuat laporan tertulis tentang suatu kejadian.'
    ), (
        'K_8',
        'Saya biasanya berbicara dengan perlahan.'
    ), (
        'K_9',
        'Tulisan tangan saya biasanya tidak rapi.'
    ), (
        'K_10',
        'Saya biasanya menggunakan jari saya untuk menunjuk kalimat yang saya baca.'
    ), (
        'K_11',
        'Saya paling mudah belajar sambil mempraktikkan atau melakukan.'
    ), (
        'K_12',
        'Sangat sulit bagi saya untuk duduk diam'
    );


-- --------------------------------------------------------

-- Indexes for dumped tables

--

--

-- Indexes for table `iso`

--

ALTER TABLE `gayabelajar` ADD PRIMARY KEY (`id`);

--

-- Indexes for table `kuisioner`

--

ALTER TABLE `kuisioner` ADD PRIMARY KEY (`id`);

--

-- Indexes for table `pertanyaan`

--

ALTER TABLE `pertanyaan` ADD PRIMARY KEY (`kode`);

--

-- AUTO_INCREMENT for dumped tables

--

--

-- AUTO_INCREMENT for table `iso`

--

ALTER TABLE
    `gayabelajar` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 17;

--

-- AUTO_INCREMENT for table `kuisioner`

--

ALTER TABLE
    `kuisioner` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */

;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */

;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */

;