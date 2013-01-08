<?php

include_once(dirname(__FILE__) . "/../pimcore/cli/startup.php");

// get db connection
$db = Pimcore_Resource::get();

function sendQuery ($sql) {
    try {
        $db = Pimcore_Resource::get();
        $db->query($sql);
    } catch (Exception $e) {
        echo $e->getMessage();
        echo "Please execute the following query manually: <br />";
        echo "<pre>" . $sql . "</pre><hr />";
    }
}

#1520
$db->query("ALTER TABLE `documents_hardlink` DROP COLUMN `inheritedPropertiesFromSource`;");

#1566
$db->query("CREATE TABLE `documents_email` (
  `id` int(11) unsigned NOT NULL DEFAULT '0',
  `controller` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `template` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `cc` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;");

#1568,1572
$db->query("CREATE TABLE IF NOT EXISTS `email_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `documentId` int(11) DEFAULT NULL,
  `requestUri` varchar(255) DEFAULT NULL,
  `params` text,
  `from` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `cc` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `sentDate` bigint(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

#1582
sendQuery("ALTER TABLE `documents_page` ADD COLUMN `module` varchar(255) NULL DEFAULT NULL AFTER `id`;");
sendQuery("ALTER TABLE `documents_snippet` ADD COLUMN `module` varchar(255) NULL DEFAULT NULL AFTER `id`;");
sendQuery("ALTER TABLE `documents_email` ADD COLUMN `module` varchar(255) NULL DEFAULT NULL AFTER `id`;");
sendQuery("ALTER TABLE `documents_doctypes` ADD COLUMN `module` varchar(255) NULL DEFAULT NULL AFTER `name`;");

#1612
sendQuery("ALTER TABLE `search_backend_data` DROP INDEX `fulltext`;");
sendQuery("ALTER TABLE `search_backend_data` DROP INDEX `fieldcollectiondata`;");
sendQuery("ALTER TABLE `search_backend_data` DROP INDEX `localizeddata`;");
sendQuery("ALTER TABLE `search_backend_data` DROP COLUMN `fieldcollectiondata`;");
sendQuery("ALTER TABLE `search_backend_data` DROP COLUMN `localizeddata`;");
sendQuery("ALTER TABLE `search_backend_data` ADD FULLTEXT INDEX `fulltext` (`data`,`properties`,`fullpath`);");
echo "Please execute the script /pimcore/cli/search-backend-reindex.php manually on the commandline!\n";

#1614
$classList = new Object_Class_List();
$classes = $classList->load();
if(is_array($classes)){
    foreach($classes as $class){
        $class->save();
    }
}

#1615
$list = new Object_Fieldcollection_Definition_List();
$list = $list->load();
foreach ($list as $fc) {
    $fc->save();
}

#1616
$list = new Object_Objectbrick_Definition_List();
$list = $list->load();
foreach ($list as $fc) {
    $fc->save();
}

#1618
sendQuery("ALTER TABLE `search_backend_data` DROP INDEX `fulltext`;");
sendQuery("ALTER TABLE `search_backend_data` ADD FULLTEXT INDEX `fulltext` (`data`,`properties`);");

#1630
sendQuery("DELETE FROM `users` WHERE hasCredentials != 1;");
sendQuery("ALTER TABLE `users` DROP COLUMN `hasCredentials`;");
sendQuery("UPDATE `users` SET `active` = 0 WHERE `admin` != 1;");
sendQuery("ALTER TABLE `users` ADD COLUMN `type` enum('user','userfolder','role','rolefolder') NOT NULL DEFAULT 'user' AFTER `parentId`;");
sendQuery("ALTER TABLE `users` CHANGE COLUMN `username` `name` varchar(50) NULL DEFAULT NULL;");
sendQuery("ALTER TABLE `users` ADD COLUMN `permissions` varchar(1000) NULL DEFAULT NULL;");
sendQuery("ALTER TABLE `users` ADD COLUMN `roles` varchar(1000) NULL DEFAULT NULL;");
sendQuery("DELETE FROM `users_permission_definitions` WHERE `key`='update';");
sendQuery("DELETE FROM `users_permission_definitions` WHERE `key`='users';");
sendQuery("DELETE FROM `users_permission_definitions` WHERE `key`='forms';");
sendQuery("ALTER TABLE `users_permission_definitions` DROP COLUMN `translation`;");
sendQuery("DROP TABLE `users_permissions`;");

sendQuery("CREATE TABLE `users_workspaces_asset` (
  `cid` int(11) unsigned DEFAULT NULL,
  `cpath` varchar(255) DEFAULT NULL,
  `userId` int(11) unsigned DEFAULT NULL,
  `list` tinyint(1) DEFAULT '0',
  `view` tinyint(1) DEFAULT '0',
  `publish` tinyint(1) DEFAULT '0',
  `delete` tinyint(1) DEFAULT '0',
  `rename` tinyint(1) DEFAULT '0',
  `create` tinyint(1) DEFAULT '0',
  `settings` tinyint(1) DEFAULT '0',
  `versions` tinyint(1) DEFAULT '0',
  `properties` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cid`, `userId`),
  KEY `cid` (`cid`),
  KEY `userId` (`userId`)
) DEFAULT CHARSET=utf8;");

sendQuery("CREATE TABLE `users_workspaces_document` (
  `cid` int(11) unsigned DEFAULT NULL,
  `cpath` varchar(255) DEFAULT NULL,
  `userId` int(11) unsigned DEFAULT NULL,
  `list` tinyint(1) unsigned DEFAULT '0',
  `view` tinyint(1) unsigned DEFAULT '0',
  `save` tinyint(1) unsigned DEFAULT '0',
  `publish` tinyint(1) unsigned DEFAULT '0',
  `unpublish` tinyint(1) unsigned DEFAULT '0',
  `delete` tinyint(1) unsigned DEFAULT '0',
  `rename` tinyint(1) unsigned DEFAULT '0',
  `create` tinyint(1) unsigned DEFAULT '0',
  `settings` tinyint(1) unsigned DEFAULT '0',
  `versions` tinyint(1) unsigned DEFAULT '0',
  `properties` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`cid`, `userId`),
  KEY `cid` (`cid`),
  KEY `userId` (`userId`)
) DEFAULT CHARSET=utf8;");

sendQuery("CREATE TABLE `users_workspaces_object` (
  `cid` int(11) unsigned DEFAULT NULL,
  `cpath` varchar(255) DEFAULT NULL,
  `userId` int(11) unsigned DEFAULT NULL,
  `list` tinyint(1) unsigned DEFAULT '0',
  `view` tinyint(1) unsigned DEFAULT '0',
  `save` tinyint(1) unsigned DEFAULT '0',
  `publish` tinyint(1) unsigned DEFAULT '0',
  `unpublish` tinyint(1) unsigned DEFAULT '0',
  `delete` tinyint(1) unsigned DEFAULT '0',
  `rename` tinyint(1) unsigned DEFAULT '0',
  `create` tinyint(1) unsigned DEFAULT '0',
  `settings` tinyint(1) unsigned DEFAULT '0',
  `versions` tinyint(1) unsigned DEFAULT '0',
  `properties` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`cid`, `userId`),
  KEY `cid` (`cid`),
  KEY `userId` (`userId`)
) DEFAULT CHARSET=utf8;");


sendQuery("RENAME TABLE `assets_permissions` TO `PLEASE_DELETE__assets_permissions`;");
sendQuery("RENAME TABLE `documents_permissions` TO `PLEASE_DELETE__documents_permissions`;");
sendQuery("RENAME TABLE `objects_permissions` TO `PLEASE_DELETE__objects_permissions`;");

#1632
sendQuery("ALTER TABLE `users` ADD UNIQUE INDEX `name` (`name`(50)), DROP INDEX `username`;");

#1635
sendQuery("ALTER TABLE `users` DROP INDEX `name`;");
sendQuery("ALTER TABLE `users` ADD UNIQUE INDEX `type_name` (`type`,`name`);");
sendQuery("ALTER TABLE `users` ADD INDEX `name` (`name`);");
sendQuery("ALTER TABLE `users` ADD INDEX `password` (`password`);");

#1645
sendQuery("ALTER TABLE `documents_page` ADD COLUMN `prettyUrl` varchar(255) NULL DEFAULT NULL;");
sendQuery("ALTER TABLE `documents_page` ADD UNIQUE INDEX `prettyUrl` (`prettyUrl`(255));");

#1649
sendQuery("UPDATE `users` SET `parentId` = 0 WHERE `admin` != 1;");

#1657
sendQuery("ALTER TABLE `documents_page` DROP INDEX `prettyUrl`;");
sendQuery("ALTER TABLE `documents_page` ADD INDEX `prettyUrl` (`prettyUrl`);");

#1659
sendQuery("ALTER TABLE `glossary` ADD COLUMN `casesensitive` tinyint(1) NULL DEFAULT NULL AFTER `language`;");

#1672
sendQuery("ALTER TABLE `users` ADD COLUMN `welcomescreen` tinyint(1) NULL DEFAULT NULL;");

#1708
// valid languages is new in system config
$configArray = Pimcore_Config::getSystemConfig()->toArray();
$configArray["documents"]["error_pages"]["default"] = Pimcore_Config::getSystemConfig()->documents->error_page;
$configArray = array_htmlspecialchars($configArray);

$config = new Zend_Config($configArray,true);
$writer = new Zend_Config_Writer_Xml(array(
	"config" => $config,
	"filename" => PIMCORE_CONFIGURATION_SYSTEM
));
$writer->write();

#1710
sendQuery("ALTER TABLE `classes` ADD COLUMN `description` text NULL AFTER `name`;");
