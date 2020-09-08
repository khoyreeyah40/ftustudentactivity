-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 08, 2020 at 10:29 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbmyproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `actchecklist`
--

CREATE TABLE `actchecklist` (
  `checklistNo` int(11) NOT NULL,
  `checklistID` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `checklistTime` int(11) NOT NULL,
  `actID` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `actName` int(11) NOT NULL,
  `checklistStatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `orgzerID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `actNo` int(11) NOT NULL,
  `actID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `actYear` int(11) DEFAULT NULL,
  `actSem` int(11) NOT NULL,
  `actName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `actSec` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `actMainorg` int(11) NOT NULL,
  `actOrgtion` int(11) NOT NULL,
  `actType` int(20) NOT NULL,
  `actGroup` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `actReason` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actPurpose` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actStyle` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actDateb` date NOT NULL,
  `actDatee` date NOT NULL,
  `actTimeb` time NOT NULL,
  `actTimee` time NOT NULL,
  `actLocate` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `actPay` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actFile` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actNote` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actAddby` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `actApprover` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actStatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `actSreason` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actAssesslink` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`actNo`, `actID`, `actYear`, `actSem`, `actName`, `actSec`, `actMainorg`, `actOrgtion`, `actType`, `actGroup`, `actReason`, `actPurpose`, `actStyle`, `actDateb`, `actDatee`, `actTimeb`, `actTimee`, `actLocate`, `actPay`, `actFile`, `actNote`, `actAddby`, `actApprover`, `actStatus`, `actSreason`, `actAssesslink`, `createat`, `updateat`) VALUES
(29, 'ORG00029', 2560, 29, 'ปฐมนิเทศ', 'มหาวิทยาลัย', 18, 29, 18, 'รวม', 'หลักการ', 'วัตถุประสงค์', 'รูปแบบ', '2017-06-02', '2017-06-04', '08:00:00', '16:00:00', 'มหาวิทยาลัยฟาฏอนี', 'ไม่มี', 'act/374411.docx', '', 'ORG00002', NULL, 'เสร็จสิ้นกิจกรรม', NULL, 'https://docs.google.com/forms/d/e/1FAIpQLSdVL7-XolfvR2yOsx9saqjh2Ght_eI3VAcwm97AB_CYfGs4jw/viewform', '2020-09-02 14:36:34', '2020-09-02 17:49:09'),
(30, 'ORG00030', 2560, 29, 'กิยามุลลัยล์', 'คณะ', 15, 30, 13, 'หญิง', 'หลักการและเหตุผล', 'วัตถุประสงค์', 'รูปแบบ', '2017-10-02', '2017-10-03', '18:00:00', '07:10:00', 'ฮารอมัยน์', 'ไม่มี', 'act/337079.docx', '', 'ORG00100', 'ORG00003', 'เสร็จสิ้นกิจกรรม', '', 'https://docs.google.com/forms/d/e/1FAIpQLSdVL7-XolfvR2yOsx9saqjh2Ght_eI3VAcwm97AB_CYfGs4jw/viewform', '2020-09-02 16:11:28', '2020-09-02 17:49:09'),
(31, 'ORG00031', 2560, 30, 'อบรมจริยธรรม', 'มหาวิทยาลัย', 18, 32, 14, 'หญิง', 'หลักการ', 'เพื่อ', 'แบบ', '2017-10-03', '2017-10-03', '10:00:00', '12:00:00', 'หอประชุม', 'ไม่มี', NULL, '', 'ORG00002', NULL, 'เสร็จสิ้นกิจกรรม', NULL, 'https://docs.google.com/forms/d/e/1FAIpQLSdVL7-XolfvR2yOsx9saqjh2Ght_eI3VAcwm97AB_CYfGs4jw/viewform', '2020-09-02 17:46:45', '2020-09-02 20:04:19'),
(33, 'ORG00033', 2561, 31, 'กิยามุลลัยล์', 'คณะ', 15, 30, 13, 'รวม', 'กกกก', 'กกก', 'กก', '2020-09-07', '2020-09-08', '17:28:00', '07:00:00', 'ฮารอมัยน์', 'ไม่มี', NULL, '', 'ORG00003', NULL, 'ดำเนินกิจกรรม', NULL, 'https://docs.google.com/forms/d/e/1FAIpQLSdVL7-XolfvR2yOsx9saqjh2Ght_eI3VAcwm97AB_CYfGs4jw/viewform', '2020-09-07 09:29:25', '2020-09-07 09:35:17'),
(35, 'ORG00035', 2561, 31, 'ค่ายพัฒนาศักยภาพนักศึกษาปี 1', 'มหาวิทยาลัย', 18, 29, 15, 'รวม', 'lll', 'llll', 'llll', '2020-09-08', '2020-09-10', '08:26:00', '16:26:00', 'มหาวิทยาลัยฟาฏอนี', 'ไม่มี', 'act/448338.xlsx', '', 'ORG00001', 'ORG00001', 'ดำเนินกิจกรรม', NULL, 'https://docs.google.com/forms/d/e/1FAIpQLSdVL7-XolfvR2yOsx9saqjh2Ght_eI3VAcwm97AB_CYfGs4jw/viewform', '2020-09-07 19:26:59', '2020-09-07 19:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `actregister`
--

CREATE TABLE `actregister` (
  `actregNo` int(11) NOT NULL,
  `actregactID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `actregstdID` int(20) NOT NULL,
  `actregStatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `actregAddby` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actregcreateat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `actregister`
--

INSERT INTO `actregister` (`actregNo`, `actregactID`, `actregstdID`, `actregStatus`, `actregAddby`, `actregcreateat`) VALUES
(25, 'ORG00029', 602431019, 'ยืนยันเรียบร้อย', 'ORG00002', '2020-09-02 14:49:33'),
(27, 'ORG00030', 602431019, 'ยืนยันเรียบร้อย', 'ORG00100', '2020-09-02 16:42:58'),
(29, 'ORG00031', 602431019, 'ยืนยันเรียบร้อย', 'ORG00089', '2020-09-02 18:39:34'),
(32, 'ORG00033', 602431019, 'ยืนยันเรียบร้อย', 'ORG00001', '2020-09-07 09:38:46');

-- --------------------------------------------------------

--
-- Table structure for table `actsem`
--

CREATE TABLE `actsem` (
  `actsemNo` int(11) NOT NULL,
  `actsem` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `actsemyear` int(11) NOT NULL,
  `actsemStatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `actsem`
--

INSERT INTO `actsem` (`actsemNo`, `actsem`, `actsemyear`, `actsemStatus`, `createat`) VALUES
(29, '1', 2560, 'สำเร็จกิจกรรมแล้ว', '2020-09-02 14:10:58'),
(30, '2', 2560, 'สำเร็จกิจกรรมแล้ว', '2020-09-02 17:43:44'),
(31, '1', 2561, 'ดำเนินกิจกรรม', '2020-09-02 17:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `acttype`
--

CREATE TABLE `acttype` (
  `acttypeNo` int(11) NOT NULL,
  `acttypeName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `acttypeAddby` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acttype`
--

INSERT INTO `acttype` (`acttypeNo`, `acttypeName`, `acttypeAddby`, `createat`) VALUES
(12, 'กลุ่มศึกษาอัลกุรอ่าน', 'ORG00000', '2020-07-08 03:07:20'),
(13, 'กิยามุลลัยล์', 'ORG00000', '2020-07-08 03:07:20'),
(14, 'อบรมคุณธรรมจริยธรรม', 'ORG00001', '2020-07-08 17:31:39'),
(15, 'ค่ายพัฒนานักศึกษา(ปี1)', 'ORG00001', '2020-07-08 17:51:41'),
(16, 'อิอฺติก๊าฟ 10 วันสุดท้ายเดือนรอมฎอน', 'ORG00001', '2020-07-08 17:51:46'),
(18, 'ปฐมนิเทศ', 'ORG00001', '2020-07-08 17:52:59'),
(20, 'กิจกรรมชมรม', 'ORG00001', '2020-08-05 16:37:38'),
(21, 'ปัจฉิมนิเทศ', 'ORG00001', '2020-08-09 17:05:23'),
(22, 'กิจกรรมองค์การบริหารนักศึกษา', 'ORG00001', '2020-08-09 17:05:45'),
(23, 'กิจกรรมชุมนุม', 'ORG00001', '2020-08-09 17:06:03'),
(24, 'กิจกรรมสโมสรคณะ', 'ORG00001', '2020-08-09 17:06:18'),
(25, 'ค่ายพัฒนานักศึกษา(ปี3)', 'ORG00001', '2020-08-31 05:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `actyear`
--

CREATE TABLE `actyear` (
  `actyear` int(11) NOT NULL,
  `actyearStatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `actyear`
--

INSERT INTO `actyear` (`actyear`, `actyearStatus`, `createat`) VALUES
(2560, 'สำเร็จกิจกรรมแล้ว', '2020-09-02 14:10:58'),
(2561, 'ดำเนินกิจกรรม', '2020-09-02 17:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE `board` (
  `boardNo` int(11) NOT NULL,
  `boardName` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardDiscribe` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `board` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `boardStatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `boardLink` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardAddby` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`boardNo`, `boardName`, `boardDiscribe`, `board`, `boardStatus`, `boardLink`, `boardAddby`, `createat`) VALUES
(14, 'เปิดบวชวันอาซูรอ', '', 'board/613891.jpg', 'แสดง', 'http://www.ftu.ac.th/2019/index.php/th/about-th', 'ORG00002', '2020-07-08 16:23:47'),
(17, 'รับสมัครนักศึกษาใหม่', '', 'board/45979.jpg', 'แสดง', '', 'ORG00002', '2020-07-08 16:33:14');

-- --------------------------------------------------------

--
-- Table structure for table `club`
--

CREATE TABLE `club` (
  `clubNo` int(11) NOT NULL,
  `clubYear` int(50) NOT NULL,
  `clubstdID` int(50) NOT NULL,
  `clubPst` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `clubOrgtion` int(11) NOT NULL,
  `clubMainorg` int(11) NOT NULL,
  `clubAddby` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `club`
--

INSERT INTO `club` (`clubNo`, `clubYear`, `clubstdID`, `clubPst`, `clubOrgtion`, `clubMainorg`, `clubAddby`, `createat`) VALUES
(12, 2560, 602431019, 'สมาชิก', 33, 14, 'ORG00093', '2020-09-02 14:52:31'),
(14, 2561, 602431019, 'สมาชิก', 64, 14, 'ORG00102', '2020-09-02 18:28:10');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dpmNo` int(11) NOT NULL,
  `department` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dpmfct` int(11) NOT NULL,
  `dpmAddby` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dpmNo`, `department`, `dpmfct`, `dpmAddby`, `createat`) VALUES
(11, 'สาขาวิชาการสอนอิสลามศึกษา', 17, 'ORG00001', '2020-07-11 12:03:43'),
(13, 'สาขาวิชาวิจัยและพัฒนาผลิตภัฑณ์ฮาลาล', 15, 'ORG00003', '2020-07-11 12:58:42'),
(14, 'สาขาวิชาการสอนเคมี', 17, 'ORG00001', '2020-07-11 16:40:11'),
(15, 'สาขาวิชาวิทยาการข้อมูลและการวิเคราะห์', 15, 'ORG00001', '2020-07-11 16:40:37'),
(18, 'สาขาวิชาเทคโนโลยีสารสนเทศ', 15, 'ORG00001', '2020-07-26 18:33:04'),
(19, 'สาขาวิชาชะรีอะฮฺ', 20, 'ORG00001', '2020-08-30 13:55:33'),
(20, 'สาขาวิชาอุศูลุดดีน', 20, 'ORG00001', '2020-08-30 13:56:03'),
(21, 'สาขาวิชาอิสลามศึกษา', 20, 'ORG00001', '2020-08-30 13:56:17'),
(22, 'สาขาวิชานิติศาสตร์', 20, 'ORG00001', '2020-08-30 13:56:31'),
(23, 'สาขาวิชาอัลกุรอานและอัสสุนนะห์', 20, 'ORG00001', '2020-08-30 13:56:59'),
(24, 'สาขาวิชาภาษาอาหรับ', 19, 'ORG00001', '2020-08-30 13:57:30'),
(25, 'สาขาวิชารัฐประศาสนศาสตร์', 19, 'ORG00001', '2020-08-30 13:57:53'),
(26, 'สาขาวิชาเศรฐศาสตร์การเงินและการธนาคาร', 19, 'ORG00001', '2020-08-30 13:58:34'),
(27, 'สาขาวิชาภาษาอังกฤษ', 19, 'ORG00001', '2020-08-30 13:58:51'),
(28, 'สาขาวิชาภาษามลายู', 19, 'ORG00001', '2020-08-30 13:59:10'),
(29, 'สาขาวิชาบริหารธุรกิจ', 19, 'ORG00001', '2020-08-30 13:59:26'),
(30, 'สาขาวิชาการสอนภาษาอาหรับ', 17, 'ORG00001', '2020-08-30 14:00:35'),
(31, 'สาขาวิชาการสอนวิทยาศาสตร์ทั่วไป', 17, 'ORG00001', '2020-08-30 14:01:33'),
(32, 'สาขาวิชาการสอนภาษาอังกฤษ', 17, 'ORG00001', '2020-08-30 14:01:55'),
(33, 'สาขาวิชาการสอนภาษามลายู', 17, 'ORG00001', '2020-08-30 14:02:25'),
(34, 'สาขาวิชาการสอนภาษามลายูและเทคโนโลยีการศึกษา', 17, 'ORG00001', '2020-08-30 14:02:56'),
(36, 'สาขาวิชาเคมี', 17, 'ORG00001', '2020-08-30 14:03:34');

-- --------------------------------------------------------

--
-- Table structure for table `eiatiqaf`
--

CREATE TABLE `eiatiqaf` (
  `eiatiqafNo` int(11) NOT NULL,
  `eiatiqafYear` int(11) NOT NULL,
  `eiatiqafactType` int(11) NOT NULL,
  `eiatiqafstdID` int(11) NOT NULL,
  `eiatiqafFile` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eiatiqaf`
--

INSERT INTO `eiatiqaf` (`eiatiqafNo`, `eiatiqafYear`, `eiatiqafactType`, `eiatiqafstdID`, `eiatiqafFile`) VALUES
(13, 2560, 16, 602431019, 'eiatiqaf/15201.xlsx');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty` int(11) NOT NULL,
  `fctAddby` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty`, `fctAddby`, `createat`) VALUES
(15, 'ORG00001', '2020-07-11 12:02:45'),
(17, 'ORG00001', '2020-07-11 12:02:39'),
(19, 'ORG00001', '2020-08-17 07:28:18'),
(20, 'ORG00001', '2020-08-30 13:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `fileNo` int(11) NOT NULL,
  `fileName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `fileDoc` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `fileStatus` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fileAddby` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`fileNo`, `fileName`, `fileDoc`, `fileStatus`, `fileAddby`, `createat`) VALUES
(1, 'ตารางกิจกรรม2563', 'announce/389919.xlsx', 'แสดง', 'ORG00001', '2020-07-16 15:24:27');

-- --------------------------------------------------------

--
-- Table structure for table `finishact`
--

CREATE TABLE `finishact` (
  `finishactNo` int(11) NOT NULL,
  `finishactYear` int(11) NOT NULL,
  `finishactSem` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `finishactStatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `finishactby` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `halaqahcheck`
--

CREATE TABLE `halaqahcheck` (
  `halaqahcheckNo` int(11) NOT NULL,
  `halaqahchecklistID` int(11) DEFAULT NULL,
  `halaqahcheckstdID` int(11) NOT NULL,
  `halaqahcheckStatus` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `halaqahchecklist`
--

CREATE TABLE `halaqahchecklist` (
  `halaqahchecklistNo` int(11) NOT NULL,
  `halaqahID` int(11) NOT NULL,
  `halaqahchecklistdate` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `halaqahstd`
--

CREATE TABLE `halaqahstd` (
  `halaqahstdNo` int(11) NOT NULL,
  `halaqahID` int(11) NOT NULL,
  `halaqahstdID` int(11) NOT NULL,
  `halaqahstdsem1Status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `halaqahstdsem2Status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `halaqahtc`
--

CREATE TABLE `halaqahtc` (
  `halaqahtcNo` int(11) NOT NULL,
  `halaqahtcYear` int(10) NOT NULL,
  `halaqahtcID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `halaqahtcMainorg` int(11) NOT NULL,
  `halaqahtcAddby` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `halaqahtc`
--

INSERT INTO `halaqahtc` (`halaqahtcNo`, `halaqahtcYear`, `halaqahtcID`, `halaqahtcMainorg`, `halaqahtcAddby`, `createat`) VALUES
(4, 2560, 'ORG00092', 15, 'ORG00003', '2020-09-02 16:53:06');

-- --------------------------------------------------------

--
-- Table structure for table `loginhistory`
--

CREATE TABLE `loginhistory` (
  `loginNo` int(11) NOT NULL,
  `userID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `userName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `userMainorg` int(11) NOT NULL,
  `userOrgtion` int(11) NOT NULL,
  `userType` int(11) NOT NULL,
  `action` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `loginat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `loginhistory`
--

INSERT INTO `loginhistory` (`loginNo`, `userID`, `userName`, `userMainorg`, `userOrgtion`, `userType`, `action`, `loginat`) VALUES
(216, 'ORG00093', 'มุมีนะห์ เจะบู', 14, 33, 7, 'login', '2020-09-02 14:52:05'),
(217, 'ORG00003', 'นูรไลลา ', 15, 30, 3, 'login', '2020-09-02 16:05:15'),
(218, 'ORG00100', 'ฟาฏอนะฮ แวบูละ', 15, 30, 5, 'login', '2020-09-02 16:05:59'),
(219, 'ORG00003', 'นูรไลลา ', 15, 30, 3, 'login', '2020-09-02 16:16:16'),
(220, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-02 16:19:50'),
(221, 'ORG00003', 'นูรไลลา ', 15, 62, 3, 'login', '2020-09-02 16:26:53'),
(222, 'ORG00002', 'suyah', 18, 29, 2, 'login', '2020-09-02 16:51:09'),
(223, 'ORG00003', 'นูรไลลา ', 15, 62, 3, 'login', '2020-09-02 16:52:13'),
(224, 'ORG00002', 'suyah', 18, 29, 2, 'login', '2020-09-02 17:42:58'),
(225, 'ORG00003', 'นูรไลลา ', 15, 62, 3, 'login', '2020-09-02 17:56:06'),
(226, 'ORG00092', 'มุรนี ตันอีโน', 15, 62, 4, 'login', '2020-09-02 17:58:23'),
(227, 'ORG00002', 'suyah', 18, 29, 2, 'login', '2020-09-02 18:03:22'),
(228, 'ORG00088', 'ฮากีมะห์ เย็ง', 18, 32, 6, 'login', '2020-09-02 18:06:13'),
(229, 'ORG00002', 'suyah', 18, 29, 2, 'login', '2020-09-02 18:06:57'),
(230, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-02 18:07:13'),
(231, 'ORG00088', 'ฮากีมะห์ เย็ง', 18, 32, 6, 'login', '2020-09-02 18:08:10'),
(232, 'ORG00002', 'suyah', 18, 29, 2, 'login', '2020-09-02 18:10:16'),
(233, 'ORG00089', 'ฮากีมะห์ เย็ง', 18, 32, 2, 'login', '2020-09-02 18:16:50'),
(234, 'ORG00102', 'กิฟละห์ บาเน็ง', 14, 64, 6, 'login', '2020-09-02 18:25:35'),
(235, 'ORG00089', 'ฮากีมะห์ เย็ง', 18, 32, 2, 'login', '2020-09-02 18:26:29'),
(236, 'ORG00102', 'กิฟละห์ บาเน็ง', 14, 64, 7, 'login', '2020-09-02 18:27:16'),
(237, 'ORG00089', 'ฮากีมะห์ เย็ง', 18, 32, 2, 'login', '2020-09-02 18:31:03'),
(238, 'ORG00089', 'ฮากีมะห์ เย็ง', 18, 32, 2, 'login', '2020-09-02 20:04:06'),
(239, 'ORG00088', 'นูรอัซมีรา บือราเฮง', 18, 32, 6, 'login', '2020-09-02 20:05:01'),
(240, 'ORG00089', 'ฮากีมะห์ เย็ง', 18, 32, 2, 'login', '2020-09-02 20:38:33'),
(241, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-02 21:07:00'),
(242, 'ORG00093', 'มุมีนะห์ เจะบู', 14, 33, 7, 'login', '2020-09-02 21:50:19'),
(243, 'ORG00088', 'นูรอัซมีรา บือราเฮง', 18, 32, 6, 'login', '2020-09-02 21:52:21'),
(244, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-02 22:47:28'),
(245, 'ORG00089', 'ฮากีมะห์ เย็ง', 18, 32, 2, 'login', '2020-09-03 02:22:29'),
(246, 'ORG00092', 'มุรนี ตันอีโน', 15, 62, 4, 'login', '2020-09-03 02:23:14'),
(247, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-03 15:46:52'),
(248, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-03 16:55:18'),
(249, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-06 18:19:53'),
(250, 'ORG00002', 'suyah', 18, 29, 2, 'login', '2020-09-06 18:42:00'),
(251, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-07 03:02:51'),
(252, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-07 03:05:32'),
(253, 'ORG00002', 'suyah', 18, 29, 2, 'login', '2020-09-07 03:07:09'),
(254, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-07 03:17:14'),
(255, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-07 03:18:43'),
(256, 'ORG00003', 'นูรไลลา ', 15, 62, 3, 'login', '2020-09-07 03:29:12'),
(257, 'ORG00003', 'นูรไลลา ', 15, 62, 3, 'login', '2020-09-07 16:54:36'),
(258, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-07 19:24:53'),
(259, 'ORG00002', 'suyah', 18, 29, 2, 'login', '2020-09-07 20:58:16'),
(260, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-07 21:00:04'),
(261, 'ORG00001', 'คอยรียะห์ ตันอีโน', 16, 31, 1, 'login', '2020-09-08 07:46:52');

-- --------------------------------------------------------

--
-- Table structure for table `mainorg`
--

CREATE TABLE `mainorg` (
  `mainorgNo` int(11) NOT NULL,
  `mainorg` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mainorgSec` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mainorgAddby` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mainorg`
--

INSERT INTO `mainorg` (`mainorgNo`, `mainorg`, `mainorgSec`, `mainorgAddby`, `createat`) VALUES
(14, 'องค์การบริหารนักศึกษา', 'มหาวิทยาลัย', 'ORG00001', '2020-07-08 02:30:33'),
(15, 'คณะวิทยาศาสตร์และเทคโนโลยี', 'คณะ', 'ORG00001', '2020-07-08 02:30:33'),
(16, 'admin', 'Admin', 'ORG00000', '2020-07-08 02:36:01'),
(17, 'คณะศึกษาศาสตร์', 'คณะ', 'ORG00001', '2020-07-08 03:33:00'),
(18, 'สำนักพัฒนาศักยภาพนักศึกษา', 'มหาวิทยาลัย', 'ORG00001', '2020-07-08 09:45:29'),
(19, 'คณะศิลปศาสตร์และสังคมศาสตร์', 'คณะ', 'ORG00001', '2020-08-17 06:09:08'),
(20, 'คณะอิสลามศึกษาและนิติศาสตร์', 'คณะ', 'ORG00001', '2020-08-29 16:08:09');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `newsNo` int(11) NOT NULL,
  `newsTitle` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `newsDescribe` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `newsImage` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `newsStatus` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `newsAddby` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `newsCreateat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`newsNo`, `newsTitle`, `newsDescribe`, `newsImage`, `newsStatus`, `newsAddby`, `newsCreateat`) VALUES
(8, 'รับสมัครเข้าร่วมโครงการ Active Tech Citizen Season 2 ', 'ประชาสัมพันธ์สำหรับนักศึกษาที่สนใจเข้าร่วมโครงการ Active Tech Citizen Season 2 \"Driving Now Local to the Next Normal : อยากเปลี่ยนชุมชนของคุณเป็นแบบไหนในวิถีใหม่\" \r\nของคณะกรรมาธิการการพัฒนาการเมือง การสื่อสารมวลชน และการมีสวนร่วมของประชาชน สภาผู้แทนราษฎร\r\n\r\n\r\nสอบถามรายละเอียดเพิ่มเติมได้ที่ facebook : สำนักพัฒนาศักยภาพนักศึกษา', 'news/779573.jpg', 'แสดง', 'ORG00001', '2020-08-27 04:14:41'),
(9, 'เข้าร่ามประกวดถ่ายภาพ ตามโครงการประชาสัมพันธ์การสร้างสันติสุขจังหวัดชายแดนภาคใต้ ปี 2563', 'ประชาสัมพันธนักศึกษาที่สนใจเข้าร่ามประกวดถ่ายภาพ ตามโครงการประชาสัมพันธ์การสร้างสันติสุขจังหวัดชายแดนภาคใต้ ปี 2563 สนใจสามารถส่งผลงานภาพถ่าย ด้วยตนเอง หรือวิธีอื่นใด ได้ตั้งแต่บัดนี้ จนถึงวันที่ 15 สิงหาคม 2563 ภานในเวลา 16.30 น. ที่ สำนักงานประชาสัมพันธ์จังหวัดปัตตานี\r\nประเภทเยาวชน นักเรียน นักศึกษา\r\nรางวัลที่ 1 เงินรางวัล 10,000 บาท พร้อมโล่เกียรติยศ\r\nรางวัลที่ 2 เงินรางวัล 5,000 บาท พร้อมโล่เกียรติยศ\r\nรางวัลที่ 3 เงินรางวัล 3,000 บาท พร้อมโล่เกียรติยศ\r\nรางวัลชมเชย 3 รางวัลๆละ 1,500 บาท พร้อมเกียรติบัตร', 'news/215149.jpg', 'แสดง', 'ORG00001', '2020-08-27 04:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `orgtionNo` int(11) NOT NULL,
  `organization` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `orgtionMainorg` int(11) NOT NULL,
  `orgtionAddby` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`orgtionNo`, `organization`, `orgtionMainorg`, `orgtionAddby`, `createat`) VALUES
(29, 'กองกิจการนักศึกษา', 18, 'ORG00001', '2020-07-22 15:38:20'),
(30, 'สโมสรนักศึกษา', 15, 'ORG00001', '2020-07-19 19:19:04'),
(31, 'admin', 16, 'ORG00000', '2020-07-08 03:03:07'),
(32, 'องค์การบริหารนักศึกษา', 18, 'ORG00002', '2020-07-08 09:53:16'),
(33, 'ชมรมธนู', 14, 'ORG00001', '2020-08-09 18:01:08'),
(34, 'สาขาวิชาเศรฐศาสตร์การเงินและการธนาคาร', 19, 'ORG00001', '2020-08-30 13:32:11'),
(35, 'สำนักพัฒนาศักยภาพนักศึกษาคณะ', 19, 'ORG00001', '2020-08-17 06:12:32'),
(36, 'สาขาวิชาเทคโนโลยีสารสนเทศ', 15, 'ORG00003', '2020-08-30 13:27:12'),
(37, 'สาขาวิชาวิจัยและพัฒนาผลิตภันฑ์ฮาลาล', 15, 'ORG00003', '2020-08-30 13:34:37'),
(38, 'สาขาวิชาชะรีอะฮฺ(กฏหมายอิสลาม)', 20, 'ORG00001', '2020-08-30 13:26:54'),
(39, 'สาขาวิชาอุศูลุดดีน', 20, 'ORG00001', '2020-08-30 13:28:24'),
(40, 'สาขาวิชาอิสลามศึกษา', 20, 'ORG00001', '2020-08-30 13:28:48'),
(41, 'สาขาวิชานิติศาสตร์', 20, 'ORG00001', '2020-08-30 13:29:06'),
(42, 'สาขาวิชาอัลกุรอานและอัสสุนนะห์', 20, 'ORG00001', '2020-08-30 13:29:52'),
(43, 'สาขาวิชาภาษาอาหรับ', 19, 'ORG00001', '2020-08-30 13:30:46'),
(44, 'สาขาวิชารัฐประศาสนศาสตร์', 19, 'ORG00001', '2020-08-30 13:31:45'),
(45, 'สาขาวิชาภาษาอังกฤษ', 19, 'ORG00001', '2020-08-30 13:32:37'),
(46, 'สาขาวิชาภาษามลายู', 19, 'ORG00001', '2020-08-30 13:33:01'),
(47, 'สาขาวิชาบริหารธุรกิจ', 19, 'ORG00001', '2020-08-30 13:33:19'),
(48, 'สาขาวิชาวิทยาการข้อมูลและการวิเคราะห์', 15, 'ORG00001', '2020-08-30 13:35:10'),
(49, 'สาขาวิชาการสอนอิสลามศึกษา', 17, 'ORG00001', '2020-08-30 13:35:43'),
(50, 'สาขาวิชาการสอนภาษาอาหรับ', 17, 'ORG00001', '2020-08-30 13:36:00'),
(51, 'สาขาวิชาการสอนวิทยาศาสตร์ทั่วไป', 17, 'ORG00001', '2020-08-30 13:36:20'),
(52, 'สาขาวิชาการสอนเคมี', 17, 'ORG00001', '2020-08-30 13:36:32'),
(53, 'สาขาวิชาการสอนภาษามลายู', 17, 'ORG00001', '2020-08-30 13:37:27'),
(54, 'สาขาวิชาการสอนภาษามลายูและเทคโนโลยีการศึกษา', 17, 'ORG00001', '2020-08-30 13:38:28'),
(55, 'สาขาวิชาการศึกษาปฐมวัย', 17, 'ORG00001', '2020-08-30 13:38:48'),
(56, 'สาขาวิชาเคมี', 17, 'ORG00001', '2020-08-30 13:39:02'),
(57, 'สโมสรนักศึกษา', 17, 'ORG00001', '2020-08-30 13:39:51'),
(58, 'สโมสรนักศึกษา', 19, 'ORG00001', '2020-08-30 13:40:06'),
(59, 'สโมสรนักศึกษา', 20, 'ORG00001', '2020-08-30 13:40:14'),
(60, 'ฝ่ายพัฒนาศักยภาพนักศึกษาคณะ', 20, 'ORG00001', '2020-08-30 14:26:27'),
(61, 'ฝ่ายพัฒนาศักยภาพนักศึกษาคณะ', 19, 'ORG00001', '2020-08-30 14:26:41'),
(62, 'ฝ่ายพัฒนาศักยภาพนักศึกษาคณะ', 15, 'ORG00001', '2020-08-30 14:26:49'),
(63, 'ฝ่ายพัฒนาศักยภาพนักศึกษาคณะ', 17, 'ORG00001', '2020-08-30 14:26:56'),
(64, 'ชมรมนักอ่าน', 14, 'ORG00089', '2020-09-02 18:18:53');

-- --------------------------------------------------------

--
-- Table structure for table `organizer`
--

CREATE TABLE `organizer` (
  `orgzerNo` int(11) NOT NULL,
  `orgzerID` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `orgzerName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `orgzeruserType` int(11) NOT NULL,
  `orgzerPhone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `orgzerEmail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `orgzerFb` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `orgzerGroup` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `orgzerSec` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `orgzerOrgtion` int(11) NOT NULL,
  `orgzerMainorg` int(11) NOT NULL,
  `orgzerImage` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `orgzerPassword` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `orgzerAddby` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `organizer`
--

INSERT INTO `organizer` (`orgzerNo`, `orgzerID`, `orgzerName`, `orgzeruserType`, `orgzerPhone`, `orgzerEmail`, `orgzerFb`, `orgzerGroup`, `orgzerSec`, `orgzerOrgtion`, `orgzerMainorg`, `orgzerImage`, `orgzerPassword`, `orgzerAddby`, `createat`) VALUES
(85, 'ORG00000', 'คอยรียะห์ ตันอีโน', 1, '(097) 938-5803', 'khoyree40@gmail.com', 'khoyreeyah tan-eno', 'admin', 'Admin', 31, 16, 'profile/278075.png', 'admin', 'ORG00000', '2020-07-08 02:49:05'),
(1, 'ORG00001', 'คอยรียะห์ ตันอีโน', 1, '(097) 938-5803', 'khoyree40@gmail.com', 'khoyreeyah tan-end', 'admin', 'Admin', 31, 16, 'profile/343368.png', 'admin', 'ORG00000', '2020-07-08 02:49:05'),
(87, 'ORG00002', 'suyah', 2, '(098) 765-4321', 'suyah@gmail.com', 'suyahFb', 'หญิง', 'มหาวิทยาลัย', 29, 18, 'profile/678516.png', 'suyah', 'ORG00001', '2020-07-08 02:54:21'),
(3, 'ORG00003', 'นูรไลลา ', 3, '(099) 999-9999', 'b@gmail.com', 'nurlaila', 'หญิง', 'คณะ', 62, 15, 'profile/240041.png', '00001', 'ORG00001', '2020-07-08 02:49:05'),
(88, 'ORG00088', 'นูรอัซมีรา บือราเฮง', 6, '(098) 765-4321', 'hakimah@gmail.com', 'hakimah yeng', 'หญิง', 'มหาวิทยาลัย', 32, 18, 'profile/247424.png', 'kaku', 'ORG00002', '2020-07-08 09:01:45'),
(89, 'ORG00089', 'ฮากีมะห์ เย็ง', 2, '(081) 234-5678', 'saodahlado@gmail.com', 'เสาเดาะห์ ลาดอ', 'หญิง', 'มหาวิทยาลัย', 32, 18, 'profile/214598.png', 'hakimah', 'ORG00002', '2020-07-08 14:39:07'),
(92, 'ORG00092', 'มุรนี ตันอีโน', 4, '(094) 885-9333', 'k3@gmail.com', 'khoคอย', 'หญิง', 'คณะ', 62, 15, 'profile/833660.png', 'khoy', 'ORG00001', '2020-07-24 16:09:20'),
(93, 'ORG00093', 'มุมีนะห์ เจะบู', 7, '(098) 765-4321', 'mu@gmail.com', 'muminah chebu', 'หญิง', 'มหาวิทยาลัย', 33, 14, 'profile/296318.jpg', 'muminah', 'ORG00001', '2020-08-13 04:05:59'),
(94, 'ORG00094', 'นูรอาซีกีน เบ็ญมูฮัมหมัดนูร', 3, '(062) 186-4201', 'sikeen@gmail.com', 'A-sikeen madnur', 'หญิง', 'คณะ', 35, 19, 'profile/233859.jpg', '00094', 'ORG00001', '2020-08-17 06:14:48'),
(95, 'ORG00095', 'อามีเนาะห์ กะนิ', 3, '(099) 999-9999', 'aminah@gmail.com', 'aminah kani', 'หญิง', 'คณะ', 60, 20, 'profile/352374.png', 'aminah', 'ORG00001', '2020-08-30 14:28:14'),
(96, 'ORG00096', 'รัยยาน จะปะกิยา', 3, '(092) 828-8288', 'raiyan@gmail.com', 'rayyan japakiya', 'หญิง', 'คณะ', 62, 15, 'profile/344193.png', 'rayyan', 'ORG00001', '2020-08-30 14:58:15'),
(97, 'ORG00097', 'ศศิธร ชวนชม', 3, '(083) 939-4994', 'sasi@gmail.com', 'solihah cuanchom', 'หญิง', 'คณะ', 61, 19, 'profile/951055.png', 'solihah', 'ORG00001', '2020-08-30 15:00:32'),
(98, 'ORG00098', 'อามานี มาหะมะ', 3, '(094) 885-9333', 'amanee@gmail.com', 'amanee mahama', 'หญิง', 'คณะ', 63, 17, 'profile/398402.png', 'amanee', 'ORG00001', '2020-08-30 15:02:36'),
(99, 'ORG00099', 'อามานี สาและ', 5, '(000) 948-8594', 'am@gmail.com', 'amanee saleah', 'หญิง', 'คณะ', 57, 17, 'profile/758637.png', 'amanee2', 'ORG00098', '2020-08-30 15:39:45'),
(100, 'ORG00100', 'ฟาฏอนะฮ แวบูละ', 5, '(099) 900-9999', 'fatonah@gmail.com', 'fatonah waebula', 'หญิง', 'คณะ', 30, 15, 'profile/524066.png', 'fatonah', 'ORG00096', '2020-08-30 15:58:38'),
(102, 'ORG00102', 'กิฟละห์ บาเน็ง', 7, '(094) 885-9333', 'k@gmail.com', 'kiflah baneng', 'หญิง', 'มหาวิทยาลัย', 64, 14, 'profile/720855.png', 'kiflah', 'ORG00089', '2020-09-02 18:25:02');

-- --------------------------------------------------------

--
-- Table structure for table `pst`
--

CREATE TABLE `pst` (
  `pstNo` int(11) NOT NULL,
  `pstYear` int(11) NOT NULL,
  `pststdID` int(11) NOT NULL,
  `pst` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pstOrgtion` int(11) NOT NULL,
  `pstMainorg` int(11) NOT NULL,
  `pstAddby` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pst`
--

INSERT INTO `pst` (`pstNo`, `pstYear`, `pststdID`, `pst`, `pstOrgtion`, `pstMainorg`, `pstAddby`, `createat`) VALUES
(7, 2561, 602431019, 'ประธาน', 32, 14, 'ORG00089', '2020-09-02 18:31:57');

-- --------------------------------------------------------

--
-- Table structure for table `pst1`
--

CREATE TABLE `pst1` (
  `pstNo` int(11) NOT NULL,
  `pstYear` int(11) NOT NULL,
  `pststdID` int(11) NOT NULL,
  `pstName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pst` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pstPhone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pstOrgtion` int(11) NOT NULL,
  `pstMainorg` int(11) NOT NULL,
  `pstAddby` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pst1`
--

INSERT INTO `pst1` (`pstNo`, `pstYear`, `pststdID`, `pstName`, `pst`, `pstPhone`, `pstOrgtion`, `pstMainorg`, `pstAddby`, `createat`) VALUES
(1, 2563, 582431019, 'khoyreeyah tan-e-no', 'เลขา', '0987654321', 30, 15, 'ORG00001', '2020-07-21 12:10:29');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `secNo` int(11) NOT NULL,
  `secName` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`secNo`, `secName`) VALUES
(1, 'มหาวิทยาลัย'),
(2, 'คณะ'),
(3, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `stdNo` int(11) NOT NULL,
  `stdYear` int(11) NOT NULL,
  `stdID` int(11) NOT NULL,
  `stdName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `stdStatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `stdFct` int(11) NOT NULL,
  `stdDpm` int(11) NOT NULL,
  `stdTc` int(11) NOT NULL,
  `stdGroup` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `stdPhone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `stdEmail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `stdFb` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stdImage` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `stdPassword` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`stdNo`, `stdYear`, `stdID`, `stdName`, `stdStatus`, `stdFct`, `stdDpm`, `stdTc`, `stdGroup`, `stdPhone`, `stdEmail`, `stdFb`, `stdImage`, `stdPassword`, `createat`) VALUES
(4, 2560, 582431019, 'khoyreeyah tan-eno', 'กำลังศึกษา', 15, 18, 8, 'หญิง', '(098) 765-4321', 'k@gmail.com', 'khoyreeyah tan-e-no', 'stdprofile/542537.png', 'khoy', '2020-07-15 06:17:41'),
(12, 2560, 602431018, 'Sainy rosytah', 'กำลังศึกษา', 15, 13, 22, 'หญิง', '(099) 933-8399', 'mt@gmail.com', 'r@gmail.com', 'stdprofile/652536.png', 'rorsy', '2020-08-31 03:37:53'),
(11, 2560, 602431019, 'มาอิดา สุนทร', 'กำลังศึกษา', 15, 18, 25, 'หญิง', '(099) 933-8399', 'mae@gmail.com', 'maeda suntorn', 'stdprofile/223093.png', 'maeda', '2020-08-30 15:53:21'),
(6, 2562, 622431017, 'rayyan japa', 'กำลังศึกษา', 15, 13, 8, 'หญิง', '0987654321', 'r@gmail.com', 'rayyan japa', '', 'rayyan', '2020-07-26 04:08:12'),
(7, 2563, 631421019, 'ซุบฮา ตัน', 'กำลังศึกษา', 17, 14, 10, 'ชาย', '(099) 999-9999', 'ha@gmail.com', 'subha tan', 'stdprofile/882801.png', 'subha', '2020-08-23 03:33:02'),
(9, 2563, 631431019, 'เชาเวีย ดอเลาะ', 'กำลังศึกษา', 17, 11, 10, 'หญิง', '(099) 999-9999', 's@gmail.com', 'shawwia doloh', 'stdprofile/661667.png', 'shaw', '2020-08-23 03:49:24'),
(8, 2563, 632411019, 'เชาวัล ดอเลาะ', 'กำลังศึกษา', 17, 11, 10, 'ชาย', '(098) 765-4666', 's@gmail.com', 'shawl doloh', 'stdprofile/819783.png', 's', '2020-08-23 03:46:48'),
(5, 2563, 632431019, 'murnee tan-e-no', 'กำลังศึกษา', 15, 13, 10, 'หญิง', '(098) 765-4321', 'm@gmail.com', 'murneetan tan', '', 'murnee', '2020-07-22 16:24:57'),
(10, 2563, 632451019, 'คอยร ตัน', 'กำลังศึกษา', 17, 14, 10, 'หญิง', '(098) 888-8888', 'k@gmail.com', 'khoyree', 'stdprofile/889516.png', 'khoyr', '2020-08-23 03:51:30');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacherNo` int(11) NOT NULL,
  `teacher` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `teacherfct` int(11) NOT NULL,
  `teacherAddby` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacherNo`, `teacher`, `teacherfct`, `teacherAddby`, `createat`) VALUES
(8, 'นูรุลฮุสนา อับดุลลาฏีฟ', 15, 'ORG00001', '2020-07-11 12:55:40'),
(10, 'สุอัยดา บือแน', 17, 'ORG00003', '2020-07-11 15:07:15'),
(13, 'ผศ.ดร.ซอบีเราะห์ การียอ', 15, 'ORG00003', '2020-08-29 16:24:29'),
(14, 'ผศ.สะอาด อาแซ', 15, 'ORG00003', '2020-08-29 16:24:59'),
(15, 'ซูไฮมีน เจ๊ะมะลี', 15, 'ORG00003', '2020-08-29 16:25:19'),
(16, 'ผศ.นัจญ์มีย์ สะอะ', 15, 'ORG00003', '2020-08-29 16:26:01'),
(17, 'ผศ.อนุวัตร วอลี', 15, 'ORG00003', '2020-08-29 16:26:21'),
(18, 'ผศ.รอปีอ๊ะ กือจิ', 15, 'ORG00003', '2020-08-29 16:26:45'),
(19, 'อัญรินทร์ เจะบือราเฮง', 15, 'ORG00003', '2020-08-29 16:27:19'),
(20, 'ฮัสนะห์ ยูโซะ', 15, 'ORG00003', '2020-08-29 16:27:39'),
(21, 'มูฮำหมัดอามีน หะยีหามะ', 15, 'ORG00003', '2020-08-29 16:28:08'),
(22, 'อานีสาห์ บือฮะ', 15, 'ORG00003', '2020-08-29 16:28:29'),
(23, 'ซากี นิเซ็ง', 15, 'ORG00003', '2020-08-29 16:28:42'),
(24, 'อิบตีซัม หะมะ', 15, 'ORG00003', '2020-08-29 16:29:01'),
(25, 'นูรฮูดา มะสาแม', 15, 'ORG00003', '2020-08-29 16:29:28'),
(26, 'มะรอนิง อุเซ็ง', 15, 'ORG00003', '2020-08-29 16:29:48'),
(27, 'ซบรี หะยีหมัด', 15, 'ORG00003', '2020-08-29 16:30:04'),
(28, 'ผศ.รอมสรรค์ เศะ', 15, 'ORG00003', '2020-08-29 16:30:28'),
(29, 'ผศ.สุไลมาน หะยีสะเอะ', 15, 'ORG00003', '2020-08-29 16:30:52'),
(30, 'อัรฟัน หะสีแม', 15, 'ORG00003', '2020-08-29 16:31:12'),
(31, 'ดร.มูหามะสาลาหูดิง เจ๊ะเล๊าะ', 15, 'ORG00003', '2020-08-29 16:31:43'),
(32, 'ผศ.ดร.สุมิตรา แสงวนิชย์', 15, 'ORG00003', '2020-08-29 16:32:16'),
(33, 'MR.Anas Mhd.Abdl.Rahman Tawalbeh', 15, 'ORG00003', '2020-08-29 16:33:13'),
(34, 'ดร.ก้อหรี บุตรหลำ', 15, 'ORG00003', '2020-08-29 16:33:42'),
(35, 'นูซานา ปะกียา', 15, 'ORG00003', '2020-08-29 16:34:25'),
(36, 'ผศ.กูซูซานา ยาวออาซัน', 15, 'ORG00003', '2020-08-29 16:35:55'),
(37, 'คอลิด ลังสารี', 15, 'ORG00003', '2020-08-29 16:36:23'),
(38, 'เฟาซาน มาปะ', 15, 'ORG00003', '2020-08-29 16:37:23'),
(39, 'อับดุลฟาตะห์ มะสาแม', 15, 'ORG00003', '2020-08-29 16:37:43'),
(40, 'มะฟายซู เจ๊ะแว', 15, 'ORG00003', '2020-08-29 16:37:57'),
(41, 'รศ.นิแวเต๊ะ หะยีวามิง', 15, 'ORG00003', '2020-08-29 16:38:48'),
(42, 'ผศ.รอซีดะห์ หะนะกาแม', 15, 'ORG00003', '2020-08-29 16:39:20'),
(43, 'ผศ.อัดนันย์ อาลีกาแห', 20, 'ORG00001', '2020-08-30 14:09:43'),
(44, 'อับดุลฟัตตาห์ จะปะกียา', 20, 'ORG00001', '2020-08-30 14:13:33'),
(45, 'MR.Gomaa Ahmef Mohamed Elsayed', 20, 'ORG00001', '2020-08-30 14:14:26'),
(46, 'ซุนกิบพลี คะแน', 20, 'ORG00001', '2020-08-30 14:14:53'),
(47, 'ซารีปะห์ กาเจ', 20, 'ORG00001', '2020-08-30 14:15:11'),
(48, 'อุศมาน เจ๊ะสือแม', 20, 'ORG00001', '2020-08-30 14:15:27'),
(49, 'สารีหฮ๊ะ ตาหยงมัส', 20, 'ORG00001', '2020-08-30 14:15:52'),
(50, 'รุสลาน มะเซ็ง', 20, 'ORG00001', '2020-08-30 14:16:07'),
(51, 'อิมรอน ดีสะเอะ', 20, 'ORG00001', '2020-08-30 14:16:26'),
(52, 'อาลาวี รอยูโมง', 20, 'ORG00001', '2020-08-30 14:16:45'),
(53, 'สะการิยา บาราเฮง', 20, 'ORG00001', '2020-08-30 14:17:09'),
(54, 'ซุลฟา ลาเตะ', 20, 'ORG00001', '2020-08-30 14:17:23'),
(55, 'อาหะมะ คาเด', 20, 'ORG00001', '2020-08-30 14:17:41'),
(56, 'ซัลมา แดเมาะเล็ง', 20, 'ORG00001', '2020-08-30 14:18:03'),
(57, 'ซาการียา เจะนะ', 20, 'ORG00001', '2020-08-30 14:18:26'),
(58, 'ผศ.มุมีน๊ะห์ บูหงอตาหยง', 20, 'ORG00001', '2020-08-30 14:19:23'),
(59, 'ผศ.อิสมาแอ สะอิ', 20, 'ORG00001', '2020-08-30 14:19:43'),
(60, 'ผศ.ดร.นัศรุลลอฮ์ หมัดตะพงศ์', 20, 'ORG00001', '2020-08-30 14:20:30'),
(61, 'MR.Mohammed Abdulrab Sharaf', 20, 'ORG00001', '2020-08-30 14:21:11'),
(62, 'อะหมัด จาปากียา', 20, 'ORG00001', '2020-08-30 14:21:27'),
(63, 'อับดุลมูซิล มะรือมอ', 20, 'ORG00001', '2020-08-30 14:21:47'),
(64, 'ฮามีดะ สาแม', 20, 'ORG00095', '2020-08-30 14:30:27'),
(65, 'ผศ.อิสมาอีล อาเนาะกาแซ', 20, 'ORG00095', '2020-08-30 14:30:55'),
(66, 'ฮูสนียะห์ สาและ', 20, 'ORG00095', '2020-08-30 14:31:18'),
(67, 'บะห์รุดดีน บินยูโซ๊ะ', 20, 'ORG00095', '2020-08-30 14:31:41'),
(68, 'กริยา หลังปูเต๊ะ', 20, 'ORG00095', '2020-08-30 14:32:31'),
(69, 'ผศ.ดร.แวยูโซะ สิเดะ', 20, 'ORG00095', '2020-08-30 14:33:05'),
(70, 'อับดุลการีม อัสมะแอ', 20, 'ORG00095', '2020-08-30 14:33:25'),
(71, 'ดร.มูหามะสาลาหูดิง เจ๊ะเลา๊ะ', 20, 'ORG00095', '2020-08-30 14:33:52'),
(72, 'ผศ.ดร.ฮามีดะห์ฮาสัน โต๊ะมะ', 20, 'ORG00095', '2020-08-30 14:34:42'),
(73, 'ดร.มูฮัมหมัดอามีน คอยา', 20, 'ORG00095', '2020-08-30 14:35:07'),
(74, 'ผศ.ดร.อับดุลการีม สาแมง', 20, 'ORG00095', '2020-08-30 14:35:26'),
(75, 'ดร.ฮูสนียะห์ สาและ', 20, 'ORG00095', '2020-08-30 14:35:53'),
(76, 'นูรอห์ คาเดร์', 20, 'ORG00095', '2020-08-30 14:36:08'),
(77, 'โมฮัมหมัด มาปะ', 20, 'ORG00095', '2020-08-30 14:36:23'),
(78, 'MR.Ammar Aslam', 20, 'ORG00095', '2020-08-30 14:36:55'),
(79, 'มูฮัมหมัด มาโระ', 20, 'ORG00095', '2020-08-30 14:37:09'),
(80, 'ดร.อับดุลรอฮมาน สามะอาลี', 20, 'ORG00095', '2020-08-30 14:37:34'),
(81, 'ผศ.ดร.อิดริส ดาราไก่', 20, 'ORG00095', '2020-08-30 14:38:03'),
(82, 'ดร.อาแว แมะอูมา', 20, 'ORG00095', '2020-08-30 14:38:16'),
(83, 'ผศ.อับดุลย์ลาเต๊ะ สาและ', 20, 'ORG00095', '2020-08-30 14:38:51'),
(84, 'ดร.มาหะมะ คาเด', 20, 'ORG00095', '2020-08-30 14:39:10'),
(85, 'ผศ.ดร.รูฮานา สาแมง', 20, 'ORG00095', '2020-08-30 14:39:36'),
(86, 'ยะหะยา นิแว', 20, 'ORG00095', '2020-08-30 14:39:52'),
(87, 'สาลาฮูดดีน มูซอ', 20, 'ORG00095', '2020-08-30 14:40:26'),
(88, 'ดร.มะซีดิ สาแล', 20, 'ORG00095', '2020-08-30 14:41:11'),
(89, 'ผศ.ดร.อาหะมะกอซี กาซอ', 20, 'ORG00095', '2020-08-30 14:42:07'),
(90, 'อับดุลมาซิ หะยีสะมาแอ', 20, 'ORG00095', '2020-08-30 14:42:36'),
(91, 'มูหำหมัดสอเระ หะยีสะมาแอ', 20, 'ORG00095', '2020-08-30 14:43:16'),
(92, 'อาแว แมะอูมา', 20, 'ORG00095', '2020-08-30 14:43:36'),
(93, 'ผศ.ดร.มูหัมมัดซอและ แวหะมะ', 20, 'ORG00095', '2020-08-30 14:44:05'),
(94, 'ดร.มูหัมมัดอิดรีส ดือเร๊ะ', 20, 'ORG00095', '2020-08-30 14:45:52'),
(95, 'นูรือมา สามะ', 20, 'ORG00095', '2020-08-30 14:46:06'),
(96, 'นัซมุดดีน อัตตอฮีรี', 20, 'ORG00095', '2020-08-30 14:46:25'),
(97, 'รศ.ดร.มุฮำหมัดซากี เจ๊ะหะ', 20, 'ORG00095', '2020-08-30 14:46:57'),
(98, 'กูปัทมา กาลีกาตะโป', 20, 'ORG00095', '2020-08-30 14:47:16'),
(99, 'อาบูหาสรรค์ ยูโซ๊ะ', 19, 'ORG00097', '2020-08-30 15:15:59'),
(100, 'ดร.ฟัตฮี จะปะเกีย', 19, 'ORG00097', '2020-08-30 15:16:32'),
(101, 'ยูหารี มะเซ่ง', 19, 'ORG00097', '2020-08-30 15:16:58'),
(102, 'MR.MUSTAFA ABD EL-KADER HAFEZ FATHALLAH', 19, 'ORG00097', '2020-08-30 15:18:48'),
(103, 'สิริวรรณ ขุนดำ', 19, 'ORG00097', '2020-08-30 15:19:10'),
(104, 'มูหำหมัดสอเระ หะยีสะมาแอ', 19, 'ORG00097', '2020-08-30 15:19:31'),
(105, 'มูนีเราะฮ์ ดอเล๊าะ', 19, 'ORG00097', '2020-08-30 15:19:59'),
(106, 'อานีซะห์ เจะมะ', 19, 'ORG00097', '2020-08-30 15:20:20'),
(107, 'นูรอห์ คาเดร์', 19, 'ORG00097', '2020-08-30 15:20:41'),
(108, 'ดร.รำซี ฮับยุโส๊ะ', 19, 'ORG00097', '2020-08-30 15:21:02'),
(109, 'ดร.มะหะมะรอเด็น แลหมัน', 19, 'ORG00097', '2020-08-30 15:21:22'),
(110, 'นูรีซัน หะมะ', 19, 'ORG00097', '2020-08-30 15:21:33'),
(111, 'ผศ.ดร.Mohamed Ali Omar', 19, 'ORG00097', '2020-08-30 15:22:15'),
(112, 'โมฮัมหมัด มาปะ', 19, 'ORG00097', '2020-08-30 15:22:23'),
(113, 'ผศ.ดร.มะพลี แมกอง', 19, 'ORG00097', '2020-08-30 15:22:51'),
(114, 'ผศ.Emad Eldin Makhlouf', 19, 'ORG00097', '2020-08-30 15:23:37'),
(115, 'ผศ.ดร.มัซลัน สุหลง', 19, 'ORG00097', '2020-08-30 15:24:04'),
(116, 'สุกัญญา มาลาวัยจันทร์', 19, 'ORG00097', '2020-08-30 15:24:23'),
(117, 'อาพันดี หะซั้น', 19, 'ORG00097', '2020-08-30 15:24:43'),
(118, 'รัชนี สูยุ', 19, 'ORG00097', '2020-08-30 15:24:53'),
(119, 'ธีวัช จาปรัง', 19, 'ORG00097', '2020-08-30 15:25:11'),
(120, 'ผศ.ดร.อิดริส ดาราไก่', 17, 'ORG00098', '2020-08-30 15:27:15'),
(121, 'ฮูดา ฆอแด๊ะ', 17, 'ORG00098', '2020-08-30 15:27:30'),
(122, 'วันบายูรี คาเว็ง', 17, 'ORG00098', '2020-08-30 15:27:47'),
(123, 'ผศ.ดร.รูฮานา สาแมง', 17, 'ORG00098', '2020-08-30 15:28:06'),
(124, 'นูรุลฮัค มูซอ', 17, 'ORG00098', '2020-08-30 15:28:20'),
(125, 'ยะหะยา นิแว', 17, 'ORG00098', '2020-08-30 15:28:28'),
(126, 'ผศ.มุมีน๊ะห์ บูหงอตาหยง', 17, 'ORG00098', '2020-08-30 15:28:49'),
(127, 'มะรอเซ๊ะ สาเม็ง', 17, 'ORG00098', '2020-08-30 15:29:12'),
(128, 'ฟาตีฮะห์ จะปะกียา', 17, 'ORG00098', '2020-08-30 15:29:32'),
(129, 'ซาฟีอี บารู', 17, 'ORG00098', '2020-08-30 15:29:44'),
(130, 'อิบรอเฮม อัลมุสฏอฟา', 17, 'ORG00098', '2020-08-30 15:30:09'),
(131, 'ผศ.ซอลีฮะห์ หะยีสะมะแอ', 17, 'ORG00098', '2020-08-30 15:30:30'),
(132, 'อับดุลฆอนี เจะโซะ', 17, 'ORG00098', '2020-08-30 15:31:07');

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `usertypeID` int(11) NOT NULL,
  `userType` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usertypeSec` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `M_1` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_2` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_3` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_4` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_5` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_6` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_7` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_8` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_9` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_10` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_11` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_12` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_13` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `M_14` enum('true','false') COLLATE utf8_unicode_ci NOT NULL,
  `usertypeAddby` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`usertypeID`, `userType`, `usertypeSec`, `M_1`, `M_2`, `M_3`, `M_4`, `M_5`, `M_6`, `M_7`, `M_8`, `M_9`, `M_10`, `M_11`, `M_12`, `M_13`, `M_14`, `usertypeAddby`, `createat`) VALUES
(1, 'แอดมินหลัก', 'Admin', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'false', 'true', 'true', 'ORG00000', '2020-07-26 16:31:41'),
(2, 'แอดมินมหาวิทยาลัย', 'มหาวิทยาลัย', 'true', 'true', 'true', 'true', 'false', 'false', 'true', 'true', 'true', 'true', 'true', 'false', 'true', 'true', 'ORG00001', '2020-07-26 16:36:04'),
(3, 'แอดมินคณะ', 'คณะ', 'true', 'true', 'true', 'true', 'false', 'false', 'true', 'true', 'true', 'true', 'true', 'false', 'true', 'true', 'ORG00001', '2020-07-26 16:38:42'),
(4, 'ที่ปรึกษากลุ่มศึกษาอัลกุรอ่าน', 'คณะ', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'true', 'true', 'false', 'ORG00001', '2020-07-26 16:40:18'),
(5, 'ผู้จัดกิจกรรม', 'คณะ', 'true', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'true', 'false', 'false', 'false', 'true', 'false', 'ORG00001', '2020-07-26 17:20:21'),
(6, 'ผู้จัดกิจกรรม', 'มหาวิทยาลัย', 'true', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'true', 'false', 'false', 'false', 'true', 'false', 'ORG00001', '2020-07-26 17:21:15'),
(7, 'ผู้จัดกิจกรรมชมรม', 'มหาวิทยาลัย', 'true', 'false', 'false', 'false', 'true', 'true', 'false', 'false', 'true', 'false', 'false', 'false', 'true', 'false', 'ORG00001', '2020-07-26 17:23:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actchecklist`
--
ALTER TABLE `actchecklist`
  ADD PRIMARY KEY (`checklistID`),
  ADD KEY `checklistNo` (`checklistNo`),
  ADD KEY `actID` (`actID`),
  ADD KEY `orgzerID` (`orgzerID`);

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`actID`),
  ADD KEY `actNo` (`actNo`) USING BTREE,
  ADD KEY `actMainorg` (`actMainorg`),
  ADD KEY `actOrgtion` (`actOrgtion`),
  ADD KEY `actType` (`actType`),
  ADD KEY `actAddby` (`actAddby`),
  ADD KEY `actApprover` (`actApprover`),
  ADD KEY `actSec` (`actSec`),
  ADD KEY `actYear` (`actYear`),
  ADD KEY `actSem` (`actSem`);

--
-- Indexes for table `actregister`
--
ALTER TABLE `actregister`
  ADD PRIMARY KEY (`actregNo`),
  ADD KEY `actregactID` (`actregactID`),
  ADD KEY `actregstdID` (`actregstdID`),
  ADD KEY `actregAddby` (`actregAddby`);

--
-- Indexes for table `actsem`
--
ALTER TABLE `actsem`
  ADD PRIMARY KEY (`actsemNo`),
  ADD KEY `actsem` (`actsem`),
  ADD KEY `actsemyear` (`actsemyear`);

--
-- Indexes for table `acttype`
--
ALTER TABLE `acttype`
  ADD PRIMARY KEY (`acttypeNo`) USING BTREE,
  ADD KEY `acttypeAddby` (`acttypeAddby`);

--
-- Indexes for table `actyear`
--
ALTER TABLE `actyear`
  ADD PRIMARY KEY (`actyear`);

--
-- Indexes for table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`boardNo`) USING BTREE,
  ADD KEY `boardAddby` (`boardAddby`);

--
-- Indexes for table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`clubNo`),
  ADD KEY `clubOrgtion` (`clubOrgtion`),
  ADD KEY `clubMainorg` (`clubMainorg`),
  ADD KEY `clubAddby` (`clubAddby`),
  ADD KEY `clubstdID` (`clubstdID`),
  ADD KEY `clubYear` (`clubYear`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dpmNo`),
  ADD KEY `dpmfct` (`dpmfct`),
  ADD KEY `dpmAddby` (`dpmAddby`);

--
-- Indexes for table `eiatiqaf`
--
ALTER TABLE `eiatiqaf`
  ADD PRIMARY KEY (`eiatiqafNo`),
  ADD KEY `eiatiqafactType` (`eiatiqafactType`),
  ADD KEY `eiatiqafstdID` (`eiatiqafstdID`),
  ADD KEY `eiatiqafYear` (`eiatiqafYear`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty`),
  ADD KEY `fctAddby` (`fctAddby`),
  ADD KEY `faculty` (`faculty`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`fileNo`),
  ADD KEY `fileAddby` (`fileAddby`);

--
-- Indexes for table `finishact`
--
ALTER TABLE `finishact`
  ADD PRIMARY KEY (`finishactNo`),
  ADD KEY `finishactby` (`finishactby`);

--
-- Indexes for table `halaqahcheck`
--
ALTER TABLE `halaqahcheck`
  ADD PRIMARY KEY (`halaqahcheckNo`),
  ADD KEY `stdID` (`halaqahchecklistID`),
  ADD KEY `halaqahTc` (`halaqahcheckstdID`);

--
-- Indexes for table `halaqahchecklist`
--
ALTER TABLE `halaqahchecklist`
  ADD PRIMARY KEY (`halaqahchecklistNo`),
  ADD KEY `halaqahID` (`halaqahID`);

--
-- Indexes for table `halaqahstd`
--
ALTER TABLE `halaqahstd`
  ADD PRIMARY KEY (`halaqahstdNo`),
  ADD KEY `halaqahID` (`halaqahID`),
  ADD KEY `halaqahstdID` (`halaqahstdID`);

--
-- Indexes for table `halaqahtc`
--
ALTER TABLE `halaqahtc`
  ADD PRIMARY KEY (`halaqahtcNo`),
  ADD KEY `halaqahtcID` (`halaqahtcID`),
  ADD KEY `halaqahtcAddby` (`halaqahtcAddby`),
  ADD KEY `halaqahtcMainorg` (`halaqahtcMainorg`),
  ADD KEY `halaqahtcYear` (`halaqahtcYear`);

--
-- Indexes for table `loginhistory`
--
ALTER TABLE `loginhistory`
  ADD PRIMARY KEY (`loginNo`),
  ADD KEY `userID` (`userID`),
  ADD KEY `userMainorg` (`userMainorg`),
  ADD KEY `userOrgtion` (`userOrgtion`),
  ADD KEY `userType` (`userType`);

--
-- Indexes for table `mainorg`
--
ALTER TABLE `mainorg`
  ADD PRIMARY KEY (`mainorgNo`) USING BTREE,
  ADD KEY `mainorgAddby` (`mainorgAddby`),
  ADD KEY `mainorgSec` (`mainorgSec`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`newsNo`),
  ADD KEY `newsAddby` (`newsAddby`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`orgtionNo`) USING BTREE,
  ADD KEY `orgtionMainorg` (`orgtionMainorg`),
  ADD KEY `orgtionAddby` (`orgtionAddby`);

--
-- Indexes for table `organizer`
--
ALTER TABLE `organizer`
  ADD PRIMARY KEY (`orgzerID`),
  ADD KEY `orgzeruserType` (`orgzeruserType`),
  ADD KEY `orgzerNo` (`orgzerNo`) USING BTREE,
  ADD KEY `orgzerOrgtion` (`orgzerOrgtion`),
  ADD KEY `orgzerMainorg` (`orgzerMainorg`) USING BTREE,
  ADD KEY `orgzerAddby` (`orgzerAddby`),
  ADD KEY `orgzerSec` (`orgzerSec`);

--
-- Indexes for table `pst`
--
ALTER TABLE `pst`
  ADD PRIMARY KEY (`pstNo`),
  ADD KEY `pstOrgtion` (`pstOrgtion`),
  ADD KEY `pstMainorg` (`pstMainorg`),
  ADD KEY `pstAddby` (`pstAddby`),
  ADD KEY `pststdID` (`pststdID`),
  ADD KEY `pstYear` (`pstYear`);

--
-- Indexes for table `pst1`
--
ALTER TABLE `pst1`
  ADD PRIMARY KEY (`pstNo`) USING BTREE,
  ADD KEY `pststdID` (`pststdID`),
  ADD KEY `pstOrgtion` (`pstOrgtion`),
  ADD KEY `pstMainorg` (`pstMainorg`),
  ADD KEY `pstAddby` (`pstAddby`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`secName`),
  ADD KEY `secNo` (`secNo`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stdID`),
  ADD KEY `stdNo` (`stdNo`) USING BTREE,
  ADD KEY `stdFct` (`stdFct`,`stdDpm`,`stdTc`),
  ADD KEY `stdDpm` (`stdDpm`),
  ADD KEY `stdTc` (`stdTc`),
  ADD KEY `stdYear` (`stdYear`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacherNo`),
  ADD KEY `teacherAddby` (`teacherAddby`),
  ADD KEY `teacherfct` (`teacherfct`) USING BTREE;

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`usertypeID`) USING BTREE,
  ADD KEY `usertypeAddby` (`usertypeAddby`),
  ADD KEY `usertypeMainorg` (`usertypeSec`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actchecklist`
--
ALTER TABLE `actchecklist`
  MODIFY `checklistNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `actNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `actregister`
--
ALTER TABLE `actregister`
  MODIFY `actregNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `actsem`
--
ALTER TABLE `actsem`
  MODIFY `actsemNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `acttype`
--
ALTER TABLE `acttype`
  MODIFY `acttypeNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
  MODIFY `boardNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `club`
--
ALTER TABLE `club`
  MODIFY `clubNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dpmNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `eiatiqaf`
--
ALTER TABLE `eiatiqaf`
  MODIFY `eiatiqafNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `fileNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `finishact`
--
ALTER TABLE `finishact`
  MODIFY `finishactNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `halaqahcheck`
--
ALTER TABLE `halaqahcheck`
  MODIFY `halaqahcheckNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `halaqahchecklist`
--
ALTER TABLE `halaqahchecklist`
  MODIFY `halaqahchecklistNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `halaqahstd`
--
ALTER TABLE `halaqahstd`
  MODIFY `halaqahstdNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `halaqahtc`
--
ALTER TABLE `halaqahtc`
  MODIFY `halaqahtcNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `loginhistory`
--
ALTER TABLE `loginhistory`
  MODIFY `loginNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `mainorg`
--
ALTER TABLE `mainorg`
  MODIFY `mainorgNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `newsNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `orgtionNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `organizer`
--
ALTER TABLE `organizer`
  MODIFY `orgzerNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `pst`
--
ALTER TABLE `pst`
  MODIFY `pstNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pst1`
--
ALTER TABLE `pst1`
  MODIFY `pstNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `secNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `stdNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacherNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `usertypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actchecklist`
--
ALTER TABLE `actchecklist`
  ADD CONSTRAINT `actchecklist_ibfk_1` FOREIGN KEY (`actID`) REFERENCES `activity` (`actID`),
  ADD CONSTRAINT `actchecklist_ibfk_2` FOREIGN KEY (`orgzerID`) REFERENCES `organizer` (`orgzerID`);

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`actAddby`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `activity_ibfk_2` FOREIGN KEY (`actApprover`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `activity_ibfk_3` FOREIGN KEY (`actMainorg`) REFERENCES `mainorg` (`mainorgNo`),
  ADD CONSTRAINT `activity_ibfk_4` FOREIGN KEY (`actOrgtion`) REFERENCES `organization` (`orgtionNo`),
  ADD CONSTRAINT `activity_ibfk_5` FOREIGN KEY (`actSec`) REFERENCES `section` (`secName`),
  ADD CONSTRAINT `activity_ibfk_6` FOREIGN KEY (`actType`) REFERENCES `acttype` (`acttypeNo`),
  ADD CONSTRAINT `activity_ibfk_7` FOREIGN KEY (`actYear`) REFERENCES `actyear` (`actyear`),
  ADD CONSTRAINT `activity_ibfk_8` FOREIGN KEY (`actSem`) REFERENCES `actsem` (`actsemNo`);

--
-- Constraints for table `actregister`
--
ALTER TABLE `actregister`
  ADD CONSTRAINT `actregister_ibfk_1` FOREIGN KEY (`actregactID`) REFERENCES `activity` (`actID`),
  ADD CONSTRAINT `actregister_ibfk_2` FOREIGN KEY (`actregstdID`) REFERENCES `student` (`stdID`),
  ADD CONSTRAINT `actregister_ibfk_3` FOREIGN KEY (`actregAddby`) REFERENCES `organizer` (`orgzerID`);

--
-- Constraints for table `actsem`
--
ALTER TABLE `actsem`
  ADD CONSTRAINT `actsem_ibfk_1` FOREIGN KEY (`actsemyear`) REFERENCES `actyear` (`actyear`);

--
-- Constraints for table `acttype`
--
ALTER TABLE `acttype`
  ADD CONSTRAINT `acttype_ibfk_1` FOREIGN KEY (`acttypeAddby`) REFERENCES `organizer` (`orgzerID`);

--
-- Constraints for table `board`
--
ALTER TABLE `board`
  ADD CONSTRAINT `board_ibfk_1` FOREIGN KEY (`boardAddby`) REFERENCES `organizer` (`orgzerID`);

--
-- Constraints for table `club`
--
ALTER TABLE `club`
  ADD CONSTRAINT `club_ibfk_1` FOREIGN KEY (`clubAddby`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `club_ibfk_2` FOREIGN KEY (`clubMainorg`) REFERENCES `mainorg` (`mainorgNo`),
  ADD CONSTRAINT `club_ibfk_3` FOREIGN KEY (`clubOrgtion`) REFERENCES `organization` (`orgtionNo`),
  ADD CONSTRAINT `club_ibfk_4` FOREIGN KEY (`clubstdID`) REFERENCES `student` (`stdID`),
  ADD CONSTRAINT `club_ibfk_5` FOREIGN KEY (`clubYear`) REFERENCES `actyear` (`actyear`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`dpmAddby`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `department_ibfk_2` FOREIGN KEY (`dpmfct`) REFERENCES `faculty` (`faculty`);

--
-- Constraints for table `eiatiqaf`
--
ALTER TABLE `eiatiqaf`
  ADD CONSTRAINT `eiatiqaf_ibfk_1` FOREIGN KEY (`eiatiqafactType`) REFERENCES `acttype` (`acttypeNo`),
  ADD CONSTRAINT `eiatiqaf_ibfk_2` FOREIGN KEY (`eiatiqafstdID`) REFERENCES `student` (`stdID`),
  ADD CONSTRAINT `eiatiqaf_ibfk_3` FOREIGN KEY (`eiatiqafYear`) REFERENCES `actyear` (`actyear`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`fctAddby`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `faculty_ibfk_2` FOREIGN KEY (`faculty`) REFERENCES `mainorg` (`mainorgNo`);

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `file_ibfk_1` FOREIGN KEY (`fileAddby`) REFERENCES `organizer` (`orgzerID`);

--
-- Constraints for table `finishact`
--
ALTER TABLE `finishact`
  ADD CONSTRAINT `finishact_ibfk_1` FOREIGN KEY (`finishactby`) REFERENCES `organizer` (`orgzerID`);

--
-- Constraints for table `halaqahcheck`
--
ALTER TABLE `halaqahcheck`
  ADD CONSTRAINT `halaqahcheck_ibfk_1` FOREIGN KEY (`halaqahcheckstdID`) REFERENCES `halaqahstd` (`halaqahstdNo`),
  ADD CONSTRAINT `halaqahcheck_ibfk_3` FOREIGN KEY (`halaqahchecklistID`) REFERENCES `halaqahchecklist` (`halaqahchecklistNo`);

--
-- Constraints for table `halaqahchecklist`
--
ALTER TABLE `halaqahchecklist`
  ADD CONSTRAINT `halaqahchecklist_ibfk_1` FOREIGN KEY (`halaqahID`) REFERENCES `halaqahtc` (`halaqahtcNo`);

--
-- Constraints for table `halaqahstd`
--
ALTER TABLE `halaqahstd`
  ADD CONSTRAINT `halaqahstd_ibfk_1` FOREIGN KEY (`halaqahID`) REFERENCES `halaqahtc` (`halaqahtcNo`),
  ADD CONSTRAINT `halaqahstd_ibfk_2` FOREIGN KEY (`halaqahstdID`) REFERENCES `student` (`stdID`);

--
-- Constraints for table `halaqahtc`
--
ALTER TABLE `halaqahtc`
  ADD CONSTRAINT `halaqahtc_ibfk_1` FOREIGN KEY (`halaqahtcAddby`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `halaqahtc_ibfk_2` FOREIGN KEY (`halaqahtcID`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `halaqahtc_ibfk_3` FOREIGN KEY (`halaqahtcMainorg`) REFERENCES `mainorg` (`mainorgNo`),
  ADD CONSTRAINT `halaqahtc_ibfk_4` FOREIGN KEY (`halaqahtcYear`) REFERENCES `actyear` (`actyear`);

--
-- Constraints for table `loginhistory`
--
ALTER TABLE `loginhistory`
  ADD CONSTRAINT `loginhistory_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `loginhistory_ibfk_2` FOREIGN KEY (`userMainorg`) REFERENCES `mainorg` (`mainorgNo`),
  ADD CONSTRAINT `loginhistory_ibfk_3` FOREIGN KEY (`userOrgtion`) REFERENCES `organization` (`orgtionNo`),
  ADD CONSTRAINT `loginhistory_ibfk_4` FOREIGN KEY (`userType`) REFERENCES `usertype` (`usertypeID`);

--
-- Constraints for table `mainorg`
--
ALTER TABLE `mainorg`
  ADD CONSTRAINT `mainorg_ibfk_2` FOREIGN KEY (`mainorgSec`) REFERENCES `section` (`secName`),
  ADD CONSTRAINT `mainorg_ibfk_3` FOREIGN KEY (`mainorgAddby`) REFERENCES `organizer` (`orgzerID`);

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`newsAddby`) REFERENCES `organizer` (`orgzerID`);

--
-- Constraints for table `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `organization_ibfk_1` FOREIGN KEY (`orgtionMainorg`) REFERENCES `mainorg` (`mainorgNo`),
  ADD CONSTRAINT `organization_ibfk_2` FOREIGN KEY (`orgtionAddby`) REFERENCES `organizer` (`orgzerID`);

--
-- Constraints for table `organizer`
--
ALTER TABLE `organizer`
  ADD CONSTRAINT `organizer_ibfk_2` FOREIGN KEY (`orgzerSec`) REFERENCES `section` (`secName`),
  ADD CONSTRAINT `organizer_ibfk_3` FOREIGN KEY (`orgzerOrgtion`) REFERENCES `organization` (`orgtionNo`),
  ADD CONSTRAINT `organizer_ibfk_4` FOREIGN KEY (`orgzerMainorg`) REFERENCES `mainorg` (`mainorgNo`),
  ADD CONSTRAINT `organizer_ibfk_5` FOREIGN KEY (`orgzerAddby`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `organizer_ibfk_6` FOREIGN KEY (`orgzeruserType`) REFERENCES `usertype` (`usertypeID`);

--
-- Constraints for table `pst`
--
ALTER TABLE `pst`
  ADD CONSTRAINT `pst_ibfk_1` FOREIGN KEY (`pstMainorg`) REFERENCES `mainorg` (`mainorgNo`),
  ADD CONSTRAINT `pst_ibfk_2` FOREIGN KEY (`pststdID`) REFERENCES `student` (`stdID`),
  ADD CONSTRAINT `pst_ibfk_3` FOREIGN KEY (`pstOrgtion`) REFERENCES `organization` (`orgtionNo`),
  ADD CONSTRAINT `pst_ibfk_4` FOREIGN KEY (`pstAddby`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `pst_ibfk_5` FOREIGN KEY (`pstYear`) REFERENCES `actyear` (`actyear`);

--
-- Constraints for table `pst1`
--
ALTER TABLE `pst1`
  ADD CONSTRAINT `pst1_ibfk_1` FOREIGN KEY (`pststdID`) REFERENCES `student` (`stdID`),
  ADD CONSTRAINT `pst1_ibfk_2` FOREIGN KEY (`pstAddby`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `pst1_ibfk_3` FOREIGN KEY (`pstOrgtion`) REFERENCES `organization` (`orgtionNo`),
  ADD CONSTRAINT `pst1_ibfk_4` FOREIGN KEY (`pstMainorg`) REFERENCES `mainorg` (`mainorgNo`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`stdDpm`) REFERENCES `department` (`dpmNo`),
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`stdTc`) REFERENCES `teacher` (`teacherNo`),
  ADD CONSTRAINT `student_ibfk_3` FOREIGN KEY (`stdFct`) REFERENCES `faculty` (`faculty`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`teacherAddby`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `teacher_ibfk_2` FOREIGN KEY (`teacherfct`) REFERENCES `faculty` (`faculty`);

--
-- Constraints for table `usertype`
--
ALTER TABLE `usertype`
  ADD CONSTRAINT `usertype_ibfk_2` FOREIGN KEY (`usertypeAddby`) REFERENCES `organizer` (`orgzerID`),
  ADD CONSTRAINT `usertype_ibfk_3` FOREIGN KEY (`usertypeSec`) REFERENCES `section` (`secName`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
