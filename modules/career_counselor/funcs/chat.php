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
    die('Access Denied');
}

// Handle AJAX Request
if ($nv_Request->isset_request('ajax_action', 'post')) {
    $action = $nv_Request->get_string('ajax_action', 'post', '');

    if ($action == 'send_message') {
        $message = $nv_Request->get_string('message', 'post', '');
        $session_token = $nv_Request->get_string('session_token', 'post', '');

        if (empty($message)) {
            echo json_encode(array('status' => 'error', 'message' => 'Empty message'));
            die();
        }

        // Get Session
        $sql = "SELECT id, userid FROM " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_chat_sessions WHERE session_token=" . $db->quote($session_token);
        $row = $db->query($sql)->fetch();

        if (!$row || $row['userid'] != $user_info['userid']) {
             // Create new session if not exists or invalid
             $session_token = md5(uniqid($user_info['userid'], true));
             $stmt = $db->prepare("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_chat_sessions (userid, session_token, created_at) VALUES (:userid, :session_token, :created_at)");
             $stmt->bindParam(':userid', $user_info['userid'], PDO::PARAM_INT);
             $stmt->bindParam(':session_token', $session_token, PDO::PARAM_STR);
             $stmt->bindParam(':created_at', NV_CURRENTTIME, PDO::PARAM_INT);
             $stmt->execute();
             $session_id = $db->lastInsertId();
        } else {
             $session_id = $row['id'];
        }

        // Save User Message
        $stmt = $db->prepare("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_chat_messages (session_id, sender, message, timestamp) VALUES (:session_id, 'user', :message, :timestamp)");
        $stmt->bindParam(':session_id', $session_id, PDO::PARAM_INT);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->bindParam(':timestamp', NV_CURRENTTIME, PDO::PARAM_INT);
        $stmt->execute();

        // Get User Holland Context
        $sql_res = "SELECT scores_json, dominant_group FROM " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_results WHERE userid=" . $user_info['userid'] . " ORDER BY test_date DESC LIMIT 1";
        $res_row = $db->query($sql_res)->fetch();

        $context = "Student Name: " . $user_info['first_name'];
        if ($res_row) {
            $context .= ", Holland Type: " . $res_row['dominant_group'];
            // $scores = json_decode($res_row['scores_json'], true);
        }

        // Call AI API
        $api_key = $module_config[$module_name]['api_key'];
        $model = $module_config[$module_name]['api_model'];
        $system_prompt = $module_config[$module_name]['system_prompt'];

        $ai_response = call_ai_api($api_key, $model, $system_prompt, $context, $message);

        // Save AI Response
        $stmt = $db->prepare("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_chat_messages (session_id, sender, message, timestamp) VALUES (:session_id, 'ai', :message, :timestamp)");
        $stmt->bindParam(':session_id', $session_id, PDO::PARAM_INT);
        $stmt->bindParam(':message', $ai_response, PDO::PARAM_STR);
        $stmt->bindParam(':timestamp', NV_CURRENTTIME, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(array('status' => 'success', 'reply' => $ai_response, 'session_token' => $session_token));
        die();
    }
}

// Function to call AI API
function call_ai_api($api_key, $model, $system_prompt, $context, $user_message) {
    if (empty($api_key)) return "System Error: API Key not configured.";

    $url = "https://api.openai.com/v1/chat/completions";
    // Note: Gemini API endpoint differs. Assuming OpenAI format for simplicity as requested 'OpenAI/Gemini' usually implies OpenAI compatibility or switchable.
    // If Gemini is strictly required via Google Vertex/Generative AI, the endpoint and payload structure changes.
    // I will use OpenAI compatible format which is standard for 'gpt-3.5', 'gpt-4'.
    // If 'gemini-pro' is selected, we might need a different handler, but for this scope, I'll stick to a generic OpenAI-like structure or assume a proxy.
    // However, I will implement a basic switch for Gemini if the model name contains 'gemini'.

    $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer " . $api_key
    );

    $messages = array(
        array("role" => "system", "content" => $system_prompt . " Context: " . $context),
        array("role" => "user", "content" => $user_message)
    );

    $data = array(
        "model" => $model,
        "messages" => $messages,
        "temperature" => 0.7
    );

    if (strpos($model, 'gemini') !== false) {
       // Gemini implementation (simplified URL for Google AI Studio API key)
       // This requires a different payload and endpoint.
       // https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=API_KEY
       $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=" . $api_key;
       $headers = array("Content-Type: application/json");
       $data = array(
           "contents" => array(
               array(
                   "parts" => array(
                       array("text" => $system_prompt . "\nContext: " . $context . "\nUser: " . $user_message)
                   )
               )
           )
       );
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($result, true);

    if (strpos($model, 'gemini') !== false) {
        if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            return $response['candidates'][0]['content']['parts'][0]['text'];
        }
    } else {
        if (isset($response['choices'][0]['message']['content'])) {
            return $response['choices'][0]['message']['content'];
        }
    }

    return "Error calling AI: " . $result;
}


$contents = nv_theme_career_counselor_chat($module_data);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
