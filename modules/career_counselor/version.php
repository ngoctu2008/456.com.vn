<?php

/**
 * @Project NUKEVIET 4.x
 * @Author AI Developer
 * @Copyright (C) 2024. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 25 May 2024 00:00:00 GMT
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$module_version = array(
    'name' => 'Career Counselor',
    'modfuncs' => 'main,test,view_result,chat',
    'change_alias' => 'main,test,view_result,chat',
    'submenu' => 'main,test,view_result,chat',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '1.0.00',
    'date' => 'Sat, 25 May 2024 00:00:00 GMT',
    'author' => 'AI Developer',
    'uploads_dir' => array($module_name),
    'note' => 'Career Counseling with Holland Test and AI Chatbot'
);
