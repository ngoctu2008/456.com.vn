<?php

/**
 * @Project NUKEVIET 4.x
 * @Author AI Developer
 * @Copyright (C) 2024. All rights reserved
 * @License GNU/GPL version 2 or any later version
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

define('NV_IS_MOD_CAREER_COUNSELOR', true);

// Include module functions
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

// Route the request
$op = $nv_Request->get_string('op', 'get', 'main');
if (empty($op)) {
    $op = 'main';
}

if (preg_match('/^([a-zA-Z0-9\-\_]+)$/', $op) and file_exists(NV_ROOTDIR . '/modules/' . $module_file . '/funcs/' . $op . '.php')) {
    include NV_ROOTDIR . '/modules/' . $module_file . '/funcs/' . $op . '.php';
} else {
    include NV_ROOTDIR . '/modules/' . $module_file . '/funcs/main.php';
}
