<?php

namespace App\models;

use App\library\Database;
use App\library\QueryToDB;

class AuthModel {
    
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
    
    public static function singIn($registration)
    {
        $query = new QueryToDB();           
        $registration['password'] = md5(trim($registration['password']));
        $sql = "SELECT id, username FROM users WHERE username='" . $registration['username'] . "' and password ='" . $registration['password'] . "'";
        $result = $query->queryToDB($sql);
        
        return $result;
    }
       
}
    

