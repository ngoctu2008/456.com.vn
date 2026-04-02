<?php

/**
 * @Project NUKEVIET 4.x
 * @Author AI Developer
 * @Copyright (C) 2024. All rights reserved
 * @License GNU/GPL version 2 or any later version
 */

if (!defined('NV_IS_MOD_CAREER_COUNSELOR')) {
    die('Stop!!!');
}

if (!defined('NV_IS_USER')) {
    Header("Location: " . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . $lang . "&" . NV_NAME_VARIABLE . "=users&" . NV_OP_VARIABLE . "=login");
    die();
}

$id = $nv_Request->get_int('id', 'get', 0);
if ($id == 0) {
    // Get latest result
    $sql = "SELECT id FROM `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_results` WHERE userid=" . $user_info['userid'] . " ORDER BY test_date DESC LIMIT 1";
    $result = $db->query($sql);
    $row = $result->fetch();
    if ($row) {
        $id = $row['id'];
    } else {
        // Redirect to test if no result
        Header("Location: " . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . $lang . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=test");
        die();
    }
}

$sql = "SELECT * FROM `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_results` WHERE id=" . $id . " AND userid=" . $user_info['userid'];
$row = $db->query($sql)->fetch();

if (!$row) {
    die("Result not found or access denied.");
}

$contents = nv_theme_career_counselor_view_result($row);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
