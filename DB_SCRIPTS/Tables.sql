SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `tab_languages`;
CREATE TABLE IF NOT EXISTS `tab_languages` (
  `id_language` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `native_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_iso639_1` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'ISO 639-1 code',
  `code_iso639_2` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'ISO 639-2 code',
  `code_ietf` char(16) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'IETF language tag',
  PRIMARY KEY (`id_language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/**** NB DO NOT CHANGE THE IDS: They are also mapped at application level *****/
INSERT INTO `tab_languages` ( `id_language`, `name`, `native_name`, `code_iso639_1`, `code_iso639_2`, `code_ietf`) VALUES
( 1,'Francese', 'Français', 'fr','fra',  'fr-fr'),
( 2, 'Italiano', 'Italiano', 'it', 'ita', 'it-it'),
( 3, 'Inglese', 'English', 'en', 'eng', 'en-us');


DROP TABLE IF EXISTS `tab_projects`;
CREATE TABLE IF NOT EXISTS `tab_projects` (
  `id_project` int unsigned NOT NULL AUTO_INCREMENT,
  `project_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id_language` int unsigned NOT NULL DEFAULT 1 COMMENT 'Default Interface language for the project',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL,
  PRIMARY KEY (`id_project`),
  UNIQUE (`project_name`),  
  FOREIGN KEY (`project_id_language`) REFERENCES tab_languages(`id_language`) ON DELETE CASCADE 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `tab_projects` ADD COLUMN `token` varchar(128) NOT NULL  DEFAULT '123456' after `id_project`;


DROP TABLE IF EXISTS `tab_project_servers`;
CREATE TABLE IF NOT EXISTS `tab_project_servers` (
  `id_server` int unsigned NOT NULL AUTO_INCREMENT,
  `id_project` int unsigned NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(255) COLLATE latin1_general_ci,
  `alert_email` varchar(255) COLLATE latin1_general_ci,
  `last_ping_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  
  PRIMARY KEY (`id_server`),  
  FOREIGN KEY (`id_project`) REFERENCES tab_projects(`id_project`) ON DELETE CASCADE 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
  

DROP TABLE IF EXISTS `tab_server_players`;
CREATE TABLE IF NOT EXISTS `tab_server_players` (
  `id_player` int unsigned NOT NULL AUTO_INCREMENT,
  `id_server` int unsigned NOT NULL,
  `ip_player` varchar(255) COLLATE latin1_general_ci,
  `last_ping_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  
  PRIMARY KEY (`id_player`),  
  FOREIGN KEY (`id_server`) REFERENCES `tab_project_servers`(`id_server`) ON DELETE CASCADE 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
  



DROP TABLE IF EXISTS `us_users`;
CREATE TABLE IF NOT EXISTS `us_users` (
  `id_user` int unsigned NOT NULL AUTO_INCREMENT,
  `id_project` int unsigned NOT NULL,
  `username` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_language` int unsigned NOT NULL DEFAULT 1 COMMENT 'Default Interface language for the user',  
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '',
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '',
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL  DEFAULT '',  
  `role` tinyint NOT NULL DEFAULT 3 COMMENT '3=user, 2=superuser, 1=admin, 0=superadmin',  
  `last_access` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_accesses` int NOT NULL DEFAULT 0,
  `consecutive_login_failures` tinyint NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL,
  `suspended_untill` timestamp NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE (`username`),
  KEY `tabadmins_user_ix` (`username`),
  FOREIGN KEY (`id_language`) REFERENCES tab_languages(`id_language`) ON DELETE CASCADE 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `us_users` ADD COLUMN `avatar_end_point` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '';
ALTER TABLE `us_users` ADD COLUMN `networks_grant` varchar(128) NULL DEFAULT NULL COMMENT 'networks sapareted by coma (es: 56,78,95) - NULL = all networks';


insert into `us_users` (`id_project`, `username`, `password`, `role`) 
values (0, 'admin', '$2y$10$zmBA8CQiopb/mA/V/Bn67uQzJQqqVPyrywUJgK1d2J1r5EfGbOjcy', 0);




DROP TABLE IF EXISTS `us_audit`;
CREATE TABLE IF NOT EXISTS `us_audit` (
  `id_audit` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int unsigned NULL,
  `id_project` int unsigned NOT NULL ,
  `id_network` int unsigned NOT NULL DEFAULT 0,
  `id_advert` bigint unsigned NOT NULL DEFAULT 0,
  `action` varchar(128) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  
  PRIMARY KEY (`id_audit`),
  kEY(`created_at`),
  FOREIGN KEY (`id_user`) REFERENCES us_users(`id_user`) ON DELETE SET NULL  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tab_networks`;
CREATE TABLE IF NOT EXISTS `tab_networks` (
  `id_network` int unsigned NOT NULL AUTO_INCREMENT,
  `id_project` int unsigned NOT NULL, 
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '', 
  `screen_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '',
  `screen_x_dimension` smallint NULL,
  `screen_y_dimension` smallint NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '',
  `num_screens` tinyint NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL,
  PRIMARY KEY (`id_network`),
  UNIQUE (`id_project`, `name`),
  FOREIGN KEY (`id_project`) REFERENCES tab_projects(`id_project`) ON DELETE CASCADE 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `tab_networks` ADD COLUMN `id_network_extra` int unsigned DEFAULT NULL after `num_screens`;

ALTER TABLE `tab_networks` ADD COLUMN `max_adverts` tinyint NOT NULL DEFAULT 7 after `description`;
ALTER TABLE `tab_networks` ADD COLUMN `max_duration_in_sec` smallint NOT NULL DEFAULT 12 after `max_adverts`;
ALTER TABLE `tab_networks` ADD COLUMN `id_language` int NOT NULL DEFAULT 0 after `num_screens`;
ALTER TABLE `tab_networks` ADD COLUMN `default_image_end_point` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '' after `id_language`;
ALTER TABLE `tab_networks` add column `default_image_sha2`  varchar(128) NOT NULL  DEFAULT '' after `default_image_end_point`;
ALTER TABLE `tab_networks` add column `h_from`  tinyint NOT NULL  DEFAULT 0 after `screen_y_dimension`;
ALTER TABLE `tab_networks` add column `h_to`  tinyint NOT NULL  DEFAULT 23 after `h_from`;


DROP TABLE IF EXISTS `tab_adverts`;
CREATE TABLE IF NOT EXISTS `tab_adverts` (
  `id_advert` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_project` int unsigned NOT NULL,
  `id_network` int unsigned NOT NULL,
  `type` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '0=advert, 1=time, 2=meteo',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '', 
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '', 
  `start_time` timestamp NULL, 
  `end_time` timestamp NULL,
  `mime_type` varchar(64) NULL,
  `end_point`  varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '',
  `size_in_bytes` int unsigned NOT NULL default 0,
  `cost` tinyint NOT NULL  DEFAULT 1 COMMENT '0=premium, 1=free',
  `duration_in_sec` INT NOT NULL DEFAULT 0,
  `width` smallint NOT NULL DEFAULT 0, 
  `height` smallint NOT NULL DEFAULT 0,
  `prog`  bigint unsigned,
  `is_active` tinyint unsigned default 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL,
  PRIMARY KEY (`id_advert`),
  UNIQUE (`id_advert`, `name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE  `tab_adverts` add column `id_parent`  bigint unsigned NOT NULL  DEFAULT 0 after `id_advert`;
ALTER TABLE  `tab_adverts` add column `sha2`  varchar(128) NOT NULL  DEFAULT '' after `is_active`;
ALTER TABLE  `tab_adverts` add column `counter`  bigint NOT NULL  DEFAULT 0 after `is_active`;



DROP TABLE IF EXISTS `tab_meteos`;
CREATE TABLE IF NOT EXISTS `tab_meteos` (
  `id_meteo` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_project` int unsigned NOT NULL,
  `id_network` int unsigned NOT NULL,
  `city_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '', 
  `city_id` bigint NOT NULL  DEFAULT '2993458' COMMENT 'used for api call, defolt is Monaco (MC)', 
  `end_point`  varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '',
  `size_in_bytes` int unsigned NOT NULL default 0,
  `width` smallint NOT NULL DEFAULT 0, 
  `height` smallint NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL,
  PRIMARY KEY (`id_meteo`),
  UNIQUE (`id_meteo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `tab_meteos` ADD COLUMN `mime_type` varchar(64) NULL after `city_id`;
ALTER TABLE `tab_meteos` add column `sha2`  varchar(128) NOT NULL  DEFAULT '' after `height`;



DROP TABLE IF EXISTS `tab_clocks`;
CREATE TABLE IF NOT EXISTS `tab_clocks` (
  `id_clock` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_project` int unsigned NOT NULL,
  `id_network` int unsigned NOT NULL,  
  `widget_id`  tinyint NOT NULL  DEFAULT '0' COMMENT 'used by frontend', 
  `end_point`  varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL  DEFAULT '',
  `size_in_bytes` int unsigned NOT NULL default 0,
  `width` smallint NOT NULL DEFAULT 0, 
  `height` smallint NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL,
  PRIMARY KEY (`id_clock`),
  UNIQUE (`id_clock`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `tab_clocks` ADD COLUMN `mime_type` varchar(64) NULL after `widget_id`;
ALTER TABLE `tab_clocks` add column `sha2`  varchar(128) NOT NULL  DEFAULT '' after `height`;
