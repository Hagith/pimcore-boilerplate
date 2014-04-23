<?php

include_once(dirname(__FILE__) . "/../pimcore/cli/startup.php");

// get db connection
$db = Pimcore_Resource_Mysql::get();
$db->beginTransaction();

# 2570
$db->query("ALTER TABLE `redirects` ADD COLUMN `passThroughParameters` tinyint(1) NULL DEFAULT NULL AFTER `sourceSite`;");

# 2574
$db->query("ALTER TABLE `keyvalue_groups` CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL DEFAULT '' AFTER `id`;");
$db->query("ALTER TABLE `keyvalue_keys` CHANGE COLUMN `name` `name` VARCHAR(255) NOT NULL DEFAULT '' AFTER `id`;");

# 2605
$db->query("ALTER TABLE `targeting` DROP INDEX `name_documentId`;");
$db->query("ALTER TABLE `targeting` DROP INDEX `documentId`;");
$db->query("ALTER TABLE `targeting` DROP COLUMN `documentId`;");

# 2622
$db->query("ALTER TABLE `classes` ADD COLUMN `showVariants` TINYINT(1) NULL AFTER `propertyVisibility`;");

# 2626
$db->query("ALTER TABLE `documents` CHANGE COLUMN `index` `index` int(11) unsigned NULL DEFAULT 0;");

$db->commit();
