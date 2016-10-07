<?php

namespace App\models;

use App\library\Database;
use App\library\QueryToDB;

class Users {
    
    private $conn;     

   
    public static function insertUsersData($registration)
    {
       
        $query = new QueryToDB();        
        
        $registration['password'] = md5(trim($registration['password']));
        $sql="INSERT INTO users (username, password, email)
            VALUES ('" . $registration['username'] . "','" . $registration['password'] . "','" . $registration['email'] . "')"; 
        
        $result = $query->queryToDB($sql); 
       
        return $result;
   } 
       
}
    

