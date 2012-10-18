<?php

include_once(dirname(__FILE__) . "/../pimcore/cli/startup.php");

// get db connection
$db = Pimcore_Resource_Mysql::get();
$db->beginTransaction();

# 2184
$db->query("ALTER TABLE `documents_page` ADD COLUMN `contentMasterDocumentId` int(11) NULL DEFAULT NULL;");
$db->query("ALTER TABLE `documents_snippet` ADD COLUMN `contentMasterDocumentId` int(11) NULL DEFAULT NULL;");

# 2190
$classList = new Object_Class_List();
$classes = $classList->load();
if(is_array($classes)){
    foreach($classes as $class){
		$hasMultiselect = false;
		foreach ($class->getFieldDefinitions() as $key => $value) {
			if($value instanceof Object_Class_Data_Multiselect) {
				$value->setQueryColumnType("text");
				$value->setColumnType("text");

                $hasMultiselect = true;
			}
		}

		if($hasMultiselect) {
			$class->save();
		}
    }
}

# 2191
$list = new Object_Fieldcollection_Definition_List();
$list = $list->load();

if(is_array($list)){
    foreach ($list as $fc) {
        $hasMultiselect = false;
        foreach ($fc->getFieldDefinitions() as $key => $value) {
            if($value instanceof Object_Class_Data_Multiselect) {
                $value->setQueryColumnType("text");
                $value->setColumnType("text");

                $hasMultiselect = true;
            }
        }

        if($hasMultiselect) {
            $fc->save();
        }
    }
}

# 2192
$list = new Object_Objectbrick_Definition_List();
$list = $list->load();

if(is_array($list)){
    foreach ($list as $brick) {
        $hasMultiselect = false;
        foreach ($brick->getFieldDefinitions() as $key => $value) {
            if($value instanceof Object_Class_Data_Multiselect) {
                $value->setQueryColumnType("text");
                $value->setColumnType("text");

                $hasMultiselect = true;
            }
        }

        if($hasMultiselect) {
            $brick->save();
        }
    }
}

# 2209
$db->query("DROP TABLE IF EXISTS `cache_tags`;");
$db->query("CREATE TABLE `cache_tags` (
  `id` varchar(165) NOT NULL DEFAULT '',
  `tag` varchar(165) NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`tag`),
  INDEX `id` (`id`),
  INDEX `tag` (`tag`)
) ENGINE=MEMORY;");


# 2214
$tables = $db->fetchAll("SHOW TABLES LIKE 'object_localized_data_%'");

foreach ($tables as $table) {
    $t = current($table);
    $db->query("ALTER TABLE `" . $t . "` CHANGE COLUMN `language` `language` varchar(10) NOT NULL DEFAULT '';");
}

# 2215
$db->query("ALTER TABLE `users` CHANGE COLUMN `language` `language` varchar(10) NULL DEFAULT NULL;");
$db->query("ALTER TABLE `glossary` CHANGE COLUMN `language` `language` varchar(10) NULL DEFAULT NULL;");

# 2236
$db->query("CREATE TABLE `targeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documentId` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `conditions` longtext,
  `actions` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_documentId` (`documentId`,`name`),
  KEY `documentId` (`documentId`)
) DEFAULT CHARSET=utf8;");

# 2237
$db->query("ALTER TABLE `documents_link` CHANGE COLUMN `direct` `direct` varchar(1000) NULL DEFAULT NULL;");

# 2247
$db->query("ALTER TABLE `staticroutes` ADD COLUMN `siteId` int(11) NULL DEFAULT NULL AFTER `defaults`;");

# 2299
$db->query("CREATE TABLE `locks` (
  `id` varchar(150) NOT NULL DEFAULT '',
  `date` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;");

$db->commit();
