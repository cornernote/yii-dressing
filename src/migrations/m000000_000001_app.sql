-- phpMyAdmin SQL Dump
-- version 4.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 02, 2013 at 06:27 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yii_skeleton`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `filetype` varchar(255) NOT NULL,
  `filesize` int(11) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `model` (`model`,`model_id`),
  KEY `created_dt` (`created`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE IF NOT EXISTS `audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(1000) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `post` text NOT NULL,
  `get` text NOT NULL,
  `files` text NOT NULL,
  `session` text NOT NULL,
  `server` text NOT NULL,
  `cookie` text NOT NULL,
  `referrer` varchar(1000) NOT NULL,
  `redirect` varchar(1000) NOT NULL,
  `app_version` varchar(255) NOT NULL,
  `yii_version` varchar(255) NOT NULL,
  `audit_trail_count` int(11) NOT NULL,
  `start_time` decimal(14,4) NOT NULL,
  `end_time` decimal(14,4) NOT NULL,
  `total_time` decimal(14,4) NOT NULL,
  `memory_usage` int(11) NOT NULL,
  `memory_peak` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `preserve` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stamp` (`created`),
  KEY `user_id` (`user_id`),
  KEY `url` (`link`(255)),
  KEY `audit_trail_count` (`audit_trail_count`),
  KEY `redirect` (`redirect`(255)),
  KEY `app_version` (`app_version`),
  KEY `start_time` (`start_time`),
  KEY `end_time` (`end_time`),
  KEY `total_time` (`total_time`),
  KEY `memory_usage` (`memory_usage`),
  KEY `memory_peak` (`memory_peak`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE IF NOT EXISTS `audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_id` int(11) NOT NULL,
  `old_value` text NOT NULL,
  `new_value` text NOT NULL,
  `action` varchar(20) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` varchar(64) NOT NULL,
  `field` varchar(64) NOT NULL,
  `created` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `model_id` (`model_id`),
  KEY `model` (`model`),
  KEY `field` (`field`),
  KEY `action` (`action`),
  KEY `page_trail_id` (`audit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_spool`
--

CREATE TABLE IF NOT EXISTS `email_spool` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(32) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `to_email` varchar(255) NOT NULL,
  `to_name` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `message_subject` varchar(255) NOT NULL,
  `message_html` text NOT NULL,
  `message_text` text NOT NULL,
  `sent` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `model_foreign_key` (`model`,`model_id`),
  KEY `deleted` (`deleted`),
  KEY `status` (`status`),
  KEY `sent` (`sent`) USING BTREE,
  KEY `created_deleted` (`created`,`deleted`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE IF NOT EXISTS `email_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `message_subject` text NOT NULL,
  `message_html` text NOT NULL,
  `message_text` text NOT NULL,
  `description` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` VALUES ('1', 'layout.default', '{{contents}} - {{Setting.name}}', '{{contents}}', '<div marginwidth=\"0\" marginheight=\"0\">\r\n    <div style=\"background-color:#eeeeee;width:100%;margin:0;padding:30px 0 30px 0\">\r\n        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n            <tbody>\r\n            <tr>\r\n                <td align=\"center\" valign=\"top\">\r\n                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" align=\"center\">\r\n                        <tr>\r\n                            <td>\r\n                                <img alt=\"{{Setting.name}}\" src=\"{{Setting.bu}}/img/logo_email.png\"/><br/>\r\n                                <br/>\r\n                            </td>\r\n                        </tr>\r\n                    </table>\r\n                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" align=\"center\" style=\"border-radius:6px!important;background-color:#fdfdfd;border:1px solid #d6d6d6;border-radius:6px!important\">\r\n                        <tbody>\r\n                        <tr>\r\n                            <td align=\"center\" valign=\"top\">\r\n                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" style=\"background-color:#394755;color:#ffffff;border-top-left-radius:6px!important;border-top-right-radius:6px!important;border-bottom:0;font-family:Arial;font-weight:bold;line-height:100%;vertical-align:middle\" bgcolor=\"#557da1\">\r\n                                    <tbody>\r\n                                    <tr>\r\n                                        <td>\r\n                                            <h1 style=\"color:#ffffff;margin:0;padding:28px 24px;display:block;font-family:Arial;font-size:30px;font-weight:bold;text-align:left;line-height:150%\">{{message_title}}</h1>\r\n                                        </td>\r\n                                    </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td align=\"center\" valign=\"top\">\r\n\r\n                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\r\n                                    <tbody>\r\n                                    <tr>\r\n                                        <td valign=\"top\" style=\"background-color:#fdfdfd;border-radius:6px!important\">\r\n                                            <table border=\"0\" cellpadding=\"20\" cellspacing=\"0\" width=\"100%\">\r\n                                                <tbody>\r\n                                                <tr>\r\n                                                    <td valign=\"top\">\r\n                                                        <div style=\"color:#4d4d4d;font-family:Arial;font-size:14px;line-height:150%;text-align:left\">\r\n                                                            {{{contents}}}\r\n                                                        </div>\r\n                                                    </td>\r\n                                                </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                        </td>\r\n                                    </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                            </td>\r\n                        </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" align=\"center\">\r\n                        <tr>\r\n                            <td>\r\n                                <div style=\"color:#737373;font-family:Arial;font-size:12px;line-height:150%;text-align:left\">\r\n                                    <br/>\r\n                                    <span style=\"font-size:16px;font-weight:bold;\">{{Setting.name}}</span><br/>\r\n                                    <b>{{Setting.phone}}</b><br/>\r\n                                    <a href=\"mailto:{{Setting.email}}\">{{Setting.email}}</a><br/>\r\n                                    <a href=\"http://{{Setting.website}}\">{{Setting.website}}</a><br/>\r\n                                </div>\r\n                            </td>\r\n                        </tr>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n            </tbody>\r\n        </table>\r\n    </div>\r\n</div>', '\r\n{{message_title}}\r\n\r\n------------\r\n\r\n{{contents}}\r\n\r\n\r\n------------\r\n{{Setting.name}}\r\n{{Setting.phone}}\r\n{{Setting.email}}\r\nhttp://{{Setting.website}}', '2013-08-19 13:39:22', null);
INSERT INTO `email_template` VALUES ('2', 'user.welcome', 'Account Activation', 'Account Activation', '<p>Welcome to {{Setting.name}}.</p>\r\n\r\n<p>To activate your account please click the button below.</p>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" style=\"border-radius:4px!important;background-color:#115504;border-collapse:collapse\">\r\n    <tbody>\r\n    <tr>\r\n        <td align=\"center\" valign=\"middle\" style=\"font-family:Arial;font-size:30px;padding:10px;border-collapse:collapse\">\r\n            <a title=\"Activate Your Account\" href=\"{{url}}\" style=\"font-weight:bold;letter-spacing:-0.5px;line-height:100%;text-align:center;text-decoration:none;color:#ffffff;word-wrap:break-word!important\" target=\"_blank\">Activate Your Account</a>\r\n        </td>\r\n    </tr>\r\n    </tbody>\r\n</table>\r\n', '{{#User.first_name}}Hello {{User.first_name}},\r\n\r\n{{/User.first_name}}Welcome to {{Setting.name}}.\r\n\r\nTo activate your account please click the following link:\r\n   {{url}}', '2013-08-19 13:39:22', null);
INSERT INTO `email_template` VALUES ('3', 'user.recover', 'Password Recovery', 'Password Recovery', '{{#User.first_name}}<p>Hello {{User.first_name}},</p>{{/User.first_name}}\r\n\r\n<p>To reset your password please click the button below.</p>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" style=\"border-radius:4px!important;background-color:#115504;border-collapse:collapse\">\r\n    <tbody>\r\n    <tr>\r\n        <td align=\"center\" valign=\"middle\" style=\"font-family:Arial;font-size:30px;padding:10px;border-collapse:collapse\">\r\n            <a title=\"Reset Your Password\" href=\"{{url}}\" style=\"font-weight:bold;letter-spacing:-0.5px;line-height:100%;text-align:center;text-decoration:none;color:#ffffff;word-wrap:break-word!important\" target=\"_blank\">Reset Your Password</a>\r\n        </td>\r\n    </tr>\r\n    </tbody>\r\n</table>\r\n', '{{User.first_name}}Hello {{User.first_name}},\r\n\r\n{{/User.first_name}}To reset your password please click the following link:\r\n{{url}}', '2013-08-19 13:39:22', null);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `model` (`model`,`model_id`),
  KEY `created` (`created`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lookup`
--

CREATE TABLE IF NOT EXISTS `lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `type` varchar(128) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `label` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `url_params` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `access_role` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `enabled` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menu_item_menu_item1` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `label`, `icon`, `url`, `url_params`, `target`, `access_role`, `sort_order`, `enabled`, `created`, `deleted`) VALUES
(1, 0, 'System', '', '', '', '', NULL, 0, 0, NOW(), NULL),
(2, 0, 'Main', '', '', '', '', NULL, 0, 0, NOW(), NULL),
(3, 0, 'User', '', '', '', '', NULL, 0, 0, NOW(), NULL),
(4, 0, 'Help', '', '', '', '', NULL, 0, 0, NOW(), NULL),
(5, 1, 'Logs', '', '/log/index', '', '', 'admin', 5, 1, NOW(), NULL),
(6, 1, 'Users', '', '/user/index', '', '', 'admin', 12, 1, NOW(), NULL),
(7, 1, 'Clear Cache', '', '/tool/clearCache', 'returnUrl={returnUrl}', '', 'admin', 0, 1, NOW(), NULL),
(8, 1, 'Generate Properties', '', '/tool/generateProperties', '', '', 'admin', 14, 1, NOW(), NULL),
(9, 1, 'Lookups', '', '/lookup/index', '', '', 'admin', 10, 1, NOW(), NULL),
(10, 1, 'Email Templates', '', '/emailTemplate/index', '', '', 'admin', 8, 1, NOW(), NULL),
(11, 1, 'Audit Trails', '', '/auditTrail/index', '', '', 'admin', 4, 1, NOW(), NULL),
(12, 1, 'Audits', '', '/audit/index', '', '', 'admin', 3, 1, NOW(), NULL),
(13, 1, 'Email Spool', '', '/emailSpool/index', '', '', 'admin', 6, 1, NOW(), NULL),
(14, 1, 'Settings', '', '/setting/index', '', '', 'admin', 2, 1, NOW(), NULL),
(15, 1, 'Menus', '', '/menu/index', '', '', 'admin', 9, 1, NOW(), NULL),
(16, 1, 'Clear Asset', '', '/tool/clearAsset', 'returnUrl={returnUrl}', '', 'admin', 1, 1, NOW(), NULL),
(17, 3, 'Account', '', '/account/index', '', '', '@', 1, 1, NOW(), NULL),
(18, 3, 'Update', '', '/account/update', '', '', '@', 2, 1, NOW(), NULL),
(19, 3, 'Password', '', '/account/password', '', '', '@', 3, 1, NOW(), NULL),
(20, 3, 'Logout', '', '/account/logout', '', '', '@', 4, 1, NOW(), NULL),
(21, 3, 'Login', '', '/account/login', '', '', '?', 0, 1, NOW(), NULL),
(22, 3, 'Register', '', '/account/register', '', '', '?', 0, 1, NOW(), NULL),
(23, 3, 'Recover', '', '/account/recover', '', '', '?', 0, 1, NOW(), NULL),
(24, 4, 'Documentation', '', '/site/page', 'view=documentation', '', NULL, 0, 1, NOW(), NULL),
(25, 4, 'Help', '', '/site/page', 'view=help', '', NULL, 0, 1, NOW(), NULL),
(274, 2, 'Documentation', '', '/site/page', 'view=documentation', '', NULL, 0, 1, NOW(), NULL),
(275, 1, 'Attachments', '', '/attachment/index', '', '', 'admin', 7, 1, NOW(), NULL),
(276, 1, 'Notes', '', '/note/index', '', '', 'admin', 11, 1, NOW(), NULL),
(277, 1, 'Generate Code', '', '/gii', '', '', 'admin', 13, 1, NOW(), NULL),
(278, 1, 'Errors', '', '/error', '', '', 'admin', 6, 1, NOW(), NULL);

-- --------------------------------------------------------

--
-- Table structure for table `model_cache`
--

CREATE TABLE IF NOT EXISTS `model_cache` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL,
  `model_id` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `cache` longtext NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `model_name` (`model`),
  KEY `model_value` (`key`),
  KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notes` text NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `important` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `model` (`model`,`model_id`),
  KEY `created_dt` (`created`,`deleted`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=119802 ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `key` varchar(128) NOT NULL,
  `value` varchar(1024) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `signature`
--

CREATE TABLE IF NOT EXISTS `signature` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL,
  `model_id` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `signature` text NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- Table structure for table `sort_order`
--

CREATE TABLE IF NOT EXISTS `sort_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `model` (`model`,`model_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1291262 ;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(64) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `uses_allowed` int(11) NOT NULL,
  `uses_remaining` int(11) NOT NULL,
  `expires` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `token` (`token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `web_status` int(11) NOT NULL,
  `api_status` int(11) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `created` (`created`,`deleted`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `name`, `phone`, `fax`, `web_status`, `api_status`, `api_key`, `created`, `deleted`) VALUES
(1, 'admin@localhost.localdomain', 'admin', '$2a$08$b.5MVtbgKv4Dvf/M3AFKKuga4pxptFOsmu7gkN.QOH5yvws6Ks03i', 'admin', '', '', 1, 0, '', NOW(), NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_eav`
--

CREATE TABLE IF NOT EXISTS `user_eav` (
  `entity` int(11) unsigned NOT NULL,
  `attribute` varchar(64) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`entity`,`attribute`),
  KEY `value` (`value`(32)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_to_role`
--

CREATE TABLE IF NOT EXISTS `user_to_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT 'FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)',
  `role_id` int(11) unsigned NOT NULL COMMENT 'FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_to_role`
--

INSERT INTO `user_to_role` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
