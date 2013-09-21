CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `user_eav` (
  `entity` int(11) unsigned NOT NULL,
  `attribute` varchar(64) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`entity`,`attribute`),
  KEY `value` (`value`(32)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_to_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT 'FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)',
  `role_id` int(11) unsigned NOT NULL COMMENT 'FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `user` (`id`, `email`, `username`, `password`, `name`, `phone`, `fax`, `web_status`, `api_status`, `api_key`, `created`, `deleted`) VALUES
(1, 'admin@localhost', 'admin', '$2a$08$b.5MVtbgKv4Dvf/M3AFKKuga4pxptFOsmu7gkN.QOH5yvws6Ks03i', 'admin', '', '', 1, 0, '', NOW(), NULL);

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin');

INSERT INTO `user_to_role` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1);