<?php

use App\models\Users;
use App\library\Validate;

class AuthController {
    
    public function actionSingIn()
    {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
                          
            $validation = new Validate;   

            $registration['username'] = $validation->validation('username', $_POST['username'], 3, 15, 'login');
            $registration['password'] = $validation->validation('password', $_POST['password'], 5, 15);            
            
            $error =  $validation->error; 
            
            if (empty($validation->error)) {

                $result = Users::singIn($registration);
                
                if ($result) {               

                    if (mysqli_num_rows($result) == 1) {
                        session_start();
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION['auth'] = 'true';
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['users_id'] = $row['id'];

                        ini_set('session.gc_maxlifetime', 60 * 60 * 24);			 		
                        $_SESSION['check'] = hash('ripemd128',$_SERVER['REMOTE_ADDR'] .  $_SERVER['HTTP_USER_AGENT']);			 		
                        echo $_SESSION['username'];
                        header("location:/");
                        //exit;
                    }
                    else {                       
                        $error['errorLogin'] = "Wrong password or login";
                    }
                }              
            }      
            
            $contentView = 'loginView.php';
            require_once ROOT. '/../app/views/tamplateView.php';  

            return $error;
            

    
        }
    }
}
