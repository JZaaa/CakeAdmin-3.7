/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.1.29-MariaDB : Database - cakeadmin_3_7
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cakeadmin_3_7` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `cakeadmin_3_7`;

/*Table structure for table `ad_menus` */

DROP TABLE IF EXISTS `ad_menus`;

CREATE TABLE `ad_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(50) DEFAULT NULL COMMENT '菜单名称',
  `parent_id` int(11) DEFAULT '0' COMMENT '上级菜单id',
  `level` tinyint(3) DEFAULT '1' COMMENT '菜单级别',
  `icon` varchar(20) DEFAULT NULL COMMENT '菜单图标',
  `target` varchar(50) DEFAULT NULL COMMENT '菜单链接',
  `reload` varchar(20) DEFAULT NULL COMMENT '重新载入某个标签',
  `sort` tinyint(3) DEFAULT '0' COMMENT '菜单排序',
  `isshow` tinyint(2) DEFAULT '1' COMMENT '是否显示。1显示，2隐藏',
  `created` datetime DEFAULT NULL COMMENT '创建时间',
  `modified` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='菜单表';

/*Data for the table `ad_menus` */

insert  into `ad_menus`(`id`,`name`,`parent_id`,`level`,`icon`,`target`,`reload`,`sort`,`isshow`,`created`,`modified`) values 
(1,'系统管理',0,1,'','','',0,1,'2019-02-19 09:03:10','2019-02-19 09:03:36'),
(2,'系统管理',1,2,'cogs','','',0,1,'2019-02-19 09:03:16','2019-02-19 09:03:39'),
(3,'管理员组',2,3,'caret-right','admin/roles/index','roles',0,1,'2019-02-19 09:03:19','2019-02-19 09:03:43'),
(4,'用户管理',2,3,'caret-right','admin/users/index','users',0,1,'2019-02-19 09:03:22','2019-02-19 09:03:45'),
(5,'系统设置',2,3,'caret-right','admin/options/index','options',0,1,'2019-02-19 09:03:25','2019-02-19 09:03:49'),
(6,'菜单管理',2,3,'caret-right','admin/menus/index','menus',0,1,'2019-02-19 09:03:28','2019-02-19 09:03:52');

/*Table structure for table `ad_options` */

DROP TABLE IF EXISTS `ad_options`;

CREATE TABLE `ad_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `field` varchar(50) DEFAULT NULL COMMENT '字段名',
  `value` text COMMENT '值',
  `type` varchar(50) DEFAULT NULL COMMENT '所属分类',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

/*Data for the table `ad_options` */

insert  into `ad_options`(`id`,`name`,`field`,`value`,`type`) values 
(1,'系统名称','systemname','后台管理系统','system'),
(2,'系统logo','systemlogo','img/cake-logo.png','system'),
(3,'显示系统名称','systemnamehide','2','system'),
(4,'起始年份','systemyear','2019','system'),
(5,'底部信息','systemfoot','Copyright © 2019 PWS','system'),
(6,'百度地图','baidu','','other'),
(7,'云片短信','yunpian','','other'),
(8,'站点名称','sitename','','site'),
(9,'站点副名称','sitefuname','','site'),
(10,'站点描述','sitedesc','','site'),
(11,'关键词','sitekeywords','','site'),
(12,'版权信息','sitecopyright','','site'),
(13,'备案编号','siteicpsn','','site'),
(14,'统计代码','sitestatistics','','site'),
(15,'登录名称','systemlogin','','system'),
(16,NULL,'systemfulltext','2','system');

/*Table structure for table `ad_roles` */

DROP TABLE IF EXISTS `ad_roles`;

CREATE TABLE `ad_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(50) DEFAULT NULL COMMENT '组别名称',
  `menus` text COMMENT '菜单权限',
  `note` varchar(100) DEFAULT NULL COMMENT '备注',
  `sort` int(11) DEFAULT '0' COMMENT '排序id',
  `created` datetime DEFAULT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员组表';

/*Data for the table `ad_roles` */

insert  into `ad_roles`(`id`,`name`,`menus`,`note`,`sort`,`created`,`modified`) values 
(1,'管理员组','[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]','',0,'2017-09-22 17:07:58','2019-03-07 10:26:26');

/*Table structure for table `ad_users` */

DROP TABLE IF EXISTS `ad_users`;

CREATE TABLE `ad_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `username` varchar(50) DEFAULT NULL COMMENT '登录名',
  `password` varchar(100) DEFAULT NULL COMMENT '登录密码',
  `nickname` varchar(50) DEFAULT NULL COMMENT '昵称',
  `role_id` int(11) DEFAULT NULL COMMENT '用户组id',
  `state` tinyint(2) DEFAULT '1' COMMENT '登录状态.1正常，2禁止',
  `created` datetime DEFAULT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  `sex` tinyint(2) DEFAULT NULL COMMENT '性别。1男，2女',
  `telphone` varchar(20) DEFAULT NULL COMMENT '联系方式',
  `email` varchar(50) DEFAULT NULL COMMENT '电子邮件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

/*Data for the table `ad_users` */

insert  into `ad_users`(`id`,`username`,`password`,`nickname`,`role_id`,`state`,`created`,`modified`,`sex`,`telphone`,`email`) values 
(1,'admin','$2y$10$4V.fuLVKilJ9dkOAJrD4q.UFUymn0wYG1eEZivJSJ1hKjqLiYMO0W','管理员',1,1,'2019-02-19 09:05:13','2019-02-28 07:34:09',1,'','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
