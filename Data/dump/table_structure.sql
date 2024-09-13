-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-db:3306
-- Generation Time: Mar 27, 2024 at 02:13 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ct07_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`ad_db_ct07`@`%` PROCEDURE `GenerateRandomRatings` ()   BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE rand_user_id INT;
    DECLARE rand_recipe_id INT;
    DECLARE rand_rating INT;
    
    WHILE i <= 100 DO
        -- Chọn ngẫu nhiên user_id từ 1 đến 4
        SET rand_user_id = FLOOR(RAND() * 4) + 1;
        
        -- Chọn ngẫu nhiên recipe_id từ 1 đến 32
        SET rand_recipe_id = FLOOR(RAND() * 32) + 1;
        
        -- Chọn ngẫu nhiên rating từ 1 đến 5
        SET rand_rating = FLOOR(RAND() * 5) + 1;
        
        -- Chèn dữ liệu vào bảng recipe_ratings
        INSERT INTO recipe_ratings (recipe_id, user_id, rating)
        VALUES (rand_recipe_id, rand_user_id, rand_rating);
        
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActive` tinyint(1) DEFAULT '1',
  `category` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `measurement_unit` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `isActive`, `category`, `measurement_unit`) VALUES
(1, 'Chicken Breast', 1, 'FRU', 'CUP'),
(2, 'Mixed Vegetables', 1, 'VEGI', 'G'),
(3, 'Soy Sauce', 0, 'OTHR', 'TBSP'),
(4, 'Cornstarch', 1, 'OTHR', 'TBSP'),
(5, 'Shrimp', 1, 'MSF', 'G'),
(6, 'Cucumber', 0, 'VEGI', 'UNIT'),
(7, 'Lime Juice', 0, 'OTHR', 'TBSP'),
(8, 'Chili Pepper', 1, 'HRBS', 'UNIT'),
(9, 'Black Beans', 0, 'PRP', 'CAN'),
(10, 'Corn', 1, 'VEGI', 'CUP'),
(11, 'Tomato', 1, 'VEGI', 'UNIT'),
(12, 'Cilantro', 1, 'HRBS', 'CUP'),
(13, 'Onion', 1, 'VEGI', 'UNIT'),
(14, 'Lime Juice', 1, 'OTHR', 'TBSP'),
(16, 'Eggplant', 1, 'VEGI', 'UNIT'),
(17, 'Tahini', 1, 'OTHR', 'TBSP'),
(18, 'Garlic', 1, 'HRBS', 'UNIT'),
(19, 'Lemon Juice', 1, 'OTHR', 'TBSP'),
(20, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(26, 'Pickle', 1, 'OTHR', 'UNIT'),
(27, 'Flour', 1, 'OTHR', 'CUP'),
(28, 'Breadcrumbs', 1, 'OTHR', 'CUP'),
(29, 'Egg', 1, 'OTHR', 'UNIT'),
(30, 'Cajun Seasoning', 1, 'OTHR', 'TBSP'),
(31, 'Black Beans (cooked)', 1, 'OTHR', 'CUP'),
(32, 'Corn', 1, 'OTHR', 'CUP'),
(33, 'Tomato (diced)', 1, 'VEGI', 'UNIT'),
(34, 'Red Onion (diced)', 1, 'VEGI', 'UNIT'),
(35, 'Cilantro (chopped)', 1, 'HRBS', 'CUP'),
(36, 'Avocado (diced)', 1, 'VEGI', 'UNIT'),
(37, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(38, 'Lime (juiced)', 1, 'OTHR', 'UNIT'),
(39, 'Garlic (minced)', 1, 'OTHR', 'TSP'),
(40, 'Cumin', 1, 'OTHR', 'TSP'),
(41, 'Salt', 1, 'OTHR', 'TSP'),
(42, 'Pepper', 1, 'OTHR', 'TSP'),
(43, 'Salmon (canned, drained)', 1, 'MSF', 'CAN'),
(44, 'Egg (beaten)', 1, 'OTHR', 'UNIT'),
(45, 'Breadcrumbs', 1, 'OTHR', 'CUP'),
(46, 'Onion (diced)', 1, 'VEGI', 'UNIT'),
(47, 'Parsley (chopped)', 1, 'HRBS', 'CUP'),
(48, 'Lemon Juice', 1, 'OTHR', 'TBSP'),
(49, 'Dijon Mustard', 1, 'OTHR', 'TBSP'),
(50, 'Salt', 1, 'OTHR', 'TSP'),
(51, 'Pepper', 1, 'OTHR', 'TSP'),
(52, 'Oil (for frying)', 1, 'OTHR', 'CUP'),
(60, 'Egg (hard-cooked and chopped)', 1, 'OTHR', 'UNIT'),
(61, 'Mayonnaise', 1, 'OTHR', 'CUP'),
(62, 'Mustard', 1, 'OTHR', 'TSP'),
(63, 'Celery (diced)', 1, 'VEGI', 'UNIT'),
(64, 'Chives (chopped)', 1, 'HRBS', 'TBSP'),
(65, 'Salt', 1, 'OTHR', 'TSP'),
(66, 'Pepper', 1, 'OTHR', 'TSP'),
(72, 'Potatoes (mashed)', 1, 'VEGI', 'UNIT'),
(73, 'Ground Beef', 1, 'MSF', 'LB'),
(74, 'Onion (chopped)', 1, 'VEGI', 'UNIT'),
(75, 'Garlic (minced)', 1, 'HRBS', 'TBSP'),
(76, 'Spices (e.g., paprika, cumin)', 1, 'OTHR', 'TSP'),
(77, 'Phyllo Pastry Sheets', 1, 'OTHR', 'UNIT'),
(78, 'Butter (melted)', 1, 'OTHR', 'TBSP'),
(79, 'Cheese (mozzarella)', 1, 'MSF', 'OZ'),
(80, 'Breadcrumbs', 1, 'OTHR', 'CUP'),
(81, 'Parmesan Cheese (grated)', 1, 'OTHR', 'CUP'),
(82, 'Egg', 1, 'OTHR', 'UNIT'),
(83, 'Italian Seasoning', 1, 'OTHR', 'TSP'),
(84, 'Jalapenos', 1, 'VEGI', 'UNIT'),
(85, 'Cream Cheese', 1, 'OTHR', 'OZ'),
(86, 'Bacon', 1, 'OTHR', 'UNIT'),
(87, 'Ground Turkey', 1, 'MSF', 'LB'),
(88, 'Onion (diced)', 1, 'OTHR', 'UNIT'),
(89, 'Garlic (minced)', 1, 'HRBS', 'TBSP'),
(90, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(91, 'Chili Powder', 1, 'OTHR', 'OZ'),
(92, 'Cumin', 1, 'OTHR', 'TBSP'),
(93, 'Paprika', 1, 'OTHR', 'TBSP'),
(94, 'Diced Tomatoes', 1, 'OTHR', 'CAN'),
(95, 'Tomato Sauce', 1, 'OTHR', 'CAN'),
(96, 'Kidney Beans', 1, 'OTHR', 'CAN'),
(97, 'Minced Chicken', 1, 'MSF', 'LB'),
(98, 'Onion (diced)', 1, 'OTHR', 'CUP'),
(99, 'Carrots (diced)', 1, 'HRBS', 'CUP'),
(100, 'Water Chestnuts (sliced)', 1, 'VEGI', 'CUP'),
(101, 'Soy Sauce', 1, 'OTHR', 'TBSP'),
(102, 'Hoisin Sauce', 1, 'OTHR', 'TBSP'),
(103, 'Sesame Oil', 1, 'OTHR', 'TBSP'),
(104, 'Green Onions (chopped)', 1, 'HRBS', 'TBSP'),
(105, 'Couscous', 1, 'OTHR', 'CUP'),
(106, 'Dried Cranberries', 1, 'FRU', 'CUP'),
(107, 'Orange (segments)', 1, 'FRU', 'UNIT'),
(108, 'Parsley (chopped)', 1, 'HRBS', 'CUP'),
(109, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(110, 'Orange Juice', 1, 'FRU', 'TBSP'),
(111, 'Lemon Juice', 1, 'FRU', 'TBSP'),
(112, 'Honey', 1, 'OTHR', 'TBSP'),
(113, 'Salt', 1, 'OTHR', 'TSP'),
(114, 'Pepper', 1, 'OTHR', 'TSP'),
(118, 'Ground Turkey', 1, 'MSF', 'LB'),
(119, 'Breadcrumbs', 1, 'OTHR', 'CUP'),
(120, 'Onion (chopped)', 1, 'VEGI', 'UNIT'),
(121, 'Garlic (minced)', 1, 'HRBS', 'TBSP'),
(122, 'Ketchup', 1, 'OTHR', 'TBSP'),
(123, 'Worcestershire Sauce', 1, 'OTHR', 'TBSP'),
(124, 'Egg', 1, 'OTHR', 'UNIT'),
(125, 'Salt', 1, 'OTHR', 'TSP'),
(126, 'Pepper', 1, 'OTHR', 'TSP'),
(131, 'Cooked Chicken Breast', 1, 'MSF', 'LB'),
(132, 'Celery (diced)', 1, 'VEGI', 'CUP'),
(133, 'Red Onion (diced)', 1, 'VEGI', 'UNIT'),
(134, 'Fresh Parsley (chopped)', 1, 'HRBS', 'CUP'),
(135, 'Grapes (halved)', 1, 'FRU', 'CUP'),
(136, 'Mayonnaise', 1, 'OTHR', 'CUP'),
(137, 'Greek Yogurt', 1, 'OTHR', 'CUP'),
(138, 'Lemon Juice', 1, 'OTHR', 'TBSP'),
(139, 'Dijon Mustard', 1, 'OTHR', 'TBSP'),
(140, 'Salt', 1, 'OTHR', 'TSP'),
(141, 'Pepper', 1, 'OTHR', 'TSP'),
(146, 'Cooked Lentils', 1, 'PRP', 'CUP'),
(147, 'Garbanzo Beans (drained and rinsed)', 1, 'PRP', 'CAN'),
(148, 'Cucumber (diced)', 1, 'VEGI', 'CUP'),
(149, 'Red Bell Pepper (diced)', 1, 'VEGI', 'CUP'),
(150, 'Fresh Cilantro (chopped)', 1, 'HRBS', 'CUP'),
(151, 'Green Onion (sliced)', 1, 'VEGI', 'UNIT'),
(152, 'Olive Oil', 1, 'OTHR', 'CUP'),
(153, 'Lemon Juice', 1, 'OTHR', 'CUP'),
(154, 'Dijon Mustard', 1, 'OTHR', 'TBSP'),
(155, 'Minced Garlic', 1, 'OTHR', 'TBSP'),
(156, 'Salt', 1, 'OTHR', 'TSP'),
(157, 'Pepper', 1, 'OTHR', 'TSP'),
(158, 'Shrimp (peeled and deveined)', 1, 'MSF', 'LB'),
(159, 'Bell Pepper (sliced)', 1, 'VEGI', 'UNIT'),
(160, 'Onion (sliced)', 1, 'VEGI', 'UNIT'),
(161, 'Garlic (minced)', 1, 'HRBS', 'TBSP'),
(162, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(163, 'Cajun Seasoning', 1, 'OTHR', 'OZ'),
(164, 'Diced Tomatoes', 1, 'OTHR', 'CAN'),
(165, 'Tomato Sauce', 1, 'OTHR', 'CAN'),
(166, 'Pasta', 1, 'OTHR', 'CUP'),
(167, 'Parsley (chopped)', 1, 'HRBS', 'TBSP'),
(168, 'Chicken Breast (diced)', 1, 'MSF', 'LB'),
(169, 'Asparagus Spears', 1, 'VEGI', 'LB'),
(170, 'Ziti Pasta', 1, 'OTHR', 'LB'),
(171, 'Alfredo Sauce', 1, 'OTHR', 'CUP'),
(172, 'Olive Oil', 1, 'OTHR', 'CUP'),
(173, 'Parmesan Cheese (grated)', 1, 'OTHR', 'TBSP'),
(174, 'Marinara Sauce', 1, 'OTHR', 'CUP'),
(175, 'Milk', 1, 'OTHR', 'CUP'),
(176, 'Cheddar Cheese (shredded)', 1, 'OTHR', 'CUP'),
(177, 'Red Bell Pepper (diced)', 1, 'VEGI', 'CUP'),
(178, 'Red Onion (sliced)', 1, 'VEGI', 'CUP'),
(179, 'Olive Oil', 1, 'OTHR', 'CUP'),
(180, 'Red Wine Vinegar', 1, 'OTHR', 'CUP'),
(181, 'Dijon Mustard', 1, 'OTHR', 'TBSP'),
(182, 'Honey', 1, 'OTHR', 'TBSP'),
(183, 'Fresh Parsley (chopped)', 1, 'OTHR', 'TBSP'),
(184, 'Bell Peppers (large)', 1, 'VEGI', 'UNIT'),
(185, 'Quinoa (cooked)', 1, 'OTHR', 'CUP'),
(186, 'Black Beans (cooked)', 1, 'VEGI', 'CUP'),
(187, 'Corn Kernels (cooked)', 1, 'VEGI', 'CUP'),
(188, 'Cilantro (chopped)', 1, 'HRBS', 'TBSP'),
(197, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(198, 'Diced Onions', 1, 'VEGI', 'CUP'),
(199, 'Diced Bell Peppers', 1, 'VEGI', 'CUP'),
(200, 'Minced Garlic', 1, 'VEGI', 'TBSP'),
(201, 'Black Beans (drained and rinsed)', 1, 'OTHR', 'CAN'),
(202, 'Corn', 1, 'VEGI', 'CUP'),
(203, 'Diced Tomatoes', 1, 'VEGI', 'CUP'),
(204, 'Taco Seasoning', 1, 'OTHR', 'TBSP'),
(205, 'Tortillas', 1, 'OTHR', 'UNIT'),
(206, 'Shredded Lettuce', 1, 'VEGI', 'CUP'),
(207, 'Apples', 1, 'FRU', 'UNIT'),
(208, 'Celery', 1, 'VEGI', 'CUP'),
(209, 'Walnuts', 1, 'OTHR', 'CUP'),
(210, 'Raisins', 1, 'OTHR', 'CUP'),
(211, 'Greek Yogurt', 1, 'MSF', 'CUP'),
(212, 'Honey', 1, 'OTHR', 'TBSP'),
(213, 'Lemon Juice', 1, 'FRU', 'TBSP'),
(214, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(215, 'Diced Onions', 1, 'VEGI', 'CUP'),
(216, 'Diced Carrots', 1, 'VEGI', 'CUP'),
(217, 'Diced Celery', 1, 'VEGI', 'CUP'),
(218, 'Minced Garlic', 1, 'OTHR', 'TBSP'),
(219, 'Dried Lentils', 1, 'OTHR', 'CUP'),
(220, 'Crushed Tomatoes', 1, 'OTHR', 'CAN'),
(221, 'Vegetable Broth', 1, 'OTHR', 'CUP'),
(222, 'Italian Seasoning', 1, 'HRBS', 'TSP'),
(223, 'Pasta', 1, 'OTHR', 'UNIT'),
(224, 'Fresh Parsley', 1, 'HRBS', 'TBSP'),
(225, 'Grated Parmesan Cheese', 1, 'OTHR', 'TBSP'),
(226, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(227, 'Diced Onions', 1, 'VEGI', 'CUP'),
(228, 'Diced Bell Peppers', 1, 'VEGI', 'CUP'),
(229, 'Minced Garlic', 1, 'OTHR', 'TBSP'),
(230, 'Ground Beef', 1, 'MSF', 'LB'),
(231, 'Diced Tomatoes', 1, 'OTHR', 'CAN'),
(232, 'Tomato Sauce', 1, 'OTHR', 'CAN'),
(233, 'Sliced Olives', 1, 'OTHR', 'CUP'),
(234, 'Raisins', 1, 'OTHR', 'CUP'),
(235, 'Cumin', 1, 'HRBS', 'TSP'),
(236, 'Paprika', 1, 'HRBS', 'TSP'),
(237, 'Dried Oregano', 1, 'HRBS', 'TSP'),
(238, 'Ground Cinnamon', 1, 'HRBS', 'TSP'),
(239, 'Ground Cloves', 1, 'HRBS', 'TSP'),
(240, 'Salt', 1, 'HRBS', 'TSP'),
(241, 'Black Pepper', 1, 'HRBS', 'TSP'),
(242, 'Rice', 1, 'OTHR', 'UNIT'),
(243, 'Fresh Parsley', 1, 'HRBS', 'TBSP'),
(244, 'Lentils', 1, 'OTHR', 'CUP'),
(245, 'Diced Tomatoes', 1, 'VEGI', 'CUP'),
(246, 'Diced Cucumbers', 1, 'VEGI', 'CUP'),
(247, 'Chopped Red Onion', 1, 'VEGI', 'CUP'),
(248, 'Crumbled Feta Cheese', 1, 'VEGI', 'CUP'),
(249, 'Chopped Parsley', 1, 'HRBS', 'CUP'),
(250, 'Olive Oil', 1, 'OTHR', 'CUP'),
(251, 'Lemon Juice', 1, 'OTHR', 'CUP'),
(252, 'Red Wine Vinegar', 1, 'OTHR', 'CUP'),
(253, 'Minced Garlic', 1, 'OTHR', 'TBSP'),
(254, 'Dried Oregano', 1, 'HRBS', 'TSP'),
(255, 'Salt', 1, 'HRBS', 'TSP'),
(256, 'Black Pepper', 1, 'HRBS', 'TSP'),
(257, 'Cheese Tortellini', 1, 'OTHR', 'LB'),
(258, 'Cherry Tomatoes (halved)', 1, 'VEGI', 'CUP'),
(259, 'Baby Spinach Leaves', 1, 'VEGI', 'CUP'),
(260, 'Sliced Red Onions', 1, 'VEGI', 'CUP'),
(261, 'Olive Oil', 1, 'OTHR', 'CUP'),
(262, 'Lemon Juice', 1, 'OTHR', 'CUP'),
(263, 'Minced Garlic', 1, 'HRBS', 'TBSP'),
(264, 'Salt', 1, 'OTHR', 'TSP'),
(265, 'Black Pepper', 1, 'OTHR', 'TSP'),
(266, 'Turkey Cutlets', 1, 'MSF', 'UNIT'),
(267, 'Sliced Zucchini', 1, 'VEGI', 'CUP'),
(268, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(269, 'Salt', 1, 'OTHR', 'TSP'),
(270, 'Black Pepper', 1, 'OTHR', 'TSP'),
(271, 'Italian Seasoning', 1, 'HRBS', 'TSP'),
(272, 'Pasta (rotini or penne)', 1, 'VEGI', 'CUP'),
(273, 'Tomatoes (diced)', 1, 'VEGI', 'CUP'),
(274, 'Cucumbers (sliced)', 1, 'VEGI', 'CUP'),
(275, 'Bell Peppers (chopped)', 1, 'VEGI', 'CUP'),
(276, 'Black Olives', 1, 'VEGI', 'CUP'),
(277, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(278, 'Red Wine Vinegar', 1, 'OTHR', 'TBSP'),
(279, 'Dijon Mustard', 1, 'OTHR', 'TSP'),
(281, 'Salt', 1, 'OTHR', 'TSP'),
(282, 'Black Pepper', 1, 'OTHR', 'TSP'),
(283, 'Parsley (chopped)', 1, 'VEGI', 'TBSP'),
(284, 'Canned Tuna', 1, 'MSF', 'CAN'),
(285, 'Mayonnaise', 1, 'OTHR', 'CUP'),
(286, 'Celery (chopped)', 1, 'VEGI', 'CUP'),
(287, 'Onion (diced)', 1, 'VEGI', 'CUP'),
(288, 'Shredded Carrots', 1, 'VEGI', 'CUP'),
(289, 'Tortilla', 1, 'OTHR', 'UNIT'),
(290, 'Mayonnaise', 1, 'OTHR', 'CUP'),
(291, 'Sweet Chili Sauce', 1, 'OTHR', 'TBSP'),
(292, 'Sriracha', 1, 'OTHR', 'TSP'),
(293, 'Shrimp (peeled and deveined)', 1, 'MSF', 'LB'),
(294, 'Vegetable Oil', 1, 'OTHR', 'TBSP'),
(295, 'Mixed Greens', 1, 'VEGI', 'CUP'),
(296, 'Cucumbers (sliced)', 1, 'VEGI', 'CUP'),
(297, 'Shredded Carrots', 1, 'VEGI', 'CUP'),
(298, 'Green Onions (chopped)', 1, 'VEGI', 'CUP'),
(299, 'Ground Turkey', 1, 'MSF', 'LB'),
(300, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(301, 'Garlic (minced)', 1, 'OTHR', 'UNIT'),
(302, 'Salt', 1, 'OTHR', 'TSP'),
(303, 'Black Pepper', 1, 'OTHR', 'TSP'),
(304, 'Italian Seasoning', 1, 'HRBS', 'TSP'),
(305, 'Marinara Sauce', 1, 'OTHR', 'CUP'),
(306, 'Penne Pasta', 1, 'MSF', 'LB'),
(307, 'Beef (sliced)', 1, 'MSF', 'LB'),
(308, 'Green Beans (trimmed and sliced)', 1, 'VEGI', 'LB'),
(309, 'Onion (sliced)', 1, 'OTHR', 'UNIT'),
(310, 'Soy Sauce', 1, 'OTHR', 'TBSP'),
(311, 'Sesame Oil', 1, 'OTHR', 'TBSP'),
(312, 'Cornstarch', 1, 'OTHR', 'TBSP'),
(313, 'Salt', 1, 'OTHR', 'TSP'),
(314, 'Black Pepper', 1, 'OTHR', 'TSP'),
(315, 'Chicken Breasts', 1, 'MSF', 'LB'),
(316, 'Bell Peppers (sliced)', 1, 'VEGI', 'UNIT'),
(317, 'Onion (sliced)', 1, 'VEGI', 'UNIT'),
(318, 'Olive Oil', 1, 'OTHR', 'TBSP'),
(319, 'Chili Powder', 1, 'OTHR', 'TSP'),
(320, 'Cumin', 1, 'OTHR', 'TSP'),
(321, 'Garlic Powder', 1, 'OTHR', 'TSP'),
(322, 'Salt', 1, 'OTHR', 'TSP'),
(323, 'Black Pepper', 1, 'OTHR', 'TSP'),
(324, 'Tortillas', 1, 'MSF', 'UNIT'),
(375, 'ac', 1, 'FAO', 'OZ'),
(376, 'abv', 1, 'FAO', 'OZ'),
(381, '2121', 1, 'FAO', 'G'),
(383, '2121', 1, 'FAO', 'G'),
(384, '2323212', 1, 'FAO', 'CAN');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_categories`
--

CREATE TABLE `ingredient_categories` (
  `id` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `detail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredient_categories`
--

INSERT INTO `ingredient_categories` (`id`, `detail`) VALUES
('EMMP', 'Eggs, milk and milk products'),
('FAO', 'Fats and oils'),
('FRU', 'Fruits'),
('GNBK', 'Grain, nuts and baking products'),
('HRBS', 'Herbs and spices'),
('MSF', 'Meat, sausages and fish'),
('OTHR', 'Others'),
('PRP', 'Pasta, rice and pulses'),
('VEGI', 'Vegetables');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_measurement_unit`
--

CREATE TABLE `ingredient_measurement_unit` (
  `id` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `detail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ingredient_measurement_unit`
--

INSERT INTO `ingredient_measurement_unit` (`id`, `detail`) VALUES
('CAN', 'cans'),
('CUP', 'cups'),
('G', 'grams'),
('LB', 'pounds'),
('OZ', 'ounces'),
('TBSP', 'tablespoons'),
('TSP', 'teaspoons'),
('UNIT', 'units');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_nutritions`
--

CREATE TABLE `ingredient_nutritions` (
  `ingredient_id` int NOT NULL,
  `nutrition_id` varchar(6) NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ingredient_nutritions`
--

INSERT INTO `ingredient_nutritions` (`ingredient_id`, `nutrition_id`, `quantity`) VALUES
(381, 'CAL', 12),
(381, 'CALC', 121),
(381, 'CARB', 2121),
(381, 'CHOL', 212),
(381, 'FE', 212),
(381, 'FIB', 2121),
(381, 'MUFAT', 1211),
(383, 'CAL', 212),
(383, 'CALC', 12121),
(383, 'CARB', 21),
(384, 'CAL', 323),
(384, 'CALC', 2323),
(384, 'CARB', 232),
(384, 'CHOL', 3232),
(384, 'FAT', 3232),
(384, 'FE', 2323),
(384, 'FIB', 23232),
(384, 'MUFAT', 2),
(384, 'NA', 2323),
(384, 'POT', 232),
(384, 'PRO', 2323);

-- --------------------------------------------------------

--
-- Table structure for table `nutrition_types`
--

CREATE TABLE `nutrition_types` (
  `id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `detail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nutrition_types`
--

INSERT INTO `nutrition_types` (`id`, `detail`) VALUES
('CAL', 'Calories'),
('CALC', 'Calcium'),
('CARB', 'Carbohydrates'),
('CHOL', 'Cholesterol'),
('FAT', 'Fat'),
('FE', 'Iron'),
('FIB', 'Fiber'),
('MUFAT', 'Monounsaturated Fat'),
('NA', 'Sodium'),
('POT', 'Potassium'),
('PRO', 'Protein'),
('PUFAT', 'Polyunsaturated Fat'),
('SATFAT', 'Saturated Fat'),
('SUG', 'Sugar'),
('VITA', 'Vitamin A'),
('VITC', 'Vitamin C');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `user_id` int NOT NULL,
  `recipe_id` int NOT NULL,
  `isActive` tinyint(1) DEFAULT '1',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `preparation_time` int DEFAULT NULL,
  `cooking_time` int DEFAULT NULL,
  `directions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course` int DEFAULT NULL,
  `meal` int DEFAULT NULL,
  `method` int DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`user_id`, `recipe_id`, `isActive`, `name`, `description`, `image_url`, `preparation_time`, `cooking_time`, `directions`, `course`, `meal`, `method`, `timestamp`) VALUES
(1, 1, 1, 'Chicken Stir Fly', '  Delicious chicken stir fry with mixed vegetable1', 'huyzh3gb.png', 12, 20, '1. Marinate chicken with soy sauce and cornstarch.\r\n2. Stir fry chicken until cooked.\r\n3. Add mixed vegetables and stir fry until tender.\r\n4. Serve hot with rice.', 1, 1, 1, '2024-03-21 09:16:24'),
(1, 2, 0, 'Cucumber and Shrimp Aguachile', '  Delicious chicken stir fry with mixed vegetabw', '07thgnst.jpg', 15, 10, '1. Clean and devein shrimp.\r\n2. Slice cucumbers thinly.\r\n3. Mix shrimp, cucumber slices, lime juice, and chili peppers in a bowl.\r\n4. Let marinate in the refrigerator for 15 minutes.\r\n5. Serve chilled.', 1, 1, 1, '2024-03-21 09:16:24'),
(3, 3, 1, 'Chicken Breast', '  taodeptrai', '07thgnst.jpg', 43, 24, '1. Clean and devein shrimp.\r\n2. Slice cucumbers thinly.\r\n3. Mix shrimp, cucumber slices, lime juice, and chili peppers in a bowl.\r\n4. Let marinate in the refrigerator for 15 minutes.\r\n5. Serve chilled.', 1, 1, 1, '2024-03-21 10:07:19'),
(1, 4, 0, 'Baba Ganoush', 'Roasted eggplant mash with tahini, lemon juice, olive oil, and garlic.', 'yzpvtzq8.png', 30, 15, '1. Roast eggplant in the oven until tender and blackened.\n2. Scoop out the flesh and mash it with tahini, lemon juice, olive oil, and garlic.\n3. Season with salt and pepper to taste.\n4. Serve with pita bread or vegetables.', 1, 1, 7, '2024-03-21 09:16:24'),
(1, 5, 1, 'Crispy Cajun Pickle Chips', ' Delicious crispy Cajun-flavored pickle chips, perfect as a snack or side dish.', '09aa3u2j.jpg', 10, 20, '1. Preheat the oven to 400°F (200°C).\r\n2. Slice the pickles into thin chips.\r\n3. In a bowl, mix flour, Cajun seasoning, and breadcrumbs.\r\n4. Dip pickle chips in beaten egg, then coat with breadcrumb mixture.\r\n5. Place coated pickle chips on a baking sheet.\r\n6. Bake in the preheated oven until golden brown and crispy, about 15-20 minutes.\r\n7. Serve hot and enjoy!', 1, 1, 1, '2024-03-21 09:16:24'),
(1, 6, 1, 'Black Bean and Corn Salad', 'A refreshing salad featuring black beans and sweet corn, perfect for a healthy side dish or light meal.', '7volhb7v.jpg', 15, 24, '1. In a large bowl, combine black beans, corn, diced tomatoes, diced red onion, chopped cilantro, and avocado.\n2. In a small bowl, whisk together olive oil, lime juice, minced garlic, cumin, salt, and pepper to make the dressing.\n3. Pour the dressing over the salad ingredients and toss gently to coat.\n4. Chill the salad in the refrigerator for at least 30 minutes before serving.\n5. Serve cold and enjoy!', 3, 2, 3, '2024-03-21 09:16:24'),
(1, 7, 1, 'Salmon Patties', 'Delicious and flavorful salmon patties, perfect for a light meal or appetizer.', '4cm7v3yn.png', 15, 15, '1. Drain and flake the canned salmon.\n2. In a mixing bowl, combine flaked salmon, beaten eggs, breadcrumbs, diced onion, chopped parsley, lemon juice, Dijon mustard, salt, and pepper.\n3. Mix well until thoroughly combined.\n4. Form the mixture into patties of desired size.\n5. Heat oil in a skillet over medium heat.\n6. Fry the salmon patties until golden brown and cooked through, about 3-4 minutes per side.\n7. Remove from the skillet and drain on paper towels.\n8. Serve hot with your favorite dipping sauce or side dishes.', 1, 3, 4, '2024-03-21 09:16:24'),
(4, 8, 1, 'Homemade Ratatouille', 'This delicious summer vegetable stew is truly something. If you love fresh vegetables, grab them from your farmer’s market and plan on making this best ratatouille recipe ASAP. It’s rich and satisfying, yet wonderfully healthy. Be sure to pick up French bread to go with this iconic French dish!', '4cm7v3yn.png', 14, 24, '1. Drain and flake the canned salmon.\n2. In a mixing bowl, combine flaked salmon, beaten eggs, breadcrumbs, diced onion, chopped parsley, lemon juice, Dijon mustard, salt, and pepper.\n3. Mix well until thoroughly combined.\n4. Form the mixture into patties of desired size.\n5. Heat oil in a skillet over medium heat.\n6. Fry the salmon patties until golden brown and cooked through, about 3-4 minutes per side.\n7. Remove from the skillet and drain on paper towels.\n8. Serve hot with your favorite dipping sauce or side dishes.', 1, 2, 7, '2024-03-21 10:09:07'),
(1, 9, 0, 'Egg Salad', 'A simple and tasty egg salad, perfect for sandwiches or as a side dish.', 'ojyw9t2p.jpg', 10, 10, '1. Boil the eggs until hard-cooked, then peel and chop them.\n2. In a mixing bowl, combine the chopped eggs, mayonnaise, mustard, diced celery, chopped chives, salt, and pepper.\n3. Mix well until all ingredients are evenly distributed.\n4. Refrigerate the egg salad for at least 30 minutes before serving to allow the flavors to meld.\n5. Serve as a sandwich filling, on crackers, or as a side dish. Enjoy!', 3, 1, 1, '2024-03-21 09:16:24'),
(2, 10, 1, 'The Perfect Medium Steak Recipe', 'My family loves it when I make their steaks medium. They come out just right and if you blindfolded us, we’d never believe we were eating steaks cooked at home. This is how you make steak if you want it to taste like those big steakhouses do it!', 'waifu_jasmin.jpg', 21, 42, 'After patting your steaks dry, season them with the salt and pepper on both sides. Heat your cast iron skillet with your oil over medium-high, then pop the steaks in when the oil is hot. Sear for 3 to 4 minutes per side and don’t forget the edges (about a minute on those). Turn heat down to medium and add the butter, herbs, and garlic, spooning that sauce over the steaks until the internal temperature is 135F. Remove from heat and cover for 10 minutes to let them rest and arrive at a perfect medium steak temperature of 145F.', 1, 4, 2, '2024-03-21 10:14:58'),
(1, 11, 1, 'Triangles with Potato and Beef', 'Delicious triangles filled with a savory mixture of potatoes and beef, perfect as a snack or appetizer.', '3z66ao3w.jpg', 30, 40, '1. Boil the potatoes until tender, then mash them.\n2. In a skillet, cook the ground beef until browned. Drain excess fat.\n3. Add onion, garlic, and spices to the skillet with the beef. Cook until onion is softened.\n4. Combine the mashed potatoes with the cooked beef mixture.\n5. Lay out the phyllo pastry sheets and cut them into triangles.\n6. Place a spoonful of the potato and beef mixture onto each triangle.\n7. Fold the pastry over the filling to form a triangle shape.\n8. Brush the triangles with melted butter.\n9. Bake in a preheated oven at 375°F (190°C) until golden brown, about 20-25 minutes.\n10. Serve hot and enjoy!', 2, 3, 7, '2024-03-21 09:16:24'),
(1, 12, 1, 'Cheese Sticks', 'Delicious crispy cheese sticks, perfect as an appetizer or snack.', 'd2gol6y5.jpg', 15, 20, '1. Preheat the oven to 375°F (190°C).\n2. Cut the cheese into sticks.\n3. In a bowl, whisk together breadcrumbs, grated Parmesan cheese, and Italian seasoning.\n4. Dip each cheese stick in beaten egg, then coat with breadcrumb mixture.\n5. Place coated cheese sticks on a baking sheet lined with parchment paper.\n6. Bake in the preheated oven until golden brown and crispy, about 15-20 minutes.\n7. Serve hot with marinara sauce for dipping, if desired.', 3, 2, 6, '2024-03-21 09:16:24'),
(1, 13, 1, 'Jalapeno Bites', 'Spicy jalapeno bites stuffed with cheese, perfect as an appetizer or snack.', 'sc6daczv.jpg', 20, 15, '1. Preheat the oven to 375°F (190°C).\n2. Cut jalapenos in half lengthwise and remove seeds.\n3. Fill each jalapeno half with cream cheese.\n4. Wrap each jalapeno with a slice of bacon.\n5. Place jalapeno bites on a baking sheet lined with parchment paper.\n6. Bake in the preheated oven until bacon is crispy and jalapenos are tender, about 15 minutes.\n7. Serve hot and enjoy!', 3, 1, 7, '2024-03-21 09:16:24'),
(1, 14, 1, 'Turkey Chili', 'Hearty and flavorful chili made with ground turkey, beans, and spices.', 'jthgyiwv.png', 15, 30, '1. Heat olive oil in a large pot over medium heat.\n2. Add diced onions and garlic, cook until softened.\n3. Add ground turkey, cook until browned.\n4. Stir in chili powder, cumin, and paprika.\n5. Add diced tomatoes, tomato sauce, and kidney beans.\n6. Season with salt and pepper to taste.\n7. Simmer for 20-25 minutes, stirring occasionally.\n8. Serve hot with your favorite toppings and enjoy!', 2, 2, 2, '2024-03-21 09:16:24'),
(1, 15, 1, 'Chicken Lettuce Cups', 'Delicious and light chicken lettuce cups filled with seasoned chicken, vegetables, and sauces.', 'tcoq4nha.png', 20, 15, '1. Heat olive oil in a pan over medium heat.\n2. Add minced chicken and cook until no longer pink.\n3. Stir in diced onions, carrots, and water chestnuts. Cook until vegetables are tender.\n4. Add soy sauce, hoisin sauce, and sesame oil. Stir to combine.\n5. Season with salt and pepper to taste.\n6. Spoon chicken mixture into lettuce leaves.\n7. Garnish with chopped green onions and serve.\n8. Enjoy!', 3, 3, 4, '2024-03-21 09:16:24'),
(1, 16, 1, 'Couscous Cranberry Orange Salad', 'A refreshing and colorful salad made with couscous, cranberries, oranges, and a citrus dressing.', 'zwgwp0gk.png', 15, 10, '1. Cook couscous according to package instructions. Let it cool.\n2. In a large bowl, combine cooked couscous, dried cranberries, orange segments, and chopped parsley.\n3. In a small bowl, whisk together olive oil, orange juice, lemon juice, honey, salt, and pepper to make the dressing.\n4. Pour the dressing over the salad and toss gently to combine.\n5. Chill in the refrigerator for at least 30 minutes before serving.\n6. Serve chilled and enjoy!', 2, 2, 2, '2024-03-21 09:16:24'),
(2, 17, 1, 'Classic Baklava Recipe', 'Baklava holds a special place in my heart for my husband and I traveled through Europe prior to kids and enjoyed this sweet and delicious dessert together. With crispy phyllo soaked in honey and an aroma that smells like heaven, this Baklava recipe is one of my favorite desserts to make the day before any gathering because it keeps well and impresses everyone.', 'tcoq4nha.png', 234, 24, '1. Heat olive oil in a large pot over medium heat.', 3, 2, 4, '2024-03-21 10:10:01'),
(1, 18, 1, 'Turkey Meatloaf', 'A healthier version of classic meatloaf made with lean ground turkey, breadcrumbs, and savory seasonings.', '4p4tb5jj.png', 15, 60, '1. Preheat the oven to 350°F (175°C). Grease a loaf pan.\n2. In a large bowl, mix together ground turkey, breadcrumbs, chopped onion, minced garlic, ketchup, Worcestershire sauce, egg, salt, and pepper until well combined.\n3. Transfer the mixture into the prepared loaf pan, and shape it into a loaf.\n4. Bake in the preheated oven for 45-50 minutes, or until the internal temperature reaches 165°F (75°C).\n5. Let the meatloaf rest for a few minutes before slicing.\n6. Serve slices of meatloaf with your favorite side dishes and enjoy!', 1, 2, 1, '2024-03-21 09:16:24'),
(1, 19, 1, 'The Best Traditional Chili Recipe', 'For the best chili recipe ever, you want something that takes easy-to-find ingredients and puts it all together in one pot. The recipe calls for stove top cooking though you could easily prep this and throw it in your slow cooker or instant pot to come home to after a long day. All you’ll need are some sides and you’ll be golden!', 'waifu_jasmin.jpg', 2, 42, 'Making homemade chili is quite simple. You’ll first need to cook the onions and garlic. Then you’ll add your beef and cook it through. You’ll finally add the peppers and seasonings, stirring it together to get that beautiful flavor together. There is nothing like a real homemade chili recipe to warm you up on a cold day.\r\n\r\nAfter that, you can choose to drain away fat or leave it in for a fuller flavor before adding in the rest of the ingredients and letting it simmer until you can’t stand salivating over the aroma any longer!', 2, 4, 4, '2024-03-21 10:12:36'),
(1, 20, 1, 'Chicken Salad', 'A refreshing salad made with cooked chicken, fresh vegetables, and a creamy dressing.', '3qbxni96.png', 15, 10, '1. In a large bowl, combine cooked chicken, diced celery, diced red onion, chopped fresh parsley, and halved grapes.\n2. In a separate small bowl, mix together mayonnaise, Greek yogurt, lemon juice, Dijon mustard, salt, and pepper to make the dressing.\n3. Pour the dressing over the chicken mixture and toss until well coated.\n4. Serve the chicken salad chilled over a bed of lettuce or in sandwiches, wraps, or on crackers.', 3, 2, 6, '2024-03-21 09:16:24'),
(1, 21, 1, 'Lentil Garbanzo Salad', 'A nutritious salad made with lentils, garbanzo beans, fresh vegetables, and a tangy vinaigrette dressing.', '406g4sbo.png', 20, 10, '1. In a large bowl, combine cooked lentils, drained and rinsed garbanzo beans, diced cucumber, diced red bell pepper, chopped fresh cilantro, and sliced green onions.\n2. In a separate small bowl, whisk together olive oil, lemon juice, Dijon mustard, minced garlic, salt, and pepper to make the dressing.\n3. Pour the dressing over the lentil mixture and toss until well coated.\n4. Serve the salad chilled or at room temperature.', 1, 3, 7, '2024-03-21 09:16:24'),
(1, 22, 1, 'Chickpea and Quinoa Salad', 'A nutritious and delicious salad made with chickpeas, quinoa, and fresh vegetables.', '1l44ovlv.png', 20, 15, '1. Cook quinoa according to package instructions and let it cool.\n2. In a large bowl, combine cooked quinoa, chickpeas, diced cucumber, cherry tomatoes, diced red onion, chopped parsley, and crumbled feta cheese.\n3. In a small bowl, whisk together olive oil, lemon juice, garlic, salt, and pepper to make the dressing.\n4. Pour the dressing over the salad and toss until well combined.\n5. Serve chilled or at room temperature and enjoy!', 2, 3, 3, '2024-03-21 09:16:24'),
(1, 23, 1, 'Cajun Shrimp Pasta', 'Spicy and flavorful pasta dish with Cajun-seasoned shrimp and vegetables.', '2mn2lz7t.png', 20, 20, '1. Cook pasta according to package instructions.\n2. In a large skillet, heat olive oil over medium heat.\n3. Add shrimp and Cajun seasoning, cook until shrimp are pink and cooked through.\n4. Remove shrimp from skillet and set aside.\n5. In the same skillet, add bell peppers, onions, and garlic, cook until softened.\n6. Stir in diced tomatoes, tomato sauce, and cooked pasta.\n7. Add cooked shrimp back to the skillet and toss everything together.\n8. Serve hot and garnish with chopped parsley if desired.', 2, 2, 2, '2024-03-21 09:16:24'),
(1, 24, 1, 'Ziti with Chicken and Asparagus', 'Delicious pasta dish with tender chicken, fresh asparagus, and ziti pasta.', '732bxaw4.png', 15, 25, '1. Cook pasta according to package instructions.\n2. In a large skillet, heat olive oil over medium heat.\n3. Add diced chicken breast, cook until browned and cooked through.\n4. Remove chicken from skillet and set aside.\n5. In the same skillet, add asparagus spears and cook until tender.\n6. Stir in cooked pasta, chicken, and Alfredo sauce.\n7. Season with salt and pepper to taste.\n8. Serve hot and garnish with grated Parmesan cheese if desired.', 1, 2, 1, '2024-03-21 09:16:24'),
(2, 25, 1, 'Homemade Lemon Curd Recipe', 'Lemon curd is delicious, no doubt about it. But making it yourself is better than anything you’ve ever had. Trust me here, once you make it, you’ll find any excuse to make it again and again!', 'waifu_jasmin.jpg', 22, 42, 'You want to place a saucepan of simmering water over medium/medium-low heat and put a heatproof bowl on top of that for a double-broiler effect. Put the egg yolks, sugar, lemon juice, zest, and salt into the heatproof bowl, whisking until thoroughly blended. Keep whisking constantly to keep the yolks from curdling, until the mixture thickens and is like hollandaise sauce in consistency, roughly 10 to 12 minutes. Then take it from the heat. Cut the butter into pieces and whisk it into your lemon curd, then pour it into a glass jar or bowl, add plastic wrap that touches the curd on top and let it cool completely before serving.', 3, 1, 7, '2024-03-21 10:12:36'),
(4, 26, 1, 'Classic New Orleans Gumbo Recipe', 'This is the best gumbo recipe because it’s made with wholesome ingredients. If you’ve ever bought those box kits to make a simple gumbo recipe at home, you can now toss the box and make it fresh yourself.', 'waifu_jasmin.jpg', 24, 15, 'I know the ingredient list looks a little daunting. I’ll admit, it’s long, however, you should have most of those ingredients in your pantry and fridge to begin with so it will all come together quite easily. It does take an hour to prepare but that’s mostly chopping and such. In the end, you get to put your feet up and enjoy the rest of your day off, soon to be better with a bowl full of shrimp and sausage gumbo!', 2, 2, 7, '2024-03-21 10:13:40'),
(1, 27, 1, 'Marinara Mac & Cheese', 'Creamy macaroni and cheese with marinara sauce.', 'xwhgnizp.png', 15, 30, '1. Cook macaroni according to package instructions. Drain and set aside.\n2. In a saucepan, melt butter over medium heat. Stir in flour until smooth. Gradually add milk, stirring constantly until thickened.\n3. Add shredded cheese and stir until melted and smooth.\n4. Mix in cooked macaroni until well coated.\n5. Serve hot topped with marinara sauce and enjoy!', 1, 2, 6, '2024-03-21 09:16:24'),
(1, 28, 1, 'Vegetable Salad with White Beans', 'A refreshing salad made with fresh vegetables and white beans, tossed in a tangy vinaigrette dressing.', 'yhzfq39e.png', 10, 10, '1. In a large mixing bowl, combine white beans, cherry tomatoes, sliced cucumber, diced red bell pepper, and sliced red onion.\n2. In a small bowl, whisk together olive oil, red wine vinegar, Dijon mustard, honey, and chopped fresh parsley to make the dressing.\n3. Pour the dressing over the salad ingredients and toss gently to coat.\n4. Season with salt and pepper to taste.\n5. Serve chilled.\n6. Enjoy!', 2, 2, 1, '2024-03-21 09:16:24'),
(1, 29, 1, 'Vegetarian Stuffed Peppers', 'Delicious vegetarian dish with bell peppers stuffed with a flavorful quinoa and vegetable mixture.', '7toae0nn.png', 10, 20, '1. Preheat the oven to 375°F (190°C).\n2. Cut the tops off the bell peppers and remove the seeds and membranes.\n3. In a large bowl, mix together cooked quinoa, black beans, corn kernels, and chopped cilantro.\n4. Stuff each bell pepper with the quinoa mixture.\n5. Place the stuffed peppers in a baking dish.\n6. Cover the baking dish with aluminum foil and bake for 25-30 minutes, or until the peppers are tender.\n7. Remove the foil and bake for an additional 5 minutes to brown the tops.\n8. Serve hot and enjoy!', 3, 2, 6, '2024-03-21 09:16:24'),
(1, 30, 1, 'Vegetarian Tacos', 'Delicious vegetarian tacos filled with black beans, corn, and bell peppers.', 'ij0zi3nq.png', 15, 20, '1. Heat olive oil in a skillet over medium heat.\n2. Add diced onions, bell peppers, and minced garlic. Cook until softened.\n3. Stir in black beans, corn, diced tomatoes, and taco seasoning. Cook for 5-7 minutes.\n4. Warm tortillas in a separate skillet.\n5. Spoon the bean mixture onto each tortilla.\n6. Top with shredded lettuce.\n7. Serve hot and enjoy!', 1, 1, 7, '2024-03-21 09:16:24'),
(1, 31, 1, 'Vegetarian Waldorf Salad', 'A refreshing and crunchy salad with apples, celery, walnuts, and a creamy dressing.', 'ol58rjg6.png', 15, 10, '1. In a large bowl, combine diced apples, sliced celery, chopped walnuts, and raisins.\n2. In a separate bowl, mix together Greek yogurt, honey, and lemon juice to make the dressing.\n3. Pour the dressing over the salad ingredients and toss until evenly coated.\n4. Serve chilled and enjoy!', 1, 1, 7, '2024-03-21 09:16:24'),
(1, 32, 1, 'Lentil Bolognese', 'A hearty and flavorful vegetarian version of the classic Bolognese sauce made with lentils and tomatoes.', '6mvjq4pk.png', 15, 30, '1. Heat olive oil in a large skillet over medium heat.\n2. Add diced onions, carrots, and celery. Cook until softened.\n3. Stir in minced garlic and cook for another minute.\n4. Add dried lentils, crushed tomatoes, vegetable broth, and Italian seasoning. Bring to a simmer.\n5. Cover and cook for about 20 minutes, or until lentils are tender.\n6. Serve over cooked pasta of your choice.\n7. Garnish with fresh parsley and grated Parmesan cheese if desired.\n8. Enjoy!', 3, 2, 7, '2024-03-21 09:16:24'),
(1, 33, 1, 'Picadillo', 'A traditional Latin American dish made with ground beef, tomatoes, and spices, often served with rice.', '2x1l3hjm.png', 15, 25, '1. Heat olive oil in a skillet over medium heat.\n2. Add diced onions, bell peppers, and minced garlic. Cook until softened.\n3. Add ground beef and cook until browned.\n4. Stir in diced tomatoes, tomato sauce, olives, raisins, and spices.\n5. Simmer for about 15 minutes, or until the flavors meld together.\n6. Serve hot with rice or as desired.\n7. Enjoy!', 3, 2, 5, '2024-03-21 09:16:24'),
(1, 34, 1, 'Mediterranean Lentil Salad', 'A refreshing and nutritious salad featuring lentils, tomatoes, cucumbers, and feta cheese, dressed with a tangy vinaigrette.', 'rjxi9tip.png', 20, 15, '1. Cook lentils according to package instructions. Drain and let cool.\n2. In a large mixing bowl, combine cooked lentils, diced tomatoes, diced cucumbers, chopped red onion, crumbled feta cheese, and chopped parsley.\n3. In a small bowl, whisk together olive oil, lemon juice, red wine vinegar, minced garlic, dried oregano, salt, and black pepper to make the dressing.\n4. Pour the dressing over the salad and toss gently to coat.\n5. Serve immediately or refrigerate for later.\n6. Enjoy!', 2, 3, 5, '2024-03-21 09:16:24'),
(1, 35, 1, 'Spring Tortellini Salad', 'A vibrant salad featuring cheese tortellini, cherry tomatoes, baby spinach, and a lemon vinaigrette.', 'sltvrsun.png', 15, 10, '1. Cook tortellini according to package instructions. Drain and let cool.\n2. In a large mixing bowl, combine cooked tortellini, halved cherry tomatoes, baby spinach leaves, and sliced red onions.\n3. In a small bowl, whisk together olive oil, lemon juice, minced garlic, salt, and black pepper to make the dressing.\n4. Pour the dressing over the salad and toss gently to coat.\n5. Serve immediately or refrigerate for later.\n6. Enjoy!', 2, 3, 5, '2024-03-21 09:16:24'),
(1, 36, 1, 'Turkey Cutlets with Zucchini', 'Juicy turkey cutlets served with sautéed zucchini, perfect for a quick and healthy dinner.', 'b32b2i8s.png', 15, 15, '1. Season turkey cutlets with salt, pepper, and Italian seasoning.\n2. Heat olive oil in a skillet over medium-high heat.\n3. Cook turkey cutlets for 3-4 minutes per side, or until cooked through.\n4. Remove turkey cutlets from skillet and set aside.\n5. In the same skillet, add sliced zucchini and cook until tender.\n6. Serve turkey cutlets with sautéed zucchini.\n7. Enjoy!', 1, 3, 5, '2024-03-21 09:16:24'),
(1, 37, 1, 'Pasta Salad', 'A refreshing pasta salad packed with veggies, perfect for picnics and gatherings.', '3697vtqo.png', 20, 10, '1. Cook pasta according to package instructions.\n2. In a large bowl, combine cooked pasta, cherry tomatoes, cucumber, bell pepper, olives, and feta cheese.\n3. In a small bowl, whisk together olive oil, lemon juice, garlic, salt, and pepper to make the dressing.\n4. Pour dressing over pasta salad and toss to coat.\n5. Refrigerate for at least 30 minutes before serving.\n6. Enjoy!', 3, 2, 2, '2024-03-21 09:16:24'),
(1, 38, 1, 'Carrot Tortilla with Tuna Spread', 'A flavorful tortilla wrap filled with tuna spread and shredded carrots.', '8ni9iwg3.png', 10, 10, '1. In a bowl, mix together canned tuna, mayonnaise, chopped celery, and diced onions to make the tuna spread.\n2. Place a tortilla on a flat surface and spread the tuna mixture evenly on top.\n3. Sprinkle shredded carrots over the tuna spread.\n4. Roll up the tortilla tightly.\n5. Slice the rolled tortilla into halves or quarters.\n6. Serve and enjoy!', 3, 3, 7, '2024-03-21 09:16:24'),
(1, 39, 1, 'Bang Bang Shrimp Salad', 'A delicious salad featuring crispy shrimp tossed in a spicy mayo-based dressing.', 'fytwb94c.png', 20, 10, '1. In a bowl, mix together mayonnaise, sweet chili sauce, and Sriracha to make the dressing.\n2. Heat oil in a skillet over medium heat. Season shrimp with salt and pepper, then cook until golden brown and crispy, about 2-3 minutes per side.\n3. In a large bowl, toss mixed greens, sliced cucumbers, shredded carrots, and chopped green onions.\n4. Add cooked shrimp to the salad and drizzle with the prepared dressing.\n5. Toss everything together until evenly coated.\n6. Serve immediately and enjoy!', 2, 1, 1, '2024-03-21 09:16:24'),
(1, 40, 1, 'Penne with Turkey', 'Delicious penne pasta served with seasoned turkey in a savory sauce.', 'o61vl6ja.png', 15, 20, '1. Cook penne pasta according to package instructions until al dente. Drain and set aside.\n2. In a skillet, heat olive oil over medium heat. Add minced garlic and cook until fragrant.\n3. Add ground turkey to the skillet and cook until browned.\n4. Season turkey with salt, pepper, and Italian seasoning.\n5. Pour marinara sauce over the turkey and let simmer for 5 minutes.\n6. Add cooked penne to the skillet and toss until pasta is evenly coated with the sauce.\n7. Serve hot and enjoy!', 3, 3, 7, '2024-03-21 09:16:24'),
(1, 41, 1, 'Beef and Beans Stir Fry', 'A flavorful stir-fry dish made with tender beef and crisp beans, perfect for a quick and satisfying dinner.', '24ks0fis.png', 15, 20, '1. In a bowl, marinate beef slices with soy sauce, sesame oil, and cornstarch for 15 minutes.\n2. Heat oil in a wok or skillet over high heat.\n3. Add marinated beef and stir-fry until browned. Remove beef from the wok and set aside.\n4. In the same wok, add sliced onions and cook until softened.\n5. Add green beans and stir-fry until tender-crisp.\n6. Return beef to the wok and stir to combine with the vegetables.\n7. Season with salt, pepper, and any additional soy sauce if needed.\n8. Serve hot and enjoy!', 2, 2, 1, '2024-03-21 09:16:24'),
(1, 42, 0, 'Air Fryer Fajitas', ' Quick and easy fajitas made in the air fryer, packed with flavor and perfect for a weeknight dinner.', 'ngsd8sgb.png', 151, 201212, '1. Preheat the air fryer to 400°F (200°C).\r\n2. Slice bell peppers and onions into strips.\r\n3. In a bowl, toss sliced bell peppers and onions with olive oil, chili powder, cumin, garlic powder, salt, and black pepper.\r\n4. Place the seasoned vegetables in the air fryer basket.\r\n5. Cook in the air fryer for 10-12 minutes, shaking the basket halfway through, until vegetables are tender and slightly charred.\r\n6. While vegetables are cooking, slice chicken breasts into strips.\r\n7. In another bowl, toss chicken strips with olive oil, chili powder, cumin, garlic powder, salt, and black pepper.\r\n8. Once the vegetables are done, remove them from the air fryer and set aside.\r\n9. Place the seasoned chicken strips in the air fryer basket.\r\n10. Cook in the air fryer for 8-10 minutes, shaking the basket halfway through, until chicken is cooked through.\r\n11. Serve the cooked chicken and vegetables in warm tortillas.\r\n12. Garnish with toppings such as salsa, sour cream, guacamole, and cilantro.\r\n13. Enjoy your air fryer fajitas!', 2, 1, 1, '2024-03-21 09:16:24'),
(3, 43, 1, '2121212', '12121', '2x1l3hjm-1.png', 2121, 2121, '1212', 2, 2, 1, '2024-03-27 11:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_course_categories`
--

CREATE TABLE `recipe_course_categories` (
  `id` int NOT NULL,
  `type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipe_course_categories`
--

INSERT INTO `recipe_course_categories` (`id`, `type_name`) VALUES
(1, 'Breakfast'),
(2, 'Lunch'),
(3, 'Dinner');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ingredient`
--

CREATE TABLE `recipe_ingredient` (
  `ingredient_id` int NOT NULL,
  `recipe_id` int NOT NULL,
  `quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_ingredient`
--

INSERT INTO `recipe_ingredient` (`ingredient_id`, `recipe_id`, `quantity`) VALUES
(1, 1, 300),
(2, 1, 200),
(3, 1, 2),
(4, 1, 1),
(5, 2, 150),
(6, 2, 1),
(7, 2, 2),
(8, 2, 1),
(16, 4, 2),
(17, 4, 2),
(18, 4, 2),
(19, 4, 2),
(20, 4, 2),
(26, 5, 4),
(27, 5, 1),
(28, 5, 1),
(29, 5, 1),
(30, 5, 2),
(31, 6, 2),
(32, 6, 1),
(33, 6, 1),
(34, 6, 1),
(35, 6, 1),
(36, 6, 1),
(37, 6, 3),
(38, 6, 2),
(39, 6, 1),
(40, 6, 1),
(41, 6, 1),
(42, 6, 1),
(43, 7, 1),
(44, 7, 2),
(45, 7, 1),
(46, 7, 1),
(47, 7, 1),
(48, 7, 1),
(49, 7, 1),
(50, 7, 1),
(51, 7, 1),
(52, 7, 1),
(60, 9, 6),
(61, 9, 1),
(62, 9, 1),
(63, 9, 1),
(64, 9, 2),
(65, 9, 1),
(66, 9, 1),
(72, 11, 2),
(73, 11, 1),
(74, 11, 1),
(75, 11, 2),
(76, 11, 1),
(77, 11, 1),
(78, 11, 2),
(79, 12, 8),
(80, 12, 1),
(81, 12, 1),
(82, 12, 2),
(83, 12, 1),
(84, 13, 12),
(85, 13, 4),
(86, 13, 12),
(87, 14, 1),
(88, 14, 1),
(89, 14, 1),
(90, 14, 2),
(91, 14, 2),
(92, 14, 1),
(93, 14, 1),
(94, 14, 1),
(95, 14, 1),
(96, 14, 1),
(97, 15, 1),
(98, 15, 1),
(99, 15, 1),
(100, 15, 1),
(101, 15, 2),
(102, 15, 1),
(103, 15, 1),
(104, 15, 1),
(105, 16, 1),
(106, 16, 1),
(107, 16, 1),
(108, 16, 1),
(109, 16, 2),
(110, 16, 3),
(111, 16, 1),
(112, 16, 1),
(113, 16, 1),
(114, 16, 1),
(118, 18, 1),
(119, 18, 1),
(120, 18, 1),
(121, 18, 2),
(122, 18, 3),
(123, 18, 1),
(124, 18, 1),
(125, 18, 1),
(126, 18, 1),
(131, 20, 1),
(132, 20, 1),
(133, 20, 1),
(134, 20, 1),
(135, 20, 1),
(136, 20, 1),
(137, 20, 1),
(138, 20, 2),
(139, 20, 1),
(140, 20, 1),
(141, 20, 1),
(146, 21, 2),
(147, 21, 1),
(148, 21, 1),
(149, 21, 1),
(150, 21, 1),
(151, 21, 1),
(152, 21, 1),
(153, 21, 2),
(154, 21, 1),
(155, 21, 1),
(156, 21, 1),
(157, 21, 1),
(158, 23, 1),
(159, 23, 1),
(160, 23, 1),
(161, 23, 2),
(162, 23, 2),
(163, 23, 2),
(164, 23, 1),
(165, 23, 1),
(166, 23, 1),
(167, 23, 1),
(168, 24, 1),
(169, 24, 1),
(170, 24, 8),
(171, 24, 1),
(172, 24, 2),
(173, 24, 1),
(174, 27, 1),
(174, 28, 1),
(175, 27, 1),
(175, 28, 1),
(176, 27, 2),
(176, 28, 1),
(177, 28, 1),
(178, 28, 1),
(179, 28, 2),
(180, 28, 2),
(181, 28, 1),
(182, 28, 1),
(183, 28, 1),
(184, 29, 4),
(185, 29, 1),
(186, 29, 1),
(187, 29, 1),
(188, 29, 2),
(197, 30, 2),
(198, 30, 1),
(199, 30, 1),
(200, 30, 2),
(201, 30, 1),
(202, 30, 1),
(203, 30, 1),
(204, 30, 1),
(205, 30, 4),
(206, 30, 1),
(207, 31, 2),
(208, 31, 1),
(209, 31, 1),
(210, 31, 1),
(211, 31, 1),
(212, 31, 1),
(213, 31, 1),
(214, 32, 2),
(215, 32, 1),
(216, 32, 1),
(217, 32, 1),
(218, 32, 2),
(219, 32, 1),
(220, 32, 1),
(221, 32, 1),
(222, 32, 1),
(223, 32, 8),
(224, 32, 1),
(225, 32, 2),
(226, 33, 2),
(227, 33, 1),
(228, 33, 1),
(229, 33, 2),
(230, 33, 1),
(231, 33, 1),
(232, 33, 1),
(233, 33, 1),
(234, 33, 1),
(235, 33, 1),
(236, 33, 1),
(237, 33, 1),
(238, 33, 1),
(239, 33, 1),
(240, 33, 1),
(241, 33, 1),
(242, 33, 1),
(243, 33, 1),
(244, 34, 1),
(245, 34, 1),
(246, 34, 1),
(247, 34, 1),
(248, 34, 1),
(249, 34, 1),
(250, 34, 1),
(251, 34, 1),
(252, 34, 2),
(253, 34, 1),
(254, 34, 1),
(255, 34, 1),
(256, 34, 1),
(257, 35, 1),
(258, 35, 1),
(259, 35, 2),
(260, 35, 1),
(261, 35, 1),
(262, 35, 1),
(263, 35, 1),
(264, 35, 1),
(265, 35, 1),
(266, 36, 4),
(267, 36, 2),
(268, 36, 2),
(269, 36, 1),
(270, 36, 1),
(271, 36, 1),
(272, 37, 2),
(273, 37, 1),
(274, 37, 1),
(275, 37, 1),
(276, 37, 1),
(277, 37, 1),
(278, 37, 2),
(279, 37, 1),
(281, 37, 1),
(282, 37, 1),
(283, 37, 1),
(284, 38, 1),
(285, 38, 1),
(286, 38, 1),
(287, 38, 1),
(288, 38, 1),
(289, 38, 1),
(290, 39, 1),
(291, 39, 1),
(292, 39, 1),
(293, 39, 1),
(294, 39, 1),
(295, 39, 2),
(296, 39, 1),
(297, 39, 1),
(298, 39, 1),
(299, 40, 1),
(300, 40, 2),
(301, 40, 2),
(302, 40, 1),
(303, 40, 1),
(304, 40, 1),
(305, 40, 1),
(306, 40, 1),
(307, 41, 1),
(308, 41, 1),
(309, 41, 1),
(310, 41, 2),
(311, 41, 1),
(312, 41, 1),
(313, 41, 1),
(314, 41, 1),
(315, 42, 1),
(316, 42, 2),
(317, 42, 1),
(318, 42, 2),
(319, 42, 1),
(320, 42, 1),
(321, 42, 1),
(322, 42, 1),
(323, 42, 1),
(324, 42, 8),
(27, 43, 12121);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_meal_categories`
--

CREATE TABLE `recipe_meal_categories` (
  `id` int NOT NULL,
  `type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipe_meal_categories`
--

INSERT INTO `recipe_meal_categories` (`id`, `type_name`) VALUES
(1, 'Appetizer'),
(2, 'Main Dish'),
(3, 'Side Dish'),
(4, 'Dessert');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_method_categories`
--

CREATE TABLE `recipe_method_categories` (
  `id` int NOT NULL,
  `method_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipe_method_categories`
--

INSERT INTO `recipe_method_categories` (`id`, `method_name`) VALUES
(1, 'Baked'),
(2, 'Salad'),
(3, 'Sauce'),
(4, 'Snack'),
(5, 'Beverage'),
(6, 'Soup'),
(7, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ratings`
--

CREATE TABLE `recipe_ratings` (
  `rating_id` int NOT NULL,
  `recipe_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL,
  `comment` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipe_ratings`
--

INSERT INTO `recipe_ratings` (`rating_id`, `recipe_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(13, 12, 3, 5, NULL, '2024-03-21 10:23:18'),
(14, 9, 4, 4, NULL, '2024-03-21 10:23:18'),
(15, 15, 1, 4, NULL, '2024-03-21 10:23:18'),
(16, 14, 3, 2, NULL, '2024-03-21 10:23:18'),
(18, 11, 3, 3, NULL, '2024-03-21 10:23:26'),
(19, 6, 3, 1, NULL, '2024-03-21 10:23:26'),
(20, 25, 2, 2, NULL, '2024-03-21 10:23:26'),
(21, 32, 3, 1, NULL, '2024-03-21 10:23:26'),
(22, 13, 3, 2, NULL, '2024-03-21 10:23:26'),
(23, 14, 2, 4, NULL, '2024-03-21 10:23:26'),
(24, 21, 1, 4, NULL, '2024-03-21 10:23:26'),
(25, 28, 1, 1, NULL, '2024-03-21 10:23:26'),
(26, 5, 2, 4, NULL, '2024-03-21 10:23:26'),
(27, 2, 4, 5, NULL, '2024-03-21 10:23:26'),
(28, 13, 2, 4, NULL, '2024-03-21 10:23:26'),
(30, 8, 2, 5, NULL, '2024-03-21 10:23:28'),
(31, 18, 1, 3, NULL, '2024-03-21 10:23:28'),
(32, 22, 3, 3, NULL, '2024-03-21 10:23:28'),
(33, 29, 4, 4, NULL, '2024-03-21 10:23:28'),
(34, 28, 4, 5, NULL, '2024-03-21 10:23:28'),
(35, 3, 4, 3, NULL, '2024-03-21 10:23:28'),
(36, 28, 3, 4, NULL, '2024-03-21 10:23:28'),
(37, 25, 1, 2, NULL, '2024-03-21 10:23:28'),
(39, 7, 3, 1, NULL, '2024-03-21 10:23:29'),
(40, 27, 4, 4, NULL, '2024-03-21 10:23:29'),
(43, 10, 3, 5, NULL, '2024-03-21 10:23:30'),
(44, 1, 3, 3, NULL, '2024-03-21 10:23:30'),
(46, 19, 1, 3, NULL, '2024-03-21 10:23:31'),
(49, 32, 1, 3, NULL, '2024-03-21 10:23:32'),
(50, 19, 3, 1, NULL, '2024-03-21 10:23:32'),
(51, 2, 2, 5, NULL, '2024-03-21 10:23:32'),
(53, 21, 3, 5, NULL, '2024-03-21 10:23:32'),
(54, 18, 4, 1, NULL, '2024-03-21 10:23:32'),
(55, 24, 1, 3, NULL, '2024-03-21 10:23:32'),
(56, 4, 3, 5, NULL, '2024-03-21 10:23:32'),
(57, 22, 2, 3, NULL, '2024-03-21 10:23:32'),
(58, 32, 2, 1, NULL, '2024-03-21 10:23:32'),
(59, 31, 2, 3, NULL, '2024-03-21 10:23:32'),
(61, 30, 1, 1, NULL, '2024-03-21 10:23:34'),
(62, 10, 2, 4, NULL, '2024-03-21 10:23:34'),
(65, 23, 4, 5, NULL, '2024-03-21 10:23:36'),
(66, 31, 3, 1, NULL, '2024-03-21 10:23:36'),
(67, 31, 4, 1, NULL, '2024-03-21 10:23:36'),
(68, 7, 4, 1, NULL, '2024-03-21 10:23:36'),
(71, 31, 1, 2, NULL, '2024-03-21 10:23:36'),
(74, 24, 4, 1, NULL, '2024-03-21 10:23:56'),
(75, 27, 2, 4, NULL, '2024-03-21 10:23:56'),
(77, 2, 3, 1, NULL, '2024-03-21 10:23:57'),
(81, 25, 4, 1, NULL, '2024-03-21 10:23:58'),
(82, 12, 1, 2, NULL, '2024-03-21 10:23:58'),
(83, 17, 4, 4, NULL, '2024-03-21 10:23:58'),
(84, 22, 1, 5, NULL, '2024-03-21 10:23:58'),
(85, 13, 1, 2, NULL, '2024-03-21 10:23:58'),
(87, 4, 4, 4, NULL, '2024-03-21 10:23:58'),
(89, 30, 4, 5, NULL, '2024-03-21 10:23:59'),
(90, 8, 4, 5, NULL, '2024-03-21 10:23:59'),
(91, 17, 2, 2, NULL, '2024-03-21 10:23:59'),
(92, 20, 1, 4, NULL, '2024-03-21 10:23:59'),
(96, 12, 2, 4, NULL, '2024-03-21 10:24:00'),
(98, 19, 4, 5, NULL, '2024-03-21 10:24:01'),
(99, 4, 1, 5, NULL, '2024-03-21 10:24:01'),
(100, 8, 1, 3, NULL, '2024-03-21 10:24:01'),
(101, 23, 1, 2, NULL, '2024-03-21 10:24:01'),
(102, 6, 1, 2, NULL, '2024-03-21 10:24:01'),
(103, 6, 4, 3, NULL, '2024-03-21 10:24:01'),
(105, 17, 1, 5, NULL, '2024-03-21 10:24:01'),
(106, 20, 2, 1, NULL, '2024-03-21 10:24:01'),
(107, 22, 4, 5, NULL, '2024-03-21 10:24:01'),
(108, 32, 4, 3, NULL, '2024-03-21 10:24:01'),
(116, 29, 2, 3, NULL, '2024-03-21 10:24:04'),
(120, 6, 2, 5, NULL, '2024-03-21 10:24:08'),
(125, 7, 2, 1, NULL, '2024-03-21 10:24:10'),
(127, 28, 2, 1, NULL, '2024-03-21 10:24:11'),
(128, 12, 4, 5, NULL, '2024-03-21 10:24:11'),
(129, 15, 4, 4, NULL, '2024-03-21 10:24:11'),
(130, 21, 4, 3, NULL, '2024-03-21 10:24:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_Name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_Name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Male',
  `level` enum('1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `BMI_index` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_Name`, `last_Name`, `date_of_birth`, `email`, `gender`, `level`, `BMI_index`) VALUES
(1, 'tao', '$2y$10$ftWSOFRz5zxbkFTd.01PHuKV6vGTmM7ocJOnsRMAWsZEGrpw6NEC6', NULL, NULL, NULL, 'tao@gmail.com', 'Male', '1', 100),
(2, 'taotao', '$2y$10$nWRRgU7ACr/ytBumq3Zb7OKhiAF6Zp6PmY8fXc9z/dOvNF2K03GoW', NULL, NULL, NULL, 'taotao@gmail.com', 'Male', '3', 100),
(3, 'admin', '$2y$10$/FTkpPSQPmjB8fAI6zHEI.9hSbZW3Z/LZwq6pTmdVemneiemCUkye', NULL, NULL, NULL, 'admin@gmail.com', NULL, '1', NULL),
(4, 'taotaotao', '$2y$10$u7WYyWQltzYc7VYs3LowTO3BewwXkEUmuestdjaaajuevEsRIgVzG', NULL, NULL, NULL, 'taotaotao@gmail.com', 'Male', '3', 100),
(5, 'adminn', '$2y$10$fpyyfrY3M2VGaLpLO38aT.79QUfmsyvHlujyTZH/5HpwOTq7rdyqK', '', '', '2000-01-01', 'adminn@gmail.com', 'Male', '3', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ingre_cat` (`category`),
  ADD KEY `FK_ingre_unit` (`measurement_unit`);

--
-- Indexes for table `ingredient_categories`
--
ALTER TABLE `ingredient_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingredient_measurement_unit`
--
ALTER TABLE `ingredient_measurement_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingredient_nutritions`
--
ALTER TABLE `ingredient_nutritions`
  ADD KEY `ingredient_id` (`ingredient_id`),
  ADD KEY `nutrition_id` (`nutrition_id`);

--
-- Indexes for table `nutrition_types`
--
ALTER TABLE `nutrition_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`,`user_id`) USING BTREE,
  ADD KEY `recipes_ibfk_2` (`meal`),
  ADD KEY `recipes_ibfk_3` (`method`),
  ADD KEY `recipes_ibfk_4` (`user_id`),
  ADD KEY `recipes_ibfk_1` (`course`);
ALTER TABLE `recipes` ADD FULLTEXT KEY `name` (`name`);

--
-- Indexes for table `recipe_course_categories`
--
ALTER TABLE `recipe_course_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe_ingredient`
--
ALTER TABLE `recipe_ingredient`
  ADD KEY `ingredient_id` (`ingredient_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `recipe_meal_categories`
--
ALTER TABLE `recipe_meal_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe_method_categories`
--
ALTER TABLE `recipe_method_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe_ratings`
--
ALTER TABLE `recipe_ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD UNIQUE KEY `recipe_id` (`recipe_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=387;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `recipe_course_categories`
--
ALTER TABLE `recipe_course_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recipe_meal_categories`
--
ALTER TABLE `recipe_meal_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `recipe_method_categories`
--
ALTER TABLE `recipe_method_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `recipe_ratings`
--
ALTER TABLE `recipe_ratings`
  MODIFY `rating_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `FK_ingre_cat` FOREIGN KEY (`category`) REFERENCES `ingredient_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ingre_unit` FOREIGN KEY (`measurement_unit`) REFERENCES `ingredient_measurement_unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ingredient_nutritions`
--
ALTER TABLE `ingredient_nutritions`
  ADD CONSTRAINT `FK_ingre_nutri` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_nutri_type` FOREIGN KEY (`nutrition_id`) REFERENCES `nutrition_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`course`) REFERENCES `recipe_course_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipes_ibfk_2` FOREIGN KEY (`meal`) REFERENCES `recipe_meal_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipes_ibfk_3` FOREIGN KEY (`method`) REFERENCES `recipe_method_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipes_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipe_ingredient`
--
ALTER TABLE `recipe_ingredient`
  ADD CONSTRAINT `recipe_ingredient_ibfk_1` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_ingredient_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipe_ratings`
--
ALTER TABLE `recipe_ratings`
  ADD CONSTRAINT `recipe_ratings_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`),
  ADD CONSTRAINT `recipe_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
