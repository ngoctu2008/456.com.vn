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

$page_title = $lang_module['questions'];

// Handle Delete
if ($nv_Request->isset_request('del_id', 'post')) {
    if (!nv_check_valid_request('del_id', 'post', '')) {
         die('Invalid Request');
    }

    $id = $nv_Request->get_int('del_id', 'post', 0);

    if ($id > 0) {
        $db->query("DELETE FROM `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_questions` WHERE id=" . $id);
        $nv_Cache->delMod($module_name);
        Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . $lang . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=questions");
        die();
    }
}

// Handle Add/Edit
if ($nv_Request->isset_request('save', 'post')) {
    if (!nv_check_valid_request('id', 'post', '')) {
         die('Invalid Request');
    }

    $id = $nv_Request->get_int('id', 'post', 0);
    $content = $nv_Request->get_string('content', 'post', '');
    $group_code = $nv_Request->get_string('group_code', 'post', '');
    $weight = $nv_Request->get_int('weight', 'post', 1);

    if (!empty($content) && !empty($group_code)) {
        if ($id > 0) {
            $stmt = $db->prepare("UPDATE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_questions` SET content=:content, group_code=:group_code, weight=:weight WHERE id=:id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            $stmt = $db->prepare("INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_questions` (content, group_code, weight) VALUES (:content, :group_code, :weight)");
        }
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':group_code', $group_code, PDO::PARAM_STR);
        $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
        $stmt->execute();

        $nv_Cache->delMod($module_name);
        Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . $lang . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=questions");
        die();
    }
}

$xtpl = new XTemplate("questions.tpl", NV_ROOTDIR . "/themes/" . $global_config['admin_theme'] . "/modules/" . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('URL_SUBMIT', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . $lang . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=questions");

// List Questions
$sql = "SELECT * FROM `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_questions` ORDER BY group_code ASC, id ASC";
$result = $db->query($sql);
while ($row = $result->fetch()) {
    $row['link_edit'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . $lang . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=questions&id=" . $row['id'];
    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.loop');
}

// Edit Form Data
$id = $nv_Request->get_int('id', 'get', 0);
$row = array('id' => 0, 'content' => '', 'group_code' => '', 'weight' => 1);
if ($id > 0) {
    $row = $db->query("SELECT * FROM `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_questions` WHERE id=" . $id)->fetch();
}
$xtpl->assign('FORM', $row);

// Group Options
$groups = array('R', 'I', 'A', 'S', 'E', 'C');
foreach ($groups as $g) {
    $xtpl->assign('GROUP', array('key' => $g, 'selected' => ($g == $row['group_code']) ? 'selected="selected"' : ''));
    $xtpl->parse('main.group_loop');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
