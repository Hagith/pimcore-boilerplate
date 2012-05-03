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

# 1808
sendQuery("CREATE TABLE `tree_locks` (
  `id` int(11) NOT NULL DEFAULT '0',
  `type` enum('asset','document','object') NOT NULL DEFAULT 'asset',
  `locked` enum('self','propagate') default NULL,
  PRIMARY KEY (`id`,`type`),
  KEY `id` (`id`),
  KEY `type` (`type`),
  KEY `locked` (`locked`)
) DEFAULT CHARSET=utf8;");

$db = Pimcore_Resource::get();

// assets
$assetLocks = $db->fetchAll("SELECT id,path,filename,locked FROM assets WHERE locked IS NOT NULL AND locked != ''");
foreach ($assetLocks as $lock) {
    $db->insert("tree_locks", array(
        "id" => $lock["id"],
        "type" => "asset",
        "locked" => $lock["locked"]
    ));
}
sendQuery("ALTER TABLE `assets` DROP COLUMN `locked`;");

// documents
$documentLocks = $db->fetchAll("SELECT id,path,`key`,locked FROM documents WHERE locked IS NOT NULL AND locked != ''");
foreach ($documentLocks as $lock) {
    $db->insert("tree_locks", array(
        "id" => $lock["id"],
        "type" => "document",
        "locked" => $lock["locked"]
    ));
}
sendQuery("ALTER TABLE `documents` DROP COLUMN `locked`;");

// objects
$ObjectLocks = $db->fetchAll("SELECT o_id,o_path,o_key,o_locked FROM objects WHERE o_locked IS NOT NULL AND o_locked != ''");
foreach ($ObjectLocks as $lock) {
    $db->insert("tree_locks", array(
        "id" => $lock["o_id"],
        "type" => "object",
        "locked" => $lock["o_locked"]
    ));
}
sendQuery("ALTER TABLE `objects` DROP COLUMN `o_locked`;");

# 1809
$classList = new Object_Class_List();
$classes = $classList->load();
if(is_array($classes)){
    foreach($classes as $class){
        $class->save();
    }
}

# 1828
sendQuery("ALTER TABLE `users` ADD COLUMN `closeWarning` tinyint(1) NULL DEFAULT NULL;");
$db->update("users", array("closeWarning" => 1), "type = 'user'");

# 1896
sendQuery("CREATE TABLE `http_error_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(1000) DEFAULT NULL,
  `code` int(3) DEFAULT NULL,
  `parametersGet` longtext,
  `parametersPost` longtext,
  `cookies` longtext,
  `serverVars` longtext,
  `date` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `path` (`path`(255)),
  KEY `code` (`code`),
  KEY `date` (`date`)
) DEFAULT CHARSET=utf8;");

# 1910
$tables = $db->fetchAll("SHOW TABLES LIKE 'object_relations_%'");
foreach ($tables as $table) {
    $t = current($table);
    $db->query("ALTER TABLE `" . $t . "` CHANGE COLUMN `position` `position` varchar(70) NULL DEFAULT NULL;");
}

# 1925
sendQuery("ALTER TABLE `redirects` ADD COLUMN `expiry` bigint(20) NULL DEFAULT NULL;");

# 1929
sendQuery("ALTER TABLE `glossary` ADD COLUMN `exactmatch` tinyint(1) NULL DEFAULT NULL AFTER `casesensitive`;");
