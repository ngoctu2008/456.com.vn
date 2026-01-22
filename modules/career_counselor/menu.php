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

$nv_menu = array();
$nv_menu[] = array(
    'title' => $lang_module['start_test'],
    'link' => NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=test",
    'alias' => $lang_module['start_test']
);

if (defined('NV_IS_USER')) {
     $nv_menu[] = array(
        'title' => $lang_module['your_result'],
        'link' => NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=view_result",
        'alias' => $lang_module['your_result']
    );
}
