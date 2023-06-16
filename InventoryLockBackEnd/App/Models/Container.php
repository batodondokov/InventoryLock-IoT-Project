<?php

namespace App\Models;

use App\Database\Database;

class Container{

    public ?int $id;

    public function __construct(array $data=[]){      
        $this->fillAuthorize($data);
    }

    public function fill(array $data = []){
        if ($data){        
            $this->user_name = $data['container_id'] ?? '';
        } 
    }

    public static function getContainerInfo($id){
        $result = Database::query("
        SELECT * 
        FROM `containers`
        WHERE `id` = " . $id . ";");
        return $result;
    }

    public static function loadAll() : array {
        return Database::queryAll("SELECT * FROM `containers`;");
    }
}