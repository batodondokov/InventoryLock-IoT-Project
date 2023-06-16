<?php

include 'init.php';

use App\Models\Auth;
$postData = file_get_contents('php://input');
$data = json_decode($postData, true);
$auth = new Auth($data);
if ($auth->validate()){
    $response['token'] = $auth->save();
    echo json_encode($response);
}else{
    $response['errore_message'] = $auth->getError();
    echo json_encode($response);
}
