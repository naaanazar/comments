<?php

//namespace App\controllers;

use App\models\Users;
use App\library\Validate;


class UsersController {
    
    public function actionRegistrationForm()
    {  
        $contentView = 'registrationView.php';
        require_once ROOT. '/../app/views/tamplateView.php';      
       
        //return true;
    }
    
    public function actionRegistration()
    {    
    
        if (isset($_POST['confirmPassword']) &&
            isset($_POST['username']) &&
            isset($_POST['password'])) {                 

            $validation = new Validate;   

            $registration['username'] = $validation->validation('username', $_POST['username'], 3, 15, 'username');
            $registration['password'] = $validation->validation('password', $_POST['password'], 5, 15);
            $registration['confirmPassword'] = $validation->validation('confirm', $_POST['confirmPassword'], null, null, 'confirm'); 
            $registration['email'] = $validation->string_fix($_POST['email']);
            $error =  $validation->error; 
            
            if (empty($validation->error)) {

                $result = Users::insertUsersData($registration);
               
                echo 'ok';                
                //header("Location: login.php");
               //exit;
            }
            
            $contentView = 'registrationView.php';
            require_once ROOT. '/../app/views/tamplateView.php';  

            return $error;
        }        
    }        
}
