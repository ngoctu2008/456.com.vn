<?php

/**
 * @Project NUKEVIET 4.x
 * @Author AI Developer
 * @Copyright (C) 2024. All rights reserved
 * @License GNU/GPL version 2 or any later version
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$page_title = $lang_module['reports'];

$xtpl = new XTemplate("reports.tpl", NV_ROOTDIR . "/themes/" . $global_config['admin_theme'] . "/modules/" . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

$sql = "SELECT r.*, u.username, u.first_name, u.last_name FROM `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_results` r LEFT JOIN " . $db_config['prefix'] . "_users u ON r.userid = u.userid ORDER BY r.test_date DESC";
$result = $db->query($sql);

while ($row = $result->fetch()) {
    $row['fullname'] = nv_show_name_user($row['first_name'], $row['last_name'], $row['username']);
    $row['test_date'] = nv_date('d/m/Y H:i', $row['test_date']);
    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.loop');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
