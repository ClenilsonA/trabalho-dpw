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


-- Dumping database structure for bookify_db
DROP DATABASE IF EXISTS `bookify_db`;
CREATE DATABASE IF NOT EXISTS `bookify_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bookify_db`;

-- Dumping structure for table bookify_db.categorias
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bookify_db.categorias: ~7 rows (approximately)
INSERT INTO `categorias` (`id`, `name`, `description`, `active`, `created_at`) VALUES
	(1, 'Romance', 'Fictional narratives centered on human relationships.', 1, '2026-02-02 17:02:55'),
	(2, 'Science Fiction', 'Stories based on science, future, or technology.', 1, '2026-02-02 17:02:55'),
	(3, 'Thriller and Mystery', 'Plots involving mystery, crime, and investigation.', 1, '2026-02-02 17:02:55'),
	(4, 'IT and Technology', 'Technical books, programming, and software development.', 1, '2026-02-02 17:02:55'),
	(5, 'History', 'Accounts of real facts and past civilizations.', 1, '2026-02-02 17:02:55'),
	(6, 'Fantasy', 'Narratives with magic and imaginary worlds.', 1, '2026-02-02 17:02:55'),
	(7, 'Business and Management', 'Books on economy, startups, and leadership.', 1, '2026-02-02 17:02:55');

-- Dumping structure for table bookify_db.livros
DROP TABLE IF EXISTS `livros`;
CREATE TABLE IF NOT EXISTS `livros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `author` varchar(150) NOT NULL,
  `category_id` int NOT NULL,
  `synopsis` text,
  `cover_url` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `is_popular` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `livros_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bookify_db.livros: ~170 rows (approximately)
INSERT INTO `livros` (`id`, `title`, `author`, `category_id`, `synopsis`, `cover_url`, `file_url`, `is_popular`) VALUES
	(1, 'Dom Casmurro (PT Edition)', 'Machado de Assis', 1, 'A classic tale of love and doubt.', 'covers/dom_casmurro.jpg', 'pdfs/dom_casmurro.pdf', 0),
	(2, 'Pride and Prejudice', 'Jane Austen', 1, 'The romantic clash between Elizabeth and Darcy.', 'covers/pride_prejudice.jpg', 'pdfs/pride_prejudice.pdf', 1),
	(3, 'The Great Gatsby', 'F. Scott Fitzgerald', 1, 'Obsession and tragedy in the Jazz Age.', 'covers/gatsby.jpg', 'pdfs/gatsby.pdf', 1),
	(4, 'Wuthering Heights', 'Emily Brontë', 1, 'A dark story of revenge and passion.', 'covers/wuthering_heights.jpg', 'pdfs/wuthering_heights.pdf', 0),
	(5, '1984', 'George Orwell', 2, 'Dystopian world under Big Brother.', 'covers/1984.jpg', 'pdfs/1984.pdf', 1),
	(6, 'Brave New World', 'Aldous Huxley', 2, 'A future engineered for social stability.', 'covers/brave_new_world.jpg', 'pdfs/brave_new_world.pdf', 0),
	(7, 'Dune', 'Frank Herbert', 2, 'Interstellar politics on a desert planet.', 'covers/dune.jpg', 'pdfs/dune.pdf', 1),
	(8, 'Foundation', 'Isaac Asimov', 2, 'Predicting the fall of empires.', 'covers/foundation.jpg', 'pdfs/foundation.pdf', 1),
	(9, 'Sherlock Holmes', 'Arthur Conan Doyle', 3, 'Classic mystery cases.', 'covers/sherlock.jpg', 'pdfs/sherlock.pdf', 1),
	(10, 'The Silent Patient', 'Alex Michaelides', 3, 'A woman refuses to speak after a crime.', 'covers/silent_patient.jpg', 'pdfs/silent_patient.pdf', 1),
	(11, 'The Da Vinci Code', 'Dan Brown', 3, 'A religious conspiracy hidden in art.', 'covers/davinci_code.jpg', 'pdfs/davinci_code.pdf', 1),
	(12, 'Gone Girl', 'Gillian Flynn', 3, 'A marriage turned into a psychological game.', 'covers/gone_girl.jpg', 'pdfs/gone_girl.pdf', 0),
	(13, 'Clean Code', 'Robert C. Martin', 4, 'Handbook of software craftsmanship.', 'covers/clean_code.jpg', 'pdfs/clean_code.pdf', 0),
	(14, 'The Pragmatic Programmer', 'Andrew Hunt', 4, 'Tips for a career in software development.', 'covers/pragmatic.jpg', 'pdfs/pragmatic.pdf', 0),
	(15, 'Refactoring', 'Martin Fowler', 4, 'Improving existing code design.', 'covers/refactoring.jpg', 'pdfs/refactoring.pdf', 1),
	(16, 'Eloquent JavaScript', 'Marijn Haverbeke', 4, 'Modern guide to JS programming.', 'covers/eloquent_js.jpg', 'pdfs/eloquent_js.pdf', 1),
	(17, 'Design Patterns', 'Erich Gamma', 4, 'Reusable software design solutions.', 'covers/design_patterns.jpg', 'pdfs/design_patterns.pdf', 0),
	(18, 'Sapiens', 'Yuval Noah Harari', 5, 'A brief history of humankind.', 'covers/sapiens.png', 'pdfs/sapiens.pdf', 1),
	(19, 'The Silk Roads', 'Peter Frankopan', 5, 'A new history of the world.', 'covers/silk_roads.jpg', 'pdfs/silk_roads.pdf', 1),
	(20, 'SPQR', 'Mary Beard', 5, 'A history of ancient Rome.', 'covers/spqr.jpg', 'pdfs/spqr.pdf', 0),
	(21, 'The Guns of August', 'Barbara Tuchman', 5, 'The events leading to World War I.', 'covers/guns_august.jpg', 'pdfs/guns_august.pdf', 1),
	(22, 'The Hobbit', 'J.R.R. Tolkien', 6, 'Bilbos journey to the Lonely Mountain.', 'covers/hobbit.jpg', 'pdfs/hobbit.pdf', 0),
	(23, 'Harry Potter', 'J.K. Rowling', 6, 'A young wizard discovers his destiny.', 'covers/hp1.jpg', 'pdfs/hp1.pdf', 1),
	(24, 'Game of Thrones', 'George R.R. Martin', 6, 'Noble houses fight for the Iron Throne.', 'covers/got.jpg', 'pdfs/got.pdf', 1),
	(25, 'The Name of the Wind', 'Patrick Rothfuss', 6, 'The legend of a powerful wizard.', 'covers/name_wind.jpg', 'pdfs/name_wind.pdf', 1),
	(26, 'The Lean Startup', 'Eric Ries', 7, 'Innovation through continuous testing.', 'covers/lean_startup.png', 'pdfs/lean_startup.pdf', 0),
	(27, 'Rich Dad Poor Dad', 'Robert Kiyosaki', 7, 'Lessons on money and financial freedom.', 'covers/rich_dad.jpg', 'pdfs/rich_dad.pdf', 1),
	(28, 'Start with Why', 'Simon Sinek', 7, 'How great leaders inspire action.', 'covers/start_why.jpg', 'pdfs/start_why.pdf', 0),
	(29, 'The Power of Habit', 'Charles Duhigg', 7, 'Why we do what we do in life.', 'covers/power_habit.png', 'pdfs/power_habit.pdf', 1),
	(30, 'Zero to One', 'Peter Thiel', 7, 'Notes on startups and the future.', 'covers/zero_to_one.jpg', 'pdfs/zero_to_one.pdf', 0),
	(31, 'The Sun and the Moon', 'Elena Gilbert', 1, 'A star-crossed romance between two rival families.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(32, 'Rainy Days in Paris', 'Marc Petit', 1, 'Finding love in the most romantic city on earth.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(33, 'Love in the Digital Age', 'Sophia Reed', 1, 'A story about finding a soulmate through an app.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(34, 'The Coffee Shop Girl', 'Julian Banks', 1, 'He visited every day just to see her smile.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(35, 'Stolen Hearts', 'Isabella Swan', 1, 'A thief falls in love with the person she robbed.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(36, 'Autumn Leaves', 'Chris Green', 1, 'Rediscovering old love in a small mountain town.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(37, 'The Wedding Planner', 'Lucy Hale', 1, 'She organizes weddings but can’t find her own.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(38, 'Under the Tuscan Sun', 'Frances Mayes', 1, 'A woman buys a villa in Italy to start over.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(39, 'Sweet Beginnings', 'Olivia Rose', 1, 'A baker finds the secret ingredient for love.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(40, 'The Midnight Letter', 'Thomas Hardy', 1, 'A letter sent 20 years late changes everything.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(41, 'Alpha Centauri', 'Neil Tyson', 2, 'The first human colony outside our solar system.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(42, 'The Robot Rebellion', 'Isaac A.', 2, 'When the laws of robotics are finally broken.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(43, 'Warp Speed', 'Gene Rodden', 2, 'A crew testing the first faster-than-light engine.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(44, 'Genetic Code', 'H.G. Wells', 2, 'A future where humans are designed in labs.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(45, 'The Martian Dust', 'Andy Weir', 2, 'Survival guide for the first man left on Mars.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(46, 'Cybernetic Life', 'Philip Dick', 2, 'Do androids dream of eternal life?', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(47, 'Time Paradox', 'Marty McFly', 2, 'What happens if you meet yourself in the past?', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(48, 'Interstellar Void', 'Kip Thorne', 2, 'Navigating the space between two black holes.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(49, 'The Last Satellite', 'Arthur Clark', 2, 'A lonely AI orbiting a dead Earth.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(50, 'Moon Base One', 'Buzz Aldrin', 2, 'The secret history of the hidden lunar city.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(51, 'Vanishing Point', 'James Patt', 3, 'A woman disappears from a moving train.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(52, 'The Cold Case', 'Kathy Reichs', 3, 'Solving a murder that happened 50 years ago.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(53, 'Shadow of Doubt', 'Lee Child', 3, 'One man against a corrupt small town police force.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(54, 'The Locked Ward', 'Shari Lapena', 3, 'A psychiatric hospital with a killer inside.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(55, 'Double Agent', 'John Le Carré', 3, 'Spy games during the height of the Cold War.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(56, 'Final Destination', 'Agatha C.', 3, 'Ten strangers invited to an island, one by one they die.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(57, 'The Alibi', 'Gillian Flynn', 3, 'Everyone has an excuse, but someone is lying.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(58, 'Blood Ties', 'Jo Nesbo', 3, 'A detective hunts a killer related to his past.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(59, 'The Fourth Floor', 'Dan Brown', 3, 'Hidden secrets in the basement of the Vatican.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(60, 'Silent Screams', 'Karin S.', 3, 'A thriller that will keep you up all night.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(61, 'React for Experts', 'Dan Abramov', 4, 'A deep dive into hooks and state management.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(62, 'Python Automation', 'Al Sweigart', 4, 'How to automate the boring stuff in your life.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(63, 'Deep Learning', 'Ian Goodfellow', 4, 'The math and logic behind modern AI.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(64, 'The Linux Bible', 'Linus T.', 4, 'Everything you need to know about the kernel.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(65, 'Cloud Computing', 'Jeff Bezos', 4, 'Building scalable apps using AWS and Azure.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(66, 'JavaScript Weird Parts', 'Tony Alicea', 4, 'Understanding the core of the JS language.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(67, 'Algorithm Design', 'Steven Skiena', 4, 'Solving complex problems with efficient code.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(68, 'Cyber War', 'Edward Snow', 4, 'The history of state-sponsored hacking.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(69, 'Database Internals', 'Alex Petrov', 4, 'How SQL and NoSQL engines work under the hood.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(70, 'The Clean Coder', 'Robert Martin', 4, 'Professionalism for software developers.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(71, 'The Great War', 'Winston S.', 5, 'A detailed account of the First World War.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(72, 'The French Revolution', 'Ian Kershaw', 5, 'Liberty, Equality, and the guillotine.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(73, 'Samurai Spirit', 'Nitobe Inazo', 5, 'The bushido code and the warriors of Japan.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(74, 'The Silk Road', 'Peter Frankopan', 5, 'A new history of the world through trade.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(75, 'Ancient Greece', 'Edith Hall', 5, 'From the Iliad to the birth of democracy.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(76, 'The Vikings', 'Neil Price', 5, 'Explorers, traders, and the myths of Valhalla.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(77, 'Cold War Secrets', 'Ben Macintyre', 5, 'The true stories of the world’s greatest spies.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(78, 'The Renaissance', 'Paul Johnson', 5, 'The era of Da Vinci, Michaelangelo, and art.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(79, 'Aztecs and Mayas', 'Michael Coe', 5, 'The rise and fall of Mesoamerican civilizations.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(80, 'Napoleonic Wars', 'Andrew Roberts', 5, 'The man who tried to conquer all of Europe.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(81, 'The Elf Kingdom', 'J.R.R. Tolkien', 6, 'A journey to the ancient forests of the elves.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(82, 'The Dragon Rider', 'Christopher P.', 6, 'A boy and his dragon against a dark king.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(83, 'Wizard Academy', 'J.K. Rowling', 6, 'Learning magic in a castle hidden from humans.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(84, 'The Orc Hordes', 'Stan Nicholls', 6, 'A story told from the perspective of the orcs.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(85, 'Broken Sword', 'Michael Moorcock', 6, 'An epic tale of gods and ancient weapons.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(86, 'The Vampire Lord', 'Anne Rice', 6, 'Eternal life comes with a very bloody price.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(87, 'Ice and Fire', 'George Martin', 6, 'Politics and war in a world of endless winter.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(88, 'The Necromancer', 'Ursula Le Guin', 6, 'Raising the dead has terrible consequences.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(89, 'Fairy Tales', 'Grimm Brothers', 6, 'The original dark stories from the forest.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(90, 'The Griffin Path', 'Tamora Pierce', 6, 'Mythical creatures return to the human world.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(91, 'The Intelligent Investor', 'Benjamin Graham', 7, 'The definitive book on value investing.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(92, 'Zero to One', 'Peter Thiel', 7, 'How to build companies that create the future.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(93, 'The Hard Thing', 'Ben Horowitz', 7, 'Building a business when there are no easy answers.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(94, 'Think and Grow Rich', 'Napoleon Hill', 7, 'The philosophy of success and wealth.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(95, 'Blue Ocean Strategy', 'W. Chan Kim', 7, 'How to create uncontested market space.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(96, 'The 4-Hour Workweek', 'Tim Ferriss', 7, 'Escape the 9-5 and live anywhere.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(97, 'Rich Dad Poor Dad', 'Robert Kiyosaki', 7, 'What the rich teach their kids about money.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(98, 'Shoe Dog', 'Phil Knight', 7, 'A memoir by the creator of Nike.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(99, 'Atomic Habits', 'James Clear', 7, 'Small changes that lead to remarkable results.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(100, 'The Psychology of Money', 'Morgan Housel', 7, 'Timeless lessons on wealth and greed.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(101, 'The Sun and the Moon', 'Elena Gilbert', 1, 'A star-crossed romance between two rival families.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(102, 'Rainy Days in Paris', 'Marc Petit', 1, 'Finding love in the most romantic city on earth.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(103, 'Love in the Digital Age', 'Sophia Reed', 1, 'A story about finding a soulmate through an app.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(104, 'The Coffee Shop Girl', 'Julian Banks', 1, 'He visited every day just to see her smile.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(105, 'Stolen Hearts', 'Isabella Swan', 1, 'A thief falls in love with the person she robbed.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(106, 'Autumn Leaves', 'Chris Green', 1, 'Rediscovering old love in a small mountain town.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(107, 'The Wedding Planner', 'Lucy Hale', 1, 'She organizes weddings but can’t find her own.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(108, 'Under the Tuscan Sun', 'Frances Mayes', 1, 'A woman buys a villa in Italy to start over.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(109, 'Sweet Beginnings', 'Olivia Rose', 1, 'A baker finds the secret ingredient for love.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(110, 'The Midnight Letter', 'Thomas Hardy', 1, 'A letter sent 20 years late changes everything.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(111, 'Alpha Centauri', 'Neil Tyson', 2, 'The first human colony outside our solar system.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(112, 'The Robot Rebellion', 'Isaac A.', 2, 'When the laws of robotics are finally broken.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(113, 'Warp Speed', 'Gene Rodden', 2, 'A crew testing the first faster-than-light engine.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(114, 'Genetic Code', 'H.G. Wells', 2, 'A future where humans are designed in labs.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(115, 'The Martian Dust', 'Andy Weir', 2, 'Survival guide for the first man left on Mars.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(116, 'Cybernetic Life', 'Philip Dick', 2, 'Do androids dream of eternal life?', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(117, 'Time Paradox', 'Marty McFly', 2, 'What happens if you meet yourself in the past?', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(118, 'Interstellar Void', 'Kip Thorne', 2, 'Navigating the space between two black holes.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(119, 'The Last Satellite', 'Arthur Clark', 2, 'A lonely AI orbiting a dead Earth.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(120, 'Moon Base One', 'Buzz Aldrin', 2, 'The secret history of the hidden lunar city.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(121, 'Vanishing Point', 'James Patt', 3, 'A woman disappears from a moving train.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(122, 'The Cold Case', 'Kathy Reichs', 3, 'Solving a murder that happened 50 years ago.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(123, 'Shadow of Doubt', 'Lee Child', 3, 'One man against a corrupt small town police force.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(124, 'The Locked Ward', 'Shari Lapena', 3, 'A psychiatric hospital with a killer inside.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(125, 'Double Agent', 'John Le Carré', 3, 'Spy games during the height of the Cold War.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(126, 'Final Destination', 'Agatha C.', 3, 'Ten strangers invited to an island, one by one they die.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(127, 'The Alibi', 'Gillian Flynn', 3, 'Everyone has an excuse, but someone is lying.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(128, 'Blood Ties', 'Jo Nesbo', 3, 'A detective hunts a killer related to his past.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(129, 'The Fourth Floor', 'Dan Brown', 3, 'Hidden secrets in the basement of the Vatican.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(130, 'Silent Screams', 'Karin S.', 3, 'A thriller that will keep you up all night.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(131, 'React for Experts', 'Dan Abramov', 4, 'A deep dive into hooks and state management.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(132, 'Python Automation', 'Al Sweigart', 4, 'How to automate the boring stuff in your life.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(133, 'Deep Learning', 'Ian Goodfellow', 4, 'The math and logic behind modern AI.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(134, 'The Linux Bible', 'Linus T.', 4, 'Everything you need to know about the kernel.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(135, 'Cloud Computing', 'Jeff Bezos', 4, 'Building scalable apps using AWS and Azure.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(136, 'JavaScript Weird Parts', 'Tony Alicea', 4, 'Understanding the core of the JS language.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(137, 'Algorithm Design', 'Steven Skiena', 4, 'Solving complex problems with efficient code.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(138, 'Cyber War', 'Edward Snow', 4, 'The history of state-sponsored hacking.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(139, 'Database Internals', 'Alex Petrov', 4, 'How SQL and NoSQL engines work under the hood.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(140, 'The Clean Coder', 'Robert Martin', 4, 'Professionalism for software developers.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(141, 'The Great War', 'Winston S.', 5, 'A detailed account of the First World War.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(142, 'The French Revolution', 'Ian Kershaw', 5, 'Liberty, Equality, and the guillotine.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(143, 'Samurai Spirit', 'Nitobe Inazo', 5, 'The bushido code and the warriors of Japan.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(144, 'The Silk Road', 'Peter Frankopan', 5, 'A new history of the world through trade.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(145, 'Ancient Greece', 'Edith Hall', 5, 'From the Iliad to the birth of democracy.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(146, 'The Vikings', 'Neil Price', 5, 'Explorers, traders, and the myths of Valhalla.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(147, 'Cold War Secrets', 'Ben Macintyre', 5, 'The true stories of the world’s greatest spies.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(148, 'The Renaissance', 'Paul Johnson', 5, 'The era of Da Vinci, Michaelangelo, and art.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(149, 'Aztecs and Mayas', 'Michael Coe', 5, 'The rise and fall of Mesoamerican civilizations.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(150, 'Napoleonic Wars', 'Andrew Roberts', 5, 'The man who tried to conquer all of Europe.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(151, 'The Elf Kingdom', 'J.R.R. Tolkien', 6, 'A journey to the ancient forests of the elves.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(152, 'The Dragon Rider', 'Christopher P.', 6, 'A boy and his dragon against a dark king.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(153, 'Wizard Academy', 'J.K. Rowling', 6, 'Learning magic in a castle hidden from humans.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(154, 'The Orc Hordes', 'Stan Nicholls', 6, 'A story told from the perspective of the orcs.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(155, 'Broken Sword', 'Michael Moorcock', 6, 'An epic tale of gods and ancient weapons.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(156, 'The Vampire Lord', 'Anne Rice', 6, 'Eternal life comes with a very bloody price.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(157, 'Ice and Fire', 'George Martin', 6, 'Politics and war in a world of endless winter.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(158, 'The Necromancer', 'Ursula Le Guin', 6, 'Raising the dead has terrible consequences.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(159, 'Fairy Tales', 'Grimm Brothers', 6, 'The original dark stories from the forest.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(160, 'The Griffin Path', 'Tamora Pierce', 6, 'Mythical creatures return to the human world.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(161, 'The Intelligent Investor', 'Benjamin Graham', 7, 'The definitive book on value investing.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(162, 'Zero to One', 'Peter Thiel', 7, 'How to build companies that create the future.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(163, 'The Hard Thing', 'Ben Horowitz', 7, 'Building a business when there are no easy answers.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(164, 'Think and Grow Rich', 'Napoleon Hill', 7, 'The philosophy of success and wealth.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(165, 'Blue Ocean Strategy', 'W. Chan Kim', 7, 'How to create uncontested market space.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(166, 'The 4-Hour Workweek', 'Tim Ferriss', 7, 'Escape the 9-5 and live anywhere.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(167, 'Rich Dad Poor Dad', 'Robert Kiyosaki', 7, 'What the rich teach their kids about money.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(168, 'Shoe Dog', 'Phil Knight', 7, 'A memoir by the creator of Nike.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(169, 'Atomic Habits', 'James Clear', 7, 'Small changes that lead to remarkable results.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0),
	(170, 'The Psychology of Money', 'Morgan Housel', 7, 'Timeless lessons on wealth and greed.', 'covers/generic-book.png', 'pdfs/generic-book.pdf', 0);

-- Dumping structure for table bookify_db.my_list
DROP TABLE IF EXISTS `my_list`;
CREATE TABLE IF NOT EXISTS `my_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_book` (`user_id`,`book_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `my_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilizadores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `my_list_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `livros` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bookify_db.my_list: ~2 rows (approximately)
INSERT INTO `my_list` (`id`, `user_id`, `book_id`, `added_at`) VALUES
	(1, 4, 9, '2026-02-04 03:43:58'),
	(2, 5, 23, '2026-02-05 00:22:26'),
	(3, 5, 24, '2026-02-05 13:17:13'),
	(4, 5, 19, '2026-02-05 16:06:20');

-- Dumping structure for table bookify_db.utilizadores
DROP TABLE IF EXISTS `utilizadores`;
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_registo` timestamp NOT NULL DEFAULT (now()),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bookify_db.utilizadores: ~5 rows (approximately)
INSERT INTO `utilizadores` (`id`, `nome`, `email`, `senha`, `data_registo`) VALUES
	(1, 'Kessyane', 'kessyaneloureiro@gmail.com', '$2y$10$q3LTttWsgCPS2Jxgtak53eoHRbaSYBbsVNlCDu7DsPfM6wIlu3aFq', '2025-12-16 14:52:36'),
	(2, 'Jean', 'jean@gmail.com', '$2y$10$lesMv.h0aPTfZSX9mgZwSuunjwA4kAhk5ZvzFFLJd.1SI0naj6F5O', '2026-01-20 23:20:44'),
	(3, 'Clenilson', 'clenia003@gmail.com', '$2y$10$D3DkAS3f1172p/mA/Nwcqeifaoci0sYQTBYzddWzWZRsJ.UPO8RbC', '2026-01-22 10:04:36'),
	(4, 'Kessyane', 'kessyane@gmail.com', '$2y$10$M5iLkp8OBIbZhlVsT6k4NuXZbfEBC8Bdcgq0f71Ls/V9qlr06MmTi', '2026-02-04 03:35:00'),
	(5, 'ADM', 'admin@bookify.com', '$2y$10$S96pyCCimLiblufzcXdKiepQ8Fzdnlc7r9sf8bC4xBF3bgO2zUsCq', '2026-02-05 00:22:08');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
