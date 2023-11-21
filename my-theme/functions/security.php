<?php

/* 

################################################## 

Protect your site from malicious requests

*/
global $user_ID; if($user_ID)
{
    if(!current_user_can('administrator')) {
        if (strlen($_SERVER['REQUEST_URI']) > 255 ||
            stripos($_SERVER['REQUEST_URI'], "eval(") ||
            stripos($_SERVER['REQUEST_URI'], "CONCAT") ||
            stripos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
            stripos($_SERVER['REQUEST_URI'], "base64")) {
                @header("HTTP/1.1 414 Request-URI Too Long");
                @header("Status: 414 Request-URI Too Long");
                @header("Connection: Close");
                @exit;
        }
    }
}


/* 

################################################## 

Remove the WordPress Version Number

*/
remove_action('wp_head', 'wp_generator');


/* 

################################################## 

Basic Authentication

*/
function basic_auth($auth_list, $realm = "Restricted Area", $failed_text = "認証に失敗しました")
{
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($auth_list[$_SERVER['PHP_AUTH_USER']])) {
        if ($auth_list[$_SERVER['PHP_AUTH_USER']] == $_SERVER['PHP_AUTH_PW']) {
            return $_SERVER['PHP_AUTH_USER'];
        }
    }
    header('WWW-Authenticate: Basic realm="' . $realm . '"');
    header('HTTP/1.0 401 Unauthorized');
    header('Content-type: text/html; charset=' . mb_internal_encoding());
    die($failed_text);
}
