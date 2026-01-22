<?php

/**
 * @Project NUKEVIET 4.x
 * @Author AI Developer
 * @Copyright (C) 2024. All rights reserved
 * @License GNU/GPL version 2 or any later version
 */

if (!defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

$sql_drop_module = array();
$array_table = array(
    'questions',
    'results',
    'chat_sessions',
    'chat_messages',
    'career_data'
);

$table = $db_config['prefix'] . '_' . $lang . '_' . $module_data;
$result = $db->query('SHOW TABLE STATUS LIKE ' . $db->quote($table . '_%'));
while ($item = $result->fetch()) {
    $name = substr($item['name'], strlen($table) + 1);
    if (preg_match('/^' . $db_config['prefix'] . '\_' . $lang . '\_' . $module_data . '\_/', $item['name']) and (in_array($name, $array_table))) {
        $sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $item['name'];
    }
}

$sql_create_module = $sql_drop_module;

// Table _questions
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_questions` (
    id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    content text NOT NULL,
    group_code varchar(1) NOT NULL,
    weight int(11) NOT NULL DEFAULT '1',
    status tinyint(4) NOT NULL DEFAULT '1',
    PRIMARY KEY (id),
    KEY group_code (group_code)
) ENGINE=MyISAM";

// Table _results
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_results` (
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    userid int(11) unsigned NOT NULL DEFAULT '0',
    test_date int(11) unsigned NOT NULL DEFAULT '0',
    scores_json text NOT NULL,
    dominant_group varchar(255) NOT NULL DEFAULT '',
    summary_text text,
    PRIMARY KEY (id),
    KEY userid (userid)
) ENGINE=MyISAM";

// Table _chat_sessions
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_chat_sessions` (
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    userid int(11) unsigned NOT NULL DEFAULT '0',
    session_token varchar(255) NOT NULL,
    created_at int(11) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (id),
    UNIQUE KEY session_token (session_token),
    KEY userid (userid)
) ENGINE=MyISAM";

// Table _chat_messages
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_chat_messages` (
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    session_id int(11) unsigned NOT NULL DEFAULT '0',
    sender varchar(10) NOT NULL DEFAULT 'user',
    message text NOT NULL,
    timestamp int(11) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (id),
    KEY session_id (session_id)
) ENGINE=MyISAM";

// Table _career_data
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_career_data` (
    id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    title varchar(250) NOT NULL,
    content text,
    keywords text,
    PRIMARY KEY (id),
    KEY title (title)
) ENGINE=MyISAM";

// Config defaults
$sql_create_module[] = "INSERT IGNORE INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'api_key', '')";
$sql_create_module[] = "INSERT IGNORE INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'api_model', 'gpt-3.5-turbo')";
$sql_create_module[] = "INSERT IGNORE INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'system_prompt', 'You are a friendly career counselor.')";
