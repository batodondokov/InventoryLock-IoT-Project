<?php

include 'init.php';

use App\Models\Accounting;

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

$accounting = new Accounting($data);
if ($accounting->validate()){
    $response['result'] = "validated";
    $accounting->save();
}else{
    $response['errore_message'] = $accounting->getError();
    echo json_encode($response);
}