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

$page_title = $lang_module['config'];

if ($nv_Request->isset_request('save', 'post')) {
    $cfg = array();
    $cfg['api_key'] = $nv_Request->get_title('api_key', 'post', '');
    $cfg['api_model'] = $nv_Request->get_title('api_model', 'post', 'gpt-3.5-turbo');
    $cfg['system_prompt'] = $nv_Request->get_string('system_prompt', 'post', '');

    foreach ($cfg as $config_name => $config_value) {
        $db->query("REPLACE INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', '" . $config_name . "', " . $db->quote($config_value) . ")");
    }

    $nv_Cache->delMod($module_name);
    Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . $lang . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main");
    die();
}

$xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/themes/" . $global_config['admin_theme'] . "/modules/" . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

$config = array();
$config['api_key'] = $module_config[$module_name]['api_key'];
$config['api_model'] = $module_config[$module_name]['api_model'];
$config['system_prompt'] = $module_config[$module_name]['system_prompt'];

$xtpl->assign('CONFIG', $config);

$models = array('gpt-3.5-turbo', 'gpt-4', 'gemini-pro');
foreach ($models as $model) {
    $xtpl->assign('MODEL', array(
        'key' => $model,
        'selected' => ($config['api_model'] == $model) ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.model_loop');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
