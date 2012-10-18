<?php

include_once(dirname(__FILE__) . "/../pimcore/cli/startup.php");

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

# 1992
sendQuery("ALTER TABLE `glossary` ADD COLUMN `site` int(11) unsigned NULL DEFAULT NULL;");
sendQuery("ALTER TABLE `glossary` ADD INDEX `site` (`site`);");

# 2028
sendQuery("CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `ctype` enum('asset','document','object') DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` longtext,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `ctype` (`ctype`),
  KEY `date` (`date`)
) DEFAULT CHARSET=utf8;");


sendQuery("CREATE TABLE `events_data` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `type` enum('text','date','document','asset','object','bool') DEFAULT NULL,
  `data` text,
  KEY `id` (`id`)
) DEFAULT CHARSET=utf8;");

# 2034
sendQuery("RENAME TABLE `events` TO `notes`;");
sendQuery("RENAME TABLE `events_data` TO `notes_data`;");

# 2038
// get db connection
$db = Pimcore_Resource_Mysql::get();

// rename column "type" to "ctype" and create the new columns "type" and "position"
$tables = $db->fetchAll("SHOW TABLES LIKE 'object_relations_%'");

foreach ($tables as $table) {
    $t = current($table);
    $db->query("ALTER TABLE `" . $t . "` CHANGE COLUMN `position` `position` varchar(70) NULL DEFAULT NULL;");
}

# 2071
// valid languages is new in system config
$configArray = Pimcore_Config::getSystemConfig()->toArray();
$configArray["services"]["google"]["simpleapikey"] = Pimcore_Config::getSystemConfig()->services->googlemaps->apikey;
$configArray = array_htmlspecialchars($configArray);

$config = new Zend_Config($configArray,true);
$writer = new Zend_Config_Writer_Xml(array(
    "config" => $config,
    "filename" => PIMCORE_CONFIGURATION_SYSTEM
));
$writer->write();
