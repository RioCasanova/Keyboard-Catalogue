-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 15, 2023 at 11:58 AM
-- Server version: 10.4.31-MariaDB
-- PHP Version: 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rcasanova2_dmit2025`
--

-- --------------------------------------------------------

--
-- Table structure for table `keyboards`
--

CREATE TABLE `keyboards` (
  `keyboard_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `rgb` tinyint(1) NOT NULL,
  `led_type` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL,
  `case_material` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `connectivity` varchar(50) NOT NULL,
  `image` varchar(250) NOT NULL,
  `site` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `youtube_link` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `keyboards`
--

INSERT INTO `keyboards` (`keyboard_id`, `name`, `brand`, `rgb`, `led_type`, `size`, `case_material`, `color`, `price`, `connectivity`, `image`, `site`, `description`, `youtube_link`) VALUES
(11, 'Zoom65', 'Meletrix', 1, 'north', '65%', 'aluminum', 'Orange, White, Blue, Black, Grey', 210, 'bluetooth, wired', 'zoom65.jpeg', 'https://meletrix.com/collections/zoom65-v2-5', 'comes in many different colors -- very hard to get your hands on unless you pre-order', 'https://www.youtube.com/watch?v=sl3dT25IAE8'),
(13, 'Hi75', 'Leobog', 1, 'south', '75%', 'aluminum', 'White', 99, 'wired', 'leobog-hi75.jpg', 'https://www.whatgeek.com/?utm_source=google-search&utm_campaign=search-0824&utm_medium=c_leobog%20hi75&gad_source=1&gclid=Cj0KCQiA67CrBhC1ARIsACKAa8Q65N559l2cEaZ0P9Kco8DPKiAcb0ejlugeFwcMFNL6gaRQ0qNXGQ0aApmpEALw_wcB', 'Very good budget keyboard', 'https://www.youtube.com/watch?v=AZnoLF942mI&t=530s'),
(17, 'Phil Test', 'Redmond', 1, 'south', '75%', 'plastic', 'Orange, White, Blue, Black, Grey', 202, 'dongle', '04.jpg', 'https://meletrix.com/collections/zoom65-v2-5', 'comes in many different colors -- very hard to get your hands on unless you pre-order', 'https://www.youtube.com/watch?v=sl3dT25IAE8'),
(19, 'Zoom 75', 'Meletrix', 1, 'south', '75%', 'aluminum', 'Black, Cool Grey, Lilac, Milk Tea, Navy', 250, 'bluetooth, dongle', 'zoom75.jpg', 'https://cannonkeys.com/products/zoom75', 'This board is extremely customizable, with over 20 colours to choose from, and swappable knob and screen.', 'https://www.youtube.com/watch?v=UfkW7LI9AtM'),
(20, 'Zoom 98', 'Meletrix', 1, 'south', '98%', 'aluminum', 'Black', 205, 'bluetooth, dongle, wired', 'zoom98.jpg', 'https://meletrix.com/collections/zoom98', 'Comes with lots of foam but is currently sold out. You can still pre-order. This is the barebones kit, meaning you need to but keycaps and switches.', 'https://www.youtube.com/watch?v=yAc7zchwKFU'),
(21, 'QK75N', 'Qwerty Keys', 1, 'south', '75%', 'aluminum', 'White, Black, Coffee', 180, 'bluetooth, dongle, wired', 'qk75n.jpeg', 'https://qwertyqop.com/pages/qk75n', '14 different available colour ways but is currently sold out in most locations. This board is great for starters because of its simple build, designed with magnet connects which are not usual.', 'https://www.youtube.com/watch?v=gLpnXCik4wY'),
(22, 'GMMK Pro', 'Glorious', 1, 'south', '75%', 'aluminum', 'Black, White, Grey', 169, 'wired', 'GMKPro.jpeg', 'https://www.deskhero.ca/products/gmmk-pro-white-75-premium-barebones-keyboard', 'Great gaming keyboard. Can buy barebones or pre-built. Often described as over-hyped. It comes from a gaming company not a custom keyboard company. Yes its weird that they&#39;re different.', 'https://www.youtube.com/watch?v=TFtuODqNSFg'),
(23, 'GMK 67', 'Zuoya', 1, 'south', '65%', 'plastic', 'Black, Blue, Brown, Red, Yellow, Silver', 65, 'bluetooth, dongle, wired', 'GMK67.jpeg', 'https://www.thekapco.com/products/gmk67-mechanical-keyboard-white', 'This is a 65% keyboard not to be confused with the GMMK brand name.This is a budget option.', 'https://www.youtube.com/watch?v=7v8bekkknjo'),
(24, 'IK75', 'FEKER', 1, 'north', '75%', 'plastic', 'White', 79, 'bluetooth, dongle, wired', 'IK75.jpeg', 'https://epomaker.com/products/epomaker-feker-ik75-v5-kit', 'This is a kit, i am not sure if you can buy this pre-built. Some people are not crazy about the see through case. It is a budget item', 'https://www.youtube.com/watch?v=-2fWM_M9BV0'),
(25, 'GK61 Pro', 'SKYLOONG', 1, 'south', '60%', 'plastic', 'Comes in various colorways - blue, grey, yellow', 69, 'bluetooth, dongle, wired', 'GK61.jpeg', 'https://skyloong.vip/products/60-keyboard-gk61-pro', 'Budget item, has a split space-bar which is very unique.', 'https://www.youtube.com/watch?v=aLGeWh8UIEE'),
(26, 'K75', 'FEKER', 1, 'south', '75%', 'plastic', 'Pink, Grey, White, Strawberry, Black', 109, 'bluetooth, dongle, wired', 'K75.jpeg', 'https://mechkeys.com/products/feker-k75-mechanical-keyboard?variant=44313796837599', 'This is a very unique board with the size of the knob and the screen on the knob. It comes with a choice of two switches, they are factory lubed. Also comes with stabilizers and foam.', 'https://www.youtube.com/watch?v=SuPuKERqw1c'),
(27, 'Summit 65', '100X THIEVES', 1, 'south', '65%', 'aluminum', 'White, Black', 260, 'wired', 'Summit65.jpeg', 'https://higround.co/collections/summit-65-keyboards', 'A joke in the custom keyboard world. Keycaps look sick though.', 'https://www.youtube.com/watch?v=k22AbvfmFnU'),
(28, 'Mojo 60', 'Melgeek', 1, 'south', '60%', 'plastic', 'Yellow, Silver, White, Black, Red, Purple', 89, 'bluetooth, dongle, wired', 'Mojo60.jpeg', 'https://www.melgeek.com/products/melgeek-mojo60-aluminum-mechanical-keyboard-case', 'Looks cool but is currently sold out.', 'https://www.youtube.com/watch?v=8Thb7Thnka0'),
(29, 'Mojo 84', 'Melgeek', 1, 'south', '75%', 'plastic', 'Transparent', 219, 'bluetooth, dongle, wired', 'Mojo84.jpeg', 'https://www.melgeek.com/products/melgeek-mojo84-plastic-original-see-through-custom-programmable-mechanical-keyboard', 'This has a fully transparent case which makes this board unique in comparison to many other options.', 'https://www.youtube.com/watch?v=6hnB6aaD7Cw'),
(30, 'Mode 97', 'Melgeek', 1, 'south', '98%', 'aluminum', 'White with black spots, Grey with black spots', 139, 'bluetooth, dongle, wired', 'Modern97.jpeg', 'https://www.melgeek.com/products/melgeek-modern97', 'I really love the design of this keyboard. You can tell compared to many other keyboards that lots of thought when into the aesthetics and colour choices.', 'https://www.youtube.com/watch?v=cZEBCE3wEf4'),
(31, 'Melgeek Pixel', 'Melgeek', 0, 'south', '98%', 'plastic', 'Blue, White, Pink', 299, 'bluetooth, dongle, wired', 'Pixel.jpeg', 'https://www.melgeek.com/products/melgeek-pixel-brick-compatible-mechanical-keyboard', 'This is a very unique keyboard because this is the first keyboard made out of lego. There is a website specifically for customizing this keyboard which is really cool.', 'https://www.youtube.com/watch?v=D3RELxBz5jU'),
(32, 'Mojo 68', 'Melgeek', 1, 'south', '65%', 'plastic', 'Transparent', 199, 'bluetooth, dongle, wired', 'Mojo68.jpeg', 'https://www.melgeek.com/products/melgeek-mojo68-plastic-see-through-custom-programmable-mechanical-keyboard', 'This is a keyboard that is often advertised everywhere because of its unique keycap design.', 'https://www.youtube.com/watch?v=w08w6LmLhRg'),
(33, 'MK870', 'FLESPORTS', 1, 'south', '98%', 'plastic', 'Translucent Black', 55, 'bluetooth, dongle, wired', 'MK870.jpeg', 'https://drop.com/buy/flesports-mk870-tkl-hot-swappable-mechanical-keyboard?defaultSelectionIds=977746', 'This comes as a DIY Kit. Budget keyboard.', 'https://www.youtube.com/watch?v=07j30EowHGU'),
(34, 'WK870', 'KeebMonkey', 1, 'south', 'other', 'aluminum', 'Pink, Green, Black, White, Blue', 59, 'wired', 'WK870.jpeg', 'https://www.keebmonkey.com/en-ca/products/wk870', 'budget keyboard TKL. Generic budget keyboard, nothing to write home about. Its price point is what makes this keyboard so desirable.', 'https://www.youtube.com/watch?v=DQ2pCncUrgM'),
(35, 'Cyboard', 'DROP', 1, 'south', 'other', 'aluminum', 'Purple & Cyber Yellow', 200, 'bluetooth, dongle, wired', 'Cyboard.jpeg', 'https://drop.com/buy/drop-paragon-series-cyboard', 'Hard to find reviews on this board because it is so expensive. It is uniquely designed when it comes to colour and style.', 'https://www.youtube.com/watch?v=o-WVLvoVo3w'),
(36, 'Block 98', 'Lofree', 0, 'south', '98%', 'plastic', 'Grey', 226, 'bluetooth, dongle, wired', 'Block98.jpeg', 'https://www.lofree.co/products/lofree-block-wireless-mechanical-keyboard-1?variant=44242489278683', 'This is supposed to be a keyboard that emulates what keyboards were like back in the day. Just by the design you can tell where their mind was at when designing it. the backlighting is only white.', 'https://www.youtube.com/watch?v=KC0_ATreEuY'),
(37, 'Alice 98', 'FEKER', 1, 'south', '98%', 'plastic', 'White', 135, 'bluetooth, dongle', 'Alice98.jpeg', 'https://epomaker.com/products/feker-alice98', 'This keyboard is unique because of the separation of the keyboard. It is like having one keyboard for each hand.', 'https://www.youtube.com/watch?v=wzA9VwZPcQI'),
(38, 'Loflick', 'Lofree', 1, 'south', '65%', 'plastic', 'Pink', 129, 'bluetooth, dongle, wired', 'Loflick.jpeg', 'https://mechkeys.com/products/lofree-loflick100-loflick68-triple-mode-connection-mechanical-keyboard?variant=42929378689247', 'Very cute keyboard', 'https://www.youtube.com/watch?v=VNdxMtbJtw0'),
(39, 'KT68', 'MACHENIKE', 1, 'south', '65%', 'plastic', 'Black, White', 129, 'bluetooth, dongle, wired', 'KT68.jpeg', 'https://epomaker.com/products/machenike-kt68', 'This keyboard is very cool because it has a huge screen across the top of the keyboard.', 'https://www.youtube.com/watch?v=MMVC2nUXEOM'),
(40, 'AK820 Pro', 'Ajazz', 1, 'south', '75%', 'plastic', 'Lilac, Green, Black', 49, 'wired', 'AK820.jpeg', 'https://epomaker.com/products/ajazz-ak820', 'Very nice budget option', 'https://www.youtube.com/watch?v=VYoPt7wB_xE'),
(41, 'MOD 007', 'Akko', 1, 'south', '75%', 'aluminum', 'White, Black, Grey, Pink', 149, 'wired', 'Mod007.jpeg', 'https://en.akkogear.com/product/mod-007-aluminum-diy-kit/', 'This is a kit that you can build yourself, you&#39;ll need to buy switches and keycaps', 'https://www.youtube.com/watch?v=9eHGWjBzFE4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keyboards`
--
ALTER TABLE `keyboards`
  ADD PRIMARY KEY (`keyboard_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keyboards`
--
ALTER TABLE `keyboards`
  MODIFY `keyboard_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
