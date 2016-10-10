<?php

use App\models\AuthModel;
use App\library\Validate;

class AuthController {
    
    public function actionSingIn()
    {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            
            if (isset($_POST['contentId'])) {
                $contentId = $_POST['contentId'];
            } 
                          
            $validation = new Validate;   

            $registration['username'] = $validation->validation('username', $_POST['username'], 3, 15, 'login');
            $registration['password'] = $validation->validation('password', $_POST['password'], 5, 15);            
            
            $error =  $validation->error; 
            
            if (empty($validation->error)) {

                $result = AuthModel::singIn($registration);
                
                if ($result) {               

                    if (mysqli_num_rows($result) == 1) {
                        session_start();
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION['auth'] = 'true';
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['users_id'] = $row['id'];
                        echo $_SESSION['username'];

                        ini_set('session.gc_maxlifetime', 60 * 60 * 24);			 		
                        $_SESSION['check'] = hash('ripemd128',$_SERVER['REMOTE_ADDR'] .  $_SERVER['HTTP_USER_AGENT']);
                       
                        if (isset($contentId)) {
                            header ("location:/?contentId=$contentId");
                        } else {
                            header ("location:/");
                        }
                        
                        exit;
                    }
                    else {                       
                        $error['errorLogin'] = "Wrong password or login";
                    }
                }              
            }      
            
            $contentView = 'comments.php';
            require_once ROOT. '/../app/views/tamplateView.php';  

            return $error;   
        }
    }
        
    public function actionRegistrationForm()
    {  
        if (isset($_GET['contentId'])) {
            $contentId = $_GET['contentId'];
        }   
        
        $contentView = 'registrationView.php';
        require_once ROOT. '/../app/views/tamplateView.php';
        
    }
    
    public function actionLoginForm()
    {
        if (isset($_GET['contentId'])) {
            $contentId = $_GET['contentId'];
        }    
        
        $contentView = 'loginView.php';      
        require_once ROOT. '/../app/views/tamplateView.php';    
               
        return true;
    }

    public function actionRegistration()
    {    

        if (isset($_POST['confirmPassword']) &&
            isset($_POST['username']) &&
            isset($_POST['password'])) {  
            
            if (isset($_POST['contentId'])) {
                $contentId = $_POST['contentId'];
            } 
            
            $validation = new Validate;
            $registration['username'] = $validation->validation('username', $_POST['username'], 3, 15, 'username');
            $registration['password'] = $validation->validation('password', $_POST['password'], 5, 15);
            $registration['confirmPassword'] = $validation->validation('confirm', $_POST['confirmPassword'], null, null, 'confirm'); 
            $registration['email'] = $validation->string_fix($_POST['email']);
            $error =  $validation->error; 

            if (empty($validation->error)) {

                $result = AuthModel::insertUsersData($registration);
            }

            $contentView = 'comments.php';
            require_once ROOT. '/../app/views/tamplateView.php';  

            return $error;
        }        
    }
    
    function actionSingOut()
    {	
        
        if (isset($_GET['contentId'])) {
            $contentId = $_GET['contentId'];
        } 
	session_unset();
	session_destroy();
        if (isset($contentId)) {
            header ("location:/?contentId=$contentId");
        } else {
            header ("location:/");
        }
	exit;
    }
}
