/*
SQLyog v10.2 
MySQL - 5.6.24 : Database - code_jiami
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`code_jiami` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `code_jiami`;

/*Table structure for table `code_dictionary` */

DROP TABLE IF EXISTS `code_dictionary`;

CREATE TABLE `code_dictionary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code_name` varchar(50) NOT NULL DEFAULT '' COMMENT '标量名',
  `code_value` varchar(15) NOT NULL DEFAULT '' COMMENT '加密数值',
  `code_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '标量类型1:变量；2:类变量;3:常量;',
  PRIMARY KEY (`id`),
  KEY `code_name` (`code_name`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `code_dictionary` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
