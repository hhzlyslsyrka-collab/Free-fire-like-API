<?php

$private_token = "https://teamxcutehack.serv00.net/chxhost/uploads/Unknownlike/Token_ind.json";

if (isset($_GET['uid']) && isset($_GET['server_name'])) {

    $uid = $_GET['uid'];
    $region = $_GET['server_name'];

    $url = "https://like-api-of-chx.vercel.app/like?uid=$uid&server_name=$region&token=$private_token";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    $response = curl_exec($ch);

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if (!$response) {
        echo json_encode([
            'status' => 'error',
            'message' => 'API Server Not Responding',
            'http_code' => $http_code
        ]);
        exit();
    }

    $response = trim($response);

    
    $res = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid JSON format',
            'error' => json_last_error_msg()
        ]);
        exit();
    }

   
    if (isset($res['status'])) {
        if ($res['status'] == "Success") {
            
            echo json_encode([
                'status' => 'success',
                'message' => 'System Access Granted',
                'data' => $res 
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'System Access Denied',
                'response' => $res
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid API Response',
            'response' => $response
        ]);
    }

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized Access',
        'error_code' => 404
    ]);
}

?>
