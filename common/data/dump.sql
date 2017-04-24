-- MySQL dump 10.16  Distrib 10.1.19-MariaDB, for Linux (x86_64)
--
-- Host: 192.168.33.30    Database: 192.168.33.30
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

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
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('主办方','2',1443412711),('参展商','3',1446535597),('发票员','4',1447494414),('工作人员','5',1447830469),('数据统计','6',1488336145),('系统管理员','1',1443189008),('门禁人员','7',1470294673);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('展会管理','/exhibition/exhibition/create'),('展会管理','/exhibition/exhibition/index'),('人员管理','/member/worker/create'),('人员管理','/member/worker/index'),('观众管理','/mod/audience/index'),('营销管理','/mod/business-opp/discount'),('营销管理','/mod/business-opp/index'),('营销管理','/mod/business-opp/product'),('推广管理','/mod/channel-track/index'),('展商管理','/mod/default/create-joiner'),('展商管理','/mod/default/joiner-list'),('页面设计','/mod/vimanage/index'),('推广管理','/mod/wechat-promotion/index'),('数据管理','/report/pkdata/entrance'),('数据管理','/report/pkdata/ticket-report'),('数据管理','/report/pkdata/ticket-tree'),('票证管理','/ticketout/batch-send/index'),('票证管理','/ticketout/certificate-type/index'),('票证管理','/ticketout/send-ticket/checkticket'),('票证管理','/ticketout/send-ticket/find-ticket'),('票证管理','/ticketout/send-ticket/genticket'),('票证管理','/ticketout/send-ticket/index'),('票证管理','/ticketout/send-ticket/set-sale'),('票证管理','/ticketout/send-ticket/set-ticket-page'),('票证管理','/ticketout/sms/index'),('票证管理','/ticketout/ticket-channel/index'),('系统管理员','主办方'),('主办方','人员管理'),('主办方','参展商'),('主办方','展会管理'),('主办方','工作人员'),('主办方','推广管理'),('主办方','数据管理'),('参展商','数据管理'),('工作人员','数据管理'),('数据统计','数据管理'),('参展商','票证管理'),('发票员','票证管理'),('工作人员','票证管理'),('参展商','营销管理'),('工作人员','营销管理'),('参展商','观众管理'),('工作人员','观众管理'),('主办方','页面设计');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) DEFAULT '0',
  `route` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'展会管理',NULL,'',1,'','&#xe6be;'),(2,'票证管理',NULL,'',2,'','&#xe6bc;'),(3,'观众管理',NULL,'/mod/audience/index',3,'','&#xe6bb;'),(4,'人员管理',NULL,'',4,'','&#xe6c0;'),(5,'展商管理',NULL,'',5,'','&#xe6ba;'),(6,'数据管理',NULL,'',6,'','&#xe6c7;'),(7,'营销管理',NULL,'',7,'','&#xe6c1;'),(8,'推广管理',NULL,'',8,'','&#xe6bf;'),(9,'页面设计',NULL,'/mod/vimanage/index',9,'','&#xe6c3;'),(10,'展会列表',1,'/exhibition/exhibition/index',3,'',''),(11,'添加展会',1,'/exhibition/exhibition/create',5,'',''),(12,'工作人员列表',4,'/member/worker/index',1,'','&#xe6c0;'),(13,'添加工作人员',4,'/member/worker/create',4,'','&#xe6c0;'),(14,'展商列表',5,'/mod/default/joiner-list',1,'','&#xe6ba;'),(15,'添加展商',5,'/mod/default/create-joiner',5,'','&#xe6ba;'),(16,'数据图表',6,'/report/pkdata/entrance',1,'','&#xe6c7;'),(17,'票证统计',6,'/report/pkdata/ticket-report',1,'','&#xe6c7;'),(18,'树形视图',6,'/report/pkdata/ticket-tree',1,'','&#xe6c7;'),(19,'商机匹配',7,'/mod/business-opp/index',7,'','&#xe6c1;'),(20,'优惠活动',7,'/mod/business-opp/discount',7,'','&#xe6c1;'),(21,'产品发布',7,'/mod/business-opp/product',7,'','&#xe6c1;'),(22,'线上渠道推广',8,'/mod/channel-track/index',8,'','&#xe6bf;'),(23,'微信线上推广',8,'/mod/wechat-promotion/index',8,'','&#xe6bf;'),(24,'票证设置',2,'/ticketout/certificate-type/index',2,'','&#xe6bc;'),(25,'短信管理',2,'/ticketout/sms/index',2,'','&#xe6bc;'),(26,'下级管理',2,'/ticketout/ticket-channel/index',2,'','&#xe6bc;'),(27,'批量分发',2,'/ticketout/batch-send/index',2,'','&#xe6bc;'),(28,'单张分发',2,'/ticketout/send-ticket/index',2,'','&#xe6bc;'),(29,'票证禁用',2,'/ticketout/send-ticket/find-ticket',2,'','&#xe6bc;'),(30,'票面设置',2,'/ticketout/send-ticket/set-ticket-page',2,'','&#xe6bc;'),(31,'补充票仓',2,'/ticketout/send-ticket/genticket',2,'','&#xe6bc;'),(32,'购票设置',2,'/ticketout/send-ticket/set-sale',2,'','&#xe6bc;'),(33,'票证审核',2,'/ticketout/send-ticket/checkticket',2,'','&#xe6bc;');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('/exhibition/exhibition/create',2,NULL,NULL,NULL,1492763142,1492763142),('/exhibition/exhibition/index',2,NULL,NULL,NULL,1492763083,1492763083),('/member/worker/create',2,NULL,NULL,NULL,1492763170,1492763170),('/member/worker/index',2,NULL,NULL,NULL,1492763160,1492763160),('/mod/audience/index',2,NULL,NULL,NULL,1492766972,1492766972),('/mod/business-opp/discount',2,NULL,NULL,NULL,1492763213,1492763213),('/mod/business-opp/index',2,NULL,NULL,NULL,1492763208,1492763208),('/mod/business-opp/product',2,NULL,NULL,NULL,1492763219,1492763219),('/mod/channel-track/index',2,NULL,NULL,NULL,1492763226,1492763226),('/mod/default/create-joiner',2,NULL,NULL,NULL,1492763182,1492763182),('/mod/default/joiner-list',2,NULL,NULL,NULL,1492763177,1492763177),('/mod/vimanage/index',2,NULL,NULL,NULL,1492767259,1492767259),('/mod/wechat-promotion/index',2,NULL,NULL,NULL,1492763231,1492763231),('/report/pkdata/entrance',2,NULL,NULL,NULL,1492763189,1492763189),('/report/pkdata/ticket-report',2,NULL,NULL,NULL,1492763195,1492763195),('/report/pkdata/ticket-tree',2,NULL,NULL,NULL,1492763202,1492763202),('/ticketout/batch-send/index',2,NULL,NULL,NULL,1492763259,1492763259),('/ticketout/certificate-type/index',2,NULL,NULL,NULL,1492763241,1492763241),('/ticketout/send-ticket/checkticket',2,NULL,NULL,NULL,1492763313,1492763313),('/ticketout/send-ticket/find-ticket',2,NULL,NULL,NULL,1492763278,1492763278),('/ticketout/send-ticket/genticket',2,NULL,NULL,NULL,1492763289,1492763289),('/ticketout/send-ticket/index',2,NULL,NULL,NULL,1492763270,1492763270),('/ticketout/send-ticket/set-sale',2,NULL,NULL,NULL,1492763302,1492763302),('/ticketout/send-ticket/set-ticket-page',2,NULL,NULL,NULL,1492763283,1492763283),('/ticketout/sms/index',2,NULL,NULL,NULL,1492763246,1492763246),('/ticketout/ticket-channel/index',2,NULL,NULL,NULL,1492763252,1492763252),('主办方',1,NULL,NULL,NULL,1446282128,1446282128),('人员管理',2,NULL,NULL,NULL,1492767040,1492767040),('参展商',1,NULL,NULL,NULL,1446282128,1446282128),('发票员',1,NULL,NULL,NULL,1446282128,1446282128),('展会管理',2,'<null>',NULL,NULL,1446282128,1446282128),('展商管理',2,NULL,NULL,NULL,1492767070,1492767070),('工作人员',1,NULL,NULL,NULL,1446282128,1446282128),('推广管理',2,'<null>',NULL,NULL,1492761645,1492761645),('数据管理',2,'<null>',NULL,NULL,1492767110,1492767110),('数据统计',1,NULL,NULL,NULL,1488278885,1488278885),('票证管理',2,NULL,NULL,NULL,1492766721,1492766721),('系统管理员',1,NULL,NULL,NULL,1446282128,1446282128),('营销管理',2,'<null>',NULL,NULL,1492761630,1492761630),('观众',1,NULL,NULL,NULL,1446282128,1446282128),('观众管理',2,NULL,NULL,NULL,1492766838,1492766838),('门禁人员',1,NULL,NULL,NULL,1470219319,1470219319),('页面设计',2,NULL,NULL,NULL,1492767245,1492767245);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-24 19:31:35
