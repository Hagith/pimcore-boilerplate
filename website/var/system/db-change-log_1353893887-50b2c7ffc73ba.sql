INSERT INTO `classes` (`name`) VALUES ('')


UPDATE `classes` SET `id` = '', `name` = '', `description` = '', `creationDate` = '', `modificationDate` = '', `userOwner` = '', `userModification` = '', `parentClass` = '', `allowInherit` = '', `allowVariants` = '', `icon` = '', `previewUrl` = '', `propertyVisibility` = '' WHERE (id = '1')


CREATE TABLE IF NOT EXISTS `object_query_1` (
			  `oo_id` int(11) NOT NULL default '0',
			  `oo_classId` int(11) default '1',
			  `oo_className` varchar(255) default 'BlogCategory',
			  PRIMARY KEY  (`oo_id`)
			) DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `object_store_1` (
			  `oo_id` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`oo_id`)
			) DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `object_relations_1` (
              `src_id` int(11) NOT NULL DEFAULT '0',
              `dest_id` int(11) NOT NULL DEFAULT '0',
              `type` varchar(50) NOT NULL DEFAULT '',
              `fieldname` varchar(70) NOT NULL DEFAULT '0',
              `index` int(11) unsigned NOT NULL DEFAULT '0',
              `ownertype` enum('object','fieldcollection','localizedfield','objectbrick') NOT NULL DEFAULT 'object',
              `ownername` varchar(70) NOT NULL DEFAULT '',
              `position` varchar(70) NOT NULL DEFAULT '0',
              PRIMARY KEY (`src_id`,`dest_id`,`ownertype`,`ownername`,`fieldname`,`type`,`position`),
              KEY `index` (`index`),
              KEY `src_id` (`src_id`),
              KEY `dest_id` (`dest_id`),
              KEY `fieldname` (`fieldname`),
              KEY `position` (`position`),
              KEY `ownertype` (`ownertype`),
              KEY `type` (`type`),
              KEY `ownername` (`ownername`)
            ) DEFAULT CHARSET=utf8;


ALTER TABLE `object_query_1` ADD COLUMN `name` varchar(255) NULL;


ALTER TABLE `object_store_1` ADD COLUMN `name` varchar(255) NULL;


ALTER TABLE `object_query_1` ADD INDEX `p_index_name` (`name`);


ALTER TABLE `object_store_1` ADD INDEX `p_index_name` (`name`);


ALTER TABLE `object_query_1` ADD COLUMN `entryCount` double DEFAULT NULL NULL;


ALTER TABLE `object_store_1` ADD COLUMN `entryCount` double DEFAULT NULL NULL;


ALTER TABLE `object_query_1` DROP INDEX `p_index_entryCount`;


ALTER TABLE `object_store_1` DROP INDEX `p_index_entryCount`;


CREATE OR REPLACE VIEW `object_1` AS SELECT * FROM `object_query_1` JOIN `objects` ON `objects`.`o_id` = `object_query_1`.`oo_id`;


INSERT INTO `classes` (`name`) VALUES ('')


UPDATE `classes` SET `id` = '', `name` = '', `description` = '', `creationDate` = '', `modificationDate` = '', `userOwner` = '', `userModification` = '', `parentClass` = '', `allowInherit` = '', `allowVariants` = '', `icon` = '', `previewUrl` = '', `propertyVisibility` = '' WHERE (id = '2')


CREATE TABLE IF NOT EXISTS `object_query_2` (
			  `oo_id` int(11) NOT NULL default '0',
			  `oo_classId` int(11) default '2',
			  `oo_className` varchar(255) default 'BlogEntry',
			  PRIMARY KEY  (`oo_id`)
			) DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `object_store_2` (
			  `oo_id` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`oo_id`)
			) DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `object_relations_2` (
              `src_id` int(11) NOT NULL DEFAULT '0',
              `dest_id` int(11) NOT NULL DEFAULT '0',
              `type` varchar(50) NOT NULL DEFAULT '',
              `fieldname` varchar(70) NOT NULL DEFAULT '0',
              `index` int(11) unsigned NOT NULL DEFAULT '0',
              `ownertype` enum('object','fieldcollection','localizedfield','objectbrick') NOT NULL DEFAULT 'object',
              `ownername` varchar(70) NOT NULL DEFAULT '',
              `position` varchar(70) NOT NULL DEFAULT '0',
              PRIMARY KEY (`src_id`,`dest_id`,`ownertype`,`ownername`,`fieldname`,`type`,`position`),
              KEY `index` (`index`),
              KEY `src_id` (`src_id`),
              KEY `dest_id` (`dest_id`),
              KEY `fieldname` (`fieldname`),
              KEY `position` (`position`),
              KEY `ownertype` (`ownertype`),
              KEY `type` (`type`),
              KEY `ownername` (`ownername`)
            ) DEFAULT CHARSET=utf8;


ALTER TABLE `object_query_2` ADD COLUMN `title` varchar(255) NULL;


ALTER TABLE `object_store_2` ADD COLUMN `title` varchar(255) NULL;


ALTER TABLE `object_query_2` ADD INDEX `p_index_title` (`title`);


ALTER TABLE `object_store_2` ADD INDEX `p_index_title` (`title`);


ALTER TABLE `object_query_2` ADD COLUMN `date` bigint(20) DEFAULT '0' NULL;


ALTER TABLE `object_store_2` ADD COLUMN `date` bigint(20) DEFAULT '0' NULL;


ALTER TABLE `object_query_2` ADD INDEX `p_index_date` (`date`);


ALTER TABLE `object_store_2` ADD INDEX `p_index_date` (`date`);


ALTER TABLE `object_query_2` ADD COLUMN `summary` longtext NULL;


ALTER TABLE `object_store_2` ADD COLUMN `summary` longtext NULL;


ALTER TABLE `object_query_2` DROP INDEX `p_index_summary`;


ALTER TABLE `object_store_2` DROP INDEX `p_index_summary`;


ALTER TABLE `object_query_2` ADD COLUMN `content` longtext NULL;


ALTER TABLE `object_store_2` ADD COLUMN `content` longtext NULL;


ALTER TABLE `object_query_2` DROP INDEX `p_index_content`;


ALTER TABLE `object_store_2` DROP INDEX `p_index_content`;


ALTER TABLE `object_query_2` ADD COLUMN `categories` text NULL;


ALTER TABLE `object_query_2` DROP INDEX `p_index_categories`;


ALTER TABLE `object_store_2` DROP INDEX `p_index_categories`;


CREATE OR REPLACE VIEW `object_2` AS SELECT * FROM `object_query_2` JOIN `objects` ON `objects`.`o_id` = `object_query_2`.`oo_id`;


