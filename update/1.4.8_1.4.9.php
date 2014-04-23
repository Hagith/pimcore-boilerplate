<?php

include_once(dirname(__FILE__) . "/../pimcore/cli/startup.php");

// get db connection
$db = Pimcore_Resource_Mysql::get();
$db->beginTransaction();

# 2355
$db->query("ALTER TABLE `users` ADD COLUMN `memorizeTabs` tinyint(1) NULL DEFAULT NULL;");
$db->query("UPDATE `users` SET `memorizeTabs`=1;");

# 2363
$htaccessFile = PIMCORE_DOCUMENT_ROOT . "/.htaccess";
$newHtaccessContent = '

# mime types
AddType video/mp4 .mp4
AddType video/webm .webm

# rewrites
RewriteEngine On

RewriteBase /

<IfModule mod_status.c>
    RewriteCond %{REQUEST_URI} ^/(server-info|server-status)
    RewriteRule . - [last]
</IfModule>

# ASSETS: check if request method is GET (because of WebDAV) and if the requested file (asset) exists on the filesystem, if both match, deliver the asset directly
RewriteCond %{REQUEST_METHOD} ^GET
RewriteCond %{DOCUMENT_ROOT}/website/var/assets%{REQUEST_URI} -f
RewriteRule ^(.*)$ /website/var/assets%{REQUEST_URI} [PT,L]

# allow access to thumnails, assets and plugin-data
RewriteRule ^website/var/tmp.* - [PT,L]
RewriteRule ^website/var/assets.* - [PT,L]
RewriteRule ^website/var/plugins.* - [PT,L]
RewriteRule ^website/var/areas.* - [PT,L]
RewriteRule ^plugins/.*/static.* - [PT,L]
RewriteRule ^pimcore/static.* - [PT,L]

# forbid the direct access to pimcore-internal data (eg. config-files, ...)
RewriteRule ^website/var/.*$ / [F,L]
RewriteRule ^plugins/.*$ / [F,L]
RewriteRule ^pimcore/.*$ / [F,L]

# basic zend-framework setup see: http://framework.zend.com/manual/en/zend.controller.html
RewriteCond %{REQUEST_FILENAME} -d [OR]
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l [OR]
RewriteCond %{REQUEST_FILENAME} -f
RewriteRule ^.*$ - [NC,L]
RewriteRule ^.*$ index.php [NC,L]

';

// try to write the .htaccess file
if(is_writable($htaccessFile)) {
    file_put_contents($htaccessFile, $newHtaccessContent);
} else {
    echo "Please update your htaccess-file to: <br /><br /><code>" . nl2br($newHtaccessContent) . "</code>";
}

# 2369 - duplicated with 2355
//$db->query("ALTER TABLE `users` ADD COLUMN `memorizeTabs` tinyint(1) NULL DEFAULT NULL;");

# 2380 // key/value datatype
$db->query("CREATE TABLE IF NOT EXISTS `keyvalue_groups` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL ,
    `description` VARCHAR(255),
    PRIMARY KEY  (`id`)
    ) DEFAULT CHARSET=utf8;");

$db->query(
    "CREATE TABLE IF NOT EXISTS `keyvalue_keys` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL ,
    `description` TEXT,
    `type` enum('bool','number','select','text') DEFAULT NULL,
    `unit` VARCHAR(255),
    `possiblevalues` TEXT,
    `group` INT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`group`) REFERENCES keyvalue_groups(`id`) ON DELETE SET NULL
    ) DEFAULT CHARSET=utf8;");

# 2403
$db->query("CREATE TABLE `content_index` (
  `id` varchar(32) NOT NULL DEFAULT '',
  `site` int(11) DEFAULT NULL,
  `url` varchar(2000) NOT NULL DEFAULT '',
  `content` longtext,
  `type` enum('document','route') DEFAULT NULL,
  `typeReference` int(11) DEFAULT NULL,
  `lastUpdate` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;");

# 2405
$db->query("DROP TABLE IF EXISTS `content_analysis`;");
$db->query("CREATE TABLE `content_analysis` (
  `id` varchar(44) NOT NULL DEFAULT '',
  `host` varchar(255) DEFAULT NULL,
  `site` int(11) DEFAULT NULL,
  `url` varchar(2000) NOT NULL DEFAULT '',
  `type` enum('document','route') DEFAULT NULL,
  `typeReference` int(11) DEFAULT NULL,
  `facebookShares` int(11) DEFAULT NULL,
  `googlePlusOne` int(11) DEFAULT NULL,
  `links` int(5) DEFAULT NULL,
  `linksExternal` int(5) DEFAULT NULL,
  `h1` int(3) DEFAULT NULL,
  `h2` int(3) DEFAULT NULL,
  `h3` int(3) DEFAULT NULL,
  `h4` int(3) DEFAULT NULL,
  `h5` int(3) DEFAULT NULL,
  `h6` int(3) DEFAULT NULL,
  `h1Text` varchar(1000) DEFAULT NULL,
  `imgWithoutAlt` int(3) DEFAULT NULL,
  `imgWithAlt` int(3) DEFAULT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `urlLength` int(4) DEFAULT NULL,
  `urlParameters` int(2) DEFAULT NULL,
  `microdata` int(3) DEFAULT NULL,
  `opengraph` int(3) DEFAULT NULL,
  `twitter` int(3) DEFAULT NULL,
  `robotsTxtBlocked` tinyint(1) DEFAULT NULL,
  `robotsMetaBlocked` tinyint(1) DEFAULT NULL,
  `lastUpdate` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `host` (`host`),
  KEY `lastUpdate` (`lastUpdate`),
  KEY `site` (`site`)
) DEFAULT CHARSET=utf8;");

$db->query("DROP TABLE IF EXISTS `content_index`;");
$db->query("CREATE TABLE `content_index` (
  `id` varchar(44) NOT NULL DEFAULT '',
  `site` int(11) DEFAULT NULL,
  `url` varchar(2000) NOT NULL DEFAULT '',
  `content` longtext,
  `type` enum('document','route') DEFAULT NULL,
  `typeReference` int(11) DEFAULT NULL,
  `lastUpdate` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lastUpdate` (`lastUpdate`)
) DEFAULT CHARSET=utf8;");

# 2408
$db->query("DROP TABLE IF EXISTS `tracking_events`;");
$db->query("CREATE TABLE `tracking_events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `timestamp` bigint(20) unsigned DEFAULT NULL,
  `year` int(5) unsigned DEFAULT NULL,
  `month` int(2) unsigned DEFAULT NULL,
  `day` int(2) unsigned DEFAULT NULL,
  `dayOfWeek` int(1) unsigned DEFAULT NULL,
  `dayOfYear` int(3) unsigned DEFAULT NULL,
  `weekOfYear` int(2) unsigned DEFAULT NULL,
  `hour` int(2) unsigned DEFAULT NULL,
  `minute` int(2) unsigned DEFAULT NULL,
  `second` int(2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`),
  KEY `year` (`year`),
  KEY `month` (`month`),
  KEY `day` (`day`),
  KEY `dayOfWeek` (`dayOfWeek`),
  KEY `dayOfYear` (`dayOfYear`),
  KEY `weekOfYear` (`weekOfYear`),
  KEY `hour` (`hour`),
  KEY `minute` (`minute`),
  KEY `second` (`second`),
  KEY `category` (`category`),
  KEY `action` (`action`),
  KEY `label` (`label`),
  KEY `value` (`value`)
) DEFAULT CHARSET=utf8;");

# 2409
$db->query("DROP TABLE IF EXISTS `tracking_events`;");
$db->query("CREATE TABLE `tracking_events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `timestamp` bigint(20) unsigned DEFAULT NULL,
  `year` int(5) unsigned DEFAULT NULL,
  `month` int(2) unsigned DEFAULT NULL,
  `day` int(2) unsigned DEFAULT NULL,
  `dayOfWeek` int(1) unsigned DEFAULT NULL,
  `dayOfYear` int(3) unsigned DEFAULT NULL,
  `weekOfYear` int(2) unsigned DEFAULT NULL,
  `hour` int(2) unsigned DEFAULT NULL,
  `minute` int(2) unsigned DEFAULT NULL,
  `second` int(2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`),
  KEY `year` (`year`),
  KEY `month` (`month`),
  KEY `day` (`day`),
  KEY `dayOfWeek` (`dayOfWeek`),
  KEY `dayOfYear` (`dayOfYear`),
  KEY `weekOfYear` (`weekOfYear`),
  KEY `hour` (`hour`),
  KEY `minute` (`minute`),
  KEY `second` (`second`),
  KEY `category` (`category`),
  KEY `action` (`action`),
  KEY `label` (`label`),
  KEY `data` (`data`)
) DEFAULT CHARSET=utf8;");

# 2423
$db->query("ALTER TABLE `documents_page` ADD COLUMN `metaData` text NULL AFTER `keywords`;");

#2454
$db->query("ALTER TABLE `documents_page` ADD COLUMN `css` longtext NULL;");

# 2492
$list = new Object_Class_List();
$classes = $list->load();
if(!empty($classes)){
    foreach($classes as $class){
        $class->save();
    }
}

# 2508
// valid languages is new in system config
$configArray = Pimcore_Config::getSystemConfig()->toArray();
$configArray["general"]["custom_php_logfile"] = "1";
$configArray = array_htmlspecialchars($configArray);

$config = new Zend_Config($configArray,true);
$writer = new Zend_Config_Writer_Xml(array(
    "config" => $config,
    "filename" => PIMCORE_CONFIGURATION_SYSTEM
));
$writer->write();

# 2526
$db->query("ALTER TABLE `keyvalue_keys` CHANGE COLUMN `type` `type` ENUM('bool','number','select','text','translated') NULL DEFAULT NULL AFTER `description`;");

# 2530
$db->query("ALTER TABLE `keyvalue_keys` ADD COLUMN `translator` INT NULL AFTER `group`;");

# 2539
$db->query("INSERT INTO `users_permission_definitions` VALUES ('document_style_editor');");
$db->query("INSERT INTO `users_permission_definitions` VALUES ('recyclebin');");
$db->query("INSERT INTO `users_permission_definitions` VALUES ('seo_document_editor');");
$db->query("INSERT INTO `users_permission_definitions` VALUES ('robots.txt');");
$db->query("INSERT INTO `users_permission_definitions` VALUES ('http_errors');");
$db->query("INSERT INTO `users_permission_definitions` VALUES ('tag_snippet_management');");
$db->query("INSERT INTO `users_permission_definitions` VALUES ('qr_codes');");
$db->query("INSERT INTO `users_permission_definitions` VALUES ('targeting');");
$db->query("INSERT INTO `users_permission_definitions` VALUES ('notes_events');");
$db->query("INSERT INTO `users_permission_definitions` VALUES ('backup');");
$db->query("INSERT INTO `users_permission_definitions` VALUES ('bounce_mail_inbox');");
$db->query("INSERT INTO `users_permission_definitions` VALUES ('website_settings');");

# 2547
$db->query("INSERT INTO `users_permission_definitions` VALUES ('newsletter');");

$db->commit();
