-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 17, 2021 at 03:14 PM
-- Server version: 5.7.34-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GymFest`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendants`
--

CREATE TABLE `attendants` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `ticketId` int(11) NOT NULL,
  `invitiationId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `startDate` varchar(255) NOT NULL,
  `endDate` varchar(255) NOT NULL,
  `publishedAt` varchar(255) DEFAULT NULL,
  `price` varchar(255) NOT NULL,
  `tickets` varchar(255) DEFAULT NULL,
  `description` mediumtext CHARACTER SET utf8 COLLATE utf8_danish_ci,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `pictureId` varchar(255) DEFAULT NULL,
  `scanToken` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `ownerId`, `name`, `startDate`, `endDate`, `publishedAt`, `price`, `tickets`, `description`, `lat`, `lng`, `pictureId`, `scanToken`) VALUES
(49, 4, '3.b2', '1620282540', '1520358940', '1620282637', '25', '200', '<p>Hej med dig:))</p>', '55.779720875966795', '12.519461474281227', NULL, 'NULL'),
(50, 4, '3.b2', '1620384540', '1820368940', '1620282638', '25', '200', '<p>Hej med dig:))</p>', '55.779720875966795', '12.519461474281227', NULL, 'NULL'),
(77, 4, 'Den her !!', '1620381600', '1620468000', '1620381600', '234', '234', '&lt;p&gt;HEj med eeig&lt;/p&gt;', '55.71770919143106', '12.477225202536264', NULL, ''),
(79, 4, 'Lang', '1620295200', '1620360600', '1620302492', '345', '234', '&lt;p&gt;HETHreh&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;hTERWHT&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;hTEWHTWE&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;htEWHTEWH&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;HTEWHTEW&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;HTEWHTEWH&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;HTEWHTEWH&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;HTWHTEW&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;HTEWH&lt;/p&gt;', '55.76989301286997', '12.642550841807614', NULL, ''),
(80, 5, 'fewfew', '1620468000', '1621591200', '1620308036', '100', '100', '&lt;p&gt;fewfwefew&lt;/p&gt;', '55.684427246764756', '12.37047546091738', NULL, ''),
(81, 4, 'He dette rigtigt', '1620298800', '1620381600', '1620309193', '23', '2345', '&lt;h1&gt;Vi&lt;strong&gt;rker dette&lt;/strong&gt;&lt;/h1&gt;&lt;p&gt;Hej med dig&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Hvordan gÃ¥r det i dag&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Kilk &lt;a href=&quot;www.mitstudiekort.dk&quot; target=&quot;_blank&quot;&gt;her&lt;/a&gt;&lt;/p&gt;', '55.77983831435904', '12.519854204370317', NULL, ''),
(83, 5, 'En fest pÃ¥ kun 1 time', '1621677600', '1621681200', '1620373076', '20', '1', '&lt;p&gt;jdbejbdjebjde&lt;/p&gt;', '55.77985635799316', '12.518776176643263', NULL, 'felixersej123'),
(84, 5, 'Yo mama event', '1620468000', '1620554400', '1620375887', '420', '69', '&lt;h1&gt;Test test test :)&lt;/h1&gt;', '55.77508000071324', '12.493572297656254', NULL, '0cd55b2b7bcbbed78426885adc7a7d2a9881a7e7'),
(86, 4, 'Fest hos villads', '1620381600', '1620554400', '1620397213', '24', '2345678', '&lt;p&gt;SÃ¥ er der vist fedest!&lt;/p&gt;', '55.75443683', '12.47753421', NULL, 'aba65548a32644023deea8d054180566ffc7abd2'),
(89, 5, 'Student admins event', '1620900000', '1621072800', '1620734667', '100', '10', '&lt;p&gt;Skal bare virke :(&lt;/p&gt;', '55.78677727', '12.46425731', NULL, '79a1a43eee436a5cd6171c0c70310a9098b84c27'),
(90, 5, 'Student admins event 2', '1620813600', '1620900000', '1620734789', '1000', '10', '&lt;p&gt;fweijfweiofew&lt;/p&gt;', '55.745139496616375', '12.277175481249984', NULL, 'd6b84d752175b0c35e83b1106437964e7c3328b9'),
(91, 5, 'Student admins event 2', '1620813600', '1620900000', '1620734794', '1000', '10', '&lt;p&gt;fweijfweiofew&lt;/p&gt;', '55.745139496616375', '12.277175481249984', NULL, 'f3bed6c56cf4861d15074eb431fe9c4188ca40e9'),
(92, 5, 'Student admins event 2', '1620813600', '1620900000', '1620734810', '1000', '10', '&lt;p&gt;fweijfweiofew&lt;/p&gt;', '55.745139496616375', '12.277175481249984', NULL, 'c88fb2332c646264e2b2aef0479a08ec241e6069'),
(93, 5, 'Student admins event 2', '1620813600', '1620900000', '1620735006', '1000', '10', '&lt;p&gt;fweijfweiofew&lt;/p&gt;', '55.745139496616375', '12.277175481249984', NULL, 'f578d222d5e510a88bbf066ea473eb114662b810'),
(94, 5, 'Felix&#039;s Seje Event :D', '1621072800', '1621159200', '1620735078', '420', '69', '&lt;p&gt;YAY!&lt;/p&gt;', '55.78677727', '12.46425731', NULL, '8b8adb38caaa24ae1429650e7c2be2c39f0e595a'),
(95, 28, 'Huefest', '1624377600', '1624403400', '1620817795', '200', '500', '&lt;p&gt;kjsdflakdjbfvzkdbv.zkdsvbkzjds&lt;/p&gt;&lt;p&gt;as.dkvjbnazldkjvbn&lt;/p&gt;', '55.77995918', '12.51949922', NULL, '608a9e4fcac739c62a129ee45aaba14d2dcb30d5'),
(96, 28, 'Huefesten 2.0', '1620813600', '1620817200', '1620819125', '120', '100', '&lt;h1&gt;Her er endnu en&lt;/h1&gt;', '55.779866494975714', '12.518816809529945', NULL, '252ded4ec5379c4e05a5c3ba12a5dd4ad47368df'),
(97, 5, 'Huefest pt. 2', '1620900000', '1620986400', '1620819226', '200', '25', '&lt;p&gt;Bedste fest, Louise :)&lt;/p&gt;', '55.77995918', '12.51949922', NULL, '5ff3aa74a8d8d48ec1f475e4b5b42af79f090593');

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

CREATE TABLE `invitations` (
  `id` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invitations`
--

INSERT INTO `invitations` (`id`, `eventId`, `userId`) VALUES
(104, 47, 4),
(105, 47, 15),
(106, 47, 14),
(107, 47, 13),
(108, 47, 5),
(109, 47, 23),
(110, 48, 4),
(111, 48, 15),
(112, 48, 14),
(113, 48, 13),
(114, 48, 5),
(115, 48, 23),
(116, 49, 26),
(117, 50, 26),
(118, 51, 4),
(119, 51, 15),
(120, 51, 14),
(121, 51, 13),
(122, 51, 5),
(123, 51, 23),
(124, 52, 4),
(125, 52, 15),
(126, 52, 14),
(128, 52, 5),
(129, 52, 23),
(130, 53, 4),
(131, 53, 15),
(132, 53, 14),
(133, 53, 13),
(134, 53, 5),
(135, 53, 23),
(136, 54, 4),
(137, 54, 15),
(138, 54, 14),
(139, 54, 13),
(140, 54, 5),
(141, 54, 23),
(142, 55, 4),
(143, 55, 15),
(144, 55, 14),
(145, 55, 13),
(146, 55, 5),
(147, 55, 23),
(148, 56, 4),
(149, 56, 15),
(150, 56, 14),
(151, 56, 13),
(152, 56, 5),
(153, 56, 23),
(154, 57, 4),
(155, 57, 15),
(156, 57, 14),
(157, 57, 13),
(158, 57, 5),
(159, 57, 23),
(160, 58, 4),
(161, 58, 15),
(162, 58, 14),
(163, 58, 5),
(164, 58, 23),
(165, 59, 4),
(166, 59, 15),
(167, 59, 14),
(168, 59, 5),
(169, 59, 23),
(171, 60, 4),
(172, 60, 15),
(173, 60, 14),
(174, 60, 5),
(175, 60, 23),
(177, 61, 4),
(178, 61, 15),
(179, 61, 14),
(180, 61, 5),
(181, 61, 23),
(183, 62, 4),
(184, 62, 15),
(185, 62, 14),
(186, 62, 5),
(187, 62, 23),
(189, 63, 4),
(190, 63, 15),
(191, 63, 14),
(192, 63, 5),
(193, 63, 23),
(195, 64, 4),
(196, 64, 15),
(197, 64, 14),
(198, 64, 5),
(199, 64, 23),
(201, 65, 4),
(202, 65, 15),
(203, 65, 14),
(204, 65, 5),
(205, 65, 23),
(207, 66, 4),
(208, 66, 15),
(209, 66, 14),
(210, 66, 5),
(211, 66, 23),
(213, 67, 4),
(214, 67, 15),
(215, 67, 14),
(216, 67, 5),
(217, 67, 23),
(219, 68, 4),
(220, 68, 15),
(221, 68, 14),
(222, 68, 5),
(223, 68, 23),
(225, 69, 4),
(226, 69, 15),
(227, 69, 14),
(228, 69, 5),
(229, 69, 23),
(231, 70, 4),
(232, 70, 15),
(233, 70, 14),
(234, 70, 5),
(235, 70, 23),
(237, 71, 4),
(238, 71, 15),
(239, 71, 14),
(240, 71, 5),
(241, 71, 23),
(243, 72, 15),
(244, 72, 14),
(245, 72, 5),
(246, 72, 23),
(248, 72, 4),
(249, 73, 15),
(250, 73, 14),
(251, 73, 5),
(252, 73, 23),
(254, 73, 4),
(255, 74, 15),
(256, 74, 14),
(257, 74, 5),
(258, 74, 23),
(260, 74, 4),
(261, 75, 15),
(262, 75, 14),
(263, 75, 5),
(264, 75, 23),
(266, 75, 4),
(267, 76, 15),
(268, 76, 14),
(269, 76, 5),
(270, 76, 23),
(272, 76, 4),
(273, 77, 15),
(274, 77, 14),
(275, 77, 5),
(276, 77, 23),
(278, 77, 4),
(280, 78, 15),
(281, 78, 14),
(282, 78, 5),
(283, 78, 23),
(285, 78, 4),
(286, 79, 15),
(287, 79, 14),
(288, 79, 5),
(289, 79, 23),
(291, 79, 4),
(292, 80, 15),
(293, 80, 14),
(294, 80, 5),
(295, 80, 23),
(297, 80, 4),
(298, 81, 15),
(299, 81, 14),
(300, 81, 5),
(301, 81, 23),
(303, 81, 4),
(304, 82, 15),
(305, 82, 14),
(306, 82, 5),
(307, 82, 23),
(309, 82, 4),
(310, 83, 15),
(311, 83, 14),
(312, 83, 5),
(313, 83, 23),
(315, 83, 4),
(316, 84, 15),
(317, 84, 14),
(318, 84, 5),
(319, 84, 23),
(321, 84, 4),
(322, 85, 15),
(323, 85, 14),
(324, 85, 5),
(325, 85, 23),
(327, 85, 4),
(328, 86, 15),
(329, 86, 14),
(330, 86, 5),
(331, 86, 23),
(333, 86, 4),
(334, 87, 15),
(335, 87, 14),
(336, 87, 5),
(337, 87, 23),
(339, 87, 4),
(340, 88, 15),
(341, 88, 14),
(342, 88, 23),
(344, 88, 4),
(345, 88, 5),
(346, 89, 15),
(347, 89, 14),
(348, 89, 23),
(350, 89, 4),
(351, 89, 5),
(352, 90, 15),
(353, 90, 14),
(354, 90, 23),
(356, 90, 4),
(357, 90, 5),
(358, 91, 15),
(359, 91, 14),
(360, 91, 23),
(362, 91, 4),
(363, 91, 5),
(364, 92, 15),
(365, 92, 14),
(366, 92, 23),
(368, 92, 4),
(369, 92, 5),
(370, 93, 15),
(371, 93, 14),
(372, 93, 23),
(374, 93, 4),
(375, 93, 5),
(376, 94, 15),
(377, 94, 14),
(378, 94, 23),
(380, 94, 4),
(381, 94, 5),
(382, 95, 5),
(383, 95, 4),
(384, 95, 5),
(385, 95, 4),
(386, 96, 15),
(387, 96, 14),
(388, 96, 23),
(389, 96, 28),
(390, 96, 4),
(391, 96, 5),
(392, 97, 16),
(393, 97, 26),
(394, 97, 15),
(395, 97, 14),
(396, 97, 23),
(397, 97, 28),
(398, 97, 4),
(399, 97, 5);

-- --------------------------------------------------------

--
-- Table structure for table `organisations`
--

CREATE TABLE `organisations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `msid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `stripe_id`, `status`, `timestamp`) VALUES
(1, 'cs_test_a1AYO9mqz0pB9odPfvyeWIWvLjD91nbYNuThF6N1qOh6jdSstfAlap8b9a', 'checkout.session.completed', '2021-05-06 10:10:48'),
(2, 'cs_test_a1ytylRQZJ6b0gZe7aYeAiDyhfkZqEtwoIun8iwIkOKyRWqtBxWFfVMxnW', 'checkout.session.completed', '2021-05-06 10:10:48'),
(3, 'cs_test_a1kO7tpl7FOyD1Bm8a3AbdvFE1VICJYLTMyqKRFgX8FrZTdRZP0slabPul', 'checkout.session.completed', '2021-05-06 10:10:48'),
(4, 'cs_test_a17AaVwIYnJ7OF5bi34vdIAPbUrAohgfo9DVBHdgozxvAC9nvZN9p3hTI6', 'checkout.session.completed', '2021-05-06 10:10:48'),
(5, 'cs_test_a1detWi9vsOCuvrC3T3L2Zy0yqLimWV64aZQC5cMsCjpqxco4fWFj5D4uj', 'checkout.session.completed', '2021-05-06 10:10:48'),
(6, 'cs_test_a1detWi9vsOCuvrC3T3L2Zy0yqLimWV64aZQC5cMsCjpqxco4fWFj5D4uj', 'checkout.session.completed', '2021-05-06 10:10:48'),
(7, 'cs_test_a1fOOvgxl3kjvLi0L6uUxNo6zwsMAyTmDB4Rqy8P1t6U3AsIH6uJ7Baa7X', 'checkout.session.completed', '2021-05-06 10:10:48'),
(8, 'cs_test_a1fOOvgxl3kjvLi0L6uUxNo6zwsMAyTmDB4Rqy8P1t6U3AsIH6uJ7Baa7X', 'checkout.session.completed', '2021-05-06 10:10:48'),
(9, 'cs_test_a1XTyTJHfLPPt6EUky1JdEtp5LC0lDfi7rEnqGnC3hKHYyUXwQcmmCTVOd', 'checkout.session.completed', '2021-05-06 10:10:48'),
(10, 'cs_test_a1XTyTJHfLPPt6EUky1JdEtp5LC0lDfi7rEnqGnC3hKHYyUXwQcmmCTVOd', 'checkout.session.completed', '2021-05-06 10:10:48'),
(11, 'cs_test_a1tAvcOzJw5Ug93jZsOt5zKt1N2FcDUNd6OFMBAGa5LEl4kzKRRn1zb1Be', 'checkout.session.completed', '2021-05-06 10:10:48'),
(12, 'cs_test_a1vjQeOMgxeRHsahsy4aLqgtTejVkxny8rpYQ0CysZB21EOthGrdSdHAHt', 'checkout.session.completed', '2021-05-06 10:10:48'),
(13, 'cs_test_a1vjQeOMgxeRHsahsy4aLqgtTejVkxny8rpYQ0CysZB21EOthGrdSdHAHt', 'checkout.session.completed', '2021-05-06 10:10:48'),
(14, 'cs_test_a1JgEcTRIVdqmG1HDqnLUBnOi6K0MVxSLCqlOMkFcIHq400F9Nx0X70ODq', 'checkout.session.completed', '2021-05-06 10:10:48'),
(15, 'cs_test_a1b3ygwVqOKnhcUKhnvZJgrDzcRPYLL8Q1PsKZPN7y62BXZpBED2T481fH', 'checkout.session.completed', '2021-05-06 10:10:48'),
(16, 'cs_test_a14SQMXv8Jv1cYB2puimvLLQQdHCYmF7CU90VDrptfihqeNcZ4r70chk83', 'checkout.session.completed', '2021-05-06 10:10:48'),
(17, 'cs_test_a1T0ttTDIoO1xmnJ15k0r7q6AhpArdUZ1lJSRii0D5bFgmVjFvz6mP5zfL', 'checkout.session.completed', '2021-05-06 10:10:48'),
(18, 'cs_test_a1MKOuBafXhBO2Bqqk2uYb8Qd53baED1aXgVjKBFmOMo1dgAESUAcTf1kn', 'checkout.session.completed', '2021-05-06 10:10:48'),
(19, 'cs_test_a1MKOuBafXhBO2Bqqk2uYb8Qd53baED1aXgVjKBFmOMo1dgAESUAcTf1kn', 'checkout.session.completed', '2021-05-06 10:10:48'),
(20, 'cs_test_a1EFrFRdLXt0QjVdRBB6bDe9ZoQnJNUH6tQ81ToqcZFD8bxSOmQYaSRSPX', 'checkout.session.completed', '2021-05-06 10:10:48'),
(21, 'cs_test_a1EFrFRdLXt0QjVdRBB6bDe9ZoQnJNUH6tQ81ToqcZFD8bxSOmQYaSRSPX', 'checkout.session.completed', '2021-05-06 10:10:48'),
(22, 'cs_test_a1rvvXaGqmOtvlsozisbgjnrvaHhJePRr1kXe6n6rcHyrZkRujb7k9Xvy3', 'checkout.session.completed', '2021-05-06 10:10:48'),
(23, 'cs_test_a1cxbFKmJg1jS70OafKhSL650u0tzJbSLaSjoer66yQMeMJtuAHohOQR0e', 'checkout.session.completed', '2021-05-06 10:11:11'),
(24, 'cs_test_a15hwO0C8uNpYW2FU0qHPfZxUMnqT3IzbAp3QbpFwVUJlHFqyGsh5NrjDz', 'checkout.session.completed', '2021-05-06 10:15:19'),
(25, 'cs_test_a1W4xlaAVYVDi1oRnj3GYKrvip6OSTWBULG1ESIe5Fo3K2Yatg3KlB9U9A', 'checkout.session.completed', '2021-05-06 10:17:20'),
(26, 'cs_test_a1FZRNsfdrR6QS7w7yT0t5E9Xq0C44pdcSiDfoUT6curUoV000UG9CsVai', 'checkout.session.completed', '2021-05-06 10:18:48'),
(27, 'cs_test_a1i0qNCY2PoS94xO0pcN2xZPGI8Q7yFWRrwIPPX6Uz7Fu2JNrkCshT2QW9', 'checkout.session.completed', '2021-05-06 10:19:38'),
(28, 'cs_test_a1sYHTc6DBI6cpJlPZM8RovpBDZdpLAUFMcR4U4otKZGAc34dYUxuc3ocM', 'checkout.session.completed', '2021-05-06 10:20:59'),
(29, 'cs_test_a1933NVKiAZrTeLMtKA53Kz2p7UDrdPHsnBPipHKBwfXejL7rLAp5VMdUL', 'checkout.session.completed', '2021-05-06 10:22:11'),
(30, 'cs_test_a1rGd2DXaruZ7wrUZIAbTysiwpOgQBzNTop2c8FM7DWw8bxHKKjTUzPY2Q', 'checkout.session.completed', '2021-05-06 10:22:57'),
(31, 'cs_test_a1Dy8bHkzgFTxZp1s40iphJMcAf7hB6anMhYN6bl7lCkkJ9v2jhBTlLGsl', 'checkout.session.completed', '2021-05-06 10:24:54'),
(32, 'cs_test_a1Lt0ZGEiVfbl6lfr6VcPYIeRafq3B3tdBvasGIdgilI3su0mgNIiRzXo3', 'checkout.session.completed', '2021-05-06 10:26:03'),
(33, 'cs_test_a1t3KUQaPNdBjmgDN74Fzhx4iyHheX7dpQt66vQVWNcmc5D8Jpq8CIyRob', 'checkout.session.completed', '2021-05-06 10:30:10'),
(34, 'cs_test_a1hP26tkALLoOsNsKn0i2pbl6aoTNH6dLpQgZcqTpwR2XZrLRHLs4BVs92', 'checkout.session.completed', '2021-05-06 10:32:48'),
(35, 'cs_test_a10qxH6f4zXSOAq1oRa7rEbBx27r8WxslZ6WLa7QJZmKNEI3FgaIyD1jwt', 'checkout.session.completed', '2021-05-06 10:37:22'),
(36, 'cs_test_a1fGATqnSniKr0NCsptbOvqMLg2SRj6ctBZt4AwRC4f5UJG2N6LYnrrPAE', 'checkout.session.completed', '2021-05-06 10:41:01'),
(37, 'cs_test_a1mJsqmFTlqIcnNQTIJyGygTm1LiFkgsthaO1ptxIRQAZIdr80TRHMG0Yb', 'checkout.session.completed', '2021-05-06 12:02:53'),
(38, 'cs_test_a1bEwODHjgR269zkUFtFIUdIFMWcUOAU3lbUsIm8bXx6jadKP5lGBJZTIL', 'checkout.session.completed', '2021-05-06 17:08:51'),
(39, 'cs_test_a1nsWTzkKMUqT2TN6eaLhUMEbgZJtXY5hvshdxTOneFeCE1jdIyApbMbNh', 'checkout.session.completed', '2021-05-06 18:09:47'),
(40, 'cs_test_a1CrGB1LNfXlHgwNCKTl090i8opIh7pAcgEaPBu3lsecjx8bEQvu2Oyf0L', 'checkout.session.completed', '2021-05-06 18:21:31'),
(41, 'cs_test_a1AAg7hsmacghsxVqu4GEnXTp8TwnyALL409rE5h1nDzqpyB5VraHOdD77', 'checkout.session.completed', '2021-05-07 10:59:56'),
(42, 'cs_test_a1Sq4icWgQdGf99QRJJIfS32SHBkOAZByoE4ecLLvsoFuOGXmePJxyRCUf', 'checkout.session.completed', '2021-05-07 11:52:44'),
(43, 'cs_test_a1vrUyUn1lVeFlLvlA9MT54GIOTDq7KbtExjIqnl2zGfh4lQ2vRnDaTcaC', 'checkout.session.completed', '2021-05-07 12:01:00'),
(44, 'cs_test_a1OAmnVyveYQ8v4aoTUNS9PDKWHFzEH2eHSXPmPjKyoOmjmU8brQlTETAe', 'checkout.session.completed', '2021-05-07 12:11:51'),
(45, 'cs_test_a1fcFUi71fQVnhvQL7Ux3xwZ8xAoCIkcHGshj6dxtHrSIlW4aERkt6dUGT', 'checkout.session.completed', '2021-05-07 12:20:49'),
(46, 'cs_test_a19tL5vrVvPf0AtseBYju3Fb8Xeeoreaa8ke3hjInBLgZcwYuzkBOXxlEY', 'checkout.session.completed', '2021-05-07 12:32:53'),
(47, 'cs_test_a1Wln585ju4ia83uVsYOpqZrIKZnrP1cTf49BuYnNBAPXahXI6DJDkvCRf', 'checkout.session.completed', '2021-05-07 12:34:16'),
(48, 'cs_test_a1dA9jVqaoT4g9ugQy8Jfd0XhUD9vzUek25e1QmZ3PSQHAt49nYFNmV7mq', 'checkout.session.completed', '2021-05-07 12:36:01'),
(49, 'cs_test_a1QyLTZxzdZnKG7Pw91yQZmtVwDEATTdr3fxByEXaYRfcsLCnpAxGGeakB', 'checkout.session.completed', '2021-05-07 12:42:39'),
(50, 'cs_test_a1BjWaRgV3gqKtyfXUFBDZF7ABqmbXFZHSlnMUugC0KvX7Tmr7zhh1n066', 'checkout.session.completed', '2021-05-07 13:31:04'),
(51, 'cs_test_a1LMKWquDNzFbRl1Tv09geB5eJqEZbO0RyxHfNN0eyKg2dcvjq63oVYwsV', 'checkout.session.completed', '2021-05-07 14:56:50'),
(52, 'cs_test_a1pt3zXVr83WNWrLTurFYMkH9oAZqsSYgoYTAOHQD7XYiEBNA0SDyjE573', 'checkout.session.completed', '2021-05-07 14:57:54'),
(53, 'cs_test_a12ZwyJu1M2PQANJ9uAl2q4wvYZCscoHXdcBTbz13yd2KQiXG8K1X0KMh5', 'checkout.session.completed', '2021-05-07 18:38:00'),
(54, 'cs_test_a1Xpard0PYUmmZMGtVNLE3VFUOOKFkcVOMz1kcEOiI2XRXRKOIMy1l05AU', 'checkout.session.completed', '2021-05-08 10:53:01'),
(55, 'cs_test_a1g8r5HOouBnB5JhBAloPyeDTSRJMOChUIMbkHmBCmkSxrLI6EMd5tNcTL', 'checkout.session.completed', '2021-05-09 12:34:40'),
(56, 'cs_test_a11H4CFw5gxMFQPxSQdtwRMdJcsebm1klUGMr0q4nlFRx1ImzWuIwg27b3', 'checkout.session.completed', '2021-05-10 10:52:29'),
(57, 'cs_test_a1AsgPdEGMilrWwEvjJpRDsI2PG3uUXERWAQ6soAMmzGd2dxufaDT7Hi5l', 'checkout.session.completed', '2021-05-12 07:41:16'),
(58, 'cs_test_b1vI2mkOQTTD99IlbjKBM84JR1xDNAyhC7rTYkNffWRbqvyFRgT6Vvgkeh', 'checkout.session.completed', '2021-05-12 08:34:59'),
(59, 'cs_test_b1LxA85kAC3tSuAcZsrTHghrzzZ91Ry4tmXPggzBIlRhCx7pOuTczVpwWW', 'checkout.session.completed', '2021-05-12 08:35:51'),
(60, 'cs_test_b1I9J2bmGtCwayLEqZQxr3T8LaFdJ9AnvHHOYGuc0rIi1aH1z9A9y7vp0n', 'checkout.session.completed', '2021-05-12 09:12:16'),
(61, 'cs_test_a11gsWxnprF9km80L4JbM4z1a0hclLwKSw6V5AT8xEPrFWocSkOpQxioiV', 'checkout.session.completed', '2021-05-12 09:19:58'),
(62, 'cs_test_a1Qzo6uQfs1cM0Qb4KPH265n9o978ZPJeiI4kkD3PmOPOxKIIoyPfIMkOh', 'checkout.session.completed', '2021-05-12 09:21:27'),
(63, 'cs_test_a1iJRVOAXLYS3fjy0bP46aMI9d3tdWL610vFnUtjcsM4PCPa5YB0n6P71Y', 'checkout.session.completed', '2021-05-12 09:22:22'),
(64, 'cs_test_a1QTKGY26QUisV1hBlzFRBbKeOTw3YJ2rcigLioYv73gx16uFaiZuBOnqD', 'checkout.session.completed', '2021-05-12 09:26:55'),
(65, 'cs_test_a1vH64b2r0oTWf3PKB2HzR6gwnIRetkdydID5rwFyovlUSevUagIpPWKRX', 'checkout.session.completed', '2021-05-12 11:14:25'),
(66, 'cs_test_a1XQcmk76PwUvj8YvOrRIVWGGfsctJVB8I3ti7hrHmogsITC0u4rUGiBXA', 'checkout.session.completed', '2021-05-12 11:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `studentEdits`
--

CREATE TABLE `studentEdits` (
  `id` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentEdits`
--

INSERT INTO `studentEdits` (`id`, `eventId`, `studentId`) VALUES
(1, 93, 5),
(2, 93, 4),
(3, 94, 5),
(4, 95, 5),
(5, 96, 28),
(6, 97, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `ticketToken` varchar(255) NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `arrivedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `userId`, `eventId`, `ticketToken`, `stripe_id`, `status`, `arrivedAt`, `type`) VALUES
(26, 5, 84, '874715349', 'cs_test_a1OAmnVyveYQ8v4aoTUNS9PDKWHFzEH2eHSXPmPjKyoOmjmU8brQlTETAe', 'ARRIVED', '2021-05-07 13:30:37', NULL),
(34, 4, 83, '735884460', 'cs_test_a1g8r5HOouBnB5JhBAloPyeDTSRJMOChUIMbkHmBCmkSxrLI6EMd5tNcTL', 'ARRIVED', '2021-05-11 07:51:18', NULL),
(35, 5, 87, '449084401', 'cs_test_a11H4CFw5gxMFQPxSQdtwRMdJcsebm1klUGMr0q4nlFRx1ImzWuIwg27b3', 'VALID', '2021-05-12 07:37:48', NULL),
(37, 5, 83, '577454600', 'cs_test_b1vI2mkOQTTD99IlbjKBM84JR1xDNAyhC7rTYkNffWRbqvyFRgT6Vvgkeh', 'ARRIVED', '2021-05-12 09:26:10', 'PERSONAL'),
(38, 5, 83, '478707106', 'cs_test_b1LxA85kAC3tSuAcZsrTHghrzzZ91Ry4tmXPggzBIlRhCx7pOuTczVpwWW', 'ARRIVED', '2021-05-12 09:26:10', 'PERSONAL'),
(39, 5, 83, '892680447', 'cs_test_b1LxA85kAC3tSuAcZsrTHghrzzZ91Ry4tmXPggzBIlRhCx7pOuTczVpwWW', 'ARRIVED', '2021-05-12 09:26:10', 'PERSONAL'),
(44, 5, 93, '714253917', 'cs_test_a1iJRVOAXLYS3fjy0bP46aMI9d3tdWL610vFnUtjcsM4PCPa5YB0n6P71Y', 'ARRIVED', '2021-05-12 10:00:40', 'PERSONAL'),
(45, 5, 93, '959772928', 'cs_test_a1QTKGY26QUisV1hBlzFRBbKeOTw3YJ2rcigLioYv73gx16uFaiZuBOnqD', 'ARRIVED', '2021-05-12 10:00:40', 'PLUSONE'),
(46, 4, 95, '455423564', 'cs_test_a1vH64b2r0oTWf3PKB2HzR6gwnIRetkdydID5rwFyovlUSevUagIpPWKRX', 'ARRIVED', '2021-05-12 11:30:22', 'PERSONAL'),
(47, 5, 95, '911098798', 'cs_test_a1XQcmk76PwUvj8YvOrRIVWGGfsctJVB8I3ti7hrHmogsITC0u4rUGiBXA', 'ARRIVED', '2021-05-12 11:30:31', 'PERSONAL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `userId` int(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userId`, `status`) VALUES
(2, 5, 'admin'),
(3, 4, 'admin'),
(4, 13, 'admin'),
(5, 14, 'admin'),
(6, 23, 'student'),
(7, 26, 'student'),
(8, 28, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendants`
--
ALTER TABLE `attendants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organisations`
--
ALTER TABLE `organisations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentEdits`
--
ALTER TABLE `studentEdits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendants`
--
ALTER TABLE `attendants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT for table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400;
--
-- AUTO_INCREMENT for table `organisations`
--
ALTER TABLE `organisations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `studentEdits`
--
ALTER TABLE `studentEdits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
