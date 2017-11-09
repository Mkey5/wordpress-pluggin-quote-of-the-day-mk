<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 6.11.2017 г.
 * Time: 16:32
 */

$command = isset($_POST['command'])? $_POST['command'] : null;

if (!empty($command)){
    switch ($command){
        case 'getUserIp':
            getUserIp();
            break;
    }
}


/**
 * Returns user IP
 * @return string user IP
 */
function getUserIp() {
    $arr = [];
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    $arr['userIp'] = $ip;
                    $arr['status'] = 'success';
                    http_response_code(200);
                    return json_encode($arr);
                }
            }
        }else {
            $arr['userIp'] = null;
            $arr['status'] = 'failed';
            http_response_code(204);
            return json_encode($arr);
        }
    }
}