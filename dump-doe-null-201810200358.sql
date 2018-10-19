-- MySQL dump 10.13  Distrib 5.7.21, for Win64 (x86_64)
--
-- Host: localhost    Database: doe
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.26-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cash`
--

DROP TABLE IF EXISTS `cash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cash` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `COLLECTOR_CODE` varchar(25) DEFAULT NULL,
  `CUSTOMER` varchar(100) DEFAULT NULL,
  `CUSTOMER_NAME` varchar(100) DEFAULT NULL,
  `CURRENCY` varchar(4) DEFAULT NULL,
  `AMOUNT` double(50,2) DEFAULT NULL,
  `BANK_DOC` varchar(20) DEFAULT NULL,
  `DATE` date DEFAULT NULL,
  `HOUSE_BANK` varchar(20) DEFAULT NULL,
  `PEMBAYARAN` varchar(255) DEFAULT NULL,
  `DATELOAD` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2052 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `daily_report`
--

DROP TABLE IF EXISTS `daily_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_report` (
  `TANGGAL` date NOT NULL,
  `TAG_NAME` varchar(50) NOT NULL,
  `VALUE` double(20,2) DEFAULT NULL,
  `CREATOR` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`TANGGAL`,`TAG_NAME`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dashboard_ptks`
--

DROP TABLE IF EXISTS `dashboard_ptks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dashboard_ptks` (
  `TANGGAL` date DEFAULT NULL,
  `KRITERIA` varchar(255) DEFAULT NULL,
  `VALUE` decimal(18,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `data_for_transfer_vd`
--

DROP TABLE IF EXISTS `data_for_transfer_vd`;
/*!50001 DROP VIEW IF EXISTS `data_for_transfer_vd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `data_for_transfer_vd` AS SELECT 
 1 AS `produk`,
 1 AS `produk_id`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `key`,
 1 AS `value`,
 1 AS `tanggal`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `data_from_up`
--

DROP TABLE IF EXISTS `data_from_up`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_from_up` (
  `tanggal` datetime NOT NULL,
  `tag_name` varchar(50) NOT NULL,
  `value` int(11) DEFAULT NULL,
  `transfer` char(1) DEFAULT NULL,
  PRIMARY KEY (`tanggal`,`tag_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `data_pl_vd`
--

DROP TABLE IF EXISTS `data_pl_vd`;
/*!50001 DROP VIEW IF EXISTS `data_pl_vd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `data_pl_vd` AS SELECT 
 1 AS `id`,
 1 AS `tanggal`,
 1 AS `description`,
 1 AS `matrial`,
 1 AS `value_idr`,
 1 AS `value_usd`,
 1 AS `sum_value_idr`,
 1 AS `sum_value_usd`,
 1 AS `sales_value_idr`,
 1 AS `sales_value_usd`,
 1 AS `produk`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `data_total_vd`
--

DROP TABLE IF EXISTS `data_total_vd`;
/*!50001 DROP VIEW IF EXISTS `data_total_vd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `data_total_vd` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `datas`
--

DROP TABLE IF EXISTS `datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datas` (
  `produk_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `group` int(11) NOT NULL,
  `tag_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child1` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_value` double(11,0) NOT NULL DEFAULT '0',
  `average_value` int(11) NOT NULL DEFAULT '0',
  `akumulasi` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`produk_id`,`tanggal`,`group`,`child1`,`child2`) USING BTREE,
  CONSTRAINT `datas_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `datas_new_vd`
--

DROP TABLE IF EXISTS `datas_new_vd`;
/*!50001 DROP VIEW IF EXISTS `datas_new_vd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `datas_new_vd` AS SELECT 
 1 AS `tanggal`,
 1 AS `tag_name`,
 1 AS `value`,
 1 AS `transfer`,
 1 AS `label`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `datas_vd`
--

DROP TABLE IF EXISTS `datas_vd`;
/*!50001 DROP VIEW IF EXISTS `datas_vd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `datas_vd` AS SELECT 
 1 AS `tanggal`,
 1 AS `produk_id`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `sum`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `demografi`
--

DROP TABLE IF EXISTS `demografi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demografi` (
  `id` int(11) NOT NULL,
  `part` varchar(10) NOT NULL,
  `tahun` int(4) NOT NULL,
  `deskripsi` varchar(100) DEFAULT NULL,
  `des_lama` double(50,2) DEFAULT NULL,
  `januari` double(50,2) DEFAULT NULL,
  `februari` double(50,2) DEFAULT NULL,
  `maret` double(50,2) DEFAULT NULL,
  `april` double(50,2) DEFAULT NULL,
  `mei` double(50,2) DEFAULT NULL,
  `juni` double(50,2) DEFAULT NULL,
  `juli` double(50,2) DEFAULT NULL,
  `agustus` double(50,2) DEFAULT NULL,
  `september` double(50,2) DEFAULT NULL,
  `oktober` double(50,2) DEFAULT NULL,
  `november` double(50,2) DEFAULT NULL,
  `desember` double(50,2) DEFAULT NULL,
  PRIMARY KEY (`id`,`tahun`,`part`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `demografi_usia`
--

DROP TABLE IF EXISTS `demografi_usia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demografi_usia` (
  `id` int(11) NOT NULL,
  `inti` varchar(100) NOT NULL,
  `tahun` int(11) NOT NULL,
  `range_usia` varchar(15) NOT NULL,
  `gol_a` int(11) DEFAULT NULL,
  `gol_b` int(11) DEFAULT NULL,
  `gol_c` int(11) DEFAULT NULL,
  `gol_d` int(11) DEFAULT NULL,
  `gol_e` int(11) DEFAULT NULL,
  `gol_f` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `finishgoods`
--

DROP TABLE IF EXISTS `finishgoods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finishgoods` (
  `produk_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `plant` varchar(5) DEFAULT NULL,
  `material` varchar(30) NOT NULL,
  `sLoc` varchar(5) DEFAULT NULL,
  `batch` varchar(10) NOT NULL,
  `salesDoc` varchar(15) DEFAULT NULL,
  `itemSD` decimal(18,0) DEFAULT NULL,
  `Unrestricted` decimal(18,2) DEFAULT NULL,
  `WHStatus` varchar(10) DEFAULT NULL,
  `WhStatus2` varchar(10) DEFAULT NULL,
  `timeload` time DEFAULT NULL,
  PRIMARY KEY (`produk_id`,`tanggal`,`material`,`batch`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `finishgoodv01`
--

DROP TABLE IF EXISTS `finishgoodv01`;
/*!50001 DROP VIEW IF EXISTS `finishgoodv01`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `finishgoodv01` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `gr`
--

DROP TABLE IF EXISTS `gr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gr` (
  `PstngDate` date DEFAULT NULL,
  `MvT` varchar(5) DEFAULT NULL,
  `Plnt` varchar(10) DEFAULT NULL,
  `SLoc` varchar(10) DEFAULT NULL,
  `MatDoc` varchar(20) DEFAULT NULL,
  `Material` varchar(15) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Quantity` decimal(18,0) DEFAULT NULL,
  `BUn` varchar(10) DEFAULT NULL,
  `Batch` varchar(25) DEFAULT NULL,
  `User` varchar(25) DEFAULT NULL,
  `Order` varchar(15) DEFAULT NULL,
  `AmountinLC` decimal(18,0) DEFAULT NULL,
  `HeaderText` varchar(25) DEFAULT NULL,
  `Reference` varchar(25) DEFAULT NULL,
  `ExtAmntLC` decimal(18,0) DEFAULT NULL,
  `Amountin` decimal(18,0) DEFAULT NULL,
  `PO` varchar(255) DEFAULT NULL,
  `Item` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hutang_kmk`
--

DROP TABLE IF EXISTS `hutang_kmk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hutang_kmk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gl_account` varchar(50) DEFAULT NULL,
  `assignment` varchar(50) DEFAULT NULL,
  `document_number` int(11) DEFAULT NULL,
  `posting_date` date DEFAULT NULL,
  `document_date` date DEFAULT NULL,
  `amount` float(12,2) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `timeload` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hutang_lc`
--

DROP TABLE IF EXISTS `hutang_lc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hutang_lc` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `VENDOR` varchar(25) DEFAULT NULL,
  `VENDOR_NAME` varchar(100) NOT NULL,
  `DOCUMENT_NUMBER` varchar(25) NOT NULL,
  `GL_ACCOUNT` varchar(25) DEFAULT NULL,
  `POSTING_DATE` date DEFAULT NULL,
  `DOCUMENT_DATE` date DEFAULT NULL,
  `REFERENCE` varchar(50) DEFAULT NULL,
  `NET_DUE_DATE` date DEFAULT NULL,
  `AMOUNT_IN_DOC_CURR` double(20,2) DEFAULT NULL,
  `DOCUMENT_CURRENCY` varchar(4) DEFAULT NULL,
  `LOCAL_CURRENCY` varchar(4) DEFAULT NULL,
  `LOCAL_CURRENCY2` varchar(4) DEFAULT NULL,
  `TEXT` varchar(255) DEFAULT NULL,
  `DATELOAD` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kamus_data`
--

DROP TABLE IF EXISTS `kamus_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kamus_data` (
  `produk_id` int(11) NOT NULL,
  `group` int(11) NOT NULL,
  `tag_name` varchar(50) NOT NULL,
  `child1` varchar(50) NOT NULL,
  `child2` varchar(50) NOT NULL,
  `key` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`produk_id`,`group`,`child1`,`child2`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kontribusi_margin`
--

DROP TABLE IF EXISTS `kontribusi_margin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kontribusi_margin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `matrial` varchar(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `sales_value_idr` float(20,2) DEFAULT NULL,
  `sales_value_usd` float(20,2) DEFAULT NULL,
  `calculated_value_idr` float(20,2) DEFAULT NULL,
  `calculated_value_usd` float(20,2) DEFAULT NULL,
  `value_idr` float(20,2) DEFAULT NULL,
  `value_usd` float(20,2) DEFAULT NULL,
  `billing_number` varchar(50) DEFAULT NULL,
  `billing_item` varchar(50) DEFAULT NULL,
  `quantity` float(20,2) DEFAULT NULL,
  `uom` varchar(10) DEFAULT NULL,
  `dist` varchar(10) DEFAULT NULL COMMENT 'D0 => Domestik; E0=>eksport',
  `datefile` datetime DEFAULT NULL COMMENT 'tanggal yang tertera di nama file',
  `dateload` datetime DEFAULT NULL COMMENT 'tanggal load file margin_YYYMMDDHH.txt',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=88950 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kurs_bi`
--

DROP TABLE IF EXISTS `kurs_bi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kurs_bi` (
  `TANGGAL` date NOT NULL,
  `MATA_UANG` varchar(3) NOT NULL,
  `NILAI` double(20,2) DEFAULT NULL,
  `KURS_JULA` double(20,2) DEFAULT NULL,
  `KURS_BELI` double(20,2) DEFAULT NULL,
  `KURS_TENGAH` double(20,2) DEFAULT NULL,
  PRIMARY KEY (`TANGGAL`,`MATA_UANG`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `laporanpk`
--

DROP TABLE IF EXISTS `laporanpk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laporanpk` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IM_POSITION` varchar(20) NOT NULL,
  `DESCRIPTION` text,
  `APPROVAL_YEAR` varchar(4) NOT NULL,
  `PROGRAM_PLAN` float(20,2) DEFAULT NULL,
  `PROGRAM_BUDGET` float(20,2) DEFAULT NULL,
  `APPR_REQ_PLAN` float(20,2) DEFAULT NULL,
  `MRA_AVAIL_BUDGET` float(20,2) DEFAULT NULL,
  `APPR_REQUEST` varchar(20) DEFAULT NULL,
  `AR_DESCRIPTION` varchar(255) DEFAULT NULL,
  `AR_VALUE` double(20,2) DEFAULT NULL,
  `INTERNAL_ORDER` varchar(20) DEFAULT NULL,
  `IO_TYPE` varchar(20) DEFAULT NULL,
  `IO_BUDGET` int(15) DEFAULT NULL,
  `IO_ASSIGNED` int(15) DEFAULT NULL,
  `IO_AVAIL_BUDGET` int(15) DEFAULT NULL,
  `PURC_REQ` varchar(20) DEFAULT NULL,
  `PR_LINE_ITEM` varchar(20) DEFAULT NULL,
  `PR_MAT_NUMBER` varchar(20) DEFAULT NULL,
  `PR_DESCRIPTION` text,
  `PR_QTY` int(15) DEFAULT NULL,
  `PR_UOM` varchar(20) DEFAULT NULL,
  `PR_VALUE_TRX` int(15) DEFAULT NULL,
  `PR_CURRENCY` varchar(20) DEFAULT NULL,
  `PR_VALUE_IDR` int(15) DEFAULT NULL,
  `PURC_ORDER` varchar(20) DEFAULT NULL,
  `PO_LINE_ITEM` varchar(20) DEFAULT NULL,
  `PO_MAT_NUMBER` varchar(20) DEFAULT NULL,
  `PO_DESCRIPTION` text,
  `PO_QTY` int(15) DEFAULT NULL,
  `PO_UOM` varchar(20) DEFAULT NULL,
  `PO_VALUE_TRX` int(15) DEFAULT NULL,
  `PO_CURRENCY` varchar(20) DEFAULT NULL,
  `PO_VALUE_IDR` int(15) DEFAULT NULL,
  `ACTUAL` float(20,2) DEFAULT NULL,
  `DATELOAD` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8365 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `likuiditas`
--

DROP TABLE IF EXISTS `likuiditas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likuiditas` (
  `likuiditas_id` int(11) NOT NULL AUTO_INCREMENT,
  `likuiditas_date` date NOT NULL,
  `persediaan` float NOT NULL DEFAULT '0',
  `saldokas` float NOT NULL DEFAULT '0',
  `piutang` float NOT NULL DEFAULT '0',
  `hutang` float NOT NULL DEFAULT '0',
  `update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`likuiditas_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_data`
--

DROP TABLE IF EXISTS `log_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_trans` datetime DEFAULT NULL,
  `log_dt` longtext COLLATE latin1_general_ci,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_down`
--

DROP TABLE IF EXISTS `log_down`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_down` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isinya` varchar(255) DEFAULT NULL,
  `stat` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=696 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `myperiod`
--

DROP TABLE IF EXISTS `myperiod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `myperiod` (
  `D0` varchar(100) DEFAULT NULL,
  `B` varchar(100) DEFAULT NULL,
  `C` varchar(100) DEFAULT NULL,
  `D` varchar(100) DEFAULT NULL,
  `E` varchar(100) DEFAULT NULL,
  `F` varchar(100) DEFAULT NULL,
  `G` int(4) DEFAULT NULL,
  `H` int(4) DEFAULT NULL,
  `I` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mytab`
--

DROP TABLE IF EXISTS `mytab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mytab` (
  `D0` varchar(100) DEFAULT NULL,
  `B` varchar(100) DEFAULT NULL,
  `C` varchar(100) DEFAULT NULL,
  `D` varchar(100) DEFAULT NULL,
  `E` varchar(100) DEFAULT NULL,
  `F` varchar(100) DEFAULT NULL,
  `G` int(4) DEFAULT NULL,
  `H` int(4) DEFAULT NULL,
  `I` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `number`
--

DROP TABLE IF EXISTS `number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `number` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `number` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `org_text`
--

DROP TABLE IF EXISTS `org_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `org_text` (
  `PV` varchar(2) DEFAULT NULL,
  `OT` varchar(2) DEFAULT NULL,
  `ObjectID` varchar(8) NOT NULL,
  `Objectname` varchar(40) DEFAULT NULL,
  `Objectabbr` varchar(12) DEFAULT NULL,
  `Startdate` date DEFAULT NULL,
  `EndDate` date NOT NULL,
  `IT` varchar(4) DEFAULT NULL,
  `LSTUPDT` date DEFAULT NULL,
  PRIMARY KEY (`ObjectID`,`EndDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='ZHROM0011';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orgunit`
--

DROP TABLE IF EXISTS `orgunit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orgunit` (
  `OT` varchar(2) DEFAULT NULL,
  `ObjectID` varchar(8) NOT NULL,
  `S` varchar(1) DEFAULT NULL,
  `Rel` varchar(3) DEFAULT NULL,
  `Startdate` date DEFAULT NULL,
  `EndDate` date NOT NULL,
  `RO` varchar(2) DEFAULT NULL,
  `IDrelatedobject` varchar(8) DEFAULT NULL,
  `LSTUPDT` date DEFAULT NULL,
  PRIMARY KEY (`ObjectID`,`EndDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='ZHROM0010';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`(191)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmo_anggaran`
--

DROP TABLE IF EXISTS `pmo_anggaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmo_anggaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wbs` varchar(100) NOT NULL,
  `tahun` year(4) NOT NULL,
  `anggaran_idr` decimal(20,0) DEFAULT NULL,
  `anggaran_usd` decimal(20,0) DEFAULT NULL,
  `realisasi_idr` decimal(20,0) DEFAULT NULL,
  `realisasi_usd` decimal(20,0) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2537 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmo_anggaranall`
--

DROP TABLE IF EXISTS `pmo_anggaranall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmo_anggaranall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wbs` varchar(100) NOT NULL,
  `anggaranall_idr` decimal(20,0) DEFAULT NULL,
  `anggaranall_usd` decimal(20,0) DEFAULT NULL,
  `realisasiall_idr` decimal(20,0) DEFAULT NULL,
  `realisasiall_usd` decimal(20,0) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=511 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmo_kurs`
--

DROP TABLE IF EXISTS `pmo_kurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmo_kurs` (
  `kurs_id` int(11) NOT NULL AUTO_INCREMENT,
  `kurs_tahun` year(4) DEFAULT NULL,
  `kurs_value` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`kurs_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmo_project`
--

DROP TABLE IF EXISTS `pmo_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmo_project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_pid` int(11) NOT NULL DEFAULT '0',
  `projecttype_id` int(11) DEFAULT NULL,
  `pinvesttype_id` int(11) DEFAULT NULL,
  `subs_id` int(11) DEFAULT NULL,
  `project_name` varchar(200) NOT NULL DEFAULT '',
  `rkap` decimal(10,0) DEFAULT NULL,
  `proyeksi_value` decimal(10,0) DEFAULT NULL,
  `proyeksi_persen` decimal(10,0) DEFAULT NULL,
  `realisasi_value` decimal(10,0) DEFAULT NULL,
  `realisasi_persen` decimal(10,0) DEFAULT NULL,
  `tahun` varchar(200) DEFAULT NULL,
  `effstatus` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `link` int(11) DEFAULT '1',
  `summary` tinyint(4) DEFAULT '1',
  `sort` int(11) NOT NULL,
  `milestone` varchar(200) DEFAULT NULL,
  `keterangan` text,
  `progress_status` int(11) DEFAULT NULL,
  `wbs` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`project_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=312 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmo_project_budget`
--

DROP TABLE IF EXISTS `pmo_project_budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmo_project_budget` (
  `budget_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `rkap` decimal(20,0) DEFAULT NULL,
  `proyeksi_value` decimal(20,0) DEFAULT NULL,
  `realisasi_value` decimal(20,0) DEFAULT NULL,
  `rkap_berjalan` decimal(20,0) DEFAULT NULL,
  `realisasi_berjalan` decimal(20,0) DEFAULT NULL,
  `rkap_year` int(11) NOT NULL DEFAULT '2012',
  `status` int(11) NOT NULL DEFAULT '1',
  `curr` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`budget_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=529 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmo_projectplan`
--

DROP TABLE IF EXISTS `pmo_projectplan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmo_projectplan` (
  `plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `plan_date` date NOT NULL,
  `plan_data` decimal(10,2) DEFAULT NULL,
  `plan_actual` decimal(10,2) DEFAULT NULL,
  `pay_plan` decimal(10,2) DEFAULT NULL,
  `pay_actual` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`plan_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10805 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmo_projecttype`
--

DROP TABLE IF EXISTS `pmo_projecttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmo_projecttype` (
  `projecttype_id` int(11) NOT NULL AUTO_INCREMENT,
  `projecttype_name` varchar(200) NOT NULL DEFAULT '',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`projecttype_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `po`
--

DROP TABLE IF EXISTS `po`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `po` (
  `PurchDoc` varchar(20) NOT NULL,
  `CreateDTPO` date DEFAULT NULL,
  `DeliveryDate` date DEFAULT NULL,
  `DelivDTPR` date DEFAULT NULL,
  `PGr` varchar(255) DEFAULT NULL,
  `Item` varchar(255) NOT NULL,
  `Material` varchar(255) DEFAULT NULL,
  `ShortText` varchar(255) DEFAULT NULL,
  `POQuantity` int(11) DEFAULT NULL,
  `OUn` varchar(255) DEFAULT NULL,
  `Per` varchar(255) DEFAULT NULL,
  `Crcy` varchar(5) DEFAULT NULL,
  `NetPrice` decimal(18,0) DEFAULT NULL,
  `TotalPrice` decimal(18,0) DEFAULT NULL,
  `VendorName` varchar(255) DEFAULT NULL,
  `LeadTime` int(11) DEFAULT NULL,
  `IncoT` varchar(255) DEFAULT NULL,
  `Destination` varchar(255) DEFAULT NULL,
  `DeleteInd` varchar(255) DEFAULT NULL,
  `R` varchar(255) DEFAULT NULL,
  `OurReff` varchar(255) DEFAULT NULL,
  `PurchReq` varchar(255) DEFAULT NULL,
  `Vendor` varchar(10) DEFAULT NULL,
  `POgrp` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`PurchDoc`,`Item`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pr`
--

DROP TABLE IF EXISTS `pr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pr` (
  `PurchReq` varchar(10) NOT NULL,
  `Rel` varchar(5) DEFAULT NULL,
  `RS` varchar(5) DEFAULT NULL,
  `PGr` varchar(15) DEFAULT NULL,
  `S` varchar(15) DEFAULT NULL,
  `D` varchar(255) DEFAULT NULL,
  `ReqDate` date DEFAULT NULL,
  `ReleaseDt` date DEFAULT NULL,
  `DelivDate` date DEFAULT NULL,
  `Material` varchar(15) DEFAULT NULL,
  `ShortText` varchar(255) DEFAULT NULL,
  `Plnt` varchar(5) DEFAULT NULL,
  `Quantity` decimal(18,0) DEFAULT NULL,
  `Changedon` date DEFAULT NULL,
  `Un` varchar(20) DEFAULT NULL,
  `PO` varchar(15) DEFAULT NULL,
  `PODate` date DEFAULT NULL,
  `ValPrice` decimal(18,0) DEFAULT NULL,
  `TotalVal` decimal(18,0) DEFAULT NULL,
  `TrackingNo` varchar(25) DEFAULT NULL,
  `SLoc` varchar(30) DEFAULT NULL,
  `Ordered` decimal(18,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prod`
--

DROP TABLE IF EXISTS `prod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prod` (
  `prod_id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_date` date NOT NULL,
  `drp` decimal(10,2) DEFAULT NULL,
  `ssp` decimal(10,2) DEFAULT NULL,
  `ssp2` decimal(10,2) NOT NULL,
  `bsp` decimal(10,2) DEFAULT NULL,
  `hsm` decimal(10,2) DEFAULT NULL,
  `crc` decimal(10,2) DEFAULT NULL,
  `po` decimal(10,2) DEFAULT NULL,
  `wrm` decimal(10,2) DEFAULT NULL,
  `prod_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prod_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=739 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prod_last`
--

DROP TABLE IF EXISTS `prod_last`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prod_last` (
  `BEREICH` varchar(10) NOT NULL COMMENT 'plant',
  `ANLAGE` varchar(10) NOT NULL COMMENT 'line',
  `LAST_PROD` datetime NOT NULL,
  `GEWINPUT` float(15,2) DEFAULT NULL COMMENT 'input',
  `GEWOUTPUT` float(15,2) DEFAULT NULL COMMENT 'output',
  `SCRAPWEIGHT` float(15,2) DEFAULT NULL COMMENT 'scrap',
  `GEWINPUT_TOTAL` float(15,2) DEFAULT NULL,
  `GEWOUTPUT_TOTAL` float(15,2) DEFAULT NULL,
  `SCRAPWEIGHT_TOTAL` float(15,2) DEFAULT NULL,
  PRIMARY KEY (`BEREICH`,`ANLAGE`,`LAST_PROD`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prod_targets`
--

DROP TABLE IF EXISTS `prod_targets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prod_targets` (
  `target_id` int(11) NOT NULL AUTO_INCREMENT,
  `target_date` date NOT NULL,
  `drp` decimal(10,2) DEFAULT NULL,
  `ssp` decimal(10,2) DEFAULT NULL,
  `ssp2` decimal(10,2) NOT NULL,
  `bsp` decimal(10,2) DEFAULT NULL,
  `hsm` decimal(10,2) DEFAULT NULL,
  `crc` decimal(10,2) DEFAULT NULL,
  `po` decimal(10,2) DEFAULT NULL,
  `wrm` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`target_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=699 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prods`
--

DROP TABLE IF EXISTS `prods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prods` (
  `prod_id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_date` date NOT NULL,
  `drp` decimal(10,2) DEFAULT NULL,
  `ssp` decimal(10,2) DEFAULT NULL,
  `ssp2` decimal(10,2) NOT NULL,
  `bsp` decimal(10,2) DEFAULT NULL,
  `hsm` decimal(10,2) DEFAULT NULL,
  `crc` decimal(10,2) DEFAULT NULL,
  `po` decimal(10,2) DEFAULT NULL,
  `wrm` decimal(10,2) DEFAULT NULL,
  `prod_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prod_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=732 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `produks`
--

DROP TABLE IF EXISTS `produks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produk` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rakordir`
--

DROP TABLE IF EXISTS `rakordir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rakordir` (
  `username` varchar(100) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `tempat` varchar(100) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `no_dokument` varchar(150) DEFAULT NULL,
  `agenda_no` int(11) NOT NULL,
  PRIMARY KEY (`agenda_no`,`date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `realisasi_foh`
--

DROP TABLE IF EXISTS `realisasi_foh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `realisasi_foh` (
  `tahun` varchar(4) NOT NULL,
  `pk` varchar(4) NOT NULL,
  `rekening` varchar(10) NOT NULL,
  `deskripsi` text,
  `nama_rekening` varchar(255) DEFAULT NULL,
  `realisasi_lama` double(50,2) DEFAULT NULL,
  `rata_rata_lama` double(50,2) DEFAULT NULL,
  `realisasi_januari` double(50,2) DEFAULT NULL,
  `realisasi_februari` double(50,2) DEFAULT NULL,
  `realisasi_maret` double(50,2) DEFAULT NULL,
  `realisasi_april` double(50,2) DEFAULT NULL,
  `realisasi_mei` double(50,2) DEFAULT NULL,
  `realisasi_juni` double(50,2) DEFAULT NULL,
  `real_smt_1` double(50,2) DEFAULT NULL,
  `realisasi_juli` double(50,2) DEFAULT NULL,
  `realisasi_agustus` double(50,2) DEFAULT NULL,
  `realisasi_september` double(50,2) DEFAULT NULL,
  `realisasi_oktober` double(50,2) DEFAULT NULL,
  `realisasi_november` double(50,2) DEFAULT NULL,
  `realisasi_desember` double(50,2) DEFAULT NULL,
  `real_q123` double(50,2) DEFAULT NULL,
  `real_jan_des` double(50,2) DEFAULT NULL,
  `anggaran_smt_1` double(50,2) DEFAULT NULL,
  `anggaran_per_bulan` double(50,2) DEFAULT NULL,
  `rkap` double(50,2) DEFAULT NULL,
  `anggaran_jan_des` double(50,2) DEFAULT NULL,
  `sisa_anggaran` double(50,2) DEFAULT NULL,
  `datefile` date DEFAULT NULL COMMENT 'tanggal pada file',
  `dateload` datetime DEFAULT NULL COMMENT 'tanggal load file',
  PRIMARY KEY (`tahun`,`pk`,`rekening`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `referensi`
--

DROP TABLE IF EXISTS `referensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `referensi` (
  `group` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sap_tag_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`group`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rkaps`
--

DROP TABLE IF EXISTS `rkaps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rkaps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produk_id` int(11) NOT NULL,
  `bulan` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`,`produk_id`) USING BTREE,
  KEY `rkaps_produk_id_foreign` (`produk_id`) USING BTREE,
  CONSTRAINT `rkaps_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rtscargos`
--

DROP TABLE IF EXISTS `rtscargos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rtscargos` (
  `salesDoc` varchar(15) NOT NULL,
  `itemSD` decimal(18,0) NOT NULL,
  `MatNo` varchar(255) NOT NULL,
  `Unrestrited` decimal(18,0) DEFAULT NULL,
  `LSD` date DEFAULT NULL,
  `DelivBlockHeader` varchar(255) DEFAULT NULL,
  `DelivBlockItem` varchar(255) DEFAULT NULL,
  `SOExpiredDate` varbinary(10) DEFAULT NULL,
  `ReasonforRejection` varchar(255) DEFAULT NULL,
  `Remark` varchar(255) DEFAULT NULL,
  `FinDocType` varchar(255) DEFAULT NULL,
  `dateload` date NOT NULL,
  `timeload` time DEFAULT NULL,
  PRIMARY KEY (`salesDoc`,`itemSD`,`MatNo`,`dateload`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saldo_bank`
--

DROP TABLE IF EXISTS `saldo_bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saldo_bank` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `CURRENCY` varchar(10) DEFAULT NULL,
  `BANK_NAME` varchar(255) DEFAULT NULL,
  `BANK_KEY` varchar(255) DEFAULT NULL,
  `ACCOUNT_NUMBER` varchar(255) DEFAULT NULL,
  `STATEMENT_DATE` date DEFAULT NULL,
  `ENDING_BALANCE` float(50,2) DEFAULT NULL,
  `DATEFILE` date DEFAULT NULL,
  `TIMELOAD` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipment_targets`
--

DROP TABLE IF EXISTS `shipment_targets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipment_targets` (
  `target_id` int(11) NOT NULL AUTO_INCREMENT,
  `target_date` date NOT NULL,
  `hr_dom` decimal(10,2) DEFAULT '0.00',
  `hrpo_dom` decimal(10,2) DEFAULT '0.00',
  `cr_dom` decimal(10,2) DEFAULT '0.00',
  `wr_dom` decimal(10,2) DEFAULT '0.00',
  `bs_dom` decimal(10,2) DEFAULT '0.00',
  `hr_exp` decimal(10,2) DEFAULT '0.00',
  `hrpo_exp` decimal(10,2) DEFAULT '0.00',
  `cr_exp` decimal(10,2) DEFAULT '0.00',
  `wr_exp` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`target_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=361 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipments`
--

DROP TABLE IF EXISTS `shipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipments` (
  `shipment_id` int(11) NOT NULL AUTO_INCREMENT,
  `shipment_date` date NOT NULL,
  `hr_dom` decimal(10,2) DEFAULT '0.00',
  `hrpo_dom` decimal(10,2) DEFAULT '0.00',
  `cr_dom` decimal(10,2) DEFAULT '0.00',
  `wr_dom` decimal(10,2) DEFAULT '0.00',
  `bs_dom` decimal(10,2) DEFAULT '0.00',
  `hr_exp` decimal(10,2) DEFAULT '0.00',
  `hrpo_exp` decimal(10,2) DEFAULT '0.00',
  `cr_exp` decimal(10,2) DEFAULT '0.00',
  `wr_exp` decimal(10,2) DEFAULT '0.00',
  `shipment_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`shipment_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=264366 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deskripsi_kode` varchar(200) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `plant` varchar(20) DEFAULT NULL,
  `sloc` varchar(20) DEFAULT NULL,
  `quantity` double(100,2) DEFAULT NULL,
  `dateload` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=35181 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `stock_child1_vd`
--

DROP TABLE IF EXISTS `stock_child1_vd`;
/*!50001 DROP VIEW IF EXISTS `stock_child1_vd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stock_child1_vd` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`,
 1 AS `sum`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stock_free_vd`
--

DROP TABLE IF EXISTS `stock_free_vd`;
/*!50001 DROP VIEW IF EXISTS `stock_free_vd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stock_free_vd` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`,
 1 AS `sum`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `structdireksi`
--

DROP TABLE IF EXISTS `structdireksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `structdireksi` (
  `no` int(3) DEFAULT NULL COMMENT 'NO URUT RELASI',
  `empnik` varchar(8) NOT NULL COMMENT 'EMPLOYEE NIK',
  `empname` varchar(40) DEFAULT NULL COMMENT 'EMPLOYEE NAME',
  `empposid` varchar(8) DEFAULT NULL COMMENT ' Posisi-ID atasan (untuk urut 1 = posisi-ID employee)',
  `emp_hrp1000_s_short` varchar(12) DEFAULT NULL COMMENT 'Abbreviasi Posisi',
  `emppostx` varchar(40) DEFAULT NULL COMMENT 'Nama Posisi (untuk urut 1 = nama posisi employee)',
  `emporid` varchar(8) DEFAULT NULL COMMENT 'Org.ID atasan (untuk urut 1 = Org.ID employee)',
  `emportx` varchar(40) DEFAULT NULL COMMENT 'Nama Org. (untuk urut 1 = nama org. employee)',
  `emp_hrp1000_o_short` varchar(12) DEFAULT NULL COMMENT 'Abbreviasi Org.',
  `empjobid` varchar(8) DEFAULT NULL COMMENT 'Job-ID',
  `empjobstext` varchar(40) DEFAULT NULL COMMENT 'Job Name',
  `emppersk` varchar(2) DEFAULT NULL COMMENT 'employee subgroup posisi',
  `emp_t503t_ptext` varchar(20) DEFAULT NULL COMMENT 'employee subgroup text posisi',
  `empkostl` varchar(10) DEFAULT NULL COMMENT ' cost center',
  `emp_cskt_ltext` varchar(40) DEFAULT NULL COMMENT 'nama cost center',
  `dirnik` varchar(8) DEFAULT NULL COMMENT 'NIK Atasan (untuk urut 1 = nik Employee)',
  `dirname` varchar(40) DEFAULT NULL COMMENT 'Nama Atasan',
  `LSTUPDT` date DEFAULT NULL COMMENT 'last update',
  PRIMARY KEY (`empnik`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `structdisp`
--

DROP TABLE IF EXISTS `structdisp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `structdisp` (
  `no` int(3) DEFAULT NULL COMMENT 'NO URUT RELASI',
  `empnik` varchar(8) DEFAULT NULL COMMENT 'EMPLOYEE NIK',
  `empname` varchar(40) DEFAULT NULL COMMENT 'EMPLOYEE NAME',
  `empposid` varchar(8) DEFAULT NULL COMMENT ' Posisi-ID atasan (untuk urut 1 = posisi-ID employee)',
  `emp_hrp1000_s_short` varchar(12) DEFAULT NULL COMMENT 'Abbreviasi Posisi',
  `emppostx` varchar(40) DEFAULT NULL COMMENT 'Nama Posisi (untuk urut 1 = nama posisi employee)',
  `emporid` varchar(8) DEFAULT NULL COMMENT 'Org.ID atasan (untuk urut 1 = Org.ID employee)',
  `emportx` varchar(40) DEFAULT NULL COMMENT 'Nama Org. (untuk urut 1 = nama org. employee)',
  `emp_hrp1000_o_short` varchar(12) DEFAULT NULL COMMENT 'Abbreviasi Org.',
  `empjobid` varchar(8) DEFAULT NULL COMMENT 'Job-ID',
  `empjobstext` varchar(40) DEFAULT NULL COMMENT 'Job Name',
  `emppersk` varchar(2) DEFAULT NULL COMMENT 'employee subgroup posisi',
  `emp_t503t_ptext` varchar(20) DEFAULT NULL COMMENT 'employee subgroup text posisi',
  `empkostl` varchar(10) DEFAULT NULL COMMENT ' cost center',
  `emp_cskt_ltext` varchar(40) DEFAULT NULL COMMENT 'nama cost center',
  `dirnik` varchar(8) DEFAULT NULL COMMENT 'NIK Atasan (untuk urut 1 = nik Employee)',
  `dirname` varchar(40) DEFAULT NULL COMMENT 'Nama Atasan',
  `LSTUPDT` date DEFAULT NULL COMMENT 'last update'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sys_groups`
--

DROP TABLE IF EXISTS `sys_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_groups` (
  `node_group` int(11) NOT NULL,
  `group` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`node_group`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sys_menus`
--

DROP TABLE IF EXISTS `sys_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_menus` (
  `node_group` int(11) NOT NULL,
  `node_menu` int(11) NOT NULL,
  `menu` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik_access` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`node_group`,`node_menu`) USING BTREE,
  CONSTRAINT `sys_menus_ibfk_1` FOREIGN KEY (`node_group`) REFERENCES `sys_groups` (`node_group`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sys_pengunjung`
--

DROP TABLE IF EXISTS `sys_pengunjung`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_pengunjung` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_NAME` varchar(20) DEFAULT NULL,
  `TANGGAL` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sys_users`
--

DROP TABLE IF EXISTS `sys_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_users` (
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pk` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`nik`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `target_rkap`
--

DROP TABLE IF EXISTS `target_rkap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `target_rkap` (
  `BULAN` varchar(2) NOT NULL,
  `TAHUN` varchar(10) NOT NULL,
  `DOM_SLAB` int(11) DEFAULT NULL,
  `DOM_HRC` int(11) DEFAULT NULL,
  `DOM_HRPO` int(11) DEFAULT NULL,
  `DOM_HRT` int(11) DEFAULT NULL,
  `DOM_CRC` int(11) DEFAULT NULL,
  `DOM_BLT` int(11) DEFAULT NULL,
  `DOM_WR` int(11) DEFAULT NULL,
  `EKS_HRC` int(11) DEFAULT NULL,
  `EKS_HRPO` int(11) DEFAULT NULL,
  `EKS_CRC` int(11) DEFAULT NULL,
  `EKS_WR` int(11) DEFAULT NULL,
  PRIMARY KEY (`BULAN`,`TAHUN`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `v1`
--

DROP TABLE IF EXISTS `v1`;
/*!50001 DROP VIEW IF EXISTS `v1`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v1` AS SELECT 
 1 AS `D0`,
 1 AS `B`,
 1 AS `C`,
 1 AS `D`,
 1 AS `E`,
 1 AS `F`,
 1 AS `G`,
 1 AS `H`,
 1 AS `I`,
 1 AS `J`,
 1 AS `K`,
 1 AS `M`,
 1 AS `O`,
 1 AS `Q`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v2`
--

DROP TABLE IF EXISTS `v2`;
/*!50001 DROP VIEW IF EXISTS `v2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v2` AS SELECT 
 1 AS `D0`,
 1 AS `B`,
 1 AS `C`,
 1 AS `D`,
 1 AS `E`,
 1 AS `F`,
 1 AS `G`,
 1 AS `H`,
 1 AS `I`,
 1 AS `J`,
 1 AS `K`,
 1 AS `M`,
 1 AS `O`,
 1 AS `Q`,
 1 AS `S`,
 1 AS `T`,
 1 AS `U`,
 1 AS `V`,
 1 AS `W`,
 1 AS `X`,
 1 AS `Y`,
 1 AS `Z`,
 1 AS `AA`,
 1 AS `AB`,
 1 AS `AC`,
 1 AS `AD`,
 1 AS `AE`,
 1 AS `AF`,
 1 AS `AG`,
 1 AS `AH`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_cargo`
--

DROP TABLE IF EXISTS `v_backup_cargo`;
/*!50001 DROP VIEW IF EXISTS `v_backup_cargo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_cargo` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_rts`
--

DROP TABLE IF EXISTS `v_backup_rts`;
/*!50001 DROP VIEW IF EXISTS `v_backup_rts`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_rts` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_sfg_cir`
--

DROP TABLE IF EXISTS `v_backup_sfg_cir`;
/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_cir`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_sfg_cir` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_sfg_fd_hold`
--

DROP TABLE IF EXISTS `v_backup_sfg_fd_hold`;
/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_hold`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_sfg_fd_hold` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_sfg_fd_lcso`
--

DROP TABLE IF EXISTS `v_backup_sfg_fd_lcso`;
/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_lcso`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_sfg_fd_lcso` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_sfg_fd_memodinas`
--

DROP TABLE IF EXISTS `v_backup_sfg_fd_memodinas`;
/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_memodinas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_sfg_fd_memodinas` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_sfg_fd_over_leeway`
--

DROP TABLE IF EXISTS `v_backup_sfg_fd_over_leeway`;
/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_over_leeway`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_sfg_fd_over_leeway` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_sfg_fd_rts`
--

DROP TABLE IF EXISTS `v_backup_sfg_fd_rts`;
/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_rts`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_sfg_fd_rts` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_sfg_fd_rts_other`
--

DROP TABLE IF EXISTS `v_backup_sfg_fd_rts_other`;
/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_rts_other`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_sfg_fd_rts_other` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_sfg_fd_waiting_for_full_pay`
--

DROP TABLE IF EXISTS `v_backup_sfg_fd_waiting_for_full_pay`;
/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_waiting_for_full_pay`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_sfg_fd_waiting_for_full_pay` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_sfg_freestok`
--

DROP TABLE IF EXISTS `v_backup_sfg_freestok`;
/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_freestok`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_sfg_freestok` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_sfg_imipis`
--

DROP TABLE IF EXISTS `v_backup_sfg_imipis`;
/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_imipis`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_sfg_imipis` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_backup_stock_fg`
--

DROP TABLE IF EXISTS `v_backup_stock_fg`;
/*!50001 DROP VIEW IF EXISTS `v_backup_stock_fg`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_backup_stock_fg` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_gr`
--

DROP TABLE IF EXISTS `v_gr`;
/*!50001 DROP VIEW IF EXISTS `v_gr`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_gr` AS SELECT 
 1 AS `PstngDate`,
 1 AS `kate`,
 1 AS `Amountinlc`,
 1 AS `PO`,
 1 AS `jenis`,
 1 AS `deskripsi`,
 1 AS `tipe`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_prod_last`
--

DROP TABLE IF EXISTS `v_prod_last`;
/*!50001 DROP VIEW IF EXISTS `v_prod_last`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prod_last` AS SELECT 
 1 AS `BEREICH`,
 1 AS `ANLAGE`,
 1 AS `LAST_PROD`,
 1 AS `DIFF`,
 1 AS `DIFF_VALUE`,
 1 AS `GEWINPUT`,
 1 AS `GEWOUTPUT`,
 1 AS `SCRAPWEIGHT`,
 1 AS `GEWINPUT_TOTAL`,
 1 AS `GEWOUTPUT_TOTAL`,
 1 AS `SCRAPWEIGHT_TOTAL`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_prod_last1`
--

DROP TABLE IF EXISTS `v_prod_last1`;
/*!50001 DROP VIEW IF EXISTS `v_prod_last1`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prod_last1` AS SELECT 
 1 AS `BEREICH`,
 1 AS `ANLAGE`,
 1 AS `LAST_PROD`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vncs`
--

DROP TABLE IF EXISTS `vncs`;
/*!50001 DROP VIEW IF EXISTS `vncs`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vncs` AS SELECT 
 1 AS `label`,
 1 AS `value`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vp1`
--

DROP TABLE IF EXISTS `vp1`;
/*!50001 DROP VIEW IF EXISTS `vp1`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vp1` AS SELECT 
 1 AS `D0`,
 1 AS `B`,
 1 AS `C`,
 1 AS `D`,
 1 AS `E`,
 1 AS `F`,
 1 AS `G`,
 1 AS `H`,
 1 AS `I`,
 1 AS `J`,
 1 AS `K`,
 1 AS `M`,
 1 AS `O`,
 1 AS `Q`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vp2`
--

DROP TABLE IF EXISTS `vp2`;
/*!50001 DROP VIEW IF EXISTS `vp2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vp2` AS SELECT 
 1 AS `D0`,
 1 AS `B`,
 1 AS `C`,
 1 AS `D`,
 1 AS `E`,
 1 AS `F`,
 1 AS `G`,
 1 AS `H`,
 1 AS `I`,
 1 AS `J`,
 1 AS `K`,
 1 AS `M`,
 1 AS `O`,
 1 AS `Q`,
 1 AS `S`,
 1 AS `T`,
 1 AS `U`,
 1 AS `V`,
 1 AS `W`,
 1 AS `X`,
 1 AS `Y`,
 1 AS `Z`,
 1 AS `AA`,
 1 AS `AB`,
 1 AS `AC`,
 1 AS `AD`,
 1 AS `AE`,
 1 AS `AF`,
 1 AS `AG`,
 1 AS `AH`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `wip_child1_vd`
--

DROP TABLE IF EXISTS `wip_child1_vd`;
/*!50001 DROP VIEW IF EXISTS `wip_child1_vd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `wip_child1_vd` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`,
 1 AS `sum`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `wip_child2_vd`
--

DROP TABLE IF EXISTS `wip_child2_vd`;
/*!50001 DROP VIEW IF EXISTS `wip_child2_vd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `wip_child2_vd` AS SELECT 
 1 AS `produk_id`,
 1 AS `tanggal`,
 1 AS `group`,
 1 AS `tag_name`,
 1 AS `child1`,
 1 AS `child2`,
 1 AS `current_value`,
 1 AS `average_value`,
 1 AS `akumulasi`,
 1 AS `sum`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'doe'
--
/*!50003 DROP FUNCTION IF EXISTS `fn_cargo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_cargo`(`tanggal` date,`produk_id` VARCHAR(10)) RETURNS int(11)
BEGIN

	#Routine body goes here...

	RETURN (

		SELECT

			sum( `f`.`Unrestricted` ) AS `current_value`

		FROM

			`finishgoods` `f`

		WHERE

			( `f`.`salesDoc` LIKE '6%' )  

			and `f`.`tanggal` = tanggal and `f`.`produk_id` = produk_id

		) - fn_rts(tanggal, produk_id);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_cir` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_cir`(`tanggal` date,`produk_id` VARCHAR(10)) RETURNS int(11)
BEGIN

	#Routine body goes here...

	RETURN (

		SELECT

			sum( `f`.`Unrestricted` ) AS `current_value`

		FROM

			`finishgoods` `f`

		WHERE

			( `f`.`salesDoc` LIKE '4%' ) and

			`f`.`tanggal` = tanggal and `f`.`produk_id` = produk_id

		);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_fd_memodinas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_fd_memodinas`(`tanggal` date,`produk_id` VARCHAR(10)) RETURNS int(11)
BEGIN

	#Routine body goes here...

	RETURN (

		SELECT

			sum( `f`.`Unrestricted` ) AS `current_value`

		FROM

			(

			`finishgoods` `f`

			JOIN `rtscargos` `c` ON (

			(

			( `c`.`salesDoc` = `f`.`salesDoc` ) 

			AND ( `c`.`itemSD` = `f`.`itemSD` ) 

			AND ( `f`.`tanggal` = `c`.`dateload` ) 

			) 

			) 

			)  

		WHERE

			( `c`.`FinDocType` LIKE 'Z8%' )

			

			and `f`.`tanggal` = tanggal and `f`.`produk_id` = produk_id

			

		);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_full_pay` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_full_pay`(`tanggal` date,`produk_id` VARCHAR(10)) RETURNS int(11)
BEGIN

	#Routine body goes here...

	RETURN (

		SELECT

			sum( `f`.`Unrestricted` ) AS `current_value`

		FROM

			(

			`finishgoods` `f`

			JOIN `rtscargos` `c` ON (

			(

			( `c`.`salesDoc` = `f`.`salesDoc` ) 

			AND ( `c`.`itemSD` = `f`.`itemSD` ) 

			AND ( `f`.`tanggal` = `c`.`dateload` ) 

			) 

			) 

			) 

		WHERE

			(

			( NOT ( ( `c`.`FinDocType` LIKE 'Z8%' ) ) ) 

			AND ( ( `c`.`DelivBlockHeader` LIKE '11 Waiting For Full Pay%' ) OR ( `c`.`DelivBlockItem` LIKE '11 Waiting For Full Pay%' ) ) 

			) and `f`.`tanggal` = tanggal and `f`.`produk_id` = produk_id

			

		);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_hold` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_hold`(`tanggal` date,`produk_id` VARCHAR(10)) RETURNS int(11)
BEGIN

	#Routine body goes here...

	RETURN (

		SELECT

			sum( `f`.`Unrestricted` ) AS `current_value`

		FROM

			(

			`finishgoods` `f`

			JOIN `rtscargos` `c` ON (

			(

			( `c`.`salesDoc` = `f`.`salesDoc` ) 

			AND ( `c`.`itemSD` = `f`.`itemSD` ) 

			AND ( `f`.`tanggal` = `c`.`dateload` ) 

			) 

			) 

			) 

		WHERE

			( ( `f`.`WhStatus2` LIKE 'UP%' ) AND ( NOT ( ( `c`.`FinDocType` LIKE 'Z8%' ) ) ) )

			

			and `f`.`tanggal` = tanggal and `f`.`produk_id` = produk_id

			

		);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_im` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_im`(`tanggal` date,`produk_id` VARCHAR(10)) RETURNS int(11)
BEGIN

	#Routine body goes here...

	RETURN (

		SELECT

			sum( `f`.`Unrestricted` ) AS `current_value`

		FROM

			`finishgoods` `f`

		WHERE

		`f`.`salesDoc` = '' and  `f`.`WHStatus` = 'IM' and

			`f`.`tanggal` = tanggal and `f`.`produk_id` = produk_id

		);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_ip` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_ip`(`tanggal` date,`produk_id` VARCHAR(10)) RETURNS int(11)
BEGIN

	#Routine body goes here...

	RETURN (

		SELECT

			sum( `f`.`Unrestricted` ) AS `current_value`

		FROM

			`finishgoods` `f`

		WHERE

		`f`.`salesDoc` = '' and  `f`.`WHStatus` = 'IP' and

			`f`.`tanggal` = tanggal and `f`.`produk_id` = produk_id

		);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_is` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_is`(`tanggal` date,`produk_id` VARCHAR(10)) RETURNS int(11)
BEGIN

	#Routine body goes here...

	RETURN (

		SELECT

			sum( `f`.`Unrestricted` ) AS `current_value`

		FROM

			`finishgoods` `f`

		WHERE

		`f`.`salesDoc` = '' and  `f`.`WHStatus` = 'IS' and

			`f`.`tanggal` = tanggal and `f`.`produk_id` = produk_id

		);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_lcso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_lcso`(`tanggal` date,`produk_id` VARCHAR(10)) RETURNS int(11)
BEGIN

	#Routine body goes here...

	RETURN (

		SELECT

			sum( `f`.`Unrestricted` ) AS `current_value`

		FROM

			(

			`finishgoods` `f`

			JOIN `rtscargos` `c` ON (

			(

			( `c`.`salesDoc` = `f`.`salesDoc` ) 

			AND ( `c`.`itemSD` = `f`.`itemSD` ) 

			AND ( `f`.`tanggal` = `c`.`dateload` ) 

			) 

			) 

			) 

		WHERE

			(

			( ( `c`.`DelivBlockHeader` LIKE '%Z2 SO Expired%' ) OR ( `c`.`Remark` LIKE '%Expired L/C%' ) ) 

			AND ( NOT ( ( `c`.`FinDocType` LIKE 'Z8%' ) ) ) 

			) 

			

			and `f`.`tanggal` = tanggal and `f`.`produk_id` = produk_id

			

		);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_rts` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_rts`(`tanggal` date,`produk_id` VARCHAR(10)) RETURNS int(11)
BEGIN

	#Routine body goes here...

	RETURN (

		SELECT

			sum( `f`.`Unrestricted` ) AS `current_value`

		FROM

			(

			`finishgoods` `f`

			JOIN `rtscargos` `r` ON (

			(

			( `r`.`salesDoc` = `f`.`salesDoc` ) 

			AND ( `r`.`itemSD` = `f`.`itemSD` ) 

			AND ( `r`.`dateload` = `f`.`tanggal` ) 

			) 

			) 

			) 

		WHERE

			(

				-- ( `r`.`LSD` >= `f`.`tanggal` ) 

				`r`.`Remark` = ''

				AND ( NOT ( ( `r`.`FinDocType` LIKE 'Z8%' ) ) ) 

				AND ( trim( `r`.`DelivBlockHeader` ) = '' ) 

				AND ( trim( `r`.`DelivBlockItem` ) = '' ) 

				AND ( trim( `r`.`ReasonforRejection` ) = '' ) 

				AND (

			CASE

				`f`.`produk_id` 

				WHEN '1' THEN

				(

				( ( NOT ( ( `f`.`WhStatus2` LIKE 'K%' ) ) ) OR ( `f`.`WhStatus2` LIKE 'KB%' ) ) 

				AND ( NOT ( ( `f`.`WhStatus2` LIKE 'U%' ) ) ) 

				) 

				WHEN '2' THEN

				( ( NOT ( ( `f`.`WhStatus2` LIKE 'K%' ) ) ) AND ( NOT ( ( `f`.`WhStatus2` LIKE 'U%' ) ) ) ) 

				WHEN '3' THEN

				( ( NOT ( ( `f`.`WhStatus2` LIKE 'K%' ) ) ) AND ( NOT ( ( `f`.`WhStatus2` LIKE 'U%' ) ) ) ) ELSE NULL 

			END 

				) 

				) and

			`f`.`tanggal` = tanggal and `f`.`produk_id` = produk_id

		);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_stock_fg` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_stock_fg`(`tanggal` date,`produk_id` VARCHAR(10)) RETURNS int(11)
BEGIN

	#Routine body goes here...

	RETURN (

		SELECT

			sum( `f`.`Unrestricted` ) AS `current_value`

		FROM

			`finishgoods` `f`

		WHERE

			(`f`.`salesDoc` = '' or `f`.`salesDoc` like '4%') and 

			`f`.`tanggal` = tanggal and `f`.`produk_id` = produk_id

		);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `prformbrg` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `prformbrg`(IN bln INT, IN thn int)
BEGIN

		DROP TABLE IF EXISTS mytab;

		CREATE TABLE mytab (

		`D0` varchar(100) DEFAULT NULL,

		`B` varchar(100) DEFAULT NULL,

		`C` varchar(100) DEFAULT NULL,

		`D` varchar(100) DEFAULT NULL,

		`E` varchar(100) DEFAULT NULL,

		`F` varchar(100) DEFAULT NULL,

		`G` int(4) DEFAULT NULL,

		`H` int(4) DEFAULT NULL,

		`I` int(11) DEFAULT NULL

		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		

		DELETE FROM	mytab;

		INSERT INTO mytab

		select D as 'D0',  IF(D='X',1,2) as B, if (D<>'X', Rel,'') as C, if (D<>'X', RS, '') as D, if (D<>'X', S, '') as E, SUBSTR(PGr,1,2) as F,

			case WHEN (if (D<>'X', Rel,''))='2' then '1' WHEN (if (D<>'X', Rel,''))='y' then '5' WHEN (if (D<>'X', Rel,''))='x' then '5' else "0" end as G,

			case IF(D<>'X', RS, '') when "SP" then 1 when "MG" then 1 when "GM" then 1 when "DR" then 1 when "OE" then 6 else "0" end as H,

			case if (D<>'X', S, '') when "A" then 1 when "B" then 2 when "K" then 2 when "N" then 1 else "0" end as I

		from pr where MONTH(ReqDate)=bln and YEAR(ReqDate)=thn;

		

		DROP VIEW IF EXISTS v1;

		CREATE VIEW v1 AS

		select a.*, (a.G + a.H + a.I) as J,

				case (a.G + a.H + a.I) when 1 then 1 when 3 then 1 else 0 end as K,

				case (a.G + a.H + a.I) when 9 then 1 when 12 then 1 when 13 then 1 else 0 end as M,

				case (a.G + a.H + a.I) when 7 then 1 when 8 then 1 else 0 end as O,

				case (a.G + a.H + a.I) when 2 then 1 when 4 then 1 else 0 end as Q

		from mytab a;

		

		DROP VIEW IF EXISTS v2;

		CREATE VIEW v2 AS

		select *, IF (F="JP",K,0) as S, IF (F="JN",K,0) as T, IF (F="JP",M,0) as U, IF (F="JN",M,0) as V, IF (F="JP",O,0) as W,

		IF (F="JN",O,0) as X, IF (F="JP",Q,0) as Y, IF (F="JN",Q,0) as Z, IF (F="NO",K,0) as AA, IF (F="NR",K,0) as AB,

		IF (F="NO",M,0) as AC, IF (F="NR",M,0) as AD, IF (F="NO",O,0) as AE, IF (F="NR",O,0) as AF, IF (F="NO",Q,0) as AG, IF (F="NR",Q,0) as AH

		from v1;



		

		

		select 'PR Outstanding' as label, (SUM(AA) + SUM(AB)) as `value` from v2

		UNION

		select 'PR Proses OE' as label,  (SUM(AC) + SUM(AD)) as `value` from v2

		union 

		select 'PR Belum Release' as label,  (SUM(AE) + SUM(AF)) as `value` from v2

		UNION

		select 'PR Sudah PO' as label, (SUM(AG) + SUM(AH)) as `value` from v2;

		

		

		

		

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `prformjs` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `prformjs`(IN bln INT, IN thn int)
BEGIN

		DROP TABLE IF EXISTS mytab;

		CREATE TABLE mytab (

		`D0` varchar(100) DEFAULT NULL,

		`B` varchar(100) DEFAULT NULL,

		`C` varchar(100) DEFAULT NULL,

		`D` varchar(100) DEFAULT NULL,

		`E` varchar(100) DEFAULT NULL,

		`F` varchar(100) DEFAULT NULL,

		`G` int(4) DEFAULT NULL,

		`H` int(4) DEFAULT NULL,

		`I` int(11) DEFAULT NULL

		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		

		DELETE FROM	mytab;

		INSERT INTO mytab

		select D as 'D0',  IF(D='X',1,2) as B, if (D<>'X', Rel,'') as C, if (D<>'X', RS, '') as D, if (D<>'X', S, '') as E, SUBSTR(PGr,1,2) as F,

			case WHEN (if (D<>'X', Rel,''))='2' then '1' WHEN (if (D<>'X', Rel,''))='y' then '5' WHEN (if (D<>'X', Rel,''))='x' then '5' else "0" end as G,

			case IF(D<>'X', RS, '') when "SP" then 1 when "MG" then 1 when "GM" then 1 when "DR" then 1 when "OE" then 6 else "0" end as H,

			case if (D<>'X', S, '') when "A" then 1 when "B" then 2 when "K" then 2 when "N" then 1 else "0" end as I

		from pr where MONTH(ReqDate)=bln and YEAR(ReqDate)=thn;

		

		DROP VIEW IF EXISTS v1;

		CREATE VIEW v1 AS

		select a.*, (a.G + a.H + a.I) as J,

				case (a.G + a.H + a.I) when 1 then 1 when 3 then 1 else 0 end as K,

				case (a.G + a.H + a.I) when 9 then 1 when 12 then 1 when 13 then 1 else 0 end as M,

				case (a.G + a.H + a.I) when 7 then 1 when 8 then 1 else 0 end as O,

				case (a.G + a.H + a.I) when 2 then 1 when 4 then 1 else 0 end as Q

		from mytab a;

		

		DROP VIEW IF EXISTS v2;

		CREATE VIEW v2 AS

		select *, IF (F="JP",K,0) as S, IF (F="JN",K,0) as T, IF (F="JP",M,0) as U, IF (F="JN",M,0) as V, IF (F="JP",O,0) as W,

		IF (F="JN",O,0) as X, IF (F="JP",Q,0) as Y, IF (F="JN",Q,0) as Z, IF (F="NO",K,0) as AA, IF (F="NR",K,0) as AB,

		IF (F="NO",M,0) as AC, IF (F="NR",M,0) as AD, IF (F="NO",O,0) as AE, IF (F="NR",O,0) as AF, IF (F="NO",Q,0) as AG, IF (F="NR",Q,0) as AH

		from v1;



		

		

		select 'PR Outstanding' as label, (SUM(S) + SUM(T)) as `value` from v2

		UNION

		select 'PR Proses OE' as label,   (SUM(U) + SUM(V)) as `value` from v2

		union 

		select 'PR Belum Release' as label, (SUM(W) + SUM(X)) as `value` from v2

		UNION

		select 'PR Sudah PO' as label, (SUM(Y) + SUM(Z)) as `value` from v2;

		

		

		

		

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `prperiodeb` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `prperiodeb`(IN thn int)
BEGIN

		DROP TABLE IF EXISTS myperiod;

		CREATE TABLE myperiod (

		`D0` varchar(100) DEFAULT NULL,

		`B` varchar(100) DEFAULT NULL,

		`C` varchar(100) DEFAULT NULL,

		`D` varchar(100) DEFAULT NULL,

		`E` varchar(100) DEFAULT NULL,

		`F` varchar(100) DEFAULT NULL,

		`G` int(4) DEFAULT NULL,

		`H` int(4) DEFAULT NULL,

		`I` int(11) DEFAULT NULL

		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		

		DELETE FROM	myperiod;

		INSERT INTO myperiod

		select D as 'D0',  IF(D='X',1,2) as B, if (D<>'X', Rel,'') as C, if (D<>'X', RS, '') as D, if (D<>'X', S, '') as E, SUBSTR(PGr,1,2) as F,

			case WHEN (if (D<>'X', Rel,''))='2' then '1' WHEN (if (D<>'X', Rel,''))='y' then '5' WHEN (if (D<>'X', Rel,''))='x' then '5' else "0" end as G,

			case IF(D<>'X', RS, '') when "SP" then 1 when "MG" then 1 when "GM" then 1 when "DR" then 1 when "OE" then 6 else "0" end as H,

			case if (D<>'X', S, '') when "A" then 1 when "B" then 2 when "K" then 2 when "N" then 1 else "0" end as I

		from pr where YEAR(ReqDate)=thn;

		

		DROP VIEW IF EXISTS vp1;

		CREATE VIEW vp1 AS

		select a.*, (a.G + a.H + a.I) as J,

				case (a.G + a.H + a.I) when 1 then 1 when 3 then 1 else 0 end as K,

				case (a.G + a.H + a.I) when 9 then 1 when 12 then 1 when 13 then 1 else 0 end as M,

				case (a.G + a.H + a.I) when 7 then 1 when 8 then 1 else 0 end as O,

				case (a.G + a.H + a.I) when 2 then 1 when 4 then 1 else 0 end as Q

		from myperiod a;

		

		DROP VIEW IF EXISTS vp2;

		CREATE VIEW vp2 AS

		select *, IF (F="JP",K,0) as S, IF (F="JN",K,0) as T, IF (F="JP",M,0) as U, IF (F="JN",M,0) as V, IF (F="JP",O,0) as W,

		IF (F="JN",O,0) as X, IF (F="JP",Q,0) as Y, IF (F="JN",Q,0) as Z, IF (F="NO",K,0) as AA, IF (F="NR",K,0) as AB,

		IF (F="NO",M,0) as AC, IF (F="NR",M,0) as AD, IF (F="NO",O,0) as AE, IF (F="NR",O,0) as AF, IF (F="NO",Q,0) as AG, IF (F="NR",Q,0) as AH

		from vp1;



		

		

		select 'PR Outstanding' as label, (SUM(AA) + SUM(AB)) as `value` from vp2

		UNION

		select 'PR Proses OE' as label,  (SUM(AC) + SUM(AD)) as `value` from vp2

		union 

		select 'PR Belum Release' as label,  (SUM(AE) + SUM(AF)) as `value` from vp2

		UNION

		select 'PR Sudah PO' as label, (SUM(AG) + SUM(AH)) as `value` from vp2;

		

		

		

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `prperiodej` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `prperiodej`(IN thn int)
BEGIN

		DROP TABLE IF EXISTS myperiod;

		CREATE TABLE myperiod (

		`D0` varchar(100) DEFAULT NULL,

		`B` varchar(100) DEFAULT NULL,

		`C` varchar(100) DEFAULT NULL,

		`D` varchar(100) DEFAULT NULL,

		`E` varchar(100) DEFAULT NULL,

		`F` varchar(100) DEFAULT NULL,

		`G` int(4) DEFAULT NULL,

		`H` int(4) DEFAULT NULL,

		`I` int(11) DEFAULT NULL

		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		

		DELETE FROM	myperiod;

		INSERT INTO myperiod

		select D as 'D0',  IF(D='X',1,2) as B, if (D<>'X', Rel,'') as C, if (D<>'X', RS, '') as D, if (D<>'X', S, '') as E, SUBSTR(PGr,1,2) as F,

			case WHEN (if (D<>'X', Rel,''))='2' then '1' WHEN (if (D<>'X', Rel,''))='y' then '5' WHEN (if (D<>'X', Rel,''))='x' then '5' else "0" end as G,

			case IF(D<>'X', RS, '') when "SP" then 1 when "MG" then 1 when "GM" then 1 when "DR" then 1 when "OE" then 6 else "0" end as H,

			case if (D<>'X', S, '') when "A" then 1 when "B" then 2 when "K" then 2 when "N" then 1 else "0" end as I

		from pr where YEAR(ReqDate)=thn;

		

		DROP VIEW IF EXISTS vp1;

		CREATE VIEW vp1 AS

		select a.*, (a.G + a.H + a.I) as J,

				case (a.G + a.H + a.I) when 1 then 1 when 3 then 1 else 0 end as K,

				case (a.G + a.H + a.I) when 9 then 1 when 12 then 1 when 13 then 1 else 0 end as M,

				case (a.G + a.H + a.I) when 7 then 1 when 8 then 1 else 0 end as O,

				case (a.G + a.H + a.I) when 2 then 1 when 4 then 1 else 0 end as Q

		from myperiod a;

		

		DROP VIEW IF EXISTS vp2;

		CREATE VIEW vp2 AS

		select *, IF (F="JP",K,0) as S, IF (F="JN",K,0) as T, IF (F="JP",M,0) as U, IF (F="JN",M,0) as V, IF (F="JP",O,0) as W,

		IF (F="JN",O,0) as X, IF (F="JP",Q,0) as Y, IF (F="JN",Q,0) as Z, IF (F="NO",K,0) as AA, IF (F="NR",K,0) as AB,

		IF (F="NO",M,0) as AC, IF (F="NR",M,0) as AD, IF (F="NO",O,0) as AE, IF (F="NR",O,0) as AF, IF (F="NO",Q,0) as AG, IF (F="NR",Q,0) as AH

		from vp1;



		

		

		select 'PR Outstanding' as label,   (SUM(S) + SUM(T)) as `value` from vp2

		UNION

		select 'PR Proses OE' as label,    (SUM(U) + SUM(V)) as `value` from vp2

		union 

		select 'PR Belum Release' as label,   (SUM(W) + SUM(X)) as `value` from vp2

		UNION

		select 'PR Sudah PO' as label,  (SUM(Y) + SUM(Z)) as `value` from vp2;

		

		

		

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_rts_itemsd` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_rts_itemsd`(tgl date)
BEGIN

	SELECT

		itemSD

	FROM

		rtscargos

	WHERE

		salesDoc IS NOT NULL

	AND FinDocType NOT LIKE 'Z8'

	AND DelivBlockHeader IS NULL

	AND DelivBlockItem IS NULL

	AND ReasonforRejection IS NULL

	AND LSD > tgl;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_rts_salesdoc` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_rts_salesdoc`(tgl date)
BEGIN

	SELECT

		salesDoc

	FROM

		rtscargos

	WHERE

		salesDoc IS NOT NULL

	AND FinDocType NOT LIKE 'Z8'

	AND DelivBlockHeader IS NULL

	AND DelivBlockItem IS NULL

	AND ReasonforRejection IS NULL

	AND LSD > tgl;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `data_for_transfer_vd`
--

/*!50001 DROP VIEW IF EXISTS `data_for_transfer_vd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `data_for_transfer_vd` AS select `c`.`produk` AS `produk`,`a`.`produk_id` AS `produk_id`,`a`.`group` AS `group`,`a`.`tag_name` AS `tag_name`,`a`.`child1` AS `child1`,`a`.`child2` AS `child2`,`a`.`key` AS `key`,`b`.`value` AS `value`,date_format(`b`.`tanggal`,'%Y-%m-%d') AS `tanggal` from ((`kamus_data` `a` join `data_from_up` `b` on((`a`.`key` = `b`.`tag_name`))) join `produks` `c` on((`c`.`id` = `a`.`produk_id`))) where (isnull(`b`.`transfer`) and (`b`.`value` is not null)) order by `b`.`tanggal`,`a`.`produk_id`,`a`.`group` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `data_pl_vd`
--

/*!50001 DROP VIEW IF EXISTS `data_pl_vd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `data_pl_vd` AS select `kontribusi_margin`.`id` AS `id`,`kontribusi_margin`.`tanggal` AS `tanggal`,`kontribusi_margin`.`description` AS `description`,`kontribusi_margin`.`matrial` AS `matrial`,`kontribusi_margin`.`value_idr` AS `value_idr`,`kontribusi_margin`.`value_usd` AS `value_usd`,sum(`kontribusi_margin`.`value_idr`) AS `sum_value_idr`,sum(`kontribusi_margin`.`value_usd`) AS `sum_value_usd`,sum(`kontribusi_margin`.`sales_value_idr`) AS `sales_value_idr`,sum(`kontribusi_margin`.`sales_value_usd`) AS `sales_value_usd`,convert('HR' using utf8) AS `produk` from `kontribusi_margin` where (`kontribusi_margin`.`matrial` like 'H%') group by `kontribusi_margin`.`tanggal` union select `kontribusi_margin`.`id` AS `id`,`kontribusi_margin`.`tanggal` AS `tanggal`,`kontribusi_margin`.`description` AS `description`,`kontribusi_margin`.`matrial` AS `matrial`,`kontribusi_margin`.`value_idr` AS `value_idr`,`kontribusi_margin`.`value_usd` AS `value_usd`,sum(`kontribusi_margin`.`value_idr`) AS `sum_value_idr`,sum(`kontribusi_margin`.`value_usd`) AS `sum_value_usd`,sum(`kontribusi_margin`.`sales_value_idr`) AS `sales_value_idr`,sum(`kontribusi_margin`.`sales_value_usd`) AS `sales_value_usd`,convert('PO' using utf8) AS `produk` from `kontribusi_margin` where (`kontribusi_margin`.`matrial` like 'P%') group by `kontribusi_margin`.`tanggal` union select `kontribusi_margin`.`id` AS `id`,`kontribusi_margin`.`tanggal` AS `tanggal`,`kontribusi_margin`.`description` AS `description`,`kontribusi_margin`.`matrial` AS `matrial`,`kontribusi_margin`.`value_idr` AS `value_idr`,`kontribusi_margin`.`value_usd` AS `value_usd`,sum(`kontribusi_margin`.`value_idr`) AS `sum_value_idr`,sum(`kontribusi_margin`.`value_usd`) AS `sum_value_usd`,sum(`kontribusi_margin`.`sales_value_idr`) AS `sales_value_idr`,sum(`kontribusi_margin`.`sales_value_usd`) AS `sales_value_usd`,convert('CR' using utf8) AS `produk` from `kontribusi_margin` where ((`kontribusi_margin`.`matrial` like 'C%') or (`kontribusi_margin`.`matrial` like 'F%')) group by `kontribusi_margin`.`tanggal` union select `kontribusi_margin`.`id` AS `id`,`kontribusi_margin`.`tanggal` AS `tanggal`,`kontribusi_margin`.`description` AS `description`,`kontribusi_margin`.`matrial` AS `matrial`,`kontribusi_margin`.`value_idr` AS `value_idr`,`kontribusi_margin`.`value_usd` AS `value_usd`,sum(`kontribusi_margin`.`value_idr`) AS `sum_value_idr`,sum(`kontribusi_margin`.`value_usd`) AS `sum_value_usd`,sum(`kontribusi_margin`.`sales_value_idr`) AS `sales_value_idr`,sum(`kontribusi_margin`.`sales_value_usd`) AS `sales_value_usd`,convert('WR' using utf8) AS `produk` from `kontribusi_margin` where ((`kontribusi_margin`.`matrial` like 'W%') or (`kontribusi_margin`.`matrial` like 'WR%')) group by `kontribusi_margin`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `data_total_vd`
--

/*!50001 DROP VIEW IF EXISTS `data_total_vd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `data_total_vd` AS select `datas`.`produk_id` AS `produk_id`,`datas`.`tanggal` AS `tanggal`,`datas`.`group` AS `group`,`datas`.`tag_name` AS `tag_name`,`datas`.`child1` AS `child1`,`datas`.`child2` AS `child2`,sum(`datas`.`current_value`) AS `current_value` from `datas` where ((`datas`.`group` = 3) and (`datas`.`tanggal` between if((date_format(now(),'%Y-%m-%d') = date_format(now(),'%Y-%m-01')),(date_format(now(),'%Y-%m-01') - interval 1 month),date_format(now(),'%Y-%m-01')) and (date_format(now(),'%Y-%m-%d') - interval 1 day))) group by `datas`.`produk_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `datas_new_vd`
--

/*!50001 DROP VIEW IF EXISTS `datas_new_vd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `datas_new_vd` AS select `a`.`tanggal` AS `tanggal`,`a`.`tag_name` AS `tag_name`,`a`.`value` AS `value`,`a`.`transfer` AS `transfer`,`b`.`child2` AS `label` from (`data_from_up` `a` join `kamus_data` `b` on((`a`.`tag_name` = `b`.`key`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `datas_vd`
--

/*!50001 DROP VIEW IF EXISTS `datas_vd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `datas_vd` AS select `datas`.`tanggal` AS `tanggal`,`datas`.`produk_id` AS `produk_id`,`datas`.`group` AS `group`,`datas`.`tag_name` AS `tag_name`,sum(`datas`.`current_value`) AS `sum` from `datas` group by `datas`.`group`,`datas`.`produk_id`,`datas`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `finishgoodv01`
--

/*!50001 DROP VIEW IF EXISTS `finishgoodv01`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `finishgoodv01` AS select `finishgoods`.`produk_id` AS `produk_id`,`finishgoods`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'CIR' AS `child1`,'CIR' AS `child2`,sum(`finishgoods`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from `finishgoods` where ((`finishgoods`.`produk_id` = '1') and (`finishgoods`.`salesDoc` like '4%')) union select `finishgoods`.`produk_id` AS `produk_id`,`finishgoods`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'CIR' AS `child1`,'CIR' AS `child2`,sum(`finishgoods`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from `finishgoods` where isnull(`finishgoods`.`salesDoc`) union select `finishgoods`.`produk_id` AS `produk_id`,`finishgoods`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'CIR' AS `child1`,'IM' AS `child2`,sum(`finishgoods`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from `finishgoods` where (isnull(`finishgoods`.`salesDoc`) and (`finishgoods`.`WHStatus` = 'IM')) union select `finishgoods`.`produk_id` AS `produk_id`,`finishgoods`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'CIR' AS `child1`,'IP' AS `child2`,sum(`finishgoods`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from `finishgoods` where (isnull(`finishgoods`.`salesDoc`) and (`finishgoods`.`WHStatus` = 'IP')) union select `finishgoods`.`produk_id` AS `produk_id`,`finishgoods`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'CIR' AS `child1`,'IS' AS `child2`,sum(`finishgoods`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from `finishgoods` where (isnull(`finishgoods`.`salesDoc`) and (`finishgoods`.`WHStatus` = 'IS')) group by `finishgoods`.`produk_id`,`finishgoods`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stock_child1_vd`
--

/*!50001 DROP VIEW IF EXISTS `stock_child1_vd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `stock_child1_vd` AS select `datas`.`produk_id` AS `produk_id`,`datas`.`tanggal` AS `tanggal`,`datas`.`group` AS `group`,`datas`.`tag_name` AS `tag_name`,`datas`.`child1` AS `child1`,`datas`.`child2` AS `child2`,`datas`.`current_value` AS `current_value`,`datas`.`average_value` AS `average_value`,`datas`.`akumulasi` AS `akumulasi`,sum(`datas`.`current_value`) AS `sum` from `datas` where ((`datas`.`group` = '5') and (`datas`.`tag_name` <> `datas`.`child1`)) group by `datas`.`child1`,`datas`.`tanggal`,`datas`.`produk_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stock_free_vd`
--

/*!50001 DROP VIEW IF EXISTS `stock_free_vd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `stock_free_vd` AS select `datas`.`produk_id` AS `produk_id`,`datas`.`tanggal` AS `tanggal`,`datas`.`group` AS `group`,`datas`.`tag_name` AS `tag_name`,`datas`.`child1` AS `child1`,`datas`.`child2` AS `child2`,`datas`.`current_value` AS `current_value`,`datas`.`average_value` AS `average_value`,`datas`.`akumulasi` AS `akumulasi`,sum(`datas`.`current_value`) AS `sum` from `datas` where ((`datas`.`group` = '5') and (`datas`.`child1` = 'Free Stock') and (`datas`.`tag_name` <> `datas`.`child1`)) group by `datas`.`child1`,`datas`.`child2`,`datas`.`tanggal`,`datas`.`produk_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v1`
--

/*!50001 DROP VIEW IF EXISTS `v1`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v1` AS select `a`.`D0` AS `D0`,`a`.`B` AS `B`,`a`.`C` AS `C`,`a`.`D` AS `D`,`a`.`E` AS `E`,`a`.`F` AS `F`,`a`.`G` AS `G`,`a`.`H` AS `H`,`a`.`I` AS `I`,((`a`.`G` + `a`.`H`) + `a`.`I`) AS `J`,(case ((`a`.`G` + `a`.`H`) + `a`.`I`) when 1 then 1 when 3 then 1 else 0 end) AS `K`,(case ((`a`.`G` + `a`.`H`) + `a`.`I`) when 9 then 1 when 12 then 1 when 13 then 1 else 0 end) AS `M`,(case ((`a`.`G` + `a`.`H`) + `a`.`I`) when 7 then 1 when 8 then 1 else 0 end) AS `O`,(case ((`a`.`G` + `a`.`H`) + `a`.`I`) when 2 then 1 when 4 then 1 else 0 end) AS `Q` from `mytab` `a` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v2`
--

/*!50001 DROP VIEW IF EXISTS `v2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v2` AS select `v1`.`D0` AS `D0`,`v1`.`B` AS `B`,`v1`.`C` AS `C`,`v1`.`D` AS `D`,`v1`.`E` AS `E`,`v1`.`F` AS `F`,`v1`.`G` AS `G`,`v1`.`H` AS `H`,`v1`.`I` AS `I`,`v1`.`J` AS `J`,`v1`.`K` AS `K`,`v1`.`M` AS `M`,`v1`.`O` AS `O`,`v1`.`Q` AS `Q`,if((`v1`.`F` = 'JP'),`v1`.`K`,0) AS `S`,if((`v1`.`F` = 'JN'),`v1`.`K`,0) AS `T`,if((`v1`.`F` = 'JP'),`v1`.`M`,0) AS `U`,if((`v1`.`F` = 'JN'),`v1`.`M`,0) AS `V`,if((`v1`.`F` = 'JP'),`v1`.`O`,0) AS `W`,if((`v1`.`F` = 'JN'),`v1`.`O`,0) AS `X`,if((`v1`.`F` = 'JP'),`v1`.`Q`,0) AS `Y`,if((`v1`.`F` = 'JN'),`v1`.`Q`,0) AS `Z`,if((`v1`.`F` = 'NO'),`v1`.`K`,0) AS `AA`,if((`v1`.`F` = 'NR'),`v1`.`K`,0) AS `AB`,if((`v1`.`F` = 'NO'),`v1`.`M`,0) AS `AC`,if((`v1`.`F` = 'NR'),`v1`.`M`,0) AS `AD`,if((`v1`.`F` = 'NO'),`v1`.`O`,0) AS `AE`,if((`v1`.`F` = 'NR'),`v1`.`O`,0) AS `AF`,if((`v1`.`F` = 'NO'),`v1`.`Q`,0) AS `AG`,if((`v1`.`F` = 'NR'),`v1`.`Q`,0) AS `AH` from `v1` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_cargo`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_cargo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_cargo` AS select `f`.`produk_id` AS `produk_id`,`f`.`tanggal` AS `tanggal`,5 AS `group`,'Cargo' AS `tag_name`,sum(`f`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from `finishgoods` `f` where (`f`.`salesDoc` like '6%') group by `f`.`produk_id`,`f`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_rts`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_rts`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_rts` AS select `f`.`produk_id` AS `produk_id`,`f`.`tanggal` AS `tanggal`,5 AS `group`,'RTS' AS `tag_name`,sum(`f`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from (`finishgoods` `f` join `rtscargos` `r` on(((`r`.`salesDoc` = `f`.`salesDoc`) and (`r`.`itemSD` = `f`.`itemSD`) and (`r`.`dateload` = `f`.`tanggal`)))) where ((`r`.`LSD` >= `f`.`tanggal`) and (not((`r`.`FinDocType` like 'Z8%'))) and (trim(`r`.`DelivBlockHeader`) = '') and (trim(`r`.`DelivBlockItem`) = '') and (trim(`r`.`ReasonforRejection`) = '') and (case `f`.`produk_id` when '1' then (((not((`f`.`WhStatus2` like 'K%'))) or (`f`.`WhStatus2` like 'KB%')) and (not((`f`.`WhStatus2` like 'U%')))) when '2' then ((not((`f`.`WhStatus2` like 'K%'))) and (not((`f`.`WhStatus2` like 'U%')))) when '3' then ((not((`f`.`WhStatus2` like 'K%'))) and (not((`f`.`WhStatus2` like 'U%')))) else NULL end)) group by `f`.`produk_id`,`f`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_sfg_cir`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_cir`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_sfg_cir` AS select `finishgoods`.`produk_id` AS `produk_id`,`finishgoods`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'CIR' AS `child1`,'CIR' AS `child2`,sum(`finishgoods`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from `finishgoods` where (`finishgoods`.`salesDoc` like '4%') group by `finishgoods`.`produk_id`,`finishgoods`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_sfg_fd_hold`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_hold`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_sfg_fd_hold` AS select `f`.`produk_id` AS `produk_id`,`f`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'Cargo' AS `child1`,'Hold' AS `child2`,sum(`f`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from (`finishgoods` `f` join `rtscargos` `c` on(((`c`.`salesDoc` = `f`.`salesDoc`) and (`c`.`itemSD` = `f`.`itemSD`) and (`f`.`tanggal` = `c`.`dateload`)))) where ((`f`.`WhStatus2` like 'UP%') and (not((`c`.`FinDocType` like 'Z8%')))) group by `f`.`produk_id`,`f`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_sfg_fd_lcso`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_lcso`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_sfg_fd_lcso` AS select `f`.`produk_id` AS `produk_id`,`f`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'Cargo' AS `child1`,'LC/SO Expired' AS `child2`,sum(`f`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from (`finishgoods` `f` join `rtscargos` `c` on(((`c`.`salesDoc` = `f`.`salesDoc`) and (`c`.`itemSD` = `f`.`itemSD`) and (`f`.`tanggal` = `c`.`dateload`)))) where (((`c`.`DelivBlockHeader` like '%Z2 SO Expired%') or (`c`.`Remark` like '%Expired L/C%')) and (not((`c`.`FinDocType` like 'Z8%')))) group by `f`.`produk_id`,`f`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_sfg_fd_memodinas`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_memodinas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_sfg_fd_memodinas` AS select `f`.`produk_id` AS `produk_id`,`f`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'Cargo' AS `child1`,'FD Memo Dinas' AS `child2`,sum(`f`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from (`finishgoods` `f` join `rtscargos` `c` on(((`c`.`salesDoc` = `f`.`salesDoc`) and (`c`.`itemSD` = `f`.`itemSD`) and (`f`.`tanggal` = `c`.`dateload`)))) where (`c`.`FinDocType` like 'Z8%') group by `f`.`produk_id`,`f`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_sfg_fd_over_leeway`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_over_leeway`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_sfg_fd_over_leeway` AS select `f`.`produk_id` AS `produk_id`,`f`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'Cargo' AS `child1`,'Over Leeway' AS `child2`,sum(`f`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from (`finishgoods` `f` join `rtscargos` `c` on(((`c`.`salesDoc` = `f`.`salesDoc`) and (`c`.`itemSD` = `f`.`itemSD`)))) where (`f`.`WhStatus2` regexp 'UL|UU|UO') group by `f`.`produk_id`,`f`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_sfg_fd_rts`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_rts`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_sfg_fd_rts` AS select `f`.`produk_id` AS `produk_id`,`f`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'RTS' AS `child1`,'RTS' AS `child2`,sum(`f`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from (`finishgoods` `f` join `rtscargos` `r` on(((`r`.`salesDoc` = `f`.`salesDoc`) and (`r`.`itemSD` = `f`.`itemSD`) and (`r`.`dateload` = `f`.`tanggal`)))) where ((`r`.`LSD` >= `f`.`tanggal`) and (not((`r`.`FinDocType` like 'Z8%'))) and (trim(`r`.`DelivBlockHeader`) = '') and (trim(`r`.`DelivBlockItem`) = '') and (trim(`r`.`ReasonforRejection`) = '') and (case `f`.`produk_id` when '1' then (((not((`f`.`WhStatus2` like 'K%'))) or (`f`.`WhStatus2` like 'KB%')) and (not((`f`.`WhStatus2` like 'U%')))) when '2' then ((not((`f`.`WhStatus2` like 'K%'))) and (not((`f`.`WhStatus2` like 'U%')))) when '3' then ((not((`f`.`WhStatus2` like 'K%'))) and (not((`f`.`WhStatus2` like 'U%')))) else NULL end)) group by `f`.`produk_id`,`f`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_sfg_fd_rts_other`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_rts_other`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_sfg_fd_rts_other` AS select `a`.`produk_id` AS `produk_id`,`a`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'Cargo' AS `child1`,'Other' AS `child2`,sum(`a`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from (`finishgoods` `a` join `rtscargos` `b` on(((`a`.`salesDoc` = `b`.`salesDoc`) and (`a`.`itemSD` = `b`.`itemSD`) and (`a`.`tanggal` = `b`.`dateload`)))) where ((not((`b`.`DelivBlockItem` regexp '16 Customer Request|18 Holiday Season|14 Ship-to addr discrep|Z2 SO  Expired|11 Waiting For Full Pay'))) or (not((`b`.`DelivBlockHeader` regexp '16 Customer Request|18 Holiday Season|14 Ship-to addr discrep|Z2 SO  Expired|11 Waiting For Full Pay'))) or (`b`.`ReasonforRejection` <> '') or (not((`b`.`FinDocType` like 'Z8%')))) group by `a`.`produk_id`,`a`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_sfg_fd_waiting_for_full_pay`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_fd_waiting_for_full_pay`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_sfg_fd_waiting_for_full_pay` AS select `f`.`produk_id` AS `produk_id`,`f`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'Cargo' AS `child1`,'Waiting For Full Pay' AS `child2`,sum(`f`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from (`finishgoods` `f` join `rtscargos` `c` on(((`c`.`salesDoc` = `f`.`salesDoc`) and (`c`.`itemSD` = `f`.`itemSD`) and (`f`.`tanggal` = `c`.`dateload`)))) where ((not((`c`.`FinDocType` like 'Z8%'))) and ((`c`.`DelivBlockHeader` like '11 Waiting For Full Pay%') or (`c`.`DelivBlockItem` like '11 Waiting For Full Pay%'))) group by `f`.`produk_id`,`f`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_sfg_freestok`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_freestok`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_sfg_freestok` AS select `finishgoods`.`produk_id` AS `produk_id`,`finishgoods`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'Free Stock' AS `child1`,'Free Stock' AS `child2`,sum(`finishgoods`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from `finishgoods` where ((`finishgoods`.`salesDoc` = '') and (`finishgoods`.`WHStatus` in ('IM','IS','IP'))) group by `finishgoods`.`produk_id`,`finishgoods`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_sfg_imipis`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_sfg_imipis`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_sfg_imipis` AS select `finishgoods`.`produk_id` AS `produk_id`,`finishgoods`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,'Free Stock' AS `child1`,`finishgoods`.`WHStatus` AS `child2`,sum(`finishgoods`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from `finishgoods` where ((`finishgoods`.`salesDoc` = '') and (`finishgoods`.`WHStatus` in ('IM','IS','IP'))) group by `finishgoods`.`produk_id`,`finishgoods`.`tanggal`,`finishgoods`.`WHStatus` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_backup_stock_fg`
--

/*!50001 DROP VIEW IF EXISTS `v_backup_stock_fg`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_backup_stock_fg` AS select `f`.`produk_id` AS `produk_id`,`f`.`tanggal` AS `tanggal`,5 AS `group`,'Stock FG' AS `tag_name`,sum(`f`.`Unrestricted`) AS `current_value`,0 AS `average_value`,0 AS `akumulasi` from `finishgoods` `f` group by `f`.`produk_id`,`f`.`tanggal` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_gr`
--

/*!50001 DROP VIEW IF EXISTS `v_gr`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_gr` AS select `gr`.`PstngDate` AS `PstngDate`,(case when (left(`gr`.`Material`,2) = '') then 'JA' else left(`gr`.`Material`,2) end) AS `kate`,`gr`.`AmountinLC` AS `Amountinlc`,left(`gr`.`PO`,2) AS `PO`,(case when (left(`gr`.`Material`,2) in ('SI','SE','SM')) then 'SPARE PART' when (left(`gr`.`Material`,2) in ('SS','OA','OG','OK','OL','OO','OE','DR','TT','HR','OR','RA','BS')) then 'NSC' when (left(`gr`.`Material`,2) = '') then 'SERVICE' end) AS `jenis`,left(`gr`.`Description`,8) AS `deskripsi`,left(`gr`.`Material`,4) AS `tipe` from `gr` where (left(`gr`.`Material`,2) in ('','SS','OA','OG','OK','OL','OO','OE','DR','TT','HR','OR','RA','BS','SI','SE','SM')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prod_last`
--

/*!50001 DROP VIEW IF EXISTS `v_prod_last`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_prod_last` AS select `t`.`BEREICH` AS `BEREICH`,`t`.`ANLAGE` AS `ANLAGE`,`t`.`LAST_PROD` AS `LAST_PROD`,timestampdiff(MINUTE,`t`.`LAST_PROD`,date_format(now(),'%Y-%m-%d %H:%i:%s')) AS `DIFF`,concat(timestampdiff(DAY,`t`.`LAST_PROD`,date_format(now(),'%Y-%m-%d %H:%i:%s')),'d ',(timestampdiff(HOUR,`t`.`LAST_PROD`,date_format(now(),'%Y-%m-%d %H:%i:%s')) % 24),'h ',(timestampdiff(MINUTE,`t`.`LAST_PROD`,date_format(now(),'%Y-%m-%d %H:%i:%s')) % 60),'m ') AS `DIFF_VALUE`,(`t`.`GEWINPUT` / 1000) AS `GEWINPUT`,(`t`.`GEWOUTPUT` / 1000) AS `GEWOUTPUT`,(`t`.`SCRAPWEIGHT` / 1000) AS `SCRAPWEIGHT`,(`t`.`GEWINPUT_TOTAL` / 1000) AS `GEWINPUT_TOTAL`,(`t`.`GEWOUTPUT_TOTAL` / 1000) AS `GEWOUTPUT_TOTAL`,(`t`.`SCRAPWEIGHT_TOTAL` / 1000) AS `SCRAPWEIGHT_TOTAL` from (`v_prod_last1` `r` join `prod_last` `t` on(((`t`.`BEREICH` = `r`.`BEREICH`) and (`t`.`ANLAGE` = `r`.`ANLAGE`) and (`t`.`LAST_PROD` = `r`.`LAST_PROD`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prod_last1`
--

/*!50001 DROP VIEW IF EXISTS `v_prod_last1`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_prod_last1` AS select `t`.`BEREICH` AS `BEREICH`,`t`.`ANLAGE` AS `ANLAGE`,max(`t`.`LAST_PROD`) AS `LAST_PROD` from `prod_last` `t` group by `t`.`BEREICH`,`t`.`ANLAGE` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vncs`
--

/*!50001 DROP VIEW IF EXISTS `vncs`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vncs` AS select 'SCRAP' AS `label`,ifnull(sum(`po`.`TotalPrice`),0) AS `value` from `po` where ((substr(`po`.`Material`,1,4) = 'RASC') and (`po`.`POgrp` = 'NSKS')) union select 'SLAB' AS `Jenis`,ifnull(sum(`po`.`TotalPrice`),0) AS `value` from `po` where ((substr(`po`.`Material`,1,2) = 'SS') and (`po`.`POgrp` = 'NSKS')) union select 'BILET' AS `Jenis`,ifnull(sum(`po`.`TotalPrice`),0) AS `IFNULL(SUM(TotalPrice),0)` from `po` where ((substr(`po`.`Material`,1,2) = 'BS') and (`po`.`POgrp` = 'NSKS')) union select 'REFRACT' AS `Jenis`,ifnull(sum(`po`.`TotalPrice`),0) AS `IFNULL(SUM(TotalPrice),0)` from `po` where ((substr(`po`.`Material`,1,2) = 'OR') and (`po`.`POgrp` = 'NSKS')) union select 'ROLL' AS `Jenis`,ifnull(sum(`po`.`TotalPrice`),0) AS `IFNULL(SUM(TotalPrice),0)` from `po` where (((substr(`po`.`Material`,1,4) = 'OAWR') or (substr(`po`.`Material`,1,4) = 'OABU')) and (`po`.`POgrp` = 'NSKS')) union select 'GRAPHITE ELECTRODE' AS `Jenis`,ifnull(sum(`po`.`TotalPrice`),0) AS `IFNULL(SUM(TotalPrice),0)` from `po` where ((substr(`po`.`Material`,1,2) = 'OE') and (`po`.`POgrp` = 'NSKS')) union select 'SPONGE SRK' AS `Jenis`,ifnull(sum(`po`.`TotalPrice`),0) AS `IFNULL(SUM(TotalPrice),0)` from `po` where ((substr(`po`.`Material`,1,2) = 'DR') and (`po`.`POgrp` = 'NSKS')) union select 'LAIN LAIN' AS `Jenis`,ifnull(sum(`po`.`TotalPrice`),0) AS `IFNULL(SUM(TotalPrice),0)` from `po` where ((substr(`po`.`Material`,1,4) <> 'RASC') and (substr(`po`.`Material`,1,2) <> 'SS') and (substr(`po`.`Material`,1,2) <> 'BS') and (substr(`po`.`Material`,1,2) <> 'OR') and (substr(`po`.`Material`,1,4) <> 'OAWR') and (substr(`po`.`Material`,1,4) <> 'OABU') and (substr(`po`.`Material`,1,2) <> 'OE') and (substr(`po`.`Material`,1,2) <> 'DR') and (`po`.`POgrp` = 'NSKS')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vp1`
--

/*!50001 DROP VIEW IF EXISTS `vp1`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vp1` AS select `a`.`D0` AS `D0`,`a`.`B` AS `B`,`a`.`C` AS `C`,`a`.`D` AS `D`,`a`.`E` AS `E`,`a`.`F` AS `F`,`a`.`G` AS `G`,`a`.`H` AS `H`,`a`.`I` AS `I`,((`a`.`G` + `a`.`H`) + `a`.`I`) AS `J`,(case ((`a`.`G` + `a`.`H`) + `a`.`I`) when 1 then 1 when 3 then 1 else 0 end) AS `K`,(case ((`a`.`G` + `a`.`H`) + `a`.`I`) when 9 then 1 when 12 then 1 when 13 then 1 else 0 end) AS `M`,(case ((`a`.`G` + `a`.`H`) + `a`.`I`) when 7 then 1 when 8 then 1 else 0 end) AS `O`,(case ((`a`.`G` + `a`.`H`) + `a`.`I`) when 2 then 1 when 4 then 1 else 0 end) AS `Q` from `myperiod` `a` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vp2`
--

/*!50001 DROP VIEW IF EXISTS `vp2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vp2` AS select `vp1`.`D0` AS `D0`,`vp1`.`B` AS `B`,`vp1`.`C` AS `C`,`vp1`.`D` AS `D`,`vp1`.`E` AS `E`,`vp1`.`F` AS `F`,`vp1`.`G` AS `G`,`vp1`.`H` AS `H`,`vp1`.`I` AS `I`,`vp1`.`J` AS `J`,`vp1`.`K` AS `K`,`vp1`.`M` AS `M`,`vp1`.`O` AS `O`,`vp1`.`Q` AS `Q`,if((`vp1`.`F` = 'JP'),`vp1`.`K`,0) AS `S`,if((`vp1`.`F` = 'JN'),`vp1`.`K`,0) AS `T`,if((`vp1`.`F` = 'JP'),`vp1`.`M`,0) AS `U`,if((`vp1`.`F` = 'JN'),`vp1`.`M`,0) AS `V`,if((`vp1`.`F` = 'JP'),`vp1`.`O`,0) AS `W`,if((`vp1`.`F` = 'JN'),`vp1`.`O`,0) AS `X`,if((`vp1`.`F` = 'JP'),`vp1`.`Q`,0) AS `Y`,if((`vp1`.`F` = 'JN'),`vp1`.`Q`,0) AS `Z`,if((`vp1`.`F` = 'NO'),`vp1`.`K`,0) AS `AA`,if((`vp1`.`F` = 'NR'),`vp1`.`K`,0) AS `AB`,if((`vp1`.`F` = 'NO'),`vp1`.`M`,0) AS `AC`,if((`vp1`.`F` = 'NR'),`vp1`.`M`,0) AS `AD`,if((`vp1`.`F` = 'NO'),`vp1`.`O`,0) AS `AE`,if((`vp1`.`F` = 'NR'),`vp1`.`O`,0) AS `AF`,if((`vp1`.`F` = 'NO'),`vp1`.`Q`,0) AS `AG`,if((`vp1`.`F` = 'NR'),`vp1`.`Q`,0) AS `AH` from `vp1` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `wip_child1_vd`
--

/*!50001 DROP VIEW IF EXISTS `wip_child1_vd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `wip_child1_vd` AS select `datas`.`produk_id` AS `produk_id`,`datas`.`tanggal` AS `tanggal`,`datas`.`group` AS `group`,`datas`.`tag_name` AS `tag_name`,`datas`.`child1` AS `child1`,`datas`.`child2` AS `child2`,`datas`.`current_value` AS `current_value`,`datas`.`average_value` AS `average_value`,`datas`.`akumulasi` AS `akumulasi`,sum(`datas`.`current_value`) AS `sum` from `datas` where ((`datas`.`group` = '6') and (`datas`.`tag_name` <> `datas`.`child1`)) group by `datas`.`child1`,`datas`.`tanggal`,`datas`.`produk_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `wip_child2_vd`
--

/*!50001 DROP VIEW IF EXISTS `wip_child2_vd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `wip_child2_vd` AS select `datas`.`produk_id` AS `produk_id`,`datas`.`tanggal` AS `tanggal`,`datas`.`group` AS `group`,`datas`.`tag_name` AS `tag_name`,`datas`.`child1` AS `child1`,`datas`.`child2` AS `child2`,`datas`.`current_value` AS `current_value`,`datas`.`average_value` AS `average_value`,`datas`.`akumulasi` AS `akumulasi`,sum(`datas`.`current_value`) AS `sum` from `datas` where ((`datas`.`group` = '6') and (`datas`.`tag_name` = `datas`.`child1`)) group by `datas`.`child1`,`datas`.`child2`,`datas`.`tanggal`,`datas`.`produk_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-20  3:58:58
