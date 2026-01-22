-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table bookify_db.livros: ~7 rows (approximately)
INSERT INTO `livros` (`id`, `titulo`, `autor`, `sinopse`, `capa_url`, `categoria`, `is_popular`, `conteudo_url`) VALUES
	(1001, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', 'An orphaned boy discovers he is a wizard and attends a magical school, beginning a series of adventures against a dark lord.', 'assets\\images\\Vector.png', 'Fantasy', 1, 'livros'),
	(1002, 'Crime and Punishment', 'Fyodor Dostoevsky', 'A struggling student, Raskolnikov, murders a ruthless pawnbroker and deals with the resulting psychological and moral consequences.', 'assets\\images\\yellow-book-4995 13.png', 'Classic', 1, NULL),
	(1003, 'War and Peace', 'Leo Tolstoy', 'A sweeping epic following five aristocratic Russian families during Napoleon\'s invasion, exploring themes of love, war, and philosophy.', 'assets\\images\\Vector (1).png', 'Classic', 0, NULL),
	(1004, 'The Communist Manifesto', 'Karl Marx', 'A political pamphlet arguing that class struggles are the motivation behind all historical developments, written by Marx and Engels.', 'assets/images/yellow-book-4995 15.png', 'Political Science', 0, NULL),
	(1005, 'Otaces', 'Jules Verne', '(Based on Twenty Thousand Leagues Under the Sea) A professor and a harpooner board the advanced submarine Nautilus, captained by the mysterious Nemo, exploring the ocean depths.', 'assets\\images\\Vector (2).png', 'Science Fiction', 1, NULL),
	(1006, 'The Lord of the Rings', 'J.R.R. Tolkien', 'A young hobbit inherits a powerful, corrupted ring and must embark on a quest across Middle-earth to destroy it, facing the Dark Lord Sauron.', 'assets\\images\\tlor.jpg', 'Fantasy', 1, NULL),
	(1007, 'The Da Vinci Code', 'Dan Brown', 'A Harvard professor races across Europe to solve a series of cryptic clues tied to Da Vinci\'s work and a secret society protecting a historical secret.', 'assets\\images\\davinchcode.jpg', 'Thriller', 1, NULL);

-- Dumping data for table bookify_db.minha_lista: ~0 rows (approximately)

-- Dumping data for table bookify_db.utilizadores: ~0 rows (approximately)
INSERT INTO `utilizadores` (`id`, `nome`, `email`, `senha`, `data_registo`) VALUES
	(1, 'Kessyane', 'kessyaneloureiro@gmail.com', '$2y$10$q3LTttWsgCPS2Jxgtak53eoHRbaSYBbsVNlCDu7DsPfM6wIlu3aFq', '2025-12-16 14:52:36'),
	(2, 'Jean', 'jean@gmail.com', '$2y$10$lesMv.h0aPTfZSX9mgZwSuunjwA4kAhk5ZvzFFLJd.1SI0naj6F5O', '2026-01-20 23:20:44'),
	(3, 'Clenilson', 'clenia003@gmail.com', '$2y$10$D3DkAS3f1172p/mA/Nwcqeifaoci0sYQTBYzddWzWZRsJ.UPO8RbC', '2026-01-22 10:04:36');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
