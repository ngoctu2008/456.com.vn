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

function nv_theme_career_counselor_main($module_data) {
    global $module_info, $lang_module, $module_file, $global_config, $module_name;

    $xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
    $xtpl->assign('LANG', $lang_module);

    // Check if user has taken test, show button to view result or retake
    // For simplicity, just show intro and start button

    $xtpl->assign('URL_TEST', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=test");

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function nv_theme_career_counselor_test($module_data) {
    global $module_info, $lang_module, $module_file, $global_config, $module_name, $db, $db_config;

    $xtpl = new XTemplate("test.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('ACTION_URL', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=test");

    $sql = "SELECT * FROM " . $db_config['prefix'] . "_" . NV_LANG_DATA . "_" . $module_data . "_questions WHERE status=1 ORDER BY RAND()";
    $result = $db->query($sql);

    while ($row = $result->fetch()) {
        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function nv_theme_career_counselor_view_result($result_row) {
    global $module_info, $lang_module, $module_file, $global_config, $module_name;

    $xtpl = new XTemplate("view_result.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('RESULT', $result_row);
    $xtpl->assign('URL_CHAT', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=chat");

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function nv_theme_career_counselor_chat($module_data) {
    global $module_info, $lang_module, $module_file, $global_config, $module_name, $user_info, $db, $db_config;

    $xtpl = new XTemplate("chat.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('AJAX_URL', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=chat");

    // Load Chat History
    // Find latest session or session in request (simplified to latest for now)
    $sql = "SELECT id, session_token FROM " . $db_config['prefix'] . "_" . NV_LANG_DATA . "_" . $module_data . "_chat_sessions WHERE userid=" . $user_info['userid'] . " ORDER BY created_at DESC LIMIT 1";
    $session = $db->query($sql)->fetch();

    if ($session) {
        $xtpl->assign('SESSION_TOKEN', $session['session_token']);

        $sql_msg = "SELECT * FROM " . $db_config['prefix'] . "_" . NV_LANG_DATA . "_" . $module_data . "_chat_messages WHERE session_id=" . $session['id'] . " ORDER BY timestamp ASC";
        $result = $db->query($sql_msg);
        while ($msg = $result->fetch()) {
            $msg['sender_class'] = ($msg['sender'] == 'user') ? 'user' : 'ai';
            $msg['sender_name'] = ($msg['sender'] == 'user') ? $lang_module['you'] : 'AI';
            $msg['message'] = htmlspecialchars($msg['message']);
            $xtpl->assign('MSG', $msg);
            $xtpl->parse('main.message_loop');
        }
    } else {
        $xtpl->assign('SESSION_TOKEN', '');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}
