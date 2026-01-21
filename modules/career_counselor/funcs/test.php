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

if ($nv_Request->isset_request('submit_test', 'post')) {
    $answers = $nv_Request->get_array('answers', 'post', array());

    // Calculate Scores
    $scores = array('R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0);

    // Fetch all questions to map ID to group_code
    $questions = array();
    $sql = "SELECT id, group_code, weight FROM " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_questions WHERE status=1";
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
        $questions[$row['id']] = $row;
    }

    foreach ($answers as $qid => $val) {
        if (isset($questions[$qid]) && $val == 1) {
            $group = $questions[$qid]['group_code'];
            $weight = $questions[$qid]['weight'];
            if (isset($scores[$group])) {
                $scores[$group] += $weight;
            }
        }
    }

    // Identify dominant groups (Top 3)
    arsort($scores);
    $top3 = array_slice(array_keys($scores), 0, 3);
    $dominant_group = implode('-', $top3);

    $scores_json = json_encode($scores);

    $sql = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_results
            (userid, test_date, scores_json, dominant_group, summary_text)
            VALUES (:userid, :test_date, :scores_json, :dominant_group, '')";

    $stmt = $db->prepare($sql);
    $timestamp = NV_CURRENTTIME;
    $stmt->bindParam(':userid', $user_info['userid'], PDO::PARAM_INT);
    $stmt->bindParam(':test_date', $timestamp, PDO::PARAM_INT);
    $stmt->bindParam(':scores_json', $scores_json, PDO::PARAM_STR);
    $stmt->bindParam(':dominant_group', $dominant_group, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $insert_id = $db->lastInsertId();
        Header("Location: " . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . $lang . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=view_result&id=" . $insert_id);
        die();
    }
}

$contents = nv_theme_career_counselor_test($module_data);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
