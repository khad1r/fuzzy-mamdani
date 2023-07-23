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

--

-- Table structure for table `fuzzy`

--

CREATE
OR
REPLACE
TABLE
    `fuzzy` (
        `maturity` varchar(255) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------

--

-- Table structure for table `iso`

--

CREATE
OR
REPLACE
TABLE
    `iso` (
        `id` int(11) NOT NULL,
        `kriteria` varchar(255) NOT NULL,
        `sub-kriteria` varchar(255) DEFAULT NULL,
        `deskripsi` text NOT NULL,
        `skor` int(255) NOT NULL,
        `kode` varchar(255) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--

-- Dumping data for table `iso`

--

INSERT INTO
    `iso` (
        `id`,
        `kriteria`,
        `sub-kriteria`,
        `deskripsi`,
        `skor`,
        `kode`
    )
VALUES (
        1,
        'Functional Suitability',
        'Functional Completeness',
        'Sejauh mana rangkaian fungsi mencakup semua tugas dan tujuan pengguna yang ditentukan.',
        30,
        'FS_1'
    ), (
        2,
        'Functional Suitability',
        'Functional correctness',
        'Sejauh mana sistem memberikan hasil yang benar dengan tingkat presisi yang dibutuhkan.',
        35,
        'FS_2'
    ), (
        3,
        'Functional Suitability',
        'Functional Appropriateness',
        'Sejauh mana fungsi memfasilitasi\r\npencapaian tugas dan tujuan tertentu.',
        35,
        'FS_3'
    ), (
        4,
        'Reliability',
        'Maturity',
        'Sejauh mana sistem, produk, atau komponen\r\nmemenuhi kebutuhan keandalan dalam\r\noperasi normal.',
        25,
        'R_1'
    ), (
        5,
        'Reliability',
        'Availability',
        'Sejauh mana sistem, produk, atau komponen\r\nberoperasi dan dapat diakses saat diperlukan\r\nuntuk digunakan.\r\n',
        28,
        'R_2'
    ), (
        6,
        'Reliability',
        'Fault Tolerance ',
        'Sejauh mana sistem, produk, atau komponen\r\nberoperasi sebagaimana dimaksud meskipun\r\nada kesalahan perangkat keras atau\r\nperangkat lunak.\r\n',
        22,
        'R_3'
    ), (
        7,
        'Reliability',
        'Recoverability',
        'Sejauh mana rangkaian fungsi mencakup semua tugas dan tujuan pengguna yang ditentukan.',
        25,
        'R_4'
    ), (
        8,
        'Usability',
        'Appropriateness recognizability ',
        'Sejauh mana pengguna dapat mengenali\r\napakah suatu produk atau sistem sesuai\r\nuntuk kebutuhan mereka.',
        19,
        'U_1'
    ), (
        9,
        'Usability',
        'Learnbility',
        'Sejauh mana produk atau sistem dapat\r\ndigunakan oleh pengguna tertentu untuk\r\nmencapai tujuan tertentu pembelajaran\r\nmenggunakan produk atau sistem dengan\r\nefektivitas, efisiensi, kebebasan dari risiko\r\ndan kepuasan dalam konteks penggunaan\r\ntertentu.\r\n',
        15,
        'U_2'
    ), (
        10,
        'Usability',
        'Operability',
        'Sejauh mana produk atau sistem memiliki\r\natribut yang membuatnya mudah\r\ndioperasikan dan dikendalikan.',
        20,
        'U_3'
    ), (
        11,
        'Usability',
        'User Interface Aesthetics',
        'Sejauh mana antarmuka pengguna\r\nmemungkinkan interaksi yang\r\nmenyenangkan dan memuaskan bagi\r\npengguna.',
        16,
        'U_4'
    ), (
        12,
        'Usability',
        'User Error Protection',
        'Sejauh mana sistem melindungi pengguna\r\ndari membuat kesalahan.',
        15,
        'U_5'
    ), (
        13,
        'Usability',
        'Accessbility',
        'Sejauh mana produk atau sistem dapat\r\ndigunakan oleh orang-orang dengan berbagai\r\nkarakteristik dan kemampuan untuk\r\nmencapai tujuan tertentu dalam konteks\r\npenggunaan tertentu.',
        15,
        'U_6'
    ), (
        14,
        'Functional Suitability',
        NULL,
        ' Sejauh mana produk atau sistem\r\nmenyediakan fungsi yang memenuhi kebutuhan yang dinyatakan\r\ndan tersirat ketika digunakan dalam kondisi tertentu.',
        100,
        'FS'
    ), (
        15,
        'Reliability',
        NULL,
        'Sejauh mana suatu sistem, produk atau\r\nkomponen melakukan fungsi tertentu dalam kondisi tertentu\r\nuntuk jangka waktu tertentu.',
        100,
        'R'
    ), (
        16,
        'Usability',
        NULL,
        'Sejauh mana produk atau sistem dapat\r\ndigunakan oleh pengguna tertentu untuk mencapai tujuan\r\ntertentu dengan efektivitas, efisiensi dan kepuasan dalam\r\nkonteks penggunaan tertentu.',
        100,
        'U'
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
        `email` varchar(255) NOT NULL,
        `nama` varchar(255) NOT NULL,
        `program_studi` varchar(255) NOT NULL,
        `FS_1_1` int(11) NOT NULL,
        `FS_1_2` int(11) NOT NULL,
        `FS_1_3` int(11) NOT NULL,
        `FS_1_4` int(11) NOT NULL,
        `FS_1_5` int(11) NOT NULL,
        `FS_2_1` int(11) NOT NULL,
        `FS_2_2` int(11) NOT NULL,
        `FS_2_3` int(11) NOT NULL,
        `FS_2_4` int(11) NOT NULL,
        `FS_3_1` int(11) NOT NULL,
        `FS_3_2` int(11) NOT NULL,
        `FS_3_3` int(11) NOT NULL,
        `FS_3_4` int(11) NOT NULL,
        `FS_3_5` int(11) NOT NULL,
        `R_1_1` int(11) NOT NULL,
        `R_1_2` int(11) NOT NULL,
        `R_1_3` int(11) NOT NULL,
        `R_1_4` int(11) NOT NULL,
        `R_2_1` int(11) NOT NULL,
        `R_2_2` int(11) NOT NULL,
        `R_2_3` int(11) NOT NULL,
        `R_2_4` int(11) NOT NULL,
        `R_3_1` int(11) NOT NULL,
        `R_3_2` int(11) NOT NULL,
        `R_3_3` int(11) NOT NULL,
        `R_3_4` int(11) NOT NULL,
        `R_3_5` int(11) NOT NULL,
        `R_4_1` int(11) NOT NULL,
        `R_4_2` int(11) NOT NULL,
        `R_4_3` int(11) NOT NULL,
        `R_4_4` int(11) NOT NULL,
        `R_4_5` int(11) NOT NULL,
        `U_1_1` int(11) NOT NULL,
        `U_1_2` int(11) NOT NULL,
        `U_1_3` int(11) NOT NULL,
        `U_1_4` int(11) NOT NULL,
        `U_2_1` int(11) NOT NULL,
        `U_2_2` int(11) NOT NULL,
        `U_2_3` int(11) NOT NULL,
        `U_2_4` int(11) NOT NULL,
        `U_2_5` int(11) NOT NULL,
        `U_3_1` int(11) NOT NULL,
        `U_3_2` int(11) NOT NULL,
        `U_3_3` int(11) NOT NULL,
        `U_3_4` int(11) NOT NULL,
        `U_3_5` int(11) NOT NULL,
        `U_4_1` int(11) NOT NULL,
        `U_4_2` int(11) NOT NULL,
        `U_4_3` int(11) NOT NULL,
        `U_4_4` int(11) NOT NULL,
        `U_4_5` int(11) NOT NULL,
        `U_5_1` int(11) NOT NULL,
        `U_5_2` int(11) NOT NULL,
        `U_5_3` int(11) NOT NULL,
        `U_5_4` int(11) NOT NULL,
        `U_6_1` int(11) NOT NULL,
        `U_6_2` int(11) NOT NULL,
        `U_6_3` int(11) NOT NULL,
        `U_6_4` int(11) NOT NULL
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
        'FS_1_1',
        'Serangkaian fungsi pada perangkat lunak sesuai dengan kebutuhan pengguna'
    ), (
        'FS_1_2',
        'Fungsi - fungsi pada perangkat lunak sudah memenuhi kebutuhan pengguna'
    ), (
        'FS_1_3',
        'Perangkat lunak dapat menjalankan tugas sesuai yang dibutuhkan'
    ), (
        'FS_1_4',
        'perangkat lunak tidak berjalan sesuai yang dibutuhkan'
    ), (
        'FS_1_5',
        'Fungsi-fungsi pada perangkat lunak kurang memenuhi kebutuhan pengguna'
    ), (
        'FS_2_1',
        'Perangkat lunak dapat mendapatkan hasil yang diharapkan'
    ), (
        'FS_2_2',
        'Perangkat lunak bekerja sesuai fungsinya'
    ), (
        'FS_2_3',
        'Fitur - fitur pada perangkat lunak dapat berfungsi'
    ), (
        'FS_2_4',
        'Fitur Create, Read, Update, dan Delete yang terdapat pada sistem dapat digunakan dengan baik'
    ), (
        'FS_3_1',
        'Fitur pemesanan pada sistem dapat berfungsi dengan baik'
    ), (
        'FS_3_2',
        'Fitur login berjalan dengan baik'
    ), (
        'FS_3_3',
        'Dapat login menggunakan username dan password lain '
    ), (
        'FS_3_4',
        'Dapat melakukan pembatalan penambahan data pemesanan yang tidak sesuai '
    ), (
        'FS_3_5',
        'Website tetap bisa dijalankan meskipun pada fungsi tambah pemesanan pada sistem terjadi eror atau bug'
    ), (
        'R_1_1',
        'Sebagian besar bug/error dapat dihilangkan dari waktu ke waktu'
    ), (
        'R_1_2',
        'Terdapat notifikasi saat terjadi kesalahan pada website'
    ), (
        'R_1_3',
        'Website dapat segera pulih setelah terjadi kesalahan perangkat lunak'
    ), (
        'R_1_4',
        'Website tetap bisa diakses saat terjadi kesalahan perangkat lunak'
    ), (
        'R_2_1',
        'Website dapat beroperasi sesuai dengan kebutuhan dan fitur yang ada'
    ), (
        'R_2_2',
        'Website tetap dapat beroperasi saat banyak pengguna yang masuk pada sistem'
    ), (
        'R_2_3',
        'Website dapat diakses oleh admin lain'
    ), (
        'R_2_4',
        'Website tetap bisa diakses saat diluar jam operasional'
    ), (
        'R_3_1',
        'Kinerja website dapat berjalan normal meskipun terdapat kesalahan pada software dan hardware'
    ), (
        'R_3_2',
        'Website tetap bisa digunakan meskipun terdapat fitur yang tidak berfungsi'
    ), (
        'R_3_3',
        'Saat terjadi kesalahan Website tetap berjalan normal'
    ), (
        'R_3_4',
        'Bisakah kemampuan perangkat lunak untuk membangun kembali tingkat kinerja ketika mengalami bug?'
    ), (
        'R_3_5',
        'Terdapat notifikasi peringatan pada website saat terjadi kesalahan perangkat lunak untuk menghindari error/bug  '
    ), (
        'R_4_1',
        'Website dapat mengembalikan data walaupun mengalami kegagalan'
    ), (
        'R_4_2',
        'Website dapat melanjutkan input data meskipun mengalami kegagalan jaringan dan mengembalikan data tersebut'
    ), (
        'R_4_3',
        'Website dapat mengembalikan data saat perangkat yang digunakan mati'
    ), (
        'R_4_4',
        'Saat kehilangan data sistem dapat mengembalikan data tersebut'
    ), (
        'R_4_5',
        'Website dapat mengembalikan data tanpa adanya koneksi jaringan'
    ), (
        'U_1_1',
        'Website mudah dipahami'
    ), (
        'U_1_2',
        'Terdapat fitur tutorial untuk memahami penggunaan website'
    ), (
        'U_1_3',
        'Website mudah dipahami walaupun baru mengaksesnya'
    ), (
        'U_1_4',
        'Website mudah dioperasikan'
    ), (
        'U_2_1',
        'Pengguna dapat mempelajari software dalam waktu yang sebentar'
    ), (
        'U_2_2',
        'Menu pada dasboard sudah sesuai dengan keinginan dan mempermudah pengguna'
    ), (
        'U_2_3',
        'Font yang digunakan mudah dibaca oleh pengguna'
    ), (
        'U_2_4',
        'Pengguna dapat mengunduh file atau mencetak halaman'
    ), (
        'U_2_5',
        'Website menggunakan tata bahasa yang mudah dimengerti oleh pengguna'
    ), (
        'U_3_1',
        'Semua jalur button dapat dieksekusi dengan benar atau paling tidak sekali proses'
    ), (
        'U_3_2',
        'Semua atribut button dapat dioperasikan'
    ), (
        'U_3_3',
        'Loading pada website berjalan dengan cepat'
    ), (
        'U_3_4',
        'Website memenuhi desain struktur informasi'
    ), (
        'U_3_5',
        'Website memuat data yang dibutuhkan oleh pengguna secara cepat'
    ), (
        'U_4_1',
        'Penggunaan warna pada website menggunakan kombinasi warna yang tepat'
    ), (
        'U_4_2',
        'Penggunaan warna pada website nyaman untuk pengelihatan pengguna'
    ), (
        'U_4_3',
        'Layout software nyaman bagi pengguna'
    ), (
        'U_4_4',
        'Tampilan website responsive'
    ), (
        'U_4_5',
        'Terdapat animasi pada saat proses loading'
    ), (
        'U_5_1',
        'Pengguna yang melakukan kesalahan akan mendapatkan notifikasi peringatan'
    ), (
        'U_5_2',
        'Tampilan sistem memudahkan pengguna dalam pengoperasiannya'
    ), (
        'U_5_3',
        'Tampilan sistem mudah dipahami oleh pengguna'
    ), (
        'U_5_4',
        'Pengguna dapat kembali dari kesalahan dengan cepat dan mudah'
    ), (
        'U_6_1',
        'Website dapat diakses melalui ponsel'
    ), (
        'U_6_2',
        'Sistem dapat diakses melalui tablet'
    ), (
        'U_6_3',
        'Tampilan website rusak saat digunakan pada size device yang kecil'
    ), (
        'U_6_4',
        'Tampilan sistem baik-baik saja saat digunakan pada size device medium'
    );

-- --------------------------------------------------------

--

-- Table structure for table `skor`

--

CREATE
OR
REPLACE
TABLE
    `skor` (
        `kode` varchar(255) NOT NULL,
        `skor` decimal(5, 3) DEFAULT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--

-- Dumping data for table `skor`

--

INSERT INTO
    `skor` (`kode`, `skor`)
VALUES ('FS', NULL), ('R', NULL), ('U', NULL);

-- --------------------------------------------------------

--

-- Table structure for table `user`

--

CREATE
OR
REPLACE
TABLE
    `user` (
        `username` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `name` varchar(255) NOT NULL,
        `level_user` varchar(255) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--

-- Dumping data for table `user`

--

INSERT INTO
    `user` (
        `username`,
        `password`,
        `name`,
        `level_user`
    )
VALUES (
        'admin',
        '21232f297a57a5a743894a0e4a801fc3',
        'Administrator',
        'admin'
    );

--

-- Indexes for dumped tables

--

--

-- Indexes for table `iso`

--

ALTER TABLE `iso` ADD PRIMARY KEY (`id`);

--

-- Indexes for table `kuisioner`

--

ALTER TABLE `kuisioner` ADD PRIMARY KEY (`id`);

--

-- Indexes for table `pertanyaan`

--

ALTER TABLE `pertanyaan` ADD PRIMARY KEY (`kode`);

--

-- Indexes for table `skor`

--

ALTER TABLE `skor` ADD PRIMARY KEY (`kode`);

--

-- Indexes for table `user`

--

ALTER TABLE `user` ADD PRIMARY KEY (`username`);

--

-- AUTO_INCREMENT for dumped tables

--

--

-- AUTO_INCREMENT for table `iso`

--

ALTER TABLE
    `iso` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
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