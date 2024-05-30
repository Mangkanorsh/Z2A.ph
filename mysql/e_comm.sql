-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 11:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_comm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(100) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `admin_image` text NOT NULL,
  `admin_contact` varchar(255) NOT NULL,
  `admin_country` text NOT NULL,
  `admin_job` varchar(255) NOT NULL,
  `admin_about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_pass`, `admin_image`, `admin_contact`, `admin_country`, `admin_job`, `admin_about`) VALUES
(5, 'admin', 'admin@gmail.com', '12345', 'croppedImage_1531040053949.png', '7015963438', 'india', 'WEB DEVELOPER', 'I AM RAKESH KUMAR');

-- --------------------------------------------------------

--
-- Table structure for table `boxes_section`
--

CREATE TABLE `boxes_section` (
  `box_id` int(100) NOT NULL,
  `box_icon` varchar(100) NOT NULL,
  `box_title` varchar(255) NOT NULL,
  `box_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boxes_section`
--

INSERT INTO `boxes_section` (`box_id`, `box_icon`, `box_title`, `box_desc`) VALUES
(4, 'fa fa-trash', 'BEST IN MARKET', 'offer'),
(6, 'fa fa-shipping-fast fa-5', 'FAST SERVICE', 'raw'),
(7, 'fa fa-user', 'EDIT YOURSELF', 'edit'),
(8, 'fa fa-trash', 'DELETE EVERYTHING', 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `p_id` int(100) NOT NULL,
  `ip_add` varchar(255) NOT NULL,
  `qty` int(100) NOT NULL,
  `size` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(100) NOT NULL,
  `cat_title` text NOT NULL,
  `cat_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`, `cat_desc`) VALUES
(1, 'Tops', ''),
(2, 'Bottoms', ''),
(3, 'Headwears', ''),
(4, 'Footwears', ''),
(5, 'Accessories', '');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(100) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_pass` varchar(255) NOT NULL,
  `customer_full_address` text NOT NULL,
  `customer_contact` varchar(255) NOT NULL,
  `customer_image` text NOT NULL,
  `customer_ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `product_id` int(100) NOT NULL,
  `due_amount` int(100) NOT NULL,
  `invoice_no` int(100) NOT NULL,
  `qty` int(10) NOT NULL,
  `size` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(100) NOT NULL,
  `invoice_id` int(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `payment_mode` text NOT NULL,
  `ref_no` int(100) NOT NULL,
  `payment_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `p_cat_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_title` text NOT NULL,
  `product_img1` text NOT NULL,
  `product_img2` text NOT NULL,
  `product_img3` text NOT NULL,
  `product_price` int(10) NOT NULL,
  `product_desc` text NOT NULL,
  `product_keyword` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `p_cat_id`, `cat_id`, `date`, `product_title`, `product_img1`, `product_img2`, `product_img3`, `product_price`, `product_desc`, `product_keyword`) VALUES
(53, 1, 1, '2024-05-24 03:22:53', 'Men T-Shirt', 'p13.png', 'p13.png', 'p13.png', 33, 'shirt', 'shirt'),
(54, 1, 1, '2024-05-24 20:30:13', 'Vintage Bomber Jackets', 'hoodie.jpg', 'hoodie1.jpg', 'hoodie2.jpg', 1000, 'qwerty', 'Hoodie'),
(55, 1, 1, '2024-05-24 20:45:20', 'Half-zip Sweater', 'cardigan.jpg', 'cardigan1.jpg', 'cardigan2.jpg', 4210, '- Model is 5ft 11\" (180cm) tall, 150 lbs(68kg) weight and wearing a size XL L (fitted), size XL (loose)- 5ft 9\'(176cm) tall, 136 lbs(62kg) weight and wearing a size L ', 'sweater'),
(56, 1, 2, '2024-05-24 20:55:16', 'Corduroy Vintage Cargo Sweatpants', 'cordo.jpg', 'cordo1.jpg', 'cordo2.jpg', 1500, 'Corduroy pants for men', 'corduroy'),
(57, 1, 4, '2024-05-24 21:01:04', 'Birkenstock Boston Clog', 'bk.png', 'bk1.png', 'bk2.png', 8000, 'The Boston clog from Birkenstock is a versatile classic you can rock all year long. A contoured footbed and suede lining keep you extra comfortable. ', 'clogs'),
(58, 1, 2, '2024-05-24 21:41:16', 'Loose Jean', 'loosejeans.png', 'loosejeans1.png', 'loosejeans2.png', 2500, 'Our on-trend loose jeans that are relaxed and loose-fitting through the hip and thigh in our 100% cotton no-stretch fabric and broken-in denim feel. Features a medium wash and frayed hem. Imported.', 'jeans'),
(59, 1, 4, '2024-05-24 21:46:30', 'Adidas Samba Green and White', 'sambas.jpg', 'sambas1.jpg', 'sambas2.jpg', 4500, 'A FAITHFUL REPRODUCTION OF THE 1950 SAMBA SNEAKER.\r\nGetting up and down the field with speed is the name of the indoor game. The Samba has dominated indoor soccer for decades for a reason. These legendary shoes feature a leather upper and a lightweight EVA midsole for better response on indoor surfaces.\r\n\r\n\r\n', 'sambas'),
(60, 2, 1, '2024-05-24 21:52:27', 'Cropped T-Shirts', 'wtop.png', 'wtop1.png', 'wtop2.png', 800, '', 'cropped'),
(61, 2, 2, '2024-05-24 21:58:15', 'Ditsy Floral Print Split Thigh Skirt', 'Ditsy Floral Print Split Thigh Skirt.png', 'Ditsy Floral Print Split Thigh Skirt1.png', 'Ditsy Floral Print Split Thigh Skirt2.png', 1500, 'Color: Black\r\nStyle: Boho\r\nPattern Type: Ditsy Floral\r\nDetails: Zipper, Split Thigh\r\nType: Slit\r\nWaist Line: High Waist\r\nLength: Midi\r\nFabric: Non-Stretch\r\nMaterial: Fabric\r\nComposition: 100% Polyester\r\nCare Instructions: Machine wash or professional dry clean\r\nBody: Unlined\r\nSheer: No', 'skirt'),
(62, 2, 1, '2024-05-24 22:02:21', 'Aspen Pastel Knit Vest', 'Aspen Pastel Knit Vest1.png', 'Aspen Pastel Knit Vest.png', 'Aspen Pastel Knit Vest2.png', 2000, 'For a soft fresh mood... Our Aspen Pastel Knit Vest is a refreshing minty green colour featuring fibbed hems and a white striped v-collar. Looks so cute paired over our Athena Polo Knit Top and Basics Tennis Skirt. ', 'vest'),
(63, 2, 2, '2024-05-24 22:06:15', 'Wide-Leg Pants', 'Wide-Leg Pants.png', 'Wide-Leg Pants1.png', 'Wide-Leg Pants2.png', 4482, 'These classic wide-leg Ms. Onassis pants from Triarchy feature a crisp cotton fabrication, tailored with a high waist.', 'Pants'),
(64, 2, 1, '2024-05-24 22:13:13', 'Frenchie Cardigan', 'FRENCHIE CARDIGAN1.png', 'FRENCHIE CARDIGAN2.png', 'FRENCHIE CARDIGAN3.png', 4400, 'Cozy up in the chicest sweater of the season. Plush, billowy, and sheer, this pretty pastel cardigan is the everyday essential you’ve been waiting for.', 'cardigan'),
(65, 2, 4, '2024-05-24 22:18:52', 'Nike Zoom Vormero 5 “520”', 'Nike Zoom Vormero 5.jpg', 'Nike Zoom Vormero 51.jpeg', 'Nike Zoom Vormero 52.jpeg', 5500, 'Dressed in a mix of white, metallic silver, and pink, the Swoosh’s latest iteration comes constructed in an open mesh base and leather overlays. Its signature plastic heel counters and side panels, along with two Swooshes on each side. Concluding the silhouette is “520” branding on the heels, which rests atop Nike’s Zoom Air cushioning.', 'shoes'),
(66, 2, 1, '2024-05-24 22:24:20', 'POPLIN, ROYAL BLUE STRIPE', 'POPLIN, ROYAL BLUE STRIPE.png', 'POPLIN, ROYAL BLUE STRIPE1.png', 'POPLIN, ROYAL BLUE STRIPE2.png', 8350, 'Designed to make you stand out, whether in the workplace or out and about in the city. The durability of the Poplin fabric and deep blue stripes makes this shirt a key item in every modern woman’s wardrobe.', 'poplo'),
(67, 1, 1, '2024-05-24 22:39:50', 'Knitted Polo Shirt', 'KNITTED POLO SHIRT.png', 'KNITTED POLO SHIRT1.png', 'KNITTED POLO SHIRT2.png', 2900, '', 'polo'),
(68, 1, 1, '2024-05-24 22:42:27', 'MANDARIN COLLAR KNITTED SHIRT', 'MANDARIN COLLAR KNITTED SHIRT.png', 'MANDARIN COLLAR KNITTED SHIRT1.png', 'MANDARIN COLLAR KNITTED SHIRT2.png', 2400, '', 'collar'),
(69, 1, 2, '2024-05-24 22:48:11', 'Loose Straight Denim Pants', 'LOOSE STRAIGHT DENIM PANTS.png', 'LOOSE STRAIGHT DENIM PANTS1.png', 'LOOSE STRAIGHT DENIM PANTS2.png', 2900, '', 'denim pants'),
(70, 1, 1, '2024-05-24 22:51:43', 'Knitted Round Neck Sweater', 'KNITTED ROUND NECK SWEATER.png', 'KNITTED ROUND NECK SWEATER1.png', 'KNITTED ROUND NECK SWEATER2.png', 3600, '', 'sweater'),
(71, 1, 1, '2024-05-24 22:53:59', 'Green Letter Print Hoodie', 'GREEN LETTER PRINT HOODIE.png', 'GREEN LETTER PRINT HOODIE1.png', 'GREEN LETTER PRINT HOODIE2.png', 3300, '', 'hoodie'),
(72, 1, 1, '2024-05-24 22:56:19', 'Short Sleeve Turtleneck Knit Pullover', 'Short Sleeve Turtleneck Knit Pullover.png', 'Short Sleeve Turtleneck Knit Pullover1.png', 'Short Sleeve Turtleneck Knit Pullover2.png', 2100, '', 'tutle'),
(73, 2, 1, '2024-05-24 22:58:21', 'Knit Gray Long Sleeve Full Zip Sweater', 'Knit Gray Long Sleeve Full Zip Sweater1.png', 'Knit Gray Long Sleeve Full Zip Sweater2.png', 'Knit Gray Long Sleeve Full Zip Sweater3.png', 3000, '', 'sweater'),
(74, 2, 1, '2024-05-24 23:00:29', 'Slim Fit Cropped Hoodie', 'Slim Fit Cropped Hoodie1.png', 'Slim Fit Cropped Hoodie2.png', 'Slim Fit Cropped Hoodie3.png', 2800, '', 'hoodie'),
(75, 2, 1, '2024-05-24 23:02:25', 'Off Shoulder Zip up Knitted Top', 'Off Shoulder Zip up Knitted Top1.png', 'Off Shoulder Zip up Knitted Top2.png', 'Off Shoulder Zip up Knitted Top3.png', 2800, '', 'shoulder'),
(76, 2, 2, '2024-05-24 23:04:27', 'High Waist Sheath Denim Skirt', 'High Waist Sheath Denim Skirt1.png', 'High Waist Sheath Denim Skirt2.png', 'High Waist Sheath Denim Skirt3.png', 3400, '', 'skirt'),
(77, 2, 2, '2024-05-24 23:07:25', 'Retro Straight Leg Jeans Pants ', 'Retro Straight Leg Jeans Pants 1.png', 'Retro Straight Leg Jeans Pants 2.png', 'Retro Straight Leg Jeans Pants 3.png', 3400, '', 'Pants'),
(78, 3, 1, '2024-05-24 23:11:28', 'Blue Stripe Top & Dungaree Set (Newborn-23mths) - Age 6 - 9 Months', 'Kids Blue Stripe Top & Dungaree Set (Newborn-23mths) - Age 6 - 9 Months2.png', 'Kids Blue Stripe Top & Dungaree Set (Newborn-23mths) - Age 6 - 9 Months1.png', 'Kids Blue Stripe Top & Dungaree Set (Newborn-23mths) - Age 6 - 9 Months2.png', 800, '', 'top');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `p_cat_id` int(10) NOT NULL,
  `p_cat_title` text NOT NULL,
  `p_cat_desc` text NOT NULL,
  `p_cat_img` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`p_cat_id`, `p_cat_title`, `p_cat_desc`, `p_cat_img`) VALUES
(1, 'Men', '', 0),
(2, 'Women', '', 0),
(3, 'Kids\' & Baby', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `Id` int(10) NOT NULL,
  `slider_name` varchar(255) NOT NULL,
  `slider_image` text NOT NULL,
  `slider_url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`Id`, `slider_name`, `slider_image`, `slider_url`) VALUES
(25, '50percent', 'Yellow White and Brown Illustrative Coming Soon Banner (3).png', '#'),
(26, 'grand opening', 'Yellow White and Brown Illustrative Coming Soon Banner (2).png', '#'),
(27, 'coming soon', 'Yellow White and Brown Illustrative Coming Soon Banner.png', '#');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `boxes_section`
--
ALTER TABLE `boxes_section`
  ADD PRIMARY KEY (`box_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`p_cat_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `boxes_section`
--
ALTER TABLE `boxes_section`
  MODIFY `box_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `p_cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
