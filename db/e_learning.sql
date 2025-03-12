-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for e_learning
CREATE DATABASE IF NOT EXISTS `e_learning` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `e_learning`;

-- Dumping structure for table e_learning.departemen
CREATE TABLE IF NOT EXISTS `departemen` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_departemen` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.departemen: ~0 rows (approximately)

-- Dumping structure for table e_learning.departemen_have_moduls
CREATE TABLE IF NOT EXISTS `departemen_have_moduls` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_modul` int NOT NULL,
  `id_departemen` int DEFAULT NULL,
  `nama_departemen` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.departemen_have_moduls: ~0 rows (approximately)
REPLACE INTO `departemen_have_moduls` (`id`, `id_modul`, `id_departemen`, `nama_departemen`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, 'Manajemen', '2025-03-03 17:15:24', '2025-03-03 17:15:24'),
	(2, 3, NULL, 'Operasional', '2025-03-05 21:44:31', '2025-03-05 21:44:31');

-- Dumping structure for table e_learning.jawaban_soal_quizs
CREATE TABLE IF NOT EXISTS `jawaban_soal_quizs` (
  `id_jawaban_soal_quiz` int unsigned NOT NULL AUTO_INCREMENT,
  `jawaban` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `is_benar` enum('1','0') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0',
  `poin` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_soal` int unsigned NOT NULL,
  PRIMARY KEY (`id_jawaban_soal_quiz`),
  KEY `jawaban_soal_quizs_id_soal_foreign` (`id_soal`),
  CONSTRAINT `jawaban_soal_quizs_id_soal_foreign` FOREIGN KEY (`id_soal`) REFERENCES `soals` (`id_soal`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.jawaban_soal_quizs: ~8 rows (approximately)
REPLACE INTO `jawaban_soal_quizs` (`id_jawaban_soal_quiz`, `jawaban`, `is_benar`, `poin`, `created_at`, `updated_at`, `id_soal`) VALUES
	(1, '3500', '', 0, NULL, '2025-01-05 17:28:58', 1),
	(2, '2500', '1', 10, NULL, NULL, 1),
	(3, '8900', '', 0, NULL, '2025-01-05 17:28:58', 1),
	(4, '250', '', 0, NULL, '2025-01-05 17:28:58', 1),
	(5, 'Mensyukuri', '0', 0, NULL, NULL, 2),
	(6, 'Menyukai', '0', 0, NULL, NULL, 2),
	(7, 'Membenci', '0', 0, NULL, NULL, 2),
	(8, 'Menyayangi', '1', 10, NULL, NULL, 2);

-- Dumping structure for table e_learning.materi_moduls
CREATE TABLE IF NOT EXISTS `materi_moduls` (
  `id_materi_modul` int unsigned NOT NULL AUTO_INCREMENT,
  `materi_judul` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `materi_nama` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `materi_departemen` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_modul` int unsigned NOT NULL,
  PRIMARY KEY (`id_materi_modul`),
  KEY `materi_moduls_id_modul_foreign` (`id_modul`),
  CONSTRAINT `materi_moduls_id_modul_foreign` FOREIGN KEY (`id_modul`) REFERENCES `moduls` (`id_modul`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.materi_moduls: ~12 rows (approximately)
REPLACE INTO `materi_moduls` (`id_materi_modul`, `materi_judul`, `materi_nama`, `materi_departemen`, `created_at`, `updated_at`, `id_modul`) VALUES
	(1, 'Manajemen Setting', 'materi_setting.pdf', 'Manajemen', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
	(2, 'Modul Marketing', 'modul_marketing.pdf', 'Marketing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
	(3, 'Modul Operasional', 'modul_operasional.pdf', 'Operasional', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3),
	(4, 'Menu Billing', 'menu_billinng.pdf', 'Billing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4),
	(5, 'Menu Payable Payment', 'menu_payable_payment.pdf', 'Account Payable', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5),
	(6, 'Menu Receivable Payment', 'menu_receivable_payment.pdf', 'Account Receivable', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6),
	(7, 'Modul Warehouse', 'modul_warehouse.pdf', 'Warehouse Inventory', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 7),
	(8, 'Menu Fleet Yard', 'menu_fleet_yard.pdf', 'Fleet Yard', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 8),
	(9, 'Driver Apps', 'driver_apps.pdf', 'Driver', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9),
	(10, 'Modul Finance', 'modul_finance.pdf', 'Finance Accounting', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10),
	(11, 'Auditor', 'menu_auditor.pdf', 'Auditor', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 11),
	(12, 'Modul Vehicle, Inventory & Tyre', 'modul_vehicle_inventory_tyre.pdf', 'Asset Vehicle', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 12);

-- Dumping structure for table e_learning.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` int NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `contact_name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `device_id` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` enum('inbox','outbox','draft') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'outbox',
  `expired_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_contact_name_contact_number_index` (`contact_name`,`contact_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.messages: ~0 rows (approximately)

-- Dumping structure for table e_learning.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.migrations: ~0 rows (approximately)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2024_01_12_014545_create_trainees_table', 1),
	(2, '2024_01_12_014836_create_trainers_table', 1),
	(3, '2024_01_12_014927_create_moduls_table', 1),
	(4, '2024_01_12_014929_create_quizs_table', 1),
	(5, '2024_01_12_014932_create_soals_table', 1),
	(6, '2024_01_12_014933_create_jawaban_soal_quizs_table', 1),
	(7, '2024_01_12_014940_create_tugass_table', 1),
	(8, '2024_01_12_023646_create_pengumumans_table', 1),
	(9, '2024_01_12_094404_create_messages_table', 1),
	(10, '2024_01_12_100403_create_nilai_tugas_trainees_table', 1),
	(11, '2024_01_12_100411_create_nilai_quiz_pilihan_ganda_trainees_table', 1),
	(12, '2024_01_12_100413_create_nilai_quiz_essay_trainees_table', 1),
	(13, '2024_01_12_100415_create_nilai_quiz_trainees_table', 1),
	(14, '2024_01_12_100416_create_nilai_trainees_table', 1),
	(15, '2024_01_13_015622_create_materi_moduls_table', 1),
	(16, '2024_01_14_122945_create_sms_gateways_table', 1),
	(17, '2024_02_12_063106_create_trainee_jawab_quiz_pilihan_gandas_table', 1),
	(18, '2024_02_12_063118_create_trainee_jawab_quiz_essays_table', 1),
	(19, '2024_02_12_063132_create_trainee_jawab_tugas_table', 1),
	(20, '2024_02_12_071814_create_soal_has_quizs_table', 1),
	(21, '2024_03_12_150923_create_departemen_have_moduls_table', 1),
	(22, '2024_03_12_150923_create_departemen_table', 1),
	(23, '2024_10_12_000000_create_users_table', 1),
	(24, '2024_10_12_100000_create_password_resets_table', 1);

-- Dumping structure for table e_learning.moduls
CREATE TABLE IF NOT EXISTS `moduls` (
  `id_modul` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_modul` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nik_trainer` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id_modul`),
  KEY `moduls_nik_trainer_foreign` (`nik_trainer`),
  CONSTRAINT `moduls_nik_trainer_foreign` FOREIGN KEY (`nik_trainer`) REFERENCES `trainers` (`nik_trainer`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.moduls: ~12 rows (approximately)
REPLACE INTO `moduls` (`id_modul`, `nama_modul`, `created_at`, `updated_at`, `nik_trainer`) VALUES
	(1, 'Manajemen Setting', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '112'),
	(2, 'Marketing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '115'),
	(3, 'Operasional', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '116'),
	(4, 'Billing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '115'),
	(5, 'Account Payable', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '114'),
	(6, 'Account Receivable', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '114'),
	(7, 'Warehouse Inventory', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '116'),
	(8, 'Fleet Yard', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '116'),
	(9, 'Driver', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '116'),
	(10, 'Finance Accounting', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '114'),
	(11, 'Auditor', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '115'),
	(12, 'Asset Vehicle', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '116');

-- Dumping structure for table e_learning.nilai_quiz_essay_trainees
CREATE TABLE IF NOT EXISTS `nilai_quiz_essay_trainees` (
  `id_nilai_quiz_essay` int unsigned NOT NULL AUTO_INCREMENT,
  `nilai` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `wkt_mulai` timestamp NOT NULL,
  `wkt_selesai` timestamp NOT NULL,
  `nik_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `id_quiz` int unsigned NOT NULL,
  PRIMARY KEY (`id_nilai_quiz_essay`),
  KEY `nilai_quiz_essay_trainees_nik_trainee_foreign` (`nik_trainee`),
  KEY `nilai_quiz_essay_trainees_id_quiz_foreign` (`id_quiz`),
  CONSTRAINT `nilai_quiz_essay_trainees_id_quiz_foreign` FOREIGN KEY (`id_quiz`) REFERENCES `quizs` (`id_quiz`) ON DELETE CASCADE,
  CONSTRAINT `nilai_quiz_essay_trainees_nik_trainee_foreign` FOREIGN KEY (`nik_trainee`) REFERENCES `trainees` (`nik_trainee`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.nilai_quiz_essay_trainees: ~0 rows (approximately)

-- Dumping structure for table e_learning.nilai_quiz_pilgan_trainees
CREATE TABLE IF NOT EXISTS `nilai_quiz_pilgan_trainees` (
  `id_nilai_quiz_pilgan` int unsigned NOT NULL AUTO_INCREMENT,
  `nilai` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `wkt_mulai` timestamp NULL DEFAULT NULL,
  `wkt_selesai` timestamp NULL DEFAULT NULL,
  `nik_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `id_quiz` int unsigned NOT NULL,
  PRIMARY KEY (`id_nilai_quiz_pilgan`),
  KEY `nilai_quiz_pilgan_trainees_nik_trainee_foreign` (`nik_trainee`),
  KEY `nilai_quiz_pilgan_trainees_id_quiz_foreign` (`id_quiz`),
  CONSTRAINT `nilai_quiz_pilgan_trainees_id_quiz_foreign` FOREIGN KEY (`id_quiz`) REFERENCES `quizs` (`id_quiz`) ON DELETE CASCADE,
  CONSTRAINT `nilai_quiz_pilgan_trainees_nik_trainee_foreign` FOREIGN KEY (`nik_trainee`) REFERENCES `trainees` (`nik_trainee`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.nilai_quiz_pilgan_trainees: ~0 rows (approximately)

-- Dumping structure for table e_learning.nilai_quiz_trainees
CREATE TABLE IF NOT EXISTS `nilai_quiz_trainees` (
  `id_nilai_quiz_trainee` int unsigned NOT NULL AUTO_INCREMENT,
  `nilai_quiz` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nik_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `id_nilai_tugas_trainee` int unsigned NOT NULL,
  `id_nilai_quiz_pilgan` int unsigned NOT NULL,
  `id_nilai_quiz_essay` int unsigned NOT NULL,
  PRIMARY KEY (`id_nilai_quiz_trainee`),
  KEY `nilai_quiz_trainees_nik_trainee_foreign` (`nik_trainee`),
  KEY `nilai_quiz_trainees_id_nilai_quiz_pilgan_foreign` (`id_nilai_quiz_pilgan`),
  KEY `nilai_quiz_trainees_id_nilai_quiz_essay_foreign` (`id_nilai_quiz_essay`),
  CONSTRAINT `nilai_quiz_trainees_id_nilai_quiz_essay_foreign` FOREIGN KEY (`id_nilai_quiz_essay`) REFERENCES `nilai_quiz_essay_trainees` (`id_nilai_quiz_essay`) ON DELETE CASCADE,
  CONSTRAINT `nilai_quiz_trainees_id_nilai_quiz_pilgan_foreign` FOREIGN KEY (`id_nilai_quiz_pilgan`) REFERENCES `nilai_quiz_pilgan_trainees` (`id_nilai_quiz_pilgan`) ON DELETE CASCADE,
  CONSTRAINT `nilai_quiz_trainees_nik_trainee_foreign` FOREIGN KEY (`nik_trainee`) REFERENCES `trainees` (`nik_trainee`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.nilai_quiz_trainees: ~0 rows (approximately)

-- Dumping structure for table e_learning.nilai_trainees
CREATE TABLE IF NOT EXISTS `nilai_trainees` (
  `id_nilai_trainee` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nik_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `id_nilai_tugas_trainee` int unsigned NOT NULL,
  `id_nilai_quiz_trainee` int unsigned NOT NULL,
  PRIMARY KEY (`id_nilai_trainee`),
  KEY `nilai_trainees_nik_trainee_foreign` (`nik_trainee`),
  KEY `nilai_trainees_id_nilai_tugas_trainee_foreign` (`id_nilai_tugas_trainee`),
  KEY `nilai_trainees_id_nilai_quiz_trainee_foreign` (`id_nilai_quiz_trainee`),
  CONSTRAINT `nilai_trainees_id_nilai_quiz_trainee_foreign` FOREIGN KEY (`id_nilai_quiz_trainee`) REFERENCES `nilai_quiz_trainees` (`id_nilai_quiz_trainee`) ON DELETE CASCADE,
  CONSTRAINT `nilai_trainees_id_nilai_tugas_trainee_foreign` FOREIGN KEY (`id_nilai_tugas_trainee`) REFERENCES `nilai_tugas_trainees` (`id_nilai_tugas_trainee`) ON DELETE CASCADE,
  CONSTRAINT `nilai_trainees_nik_trainee_foreign` FOREIGN KEY (`nik_trainee`) REFERENCES `trainees` (`nik_trainee`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.nilai_trainees: ~0 rows (approximately)

-- Dumping structure for table e_learning.nilai_tugas_trainees
CREATE TABLE IF NOT EXISTS `nilai_tugas_trainees` (
  `id_nilai_tugas_trainee` int unsigned NOT NULL AUTO_INCREMENT,
  `nilai_tugas` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `wkt_mulai` timestamp NOT NULL,
  `wkt_selesai` timestamp NOT NULL,
  `id_tugas` int unsigned NOT NULL,
  `nik_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id_nilai_tugas_trainee`),
  KEY `nilai_tugas_trainees_id_tugas_foreign` (`id_tugas`),
  KEY `nilai_tugas_trainees_nik_trainee_foreign` (`nik_trainee`),
  CONSTRAINT `nilai_tugas_trainees_id_tugas_foreign` FOREIGN KEY (`id_tugas`) REFERENCES `tugass` (`id_tugas`) ON DELETE CASCADE,
  CONSTRAINT `nilai_tugas_trainees_nik_trainee_foreign` FOREIGN KEY (`nik_trainee`) REFERENCES `trainees` (`nik_trainee`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.nilai_tugas_trainees: ~0 rows (approximately)

-- Dumping structure for table e_learning.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.password_resets: ~0 rows (approximately)

-- Dumping structure for table e_learning.pengumumans
CREATE TABLE IF NOT EXISTS `pengumumans` (
  `id_pengumuman` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengumuman`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.pengumumans: ~2 rows (approximately)
REPLACE INTO `pengumumans` (`id_pengumuman`, `judul`, `deskripsi`, `author`, `created_at`, `updated_at`) VALUES
	(1, 'Sosialisai e_learning Solog', 'Diumumkan kepada Seluruh Trainee departemen Operasional agar mengikuti acara Sosialisasi E-Learnig Solog pada :\r\n							Hari : Senin\r\n							Pukul : 09.00 s.d Selesai\r\n							Ruangan : Aula \r\n							Terima Kasih atas partisipasinya.', 'Muhammad Firyanul Rizky', '2024-01-12 09:00:00', '2024-01-12 09:00:00'),
	(2, 'Rapat Audit Keuangan', 'Diumumkan kepada Seluruh Trainee departemen Finance agar mengikuti acara Rapat Audit pada :\r\n							Hari : Rabu\r\n							Pukul : 09.00 s.d Selesai\r\n							Ruangan : Aula \r\n							Terima Kasih atas partisipasinya.', 'Muhammad Firyanul Rizky', '2024-01-12 09:00:00', '2024-01-12 09:00:00');

-- Dumping structure for table e_learning.quizs
CREATE TABLE IF NOT EXISTS `quizs` (
  `id_quiz` int unsigned NOT NULL AUTO_INCREMENT,
  `jenis_quiz` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `judul_quiz` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `info_quiz` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `departemen_quiz` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `waktu_quiz` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `jumlah_soal` tinyint NOT NULL,
  `is_random` enum('1','0') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0',
  `pembuat_quiz` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tgl_quiz` date NOT NULL,
  `status_quiz` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_modul` int unsigned NOT NULL,
  PRIMARY KEY (`id_quiz`),
  KEY `quizs_id_modul_foreign` (`id_modul`),
  CONSTRAINT `quizs_id_modul_foreign` FOREIGN KEY (`id_modul`) REFERENCES `moduls` (`id_modul`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.quizs: ~2 rows (approximately)
REPLACE INTO `quizs` (`id_quiz`, `jenis_quiz`, `judul_quiz`, `info_quiz`, `departemen_quiz`, `waktu_quiz`, `jumlah_soal`, `is_random`, `pembuat_quiz`, `tgl_quiz`, `status_quiz`, `created_at`, `updated_at`, `id_modul`) VALUES
	(1, 'Quiz Latihan', 'Job File Manajemen', 'Dikerjakan Sekarang Juga', 'Operasional', '60', 20, '0', 'Muhammad Firyanul Rizky', '2025-03-06', 'Aktif', '2024-03-12 09:00:00', '2025-03-05 18:15:39', 3),
	(2, 'Quiz Uji Kompetensi', 'Quotation Request', 'Dikerjakan Sekarang Juga', 'Marketing', '120', 20, '1', 'Muhammad Firyanul Rizky', '2025-01-06', 'Aktif', '2024-03-12 09:00:00', '2025-01-05 17:26:02', 3);

-- Dumping structure for table e_learning.sms_gateways
CREATE TABLE IF NOT EXISTS `sms_gateways` (
  `id_sms_gateway` int unsigned NOT NULL AUTO_INCREMENT,
  `pesan` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_tugas` int unsigned NOT NULL,
  `nik_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id_sms_gateway`),
  KEY `sms_gateways_id_tugas_foreign` (`id_tugas`),
  KEY `sms_gateways_nik_trainee_foreign` (`nik_trainee`),
  CONSTRAINT `sms_gateways_id_tugas_foreign` FOREIGN KEY (`id_tugas`) REFERENCES `tugass` (`id_tugas`) ON DELETE CASCADE,
  CONSTRAINT `sms_gateways_nik_trainee_foreign` FOREIGN KEY (`nik_trainee`) REFERENCES `trainees` (`nik_trainee`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.sms_gateways: ~0 rows (approximately)

-- Dumping structure for table e_learning.soals
CREATE TABLE IF NOT EXISTS `soals` (
  `id_soal` int unsigned NOT NULL AUTO_INCREMENT,
  `jenis_soal` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `pertanyaan` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_quiz` int unsigned NOT NULL,
  PRIMARY KEY (`id_soal`),
  KEY `soals_id_quiz_foreign` (`id_quiz`),
  CONSTRAINT `soals_id_quiz_foreign` FOREIGN KEY (`id_quiz`) REFERENCES `quizs` (`id_quiz`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.soals: ~2 rows (approximately)
REPLACE INTO `soals` (`id_soal`, `jenis_soal`, `pertanyaan`, `gambar`, `created_at`, `updated_at`, `id_quiz`) VALUES
	(1, 'Pilihan Ganda', '<p>Paket Pekerjaan yang terdiri atas banyak service disebut ?</p>', 'Nitro_Wallpaper_03_3840x2400.jpg', NULL, '2025-01-05 17:28:58', 1),
	(2, 'Pilihan Ganda', '<p>Raihan memerlukan Layanan Jual <strong><em>LCL</em></strong> pada pengiriman Logistik nya. Jelaskan cara memilih layanan jual LCL pada Job File yang dibuat!</p>', '', NULL, NULL, 1);

-- Dumping structure for table e_learning.soal_has_quizs
CREATE TABLE IF NOT EXISTS `soal_has_quizs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_soal` int unsigned NOT NULL,
  `id_quiz` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `soal_has_quizs_id_soal_foreign` (`id_soal`),
  KEY `soal_has_quizs_id_quiz_foreign` (`id_quiz`),
  CONSTRAINT `soal_has_quizs_id_quiz_foreign` FOREIGN KEY (`id_quiz`) REFERENCES `quizs` (`id_quiz`) ON DELETE CASCADE,
  CONSTRAINT `soal_has_quizs_id_soal_foreign` FOREIGN KEY (`id_soal`) REFERENCES `soals` (`id_soal`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.soal_has_quizs: ~0 rows (approximately)
REPLACE INTO `soal_has_quizs` (`id`, `id_soal`, `id_quiz`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2025-01-05 17:28:58', '2025-01-05 17:28:58');

-- Dumping structure for table e_learning.trainees
CREATE TABLE IF NOT EXISTS `trainees` (
  `nik_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `nama_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `no_hp_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ttl_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `jns_kelamin_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `alamat_trainee` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `departemen_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `foto_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_user` int unsigned NOT NULL,
  PRIMARY KEY (`nik_trainee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.trainees: ~2 rows (approximately)
REPLACE INTO `trainees` (`nik_trainee`, `nama_trainee`, `email_trainee`, `no_hp_trainee`, `ttl_trainee`, `jns_kelamin_trainee`, `alamat_trainee`, `departemen_trainee`, `foto_trainee`, `status_trainee`, `created_at`, `updated_at`, `id_user`) VALUES
	('121', 'Muhammad Raihan ', 'raihan@tcontinent.com', '082176074036', 'Bandung, 26 Mei 1999', 'Laki - laki', 'Tebet Raya', 'Operasional', 'foto .jpg', 'Aktif', '2024-01-12 09:00:00', '2024-01-12 09:00:00', 7),
	('122', 'Abda Syakura Taqwadin', 'abda@tcontinent.com', '081215869294', 'Aceh, 34 Juli 1998', 'Laki - laki', 'Tebet Barat', 'Marketing', 'user1-128x128.jpg', 'Aktif', '2024-01-12 09:00:00', '2024-01-12 09:00:00', 8);

-- Dumping structure for table e_learning.trainee_jawab_quiz_essays
CREATE TABLE IF NOT EXISTS `trainee_jawab_quiz_essays` (
  `id_trainee_jawab_quiz_essays` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_soal` int unsigned NOT NULL,
  `id_jawaban_soal_quiz` int unsigned NOT NULL,
  `id_nilai_quiz_essay` int unsigned NOT NULL,
  PRIMARY KEY (`id_trainee_jawab_quiz_essays`),
  KEY `trainee_jawab_quiz_essays_id_soal_foreign` (`id_soal`),
  KEY `trainee_jawab_quiz_essays_id_jawaban_soal_quiz_foreign` (`id_jawaban_soal_quiz`),
  KEY `trainee_jawab_quiz_essays_id_nilai_quiz_essay_foreign` (`id_nilai_quiz_essay`),
  CONSTRAINT `trainee_jawab_quiz_essays_id_jawaban_soal_quiz_foreign` FOREIGN KEY (`id_jawaban_soal_quiz`) REFERENCES `jawaban_soal_quizs` (`id_jawaban_soal_quiz`) ON DELETE CASCADE,
  CONSTRAINT `trainee_jawab_quiz_essays_id_nilai_quiz_essay_foreign` FOREIGN KEY (`id_nilai_quiz_essay`) REFERENCES `nilai_quiz_essay_trainees` (`id_nilai_quiz_essay`) ON DELETE CASCADE,
  CONSTRAINT `trainee_jawab_quiz_essays_id_soal_foreign` FOREIGN KEY (`id_soal`) REFERENCES `soals` (`id_soal`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.trainee_jawab_quiz_essays: ~0 rows (approximately)

-- Dumping structure for table e_learning.trainee_jawab_quiz_pilgans
CREATE TABLE IF NOT EXISTS `trainee_jawab_quiz_pilgans` (
  `id_trainee_jawab_quiz_pilgan` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_soal` int unsigned NOT NULL,
  `id_jawaban_soal_quiz` int unsigned DEFAULT NULL,
  `id_nilai_quiz_pilgan` int unsigned NOT NULL,
  PRIMARY KEY (`id_trainee_jawab_quiz_pilgan`),
  KEY `trainee_jawab_quiz_pilgans_id_soal_foreign` (`id_soal`),
  KEY `trainee_jawab_quiz_pilgans_id_jawaban_soal_quiz_foreign` (`id_jawaban_soal_quiz`),
  KEY `trainee_jawab_quiz_pilgans_id_nilai_quiz_pilgan_foreign` (`id_nilai_quiz_pilgan`),
  CONSTRAINT `trainee_jawab_quiz_pilgans_id_jawaban_soal_quiz_foreign` FOREIGN KEY (`id_jawaban_soal_quiz`) REFERENCES `jawaban_soal_quizs` (`id_jawaban_soal_quiz`) ON DELETE CASCADE,
  CONSTRAINT `trainee_jawab_quiz_pilgans_id_nilai_quiz_pilgan_foreign` FOREIGN KEY (`id_nilai_quiz_pilgan`) REFERENCES `nilai_quiz_pilgan_trainees` (`id_nilai_quiz_pilgan`) ON DELETE CASCADE,
  CONSTRAINT `trainee_jawab_quiz_pilgans_id_soal_foreign` FOREIGN KEY (`id_soal`) REFERENCES `soals` (`id_soal`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.trainee_jawab_quiz_pilgans: ~0 rows (approximately)

-- Dumping structure for table e_learning.trainee_jawab_tugas
CREATE TABLE IF NOT EXISTS `trainee_jawab_tugas` (
  `id_trainee_jawab_tugas` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_tugas` int unsigned NOT NULL,
  `nik_trainee` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `nilai` int NOT NULL,
  PRIMARY KEY (`id_trainee_jawab_tugas`),
  KEY `trainee_jawab_tugas_id_tugas_foreign` (`id_tugas`),
  KEY `trainee_jawab_tugas_nik_trainee_foreign` (`nik_trainee`),
  CONSTRAINT `trainee_jawab_tugas_id_tugas_foreign` FOREIGN KEY (`id_tugas`) REFERENCES `tugass` (`id_tugas`) ON DELETE CASCADE,
  CONSTRAINT `trainee_jawab_tugas_nik_trainee_foreign` FOREIGN KEY (`nik_trainee`) REFERENCES `trainees` (`nik_trainee`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.trainee_jawab_tugas: ~0 rows (approximately)
REPLACE INTO `trainee_jawab_tugas` (`id_trainee_jawab_tugas`, `judul`, `nama_file`, `created_at`, `updated_at`, `id_tugas`, `nik_trainee`, `nilai`) VALUES
	(1, 'test', '2024 Daily Bank Daily PettyCash Payment Schedule Sheet.xlsx', '2025-01-04 05:18:05', '2025-01-04 05:28:14', 1, '121', 90);

-- Dumping structure for table e_learning.trainers
CREATE TABLE IF NOT EXISTS `trainers` (
  `nik_trainer` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `nama_trainer` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ttl_trainer` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `jns_kelamin_trainer` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `agama_trainer` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `no_telp_trainer` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_trainer` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `alamat_trainer` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `jabatan_trainer` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `foto_trainer` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status_trainer` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_user` int unsigned NOT NULL,
  PRIMARY KEY (`nik_trainer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.trainers: ~6 rows (approximately)
REPLACE INTO `trainers` (`nik_trainer`, `nama_trainer`, `ttl_trainer`, `jns_kelamin_trainer`, `agama_trainer`, `no_telp_trainer`, `email_trainer`, `alamat_trainer`, `jabatan_trainer`, `foto_trainer`, `status_trainer`, `created_at`, `updated_at`, `id_user`) VALUES
	('111', 'Muhammad Firyanul Rizky', 'Kabupaten Tuban, 29 Maret 1999', 'Laki-Laki', 'Islam', '0895606181117', 'rizki@tcontinent.com', 'Jl. Tebet Dalam IV', 'IT Software Development', 'TI-RIZKI.JPG', 'Aktif', '2024-12-18 09:00:00', '2024-12-18 09:00:00', 1),
	('112', 'Gusti Denata Bagus Narawangsa', 'Surabaya, 26 Mei 2001', 'Laki-Laki', 'Islam', '081279098909', 'gusti@tcontinent.com', 'Tebet Raya', 'IT Helpdesk', 'TI-GUSTI.JPG', 'Aktif', '2024-11-28 09:00:00', '2024-11-28 09:00:00', 2),
	('113', 'Ade Nasfudin', 'Bandung, 26 Mei 1970', 'Laki - laki', 'Islam', '081279098909', 'ade@tcontinent.com', 'Tebet Raya', 'General Manajer', 'MNJ-ADE.JPG', 'Aktif', '2024-11-28 09:00:00', '2025-03-05 22:01:50', 3),
	('114', 'Tri Joko Yani', 'Bandung, 26 Mei 1970', 'Laki-Laki', 'Islam', '081279098909', 'tri@tcontinent.com', 'Tebet Raya', 'Manajer Finance', 'MNJ-TRI.JPG', 'Aktif', '2024-11-28 09:00:00', '2024-11-28 09:00:00', 4),
	('115', 'Lilis Sugiarti', 'Bandung, 26 Mei 1987', 'Perempuan', 'Islam', '081279098909', 'lilis@tcontinent.com', 'Tebet Raya', 'Nasional Manajer', 'MNJ-LILIS.JPG', 'Aktif', '2024-11-28 09:00:00', '2024-11-28 09:00:00', 5),
	('116', 'Fredy Hutagalung', 'Bandung, 26 Mei 1970', 'Laki-Laki', 'Islam', '081279098909', 'fredy@tcontinent.com', 'Tebet Raya', 'Manajer Operasional', 'MNJ-FREDY.JPG', 'Aktif', '2024-11-28 09:00:00', '2024-11-28 09:00:00', 6);

-- Dumping structure for table e_learning.tugass
CREATE TABLE IF NOT EXISTS `tugass` (
  `id_tugas` int unsigned NOT NULL AUTO_INCREMENT,
  `judul_tugas` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `deskripsi_tugas` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `departemen_tugas` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `waktu_tugas` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `pembuat_tugas` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tgl_tugas` date NOT NULL,
  `info_tugas` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status_tugas` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `sms_status_tugas` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_modul` int unsigned NOT NULL,
  PRIMARY KEY (`id_tugas`),
  KEY `tugass_id_modul_foreign` (`id_modul`),
  CONSTRAINT `tugass_id_modul_foreign` FOREIGN KEY (`id_modul`) REFERENCES `moduls` (`id_modul`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.tugass: ~0 rows (approximately)
REPLACE INTO `tugass` (`id_tugas`, `judul_tugas`, `deskripsi_tugas`, `departemen_tugas`, `waktu_tugas`, `pembuat_tugas`, `tgl_tugas`, `info_tugas`, `status_tugas`, `sms_status_tugas`, `created_at`, `updated_at`, `id_modul`) VALUES
	(1, 'Tugas Membuat Breakdown Job File', 'Input Job File berdasarkan studi kasus yang diberikan', 'Operasional', '1 Hari', 'Muhammad Firyanul Rizky', '2025-01-04', 'Paling Lambat Upload Tugas hari ini', 'Aktif', 'Aktif', '2018-02-01 09:00:00', '2025-01-04 05:17:56', 3);

-- Dumping structure for table e_learning.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `username` varchar(60) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `level` tinyint NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table e_learning.users: ~8 rows (approximately)
REPLACE INTO `users` (`id_user`, `name`, `username`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `level`) VALUES
	(1, 'Muhammad Firyanul Rizky', 'rizky', 'rizki@tcontinent.com', '$2y$12$NID6YONWisMPJh3QGDfPu.iFOC3m5uLhiyQNzEGeJarQLttXnzeo6', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 11),
	(2, 'Gusti Denata Bagus Narawangsa', 'gusti', 'gusti@tcontinent.com', '$2y$12$HssvAhRhwJqMoSHi6hKoW.hgyWfRTLyFnXcUJmQpEod/dz3cezlKu', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 12),
	(3, 'Ade Nasfudin', 'ade_bpn', 'ade@tcontinent.com', '$2y$12$f0LdaFwYjgUXCOK44XweH.f906VESMF0fq5XG1owqlTQnkAvHWbCy', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 12),
	(4, 'Tri Joko Yani', 'tri_joko', 'tri@tcontinent.com', '$2y$12$//wRG86mgrQRVS9saPabGOr2AKCAp7EuFQZ9caOXXspIwoQ5BsMxW', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 12),
	(5, 'Lilis Sugiarti', 'lilis', 'lilis@tcontinent.com', '$2y$12$Z3TXuB/W8K7YRtphcFa6GOnv1FFNGkiaR9zTP8DQSRvobYi5ox9zW', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 12),
	(6, 'Fredy Hutagalung', 'fredy', 'fredy@tcontinent.com', '$2y$12$1isHJF/Xe979g4APreRqlevkms89RV6P2PixlHgjRUU9XFqHRH8hq', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 12),
	(7, 'Muhammad Raihan', 'raihan', 'raihan@tcontinent.com', '$2y$12$g2zt/2AsLCnUusj/2xJsXe0KhoiVQOaEkxl7910K1Kycm4LOXwMoK', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 13),
	(8, 'Abda Syakura Taqwadin', 'abda', 'abda@tcontinent.com', '$2y$12$OnLUpXUZKR0zniJCc6mETutNZLVpfCV.d1Voi5sCuOHzwpx10wfh6', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 13);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
