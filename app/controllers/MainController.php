<?php

//namespace App\controllers;

class MainController 
{  
    
    public function actionIndex()
    {
        $contentId = '';
        
        if (isset($_GET['contentId'])) {
            $contentId = $_GET['contentId'];
        }  
        
        $contentView = 'comments.php';
        require_once ROOT. '/../app/views/tamplateView.php';    
               
        return true;
    }
}
