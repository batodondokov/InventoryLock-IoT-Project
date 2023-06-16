<?php

include 'init.php';

use App\Models\Container;

if ($_GET){
    if (!empty($_GET['container_id'])){
        $response = Container::getContainerInfo($_GET['container_id']);
        echo json_encode($response);
    }
    else if(!empty($_GET['load_all'])){
        if($_GET['load_all'] = 1){
            $containers = Container::loadAll();
            $response['containers'] = $containers;
            echo json_encode($response);
        }
    }
    else {
        $response['errore_message'] = "Неверный запрос";
        echo json_encode($response);
    }
}