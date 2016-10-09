<?php

use App\models\CommentsModel;
use App\library\Validate;

class CommentsController {
    
    public function actionInsertComment()
    {
       
        $validation = new Validate;   
        if (isset($_POST['parentId'])) {
            $data['parentId'] = $validation->validation('parentId', $_POST['parentId'], null, null);
        } else {
            $data['parentId'] = '0';
        }
        $data['userId'] = $validation->validation('userId', $_POST['userId'], null, null);
        $data['contentId'] = $validation->validation('contentId', $_POST['contentId'], null, null);
        $data['comment'] = $validation->validation('comment', $_POST['comment'], 2, 1000);
        
        if ($data['userId'] == $_SESSION['users_id']) {
            $error =  $validation->error; 

            if (empty($validation->error)) {

                $result = CommentsModel::insertComment($data);  
                
                echo json_encode(array('status' => 'ok'));
            }            
        }
    }
    
    public function actionSelectComments()
    {
        
        $data=[];
        
        if (isset($_GET['contentsId'])) {
            $contentsId = $_GET['contentsId'];
        }
        
        $result = CommentsModel::selectComments($contentsId);
        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                $data[$row['id']] = $row;                
                $rating = $this->selectRating($row['id']);
                $data[$row['id']]['up'] = $rating['up']; 
                $data[$row['id']]['down'] = $rating['down'];                 
            }           
            
        }
    
        $tree = array(); 
        foreach ($data as $id=>&$node) {
            if (!$node['parent_id']) { 
                $tree[$id] = &$node;
            } else {
                $data[$node['parent_id']][$id] = &$node; 
            }  
        }
        
        echo json_encode(array('data' => $tree));
    }
    
    private function selectRating($commentId)
    {
        $result = CommentsModel::selectRating($commentId);        
        $row = $result->fetch_assoc();
        
        if (empty($row['up'])){
            $row['up'] = '0';
        } 
        
        if (empty($row['down'])) {
            $row['down'] = '0';        
        }
               
        return $row;
    }
    
    public function actionUpdateComment()
    {
        
        $validation = new Validate;   
       
        $data['id'] = $validation->validation('id', $_POST['id'], null, null);      
        $data['comment'] = $validation->validation('comment', $_POST['comment'], 2, 1000);
        $error =  $validation->error;
        
        if (empty($validation->error)) {

            $result = CommentsModel::updateComment($data);

            echo json_encode(array('status' => 'ok'));
        }
       
    }
    
    public function actionDeleteComment()
    {
        
        $validation = new Validate;   
       
        $data['id'] = $validation->validation('id', $_POST['id'], null, null);
       
        $result=CommentsModel::deleteSub($data['id']);    

        echo json_encode(array('status' => 'ok'));
        
       
    }

    public function actionGetSessionUsername() 
    {
        
        if(isset($_SESSION['users_id'])) {
            echo $_SESSION['users_id'];
        } else {
            echo 'null';
        }            
    }
    
    public function actionSetRating() 
    {
        $validation = new Validate;   
       
        $data['rating'] = $validation->validation('rating', $_POST['rating'], null, null);
        $data['id'] = $validation->validation('id', $_POST['id'], null, null);
       
        $result=CommentsModel::setUpRating($data);    

        echo $result;
               
    }
}
