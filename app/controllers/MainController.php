<?php

//namespace App\controllers;

class MainController 
{  
    
    public function actionIndex()
    {
              
        require_once ROOT. '/../app/views/tamplateView.php';    
               
        return true;
    }  
    
    public function actionLoginForm()
    {
        $contentView = 'loginView.php';      
        require_once ROOT. '/../app/views/tamplateView.php';    
               
        return true;
    }
}
