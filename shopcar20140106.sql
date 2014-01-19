-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 01 月 06 日 06:48
-- 服务器版本: 5.0.67
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `shopcar`
--

-- --------------------------------------------------------

--
-- 表的结构 `admins`
--
-- 创建时间: 2014 年 01 月 06 日 11:32
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` tinyint(4) NOT NULL auto_increment,
  `username` varchar(10) default NULL,
  `password` varchar(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'alvin', '123456');

-- --------------------------------------------------------

--
-- 表的结构 `categories`
--
-- 创建时间: 2014 年 01 月 06 日 11:32
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` tinyint(4) NOT NULL auto_increment COMMENT '自增id',
  `name` varchar(20) default NULL COMMENT '分类名称',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='分类表' AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, '饮料'),
(2, '蛋糕');

-- --------------------------------------------------------

--
-- 表的结构 `customers`
--
-- 创建时间: 2014 年 01 月 06 日 11:32
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL auto_increment,
  `forename` varchar(50) default NULL,
  `surname` varchar(50) default NULL,
  `add1` varchar(50) default NULL COMMENT '地址1',
  `add2` varchar(50) default NULL COMMENT '地址二',
  `add3` varchar(50) default NULL,
  `postcode` varchar(10) default NULL COMMENT '邮政编码',
  `phone` varchar(20) default NULL COMMENT '手机号',
  `email` varchar(100) NOT NULL COMMENT '电子邮件',
  `registered` tinyint(4) default NULL COMMENT '注册标志',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT=' 顾客表单' AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `customers`
--

INSERT INTO `customers` (`id`, `forename`, `surname`, `add1`, `add2`, `add3`, `postcode`, `phone`, `email`, `registered`) VALUES
(1, '阿毛', '1', '北京', '延庆', '天津', '102100', '13811315477', 'bbc@xx.cc', 1),
(2, '阿狗', '2', '南京', '上海', '江苏', '778854', '13811315478', 'cc@cc.cc', 1);

-- --------------------------------------------------------

--
-- 表的结构 `delivery_addresses`
--
-- 创建时间: 2014 年 01 月 06 日 11:32
--

DROP TABLE IF EXISTS `delivery_addresses`;
CREATE TABLE IF NOT EXISTS `delivery_addresses` (
  `id` int(11) NOT NULL auto_increment,
  `forename` varchar(50) default NULL,
  `surname` varchar(50) default NULL,
  `add1` varchar(50) default NULL,
  `add2` varchar(50) default NULL,
  `add3` varchar(50) default NULL,
  `postcode` varchar(10) default NULL COMMENT '邮政编码',
  `phone` varchar(20) default NULL,
  `email` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='未注册用户相关信息' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `delivery_addresses`
--


-- --------------------------------------------------------

--
-- 表的结构 `logins`
--
-- 创建时间: 2014 年 01 月 06 日 11:32
--

DROP TABLE IF EXISTS `logins`;
CREATE TABLE IF NOT EXISTS `logins` (
  `id` int(11) NOT NULL auto_increment,
  `customer_id` int(11) default NULL,
  `username` varchar(10) default NULL,
  `password` varchar(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='登录表单' AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `logins`
--

INSERT INTO `logins` (`id`, `customer_id`, `username`, `password`) VALUES
(1, 1, '阿毛', '123'),
(2, 2, '阿狗', '123');

-- --------------------------------------------------------

--
-- 表的结构 `orderitems`
--
-- 创建时间: 2014 年 01 月 06 日 11:32
--

DROP TABLE IF EXISTS `orderitems`;
CREATE TABLE IF NOT EXISTS `orderitems` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) default NULL COMMENT '订单id',
  `product_id` int(11) default NULL COMMENT '商品id',
  `quantity` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT=' 订单详情' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `orderitems`
--


-- --------------------------------------------------------

--
-- 表的结构 `orders`
--
-- 创建时间: 2014 年 01 月 06 日 11:32
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL auto_increment,
  `customer_id` int(11) default NULL COMMENT '顾客id',
  `registered` int(11) default NULL,
  `delivery_add_id` int(11) default NULL,
  `payment_type` int(11) default NULL,
  `date` datetime default NULL,
  `status` tinyint(4) default NULL,
  `session` varchar(50) default NULL,
  `total` float default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表单' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `orders`
--


-- --------------------------------------------------------

--
-- 表的结构 `products`
--
-- 创建时间: 2014 年 01 月 06 日 11:32
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL auto_increment,
  `cat_id` tinyint(4) default NULL,
  `name` varchar(100) default NULL,
  `description` text,
  `image` varchar(30) default NULL,
  `price` float default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `products`
--

INSERT INTO `products` (`id`, `cat_id`, `name`, `description`, `image`, `price`) VALUES
(1, 1, '百事可乐', '家不以远近，乐无为大小,只要是你关爱的人，都是家人,关爱无为多少，都是快乐。', 'baishikele.jpg', 2.5),
(2, 1, '九个玫瑰', '玫瑰香\r\n纯天然\r\n无污染', 'jiugemeigui.jpg', 3.5);
