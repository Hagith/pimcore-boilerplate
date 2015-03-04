<?php

include_once(dirname(__FILE__) . "/../pimcore/cli/startup.php");

// get db connection
$db = Pimcore_Resource::get();

# 3207
try {
    $db->query("CREATE TABLE `keyvalue_translator_configuration` (
      `id` INT(10) NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(200) NULL DEFAULT NULL,
      `translator` VARCHAR(200) NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) DEFAULT CHARSET=utf8;");
} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
}

# 3208
try {
    $config = Pimcore_Config::getReportConfig()->toArray();
    if (isset($config["analytics"]) && is_array($config["analytics"]["sites"])) {
        foreach ($config["analytics"]["sites"] as $siteKey => &$siteConfig) {
            if (!$siteConfig["universalcode"]) {
                $siteConfig["asynchronouscode"] = 1;
            }
        }
    }
    $config = new Zend_Config($config, true);
    $writer = new Zend_Config_Writer_Xml(array(
        "config" => $config,
        "filename" => PIMCORE_CONFIGURATION_DIRECTORY . "/reports.xml"
    ));
    $writer->write();
} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
}

# 3210
try {
    // objectsmetadata inside localized fields/bricks/fieldcollection
    $tables = $db->fetchAll("SHOW TABLES LIKE 'object_metadata_%'");
    foreach ($tables as $table) {
        $t = current($table);
        $sql = "ALTER TABLE `" . $t . "`
        ADD COLUMN `ownertype` ENUM('object','fieldcollection','localizedfield','objectbrick') NOT NULL DEFAULT 'object' AFTER `data`,
        ADD COLUMN `ownername` VARCHAR(70) NOT NULL DEFAULT '' AFTER `ownertype`,
        ADD COLUMN `position` VARCHAR(70) NOT NULL DEFAULT '0' AFTER `ownername`,
        DROP PRIMARY KEY,
        ADD PRIMARY KEY (`o_id`, `dest_id`, `fieldname`, `column`, `ownertype`, `ownername`, `position`),
        ADD INDEX `ownertype` (`ownertype`),
        ADD INDEX `ownername` (`ownername`),
        ADD INDEX `position` (`position`);";
        $db->query($sql);
    }
} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
}

# 3213
try {
    $db->query("ALTER TABLE `assets_metadata`
	    CHANGE COLUMN `type` `type` ENUM('input','textarea','asset','document','object','date') DEFAULT NULL AFTER `language`;");
} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
}

# 3214
try {
    $db->query("DROP TABLE IF EXISTS `assets_metadata_predefined`;");
    $db->query("CREATE TABLE `assets_metadata_predefined` (
                      `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                      `name` VARCHAR(255) DEFAULT NULL,
                      `description` TEXT,
                      `language` VARCHAR(255) DEFAULT NULL,
                      `type` ENUM('input','textarea','asset','document','object','date') DEFAULT NULL,
                      `data` TEXT,
                      `targetSubtype` ENUM('image', 'text', 'audio', 'video', 'document', 'archive', 'unknown') DEFAULT NULL,
                      `creationDate` BIGINT(20) UNSIGNED DEFAULT '0',
                      `modificationDate` BIGINT(20) UNSIGNED DEFAULT '0',
                      PRIMARY KEY (`id`),
                      KEY `name` (`name`),
                      KEY `id` (`id`),
                      KEY `type` (`type`),
                      KEY `language` (`language`),
                      KEY `targetSubtype` (`targetSubtype`)
                    ) DEFAULT CHARSET=utf8;");
} catch (\Exception $e) {
    echo $e->getMessage();
}

# 3221
try {
    $db->query("ALTER TABLE `users_workspaces_asset` CHANGE COLUMN `userId` `userId` INT(11) NOT NULL DEFAULT 0;");
    $db->query("ALTER TABLE `users_workspaces_document` CHANGE COLUMN `userId` `userId` INT(11) NOT NULL DEFAULT 0;");
    $db->query("ALTER TABLE `users_workspaces_object` CHANGE COLUMN `userId` `userId` INT(11) NOT NULL DEFAULT 0;");
} catch (\Exception $e) {
    echo $e->getMessage();
}
