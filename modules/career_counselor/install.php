<?php

/**
 * @Project NUKEVIET 4.x
 * @Author AI Developer
 * @Copyright (C) 2024. All rights reserved
 * @License GNU/GPL version 2 or any later version
 */

// This file is provided for manual installation or reference.
// The primary installation logic is in action_mysql.php which is used by the NukeViet Module Manager.

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

// Ensure $db_config, $lang, $module_data are available or define placeholders if running standalone (not recommended)
// In a real NukeViet install context, these are globals.

// SQL Structure Reference
/*
CREATE TABLE `nv4_vi_career_counselor_questions` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `group_code` varchar(1) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `group_code` (`group_code`)
) ENGINE=MyISAM;

CREATE TABLE `nv4_vi_career_counselor_results` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `test_date` int(11) unsigned NOT NULL DEFAULT '0',
  `scores_json` text NOT NULL,
  `dominant_group` varchar(255) NOT NULL DEFAULT '',
  `summary_text` text,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM;

CREATE TABLE `nv4_vi_career_counselor_chat_sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `session_token` varchar(255) NOT NULL,
  `created_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_token` (`session_token`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM;

CREATE TABLE `nv4_vi_career_counselor_chat_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(11) unsigned NOT NULL DEFAULT '0',
  `sender` varchar(10) NOT NULL DEFAULT 'user',
  `message` text NOT NULL,
  `timestamp` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`)
) ENGINE=MyISAM;

CREATE TABLE `nv4_vi_career_counselor_career_data` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `content` text,
  `keywords` text,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=MyISAM;
*/
