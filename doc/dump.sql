-- MySQL dump 10.16  Distrib 10.1.19-MariaDB, for Linux (x86_64)
--
-- Host: 192.168.11.251    Database: 192.168.11.251
-- ------------------------------------------------------
-- Server version	5.6.30-log

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
INSERT INTO `auth_item_child` VALUES ('展会管理','/exhibition/exhibition/create'),('展会管理','/exhibition/exhibition/index'),('人员管理','/member/worker/create'),('人员管理','/member/worker/index'),('观众管理','/mod/audience/index'),('营销管理','/mod/business-opp/discount'),('营销管理','/mod/business-opp/index'),('营销管理','/mod/business-opp/product'),('推广管理','/mod/channel-track/index'),('展商管理','/mod/default/create-joiner'),('展商管理','/mod/default/joiner-list'),('页面设计','/mod/vimanage/index'),('推广管理','/mod/wechat-promotion/index'),('数据管理','/report/pkdata/entrance'),('数据管理','/report/pkdata/ticket-report'),('数据管理','/report/pkdata/ticket-tree'),('票证管理','/ticketout/batch-send/index'),('票证管理','/ticketout/certificate-type/index'),('票证管理','/ticketout/send-ticket/checkticket'),('票证管理','/ticketout/send-ticket/find-ticket'),('票证管理','/ticketout/send-ticket/genticket'),('票证管理','/ticketout/send-ticket/index'),('票证管理','/ticketout/send-ticket/set-sale'),('票证管理','/ticketout/send-ticket/set-ticket-page'),('票证管理','/ticketout/sms/index'),('票证管理','/ticketout/ticket-channel/index'),('系统管理员','user/del'),('系统管理员','主办方'),('主办方','人员管理'),('主办方','参展商'),('主办方','展会管理'),('主办方','工作人员'),('主办方','推广管理'),('主办方','数据管理'),('参展商','数据管理'),('工作人员','数据管理'),('数据统计','数据管理'),('参展商','票证管理'),('发票员','票证管理'),('工作人员','票证管理'),('参展商','营销管理'),('工作人员','营销管理'),('参展商','观众管理'),('工作人员','观众管理'),('主办方','页面设计');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
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
INSERT INTO `auth_item` VALUES ('/exhibition/exhibition/create',2,NULL,NULL,NULL,1492763142,1492763142),('/exhibition/exhibition/index',2,NULL,NULL,NULL,1492763083,1492763083),('/member/worker/create',2,NULL,NULL,NULL,1492763170,1492763170),('/member/worker/index',2,NULL,NULL,NULL,1492763160,1492763160),('/mod/audience/index',2,NULL,NULL,NULL,1492766972,1492766972),('/mod/business-opp/discount',2,NULL,NULL,NULL,1492763213,1492763213),('/mod/business-opp/index',2,NULL,NULL,NULL,1492763208,1492763208),('/mod/business-opp/product',2,NULL,NULL,NULL,1492763219,1492763219),('/mod/channel-track/index',2,NULL,NULL,NULL,1492763226,1492763226),('/mod/default/create-joiner',2,NULL,NULL,NULL,1492763182,1492763182),('/mod/default/joiner-list',2,NULL,NULL,NULL,1492763177,1492763177),('/mod/vimanage/index',2,NULL,NULL,NULL,1492767259,1492767259),('/mod/wechat-promotion/index',2,NULL,NULL,NULL,1492763231,1492763231),('/report/pkdata/entrance',2,NULL,NULL,NULL,1492763189,1492763189),('/report/pkdata/ticket-report',2,NULL,NULL,NULL,1492763195,1492763195),('/report/pkdata/ticket-tree',2,NULL,NULL,NULL,1492763202,1492763202),('/ticketout/batch-send/index',2,NULL,NULL,NULL,1492763259,1492763259),('/ticketout/certificate-type/index',2,NULL,NULL,NULL,1492763241,1492763241),('/ticketout/send-ticket/checkticket',2,NULL,NULL,NULL,1492763313,1492763313),('/ticketout/send-ticket/find-ticket',2,NULL,NULL,NULL,1492763278,1492763278),('/ticketout/send-ticket/genticket',2,NULL,NULL,NULL,1492763289,1492763289),('/ticketout/send-ticket/index',2,NULL,NULL,NULL,1492763270,1492763270),('/ticketout/send-ticket/set-sale',2,NULL,NULL,NULL,1492763302,1492763302),('/ticketout/send-ticket/set-ticket-page',2,NULL,NULL,NULL,1492763283,1492763283),('/ticketout/sms/index',2,NULL,NULL,NULL,1492763246,1492763246),('/ticketout/ticket-channel/index',2,NULL,NULL,NULL,1492763252,1492763252),('marketing',2,'营销支持',NULL,NULL,NULL,NULL),('marketing/lottery/record',2,'兑奖查询',NULL,NULL,NULL,NULL),('marketing/lottery/turntable',2,'大转盘',NULL,NULL,NULL,NULL),('member/member/profile',2,'帐号信息',NULL,NULL,1446282128,1446282128),('member/weixin/index',2,'微信公众号绑定',NULL,NULL,1446282128,1446282128),('member/worker/index',2,'工作人员管理',NULL,NULL,1446282128,1446282128),('member/zfb/index',2,'支付宝帐号管理',NULL,NULL,1446282128,1446282128),('mod/audience/index',2,'观众管理',NULL,NULL,1492761547,1492761547),('mod/default/joiner-list',2,'展商管理',NULL,NULL,1492761592,1492761592),('mod/vimanage/index',2,'页面设计',NULL,NULL,1492761777,1492761777),('report/pkdata/entrance',2,'数据管理',NULL,NULL,1492761610,1492761610),('ticketout/batch-send/index',2,'批量分发功能',NULL,NULL,1446282128,1446282128),('ticketout/certificate-type/index',2,'票证管理',NULL,NULL,1446282128,1492761399),('ticketout/send-ticket/find-ticket',2,'票证禁用功能',NULL,NULL,1446282128,1446282128),('ticketout/send-ticket/index',2,'单张生成功能',NULL,NULL,1446282128,1446282128),('ticketout/ticket-channel/index',2,'下级管理功能',NULL,NULL,1446282128,1446282128),('User',2,'权限管理',NULL,NULL,1446282128,1446282128),('user/create',2,'创建用户的权限',NULL,NULL,1446282128,1446282128),('user/del',2,'删除用户的权限',NULL,NULL,1446282128,1446282128),('user/edit',2,'编辑用户的权限',NULL,NULL,1446282128,1446282128),('user/index',2,'用户管理',NULL,NULL,1446282128,1446282128),('user/list',2,'展示用户的权限',NULL,NULL,1446282128,1446282128),('主办方',1,NULL,NULL,NULL,1446282128,1446282128),('人员管理',2,NULL,NULL,NULL,1492767040,1492767040),('参展商',1,NULL,NULL,NULL,1446282128,1446282128),('发票员',1,NULL,NULL,NULL,1446282128,1446282128),('展会管理',2,'',NULL,NULL,1446282128,1446282128),('展商管理',2,NULL,NULL,NULL,1492767070,1492767070),('工作人员',1,NULL,NULL,NULL,1446282128,1446282128),('推广管理',2,'mod/channel-track/index',NULL,NULL,1492761645,1492761645),('数据管理',2,NULL,NULL,NULL,1492767110,1492767110),('数据统计',1,NULL,NULL,NULL,1488278885,1488278885),('票证管理',2,NULL,NULL,NULL,1492766721,1492766721),('系统管理员',1,NULL,NULL,NULL,1446282128,1446282128),('营销管理',2,'mod/business-opp/index',NULL,NULL,1492761630,1492761630),('观众',1,NULL,NULL,NULL,1446282128,1446282128),('观众管理',2,NULL,NULL,NULL,1492766838,1492766838),('门禁人员',1,NULL,NULL,NULL,1470219319,1470219319),('页面设计',2,NULL,NULL,NULL,1492767245,1492767245);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `auth_assignment` VALUES ('主办方','108',1447412743),('主办方','114',1447826640),('主办方','144',1447901923),('主办方','150',1447913478),('主办方','151',1447913697),('主办方','152',1447913799),('主办方','153',1447913828),('主办方','154',1447913855),('主办方','155',1447914358),('主办方','157',1447914409),('主办方','158',1447914456),('主办方','2',1443189007),('主办方','23291',1459476567),('主办方','27278',1467079857),('主办方','27280',1467082306),('主办方','27325',1470297800),('主办方','39',1444793186),('主办方','48',1445258568),('主办方','50',1445346189),('主办方','52',1445396067),('主办方','61',1445857208),('主办方','62',1445859060),('主办方','63',1445859758),('主办方','7',1443412711),('参展商','100',1446535597),('参展商','101',1446535784),('参展商','103',1446630116),('参展商','104',1446803024),('参展商','105',1446805008),('参展商','106',1447223243),('参展商','107',1463478956),('参展商','109',1447473559),('参展商','110',1447487481),('参展商','111',1447487799),('参展商','113',1447494540),('参展商','133',1447846389),('参展商','134',1447846727),('参展商','136',1447846861),('参展商','137',1447849859),('参展商','139',1447854521),('参展商','140',1447875563),('参展商','141',1447877177),('参展商','142',1447889327),('参展商','143',1447899197),('参展商','145',1447903440),('参展商','147',1447904013),('参展商','148',1447907348),('参展商','156',1447914425),('参展商','159',1447918981),('参展商','160',1447921766),('参展商','161',1448253757),('参展商','162',1448270526),('参展商','163',1448270649),('参展商','164',1448279607),('参展商','165',1448280004),('参展商','166',1448280342),('参展商','167',1448282530),('参展商','168',1448333693),('参展商','169',1448424257),('参展商','170',1448435574),('参展商','171',1448436259),('参展商','172',1448437319),('参展商','173',1448441153),('参展商','174',1448441204),('参展商','175',1448445343),('参展商','176',1448445532),('参展商','177',1448445641),('参展商','23215',1449112314),('参展商','23216',1449112386),('参展商','23217',1449113151),('参展商','23218',1449558598),('参展商','23219',1449559384),('参展商','23220',1449559635),('参展商','23221',1449559750),('参展商','23223',1456221094),('参展商','23224',1456222891),('参展商','23253',1457073656),('参展商','23261',1464599409),('参展商','23269',1459244020),('参展商','23270',1461922179),('参展商','23279',1459322666),('参展商','23280',1459324775),('参展商','23281',1459324875),('参展商','23282',1459325070),('参展商','23283',1459326368),('参展商','23284',1459326994),('参展商','23285',1459327955),('参展商','23286',1459328100),('参展商','23301',1460538273),('参展商','27',1443524730),('参展商','27224',1463540954),('参展商','27229',1464264276),('参展商','27233',1463723802),('参展商','27239',1463716008),('参展商','27240',1463722572),('参展商','27242',1464165710),('参展商','27244',1464167246),('参展商','27245',1464167428),('参展商','27246',1464167587),('参展商','27247',1464167812),('参展商','27248',1464168533),('参展商','27249',1464168597),('参展商','27255',1464607057),('参展商','27263',1464245849),('参展商','27264',1464248668),('参展商','27265',1464264609),('参展商','27266',1464685386),('参展商','27272',1466424277),('参展商','27273',1466425405),('参展商','27274',1466476818),('参展商','27276',1466479555),('参展商','27281',1467095640),('参展商','27284',1467099409),('参展商','27285',1467099533),('参展商','27286',1467099553),('参展商','27287',1467099716),('参展商','27288',1467102173),('参展商','27291',1467184886),('参展商','27301',1467876207),('参展商','27302',1468376925),('参展商','27305',1468919258),('参展商','27306',1469069139),('参展商','27308',1470052852),('参展商','27309',1470126352),('参展商','27314',1470218121),('参展商','27322',1470221040),('参展商','27329',1470367217),('参展商','27335',1470378693),('参展商','27337',1470380098),('参展商','27338',1470380391),('参展商','27339',1470380975),('参展商','27341',1470381305),('参展商','27343',1470381976),('参展商','27344',1470382284),('参展商','27345',1470654020),('参展商','27346',1470710243),('参展商','27347',1470710647),('参展商','27361',1473041270),('参展商','27362',1473042381),('参展商','27367',1473056413),('参展商','27373',1473066890),('参展商','27375',1473067936),('参展商','27376',1473068018),('参展商','27378',1473070811),('参展商','27381',1473148899),('参展商','27387',1473738462),('参展商','27393',1479443696),('参展商','27397',1479799421),('参展商','28',1443524958),('参展商','29',1444270015),('参展商','30',1444270111),('参展商','31',1444287265),('参展商','32',1444391562),('参展商','34',1444392279),('参展商','35',1444449372),('参展商','36',1444449520),('参展商','37',1444459688),('参展商','38',1444460774),('参展商','39',1446105878),('参展商','47',1445257649),('参展商','58',1445498209),('参展商','59',1445498826),('参展商','60',1445517903),('参展商','67',1446106235),('参展商','68',1446110957),('参展商','69',1446112678),('参展商','70',1446113041),('参展商','79',1446113290),('参展商','97',1446354327),('参展商','98',1446354349),('发票员','112',1447494414),('发票员','132',1447846368),('发票员','135',1447846828),('发票员','23222',1449567710),('发票员','23290',1473736011),('发票员','27223',1463539005),('发票员','27243',1464167020),('发票员','27250',1464168652),('发票员','27282',1467096015),('发票员','27283',1467098122),('发票员','27289',1467182738),('发票员','27294',1467362594),('发票员','27296',1467599537),('发票员','27310',1470196939),('发票员','27327',1470305775),('发票员','27328',1470367064),('发票员','27336',1470379866),('发票员','27340',1470381126),('发票员','27351',1472544115),('发票员','27353',1472721816),('发票员','27355',1472804759),('发票员','27356',1472808581),('发票员','27359',1472812977),('发票员','27365',1473048235),('发票员','27369',1473056813),('发票员','27371',1473066627),('发票员','27382',1473149044),('发票员','27383',1473149131),('发票员','27384',1473149268),('发票员','27395',1479696744),('工作人员','115',1447830469),('工作人员','138',1447850271),('工作人员','146',1447903569),('工作人员','149',1447908426),('工作人员','23479',1462527250),('工作人员','27275',1466479238),('工作人员','27279',1469785353),('工作人员','27303',1469789243),('工作人员','27304',1468567330),('工作人员','27323',1470296025),('工作人员','27409',1488277259),('工作人员','42',1445327261),('工作人员','43',1445258329),('工作人员','54',1469182585),('工作人员','55',1445480745),('工作人员','56',1446609291),('工作人员','88',1446193533),('工作人员','89',1446201051),('工作人员','90',1446201167),('工作人员','91',1446201291),('工作人员','92',1446204200),('工作人员','93',1446205476),('工作人员','94',1446205617),('工作人员','95',1446608451),('工作人员','96',1446206003),('数据统计','27412',1488333316),('数据统计','27413',1488336145),('系统管理员','1',1443189008),('门禁人员','131',1470294673),('门禁人员','27321',1470220915),('门禁人员','27348',1470897826),('门禁人员','27349',1473319147),('门禁人员','27352',1472544679),('门禁人员','27391',1474186766),('门禁人员','53',1470298571);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-21 18:33:09
