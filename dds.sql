-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 17, 2021 at 03:10 PM
-- Server version: 5.7.34-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dds`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(13) NOT NULL,
  `ownerid` int(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `school` varchar(255) CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_danish_ci NOT NULL,
  `expiry` varchar(255) NOT NULL,
  `birthdate` varchar(255) NOT NULL,
  `pictureid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `ownerid`, `barcode`, `school`, `class`, `expiry`, `birthdate`, `pictureid`) VALUES
(49, 15, '0020002615965', 'H.C. &Oslash;rsted Gymnasiet - Lyngby', 'L 3c Carbon', '1627689600', '1010966400', '/dashboard/cardstore/users/Soph3273.png'),
(50, 16, '0400002618584', 'H.C. &Oslash;rsted Gymnasiet - Lyngby', 'L 3a', '1627689600', '999475200', '/dashboard/cardstore/users/fili0705.png'),
(52, 18, '0400002212720', 'Virum Gymnasium', '3m', '1624924800', '1030838400', '/dashboard/cardstore/users/emil046k.png'),
(63, 14, '0020002615298', 'H.C. &Oslash;rsted Gymnasiet - Lyngby', 'L 3c Carbon', '1627689600', '1010966400', '/dashboard/cardstore/users/vill0351.png'),
(66, 21, '0400002616122', 'AABC - Aarhus Handelsgymnasium Viemosevej', 'VI 3m Global Market.', '1625011200', '1009497600', '/dashboard/cardstore/users/18VI 0302.png'),
(70, 23, '0400002616153', 'H.C. &Oslash;rsted Gymnasiet - Lyngby', 'L 3c Carbon', '1627689600', '1012262400', '/dashboard/cardstore/users/birk0201.png'),
(71, 26, '0400002616368', 'H.C. &Oslash;rsted Gymnasiet - Lyngby', 'L 3b2', '1627689600', '1005004800', '/dashboard/cardstore/users/mill1758.png'),
(72, 28, '0400002616122', 'H.C. &Oslash;rsted Gymnasiet - Lyngby', 'L 3c Carbon', '1627689600', '991958400', '/dashboard/cardstore/users/emil375k.png'),
(73, 4, '0400002615965', 'H.C. &Oslash;rsted Gymnasiet - Lyngby', 'L 3c Carbon', '1628294400', '1024358400', '/dashboard/cardstore/users/vill0351.png'),
(74, 5, '0400002616108', 'H.C. &Oslash;rsted Gymnasiet - Lyngby', 'L 3c Carbon', '1627689600', '1003449600', '/dashboard/cardstore/users/feli0423.png'),
(75, 31, '0400002616115', 'H.C. &Oslash;rsted Gymnasiet - Lyngby', 'L 3c Carbon', '1627689600', '1024704000', '/dashboard/cardstore/users/emil794k.png');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `schoolId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `schoolId`) VALUES
(121, 'L 1a1', 6),
(122, 'L 1a2', 6),
(123, 'L 1b1', 6),
(124, 'L 1b2', 6),
(125, 'L 1c', 6),
(126, 'L 1d1', 6),
(127, 'L 1d2', 6),
(128, 'L 1e', 6),
(129, 'L 1h', 6),
(130, 'L 1i', 6),
(131, 'L Aluminium', 6),
(132, 'L Argon', 6),
(133, 'L Beryllium', 6),
(134, 'L Brom', 6),
(135, 'L Chrom', 6),
(136, 'L Dubnium', 6),
(137, 'L Erbium', 6),
(138, 'L Helium', 6),
(139, 'L Indium', 6),
(140, 'L Krypton', 6),
(141, 'L 2a1', 6),
(142, 'L 2a2', 6),
(143, 'L 2b1', 6),
(144, 'L 2b2', 6),
(145, 'L 2c', 6),
(146, 'L 2d', 6),
(147, 'L 2e Liten', 6),
(148, 'L 2h', 6),
(149, 'L 2i Kerm/It', 6),
(150, 'L 2k', 6),
(151, 'L 3a', 6),
(152, 'L 3ak', 6),
(153, 'L 3b1', 6),
(154, 'L 3b2', 6),
(155, 'L 3c Carbon', 6),
(156, 'L 3d1', 6),
(157, 'L 3d2', 6),
(158, 'L 3e Liten', 6),
(159, 'L 3h', 6),
(160, 'L 3i', 6),
(161, 'L 1a1', 7),
(162, 'L 1a2', 7),
(163, 'L 1b1', 7),
(164, 'L 1b2', 7),
(165, 'L 1c', 7),
(166, 'L 1d1', 7),
(167, 'L 1d2', 7),
(168, 'L 1e', 7),
(169, 'L 1h', 7),
(170, 'L 1i', 7),
(171, 'L Aluminium', 7),
(172, 'L Argon', 7),
(173, 'L Beryllium', 7),
(174, 'L Brom', 7),
(175, 'L Chrom', 7),
(176, 'L Dubnium', 7),
(177, 'L Erbium', 7),
(178, 'L Helium', 7),
(179, 'L Indium', 7),
(180, 'L Krypton', 7),
(181, 'L 2a1', 7),
(182, 'L 2a2', 7),
(183, 'L 2b1', 7),
(184, 'L 2b2', 7),
(185, 'L 2c', 7),
(186, 'L 2d', 7),
(187, 'L 2e Liten', 7),
(188, 'L 2h', 7),
(189, 'L 2i Kerm/It', 7),
(190, 'L 2k', 7),
(191, 'L 3a', 7),
(192, 'L 3ak', 7),
(193, 'L 3b1', 7),
(194, 'L 3b2', 7),
(195, 'L 3c Carbon', 7),
(196, 'L 3d1', 7),
(197, 'L 3d2', 7),
(198, 'L 3e Liten', 7),
(199, 'L 3h', 7),
(200, 'L 3i', 7),
(201, 'L 1a1', 8),
(202, 'L 1a2', 8),
(203, 'L 1b1', 8),
(204, 'L 1b2', 8),
(205, 'L 1c', 8),
(206, 'L 1d1', 8),
(207, 'L 1d2', 8),
(208, 'L 1e', 8),
(209, 'L 1h', 8),
(210, 'L 1i', 8),
(211, 'L Aluminium', 8),
(212, 'L Argon', 8),
(213, 'L Beryllium', 8),
(214, 'L Brom', 8),
(215, 'L Chrom', 8),
(216, 'L Dubnium', 8),
(217, 'L Erbium', 8),
(218, 'L Helium', 8),
(219, 'L Indium', 8),
(220, 'L Krypton', 8),
(221, 'L 2a1', 8),
(222, 'L 2a2', 8),
(223, 'L 2b1', 8),
(224, 'L 2b2', 8),
(225, 'L 2c', 8),
(226, 'L 2d', 8),
(227, 'L 2e Liten', 8),
(228, 'L 2h', 8),
(229, 'L 2i Kerm/It', 8),
(230, 'L 2k', 8),
(231, 'L 3a', 8),
(232, 'L 3ak', 8),
(233, 'L 3b1', 8),
(234, 'L 3b2', 8),
(235, 'L 3c Carbon', 8),
(236, 'L 3d1', 8),
(237, 'L 3d2', 8),
(238, 'L 3e Liten', 8),
(239, 'L 3h', 8),
(240, 'L 3i', 8),
(241, 'L 1a1', 9),
(242, 'L 1a2', 9),
(243, 'L 1b1', 9),
(244, 'L 1b2', 9),
(245, 'L 1c', 9),
(246, 'L 1d1', 9),
(247, 'L 1d2', 9),
(248, 'L 1e', 9),
(249, 'L 1h', 9),
(250, 'L 1i', 9),
(251, 'L Aluminium', 9),
(252, 'L Argon', 9),
(253, 'L Beryllium', 9),
(254, 'L Brom', 9),
(255, 'L Chrom', 9),
(256, 'L Dubnium', 9),
(257, 'L Erbium', 9),
(258, 'L Helium', 9),
(259, 'L Indium', 9),
(260, 'L Krypton', 9),
(261, 'L 2a1', 9),
(262, 'L 2a2', 9),
(263, 'L 2b1', 9),
(264, 'L 2b2', 9),
(265, 'L 2c', 9),
(266, 'L 2d', 9),
(267, 'L 2e Liten', 9),
(268, 'L 2h', 9),
(269, 'L 2i Kerm/It', 9),
(270, 'L 2k', 9),
(271, 'L 3a', 9),
(272, 'L 3ak', 9),
(273, 'L 3b1', 9),
(274, 'L 3b2', 9),
(275, 'L 3c Carbon', 9),
(276, 'L 3d1', 9),
(277, 'L 3d2', 9),
(278, 'L 3e Liten', 9),
(279, 'L 3h', 9),
(280, 'L 3i', 9),
(281, 'L 1a1', 10),
(282, 'L 1a2', 10),
(283, 'L 1b1', 10),
(284, 'L 1b2', 10),
(285, 'L 1c', 10),
(286, 'L 1d1', 10),
(287, 'L 1d2', 10),
(288, 'L 1e', 10),
(289, 'L 1h', 10),
(290, 'L 1i', 10),
(291, 'L Aluminium', 10),
(292, 'L Argon', 10),
(293, 'L Beryllium', 10),
(294, 'L Brom', 10),
(295, 'L Chrom', 10),
(296, 'L Dubnium', 10),
(297, 'L Erbium', 10),
(298, 'L Helium', 10),
(299, 'L Indium', 10),
(300, 'L Krypton', 10),
(301, 'L 2a1', 10),
(302, 'L 2a2', 10),
(303, 'L 2b1', 10),
(304, 'L 2b2', 10),
(305, 'L 2c', 10),
(306, 'L 2d', 10),
(307, 'L 2e Liten', 10),
(308, 'L 2h', 10),
(309, 'L 2i Kerm/It', 10),
(310, 'L 2k', 10),
(311, 'L 3a', 10),
(312, 'L 3ak', 10),
(313, 'L 3b1', 10),
(314, 'L 3b2', 10),
(315, 'L 3c Carbon', 10),
(316, 'L 3d1', 10),
(317, 'L 3d2', 10),
(318, 'L 3e Liten', 10),
(319, 'L 3h', 10),
(320, 'L 3i', 10),
(321, 'L 1a1', 12),
(322, 'L 1a2', 12),
(323, 'L 1b1', 12),
(324, 'L 1b2', 12),
(325, 'L 1c', 12),
(326, 'L 1d1', 12),
(327, 'L 1d2', 12),
(328, 'L 1e', 12),
(329, 'L 1h', 12),
(330, 'L 1i', 12),
(331, 'L Aluminium', 12),
(332, 'L Argon', 12),
(333, 'L Beryllium', 12),
(334, 'L Brom', 12),
(335, 'L Chrom', 12),
(336, 'L Dubnium', 12),
(337, 'L Erbium', 12),
(338, 'L Helium', 12),
(339, 'L Indium', 12),
(340, 'L Krypton', 12),
(341, 'L 2a1', 12),
(342, 'L 2a2', 12),
(343, 'L 2b1', 12),
(344, 'L 2b2', 12),
(345, 'L 2c', 12),
(346, 'L 2d', 12),
(347, 'L 2e Liten', 12),
(348, 'L 2h', 12),
(349, 'L 2i Kerm/It', 12),
(350, 'L 2k', 12),
(351, 'L 3a', 12),
(352, 'L 3ak', 12),
(353, 'L 3b1', 12),
(354, 'L 3b2', 12),
(355, 'L 3c Carbon', 12),
(356, 'L 3d1', 12),
(357, 'L 3d2', 12),
(358, 'L 3e Liten', 12),
(359, 'L 3h', 12),
(360, 'L 3i', 12),
(361, 'L 1a1', 13),
(362, 'L 1a2', 13),
(363, 'L 1b1', 13),
(364, 'L 1b2', 13),
(365, 'L 1c', 13),
(366, 'L 1d1', 13),
(367, 'L 1d2', 13),
(368, 'L 1e', 13),
(369, 'L 1h', 13),
(370, 'L 1i', 13),
(371, 'L Aluminium', 13),
(372, 'L Argon', 13),
(373, 'L Beryllium', 13),
(374, 'L Brom', 13),
(375, 'L Chrom', 13),
(376, 'L Dubnium', 13),
(377, 'L Erbium', 13),
(378, 'L Helium', 13),
(379, 'L Indium', 13),
(380, 'L Krypton', 13),
(381, 'L 2a1', 13),
(382, 'L 2a2', 13),
(383, 'L 2b1', 13),
(384, 'L 2b2', 13),
(385, 'L 2c', 13),
(386, 'L 2d', 13),
(387, 'L 2e Liten', 13),
(388, 'L 2h', 13),
(389, 'L 2i Kerm/It', 13),
(390, 'L 2k', 13),
(391, 'L 3a', 13),
(392, 'L 3ak', 13),
(393, 'L 3b1', 13),
(394, 'L 3b2', 13),
(395, 'L 3c Carbon', 13),
(396, 'L 3d1', 13),
(397, 'L 3d2', 13),
(398, 'L 3e Liten', 13),
(399, 'L 3h', 13),
(400, 'L 3i', 13),
(401, 'L 1a1', 14),
(402, 'L 1a2', 14),
(403, 'L 1b1', 14),
(404, 'L 1b2', 14),
(405, 'L 1c', 14),
(406, 'L 1d1', 14),
(407, 'L 1d2', 14),
(408, 'L 1e', 14),
(409, 'L 1h', 14),
(410, 'L 1i', 14),
(411, 'L Aluminium', 14),
(412, 'L Argon', 14),
(413, 'L Beryllium', 14),
(414, 'L Brom', 14),
(415, 'L Chrom', 14),
(416, 'L Dubnium', 14),
(417, 'L Erbium', 14),
(418, 'L Helium', 14),
(419, 'L Indium', 14),
(420, 'L Krypton', 14),
(421, 'L 2a1', 14),
(422, 'L 2a2', 14),
(423, 'L 2b1', 14),
(424, 'L 2b2', 14),
(425, 'L 2c', 14),
(426, 'L 2d', 14),
(427, 'L 2e Liten', 14),
(428, 'L 2h', 14),
(429, 'L 2i Kerm/It', 14),
(430, 'L 2k', 14),
(431, 'L 3a', 14),
(432, 'L 3ak', 14),
(433, 'L 3b1', 14),
(434, 'L 3b2', 14),
(435, 'L 3c Carbon', 14),
(436, 'L 3d1', 14),
(437, 'L 3d2', 14),
(438, 'L 3e Liten', 14),
(439, 'L 3h', 14),
(440, 'L 3i', 14),
(441, 'L 1a1', 15),
(442, 'L 1a2', 15),
(443, 'L 1b1', 15),
(444, 'L 1b2', 15),
(445, 'L 1c', 15),
(446, 'L 1d1', 15),
(447, 'L 1d2', 15),
(448, 'L 1e', 15),
(449, 'L 1h', 15),
(450, 'L 1i', 15),
(451, 'L Aluminium', 15),
(452, 'L Argon', 15),
(453, 'L Beryllium', 15),
(454, 'L Brom', 15),
(455, 'L Chrom', 15),
(456, 'L Dubnium', 15),
(457, 'L Erbium', 15),
(458, 'L Helium', 15),
(459, 'L Indium', 15),
(460, 'L Krypton', 15),
(461, 'L 2a1', 15),
(462, 'L 2a2', 15),
(463, 'L 2b1', 15),
(464, 'L 2b2', 15),
(465, 'L 2c', 15),
(466, 'L 2d', 15),
(467, 'L 2e Liten', 15),
(468, 'L 2h', 15),
(469, 'L 2i Kerm/It', 15),
(470, 'L 2k', 15),
(471, 'L 3a', 15),
(472, 'L 3ak', 15),
(473, 'L 3b1', 15),
(474, 'L 3b2', 15),
(475, 'L 3c Carbon', 15),
(476, 'L 3d1', 15),
(477, 'L 3d2', 15),
(478, 'L 3e Liten', 15),
(479, 'L 3h', 15),
(480, 'L 3i', 15),
(481, 'L 1a1', 16),
(482, 'L 1a2', 16),
(483, 'L 1b1', 16),
(484, 'L 1b2', 16),
(485, 'L 1c', 16),
(486, 'L 1d1', 16),
(487, 'L 1d2', 16),
(488, 'L 1e', 16),
(489, 'L 1h', 16),
(490, 'L 1i', 16),
(491, 'L Aluminium', 16),
(492, 'L Argon', 16),
(493, 'L Beryllium', 16),
(494, 'L Brom', 16),
(495, 'L Chrom', 16),
(496, 'L Dubnium', 16),
(497, 'L Erbium', 16),
(498, 'L Helium', 16),
(499, 'L Indium', 16),
(500, 'L Krypton', 16),
(501, 'L 2a1', 16),
(502, 'L 2a2', 16),
(503, 'L 2b1', 16),
(504, 'L 2b2', 16),
(505, 'L 2c', 16),
(506, 'L 2d', 16),
(507, 'L 2e Liten', 16),
(508, 'L 2h', 16),
(509, 'L 2i Kerm/It', 16),
(510, 'L 2k', 16),
(511, 'L 3a', 16),
(512, 'L 3ak', 16),
(513, 'L 3b1', 16),
(514, 'L 3b2', 16),
(515, 'L 3c Carbon', 16),
(516, 'L 3d1', 16),
(517, 'L 3d2', 16),
(518, 'L 3e Liten', 16),
(519, 'L 3h', 16),
(520, 'L 3i', 16),
(521, 'L 1a1', 17),
(522, 'L 1a2', 17),
(523, 'L 1b1', 17),
(524, 'L 1b2', 17),
(525, 'L 1c', 17),
(526, 'L 1d1', 17),
(527, 'L 1d2', 17),
(528, 'L 1e', 17),
(529, 'L 1h', 17),
(530, 'L 1i', 17),
(531, 'L Aluminium', 17),
(532, 'L Argon', 17),
(533, 'L Beryllium', 17),
(534, 'L Brom', 17),
(535, 'L Chrom', 17),
(536, 'L Dubnium', 17),
(537, 'L Erbium', 17),
(538, 'L Helium', 17),
(539, 'L Indium', 17),
(540, 'L Krypton', 17),
(541, 'L 2a1', 17),
(542, 'L 2a2', 17),
(543, 'L 2b1', 17),
(544, 'L 2b2', 17),
(545, 'L 2c', 17),
(546, 'L 2d', 17),
(547, 'L 2e Liten', 17),
(548, 'L 2h', 17),
(549, 'L 2i Kerm/It', 17),
(550, 'L 2k', 17),
(551, 'L 3a', 17),
(552, 'L 3ak', 17),
(553, 'L 3b1', 17),
(554, 'L 3b2', 17),
(555, 'L 3c Carbon', 17),
(556, 'L 3d1', 17),
(557, 'L 3d2', 17),
(558, 'L 3e Liten', 17),
(559, 'L 3h', 17),
(560, 'L 3i', 17),
(561, 'L 1a1', 18),
(562, 'L 1a2', 18),
(563, 'L 1b1', 18),
(564, 'L 1b2', 18),
(565, 'L 1c', 18),
(566, 'L 1d1', 18),
(567, 'L 1d2', 18),
(568, 'L 1e', 18),
(569, 'L 1h', 18),
(570, 'L 1i', 18),
(571, 'L Aluminium', 18),
(572, 'L Argon', 18),
(573, 'L Beryllium', 18),
(574, 'L Brom', 18),
(575, 'L Chrom', 18),
(576, 'L Dubnium', 18),
(577, 'L Erbium', 18),
(578, 'L Helium', 18),
(579, 'L Indium', 18),
(580, 'L Krypton', 18),
(581, 'L 2a1', 18),
(582, 'L 2a2', 18),
(583, 'L 2b1', 18),
(584, 'L 2b2', 18),
(585, 'L 2c', 18),
(586, 'L 2d', 18),
(587, 'L 2e Liten', 18),
(588, 'L 2h', 18),
(589, 'L 2i Kerm/It', 18),
(590, 'L 2k', 18),
(591, 'L 3a', 18),
(592, 'L 3ak', 18),
(593, 'L 3b1', 18),
(594, 'L 3b2', 18),
(595, 'L 3c Carbon', 18),
(596, 'L 3d1', 18),
(597, 'L 3d2', 18),
(598, 'L 3e Liten', 18),
(599, 'L 3h', 18),
(600, 'L 3i', 18),
(601, 'L 1a1', 19),
(602, 'L 1a2', 19),
(603, 'L 1b1', 19),
(604, 'L 1b2', 19),
(605, 'L 1c', 19),
(606, 'L 1d1', 19),
(607, 'L 1d2', 19),
(608, 'L 1e', 19),
(609, 'L 1h', 19),
(610, 'L 1i', 19),
(611, 'L Aluminium', 19),
(612, 'L Argon', 19),
(613, 'L Beryllium', 19),
(614, 'L Brom', 19),
(615, 'L Chrom', 19),
(616, 'L Dubnium', 19),
(617, 'L Erbium', 19),
(618, 'L Helium', 19),
(619, 'L Indium', 19),
(620, 'L Krypton', 19),
(621, 'L 2a1', 19),
(622, 'L 2a2', 19),
(623, 'L 2b1', 19),
(624, 'L 2b2', 19),
(625, 'L 2c', 19),
(626, 'L 2d', 19),
(627, 'L 2e Liten', 19),
(628, 'L 2h', 19),
(629, 'L 2i Kerm/It', 19),
(630, 'L 2k', 19),
(631, 'L 3a', 19),
(632, 'L 3ak', 19),
(633, 'L 3b1', 19),
(634, 'L 3b2', 19),
(635, 'L 3c Carbon', 19),
(636, 'L 3d1', 19),
(637, 'L 3d2', 19),
(638, 'L 3e Liten', 19),
(639, 'L 3h', 19),
(640, 'L 3i', 19);

-- --------------------------------------------------------

--
-- Table structure for table `connectedServices`
--

CREATE TABLE `connectedServices` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `connectedServices`
--

INSERT INTO `connectedServices` (`id`, `user`, `service`, `token`) VALUES
(5, 5, 1, 'e014241474173e8e5432d9856004d53fbc6b4d9f'),
(7, 4, 1, '963ce50d9d9ff03c39ed26ac7ba90a70a3966590'),
(8, 16, 1, '5fe05d157ac599cdc5dc0a59dc3667b57053b91c'),
(9, 14, 1, 'bf82c1e1b3a1016c1696915e30948bc65673357a'),
(10, 23, 1, '79081784f58ecd9fb8dda4ccbd3d2d410790a89f'),
(11, 26, 1, 'a286a598c6c2ddf17b621d04e01e5cc3fb5f344f'),
(12, 28, 1, '5830c7f9e8d40a8b7d2d9cbca9a13774fd9b0ab4');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`) VALUES
(6, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(7, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(8, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(9, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(10, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(11, ''),
(12, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(13, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(14, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(15, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(16, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(17, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(18, 'H.C. &Oslash;rsted Gymnasiet - Lyngby'),
(19, 'H.C. &Oslash;rsted Gymnasiet - Lyngby');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `serviceName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `serviceName`) VALUES
(1, 'GymFest');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `emailVerifiedAt` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `emailKey` varchar(255) DEFAULT NULL,
  `passwordKey` varchar(255) DEFAULT NULL,
  `loginChange` varchar(255) DEFAULT NULL,
  `emailDate` varchar(255) DEFAULT NULL,
  `appToken` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `emailVerifiedAt`, `password`, `emailKey`, `passwordKey`, `loginChange`, `emailDate`, `appToken`) VALUES
(3, 'Villads Asger', 'Lund', 'villads.lund@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Villads Asger', 'Lund', 'v.v@f.f', '1616584095', '$2y$10$xSSihbLz0fFDdJL1FAEaiOe7o3gh1ujkOmBraOGeXntddaCPPLLIS', NULL, NULL, NULL, NULL, '45639282d3c7a0b48c910a8494e6d989fdb031a8'),
(5, 'Felix Falck', 'Jacobsen', 'felixfalck@gmail.com', '1620295169', '$2y$10$.D5SmWdJ0PkGRD.SrErrtOzWhblHdfBEph/nc8dLBCp0r3q7O/NAC', NULL, NULL, NULL, NULL, 'e71c50fc853292cd2f75f3247d70481a07d91003'),
(7, 'Hej', 'Hej', 'hej.g@g.bv', NULL, '$2y$10$bkgOf5T/aojeyF66U/CZS.W8dhBduDbw00Z.1dMHbBqaWOtJdcXDm', NULL, NULL, NULL, NULL, NULL),
(8, 'Karl', 'Karlsen', 'K@k.k', NULL, '$2y$10$u/qPIw57SsZjumwgkYRoRePzknKDkmCPJ9xzVeShw8UyLG7c//ZSe', NULL, NULL, NULL, NULL, NULL),
(9, 'hej', 'lol', 'det@mig.dk', NULL, '$2y$10$KkXBU6m/SFo4tYKp908yCujMRyoEL2TCB.HwifdWgLciXF4ECHVcy', NULL, NULL, NULL, NULL, NULL),
(11, 'Gustav', 'Johannsen', 'gustavsjohannsen@gmail.com', NULL, '$2y$10$LqZ..WboghskRqAnxcY6tOiYzk95iuhYtXJ7cwin5P0Sb5sUWAb7u', NULL, NULL, NULL, NULL, NULL),
(14, 'Carl', 'Carlsen', 'carlcarlsen15@gmail.com', NULL, '$2y$10$oVmZZSF0QcooHmWtL1OkK.fVkftM/ZL0WczEw/lix4rqtxAESqVEu', NULL, NULL, NULL, NULL, NULL),
(15, 'Sophie Schr&ouml;der', 'Pagh', 'Sophiespagh@gmail.com', '1618596572', '$2y$10$/hcaursaAymiUxRE/djzZedKRx8iq8tMj7eWhalEZOWnoHbfPZaZm', NULL, NULL, NULL, NULL, NULL),
(16, 'Filip Kikkenborg', 'Osmark', 'hej@hej.dk', NULL, '$2y$10$.hxTiGxHM86XeqLbGrcwEO5dhAwYZGZ.FQoqS4KrrTiqNRIRw61KC', NULL, NULL, NULL, NULL, NULL),
(17, 'Test', 'Testwn', 'hej@hej.co', NULL, '$2y$10$vjNtdXR8CEFrrj/Xtg/mte1ZIqXr03kkZUtV38GL0JitOCW2ujo9i', NULL, NULL, NULL, NULL, NULL),
(18, 'Emilia Asta Pihl', 'S&oslash;rensen', 'emiliapihl@hotmail.com', NULL, '$2y$10$x..Hyp9Yhqbgvpu1cQKhBODmdxu7ok.YVmtqIZWqTiZkJxveph/hq', NULL, NULL, NULL, NULL, NULL),
(21, 'Amalie Holst', 'Jensen', 'amalieholstj@gmail.com', '1619298321', '$2y$10$XqK7V3WooTablXz5tdyRKuYP31k.wD1dafh//mpBpT2EV4VGq1I4e', NULL, NULL, NULL, NULL, NULL),
(22, 'Test', 'test', 'test@test.dk', NULL, '$2y$10$8r8kmsh4dkOCVHRyeKeyL.0tf1dAlQWos4KLe0sKsLoG8MWbpxRXS', NULL, NULL, NULL, NULL, NULL),
(23, 'Birk Immanuel', 'Tjelum', 'btjelum@gmail.com', '1619680045', '$2y$10$FNtr2t8cC1Mk/3K/6.nxTOKy5ReaZVwQCCKXYI.ea.7GgkMyOQBs2', NULL, NULL, NULL, NULL, NULL),
(25, 'Karl-Emil', 'Espersen', 'keogkamed@hotmail.dk', NULL, '$2y$10$fUsZhrrfHIEoc/YY5Z6cAOmXd0zbqohaHRWArKRMdh7Lpsp0bytLW', NULL, NULL, NULL, NULL, NULL),
(26, 'Mille Vinkel', 'Simonsen', 'mille0611@gmail.com', NULL, '$2y$10$MUTPq/xLNSaRXtMKKpFfSOTpAGc0Fr4nFpRsui5ffMA15.mz6Zuf2', NULL, NULL, NULL, NULL, NULL),
(28, 'Emil Beck Aagaard', 'Korneliussen', 'emil.aagaard8@gmail.com', '1620294854', '$2y$10$Qdz3vqgOcmI7vAaIDpqQfOTfQrhvbXZT89V0CGe3pUK5UtdYBuCQO', NULL, NULL, NULL, NULL, NULL),
(30, 'Felix', 'Falck Jacobsen', '123@nej.dk', NULL, '$2y$10$yonQjtyMRLznvT/x3MnGh.fqMbostMYBGGuwPfg6Q/6Vnhe89sJoC', NULL, NULL, NULL, NULL, NULL),
(31, 'Emil', 'Gozalov', 'emilgozalov02@hotmail.com', NULL, '$2y$10$wguiQy4LwnY7Mk.tVkZ/TOjs19QtSZOo4VEoaPMTV1EC53rqRwGpG', '02267860-b3ec-11eb-9641-e2f16065c638', NULL, NULL, '1620911179', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `connectedServices`
--
ALTER TABLE `connectedServices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
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
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=641;
--
-- AUTO_INCREMENT for table `connectedServices`
--
ALTER TABLE `connectedServices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
