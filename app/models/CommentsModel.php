<?php

namespace App\models;

use App\library\Database;
use App\library\QueryToDB;

class CommentsModel {   

    public static function insertComment($data)
    {
       
        $query = new QueryToDB();
       
        $sql="INSERT INTO comments (parent_id, user_id, content_id, comment)
            VALUES ('" . $data['parentId'] . "','" . $data['userId'] . "','"  
            . $data['contentId'] . "','" . $data['comment'] . "')"; 
        
        $result = $query->queryToDB($sql);
                
        if ($result === TRUE) {
            return $result;
        }
    }
    
    public static function selectComments($contentsId)
    {
        
        $query = new QueryToDB();
        
        $sql = "SELECT comments.id, comments.user_id, comments.parent_id, users.username, comments.comment, comments.date "
                . "FROM comments "
                . "INNER JOIN users ON comments.user_id = users.id "
                . "WHERE comments.content_id = $contentsId";
        
        $result = $query->queryToDB($sql); 
       
        return $result;
    }
    
    public static function updateComment($data)
    {
       
        $query = new QueryToDB();
       
        $sql="UPDATE comments SET comment='" .$data['comment'] . "' WHERE id='" . 
            $data['id'] . "' AND  user_id='" . $_SESSION['users_id']. "'";       
        
        $result = $query->queryToDB($sql); 
       
        return $result;
    }
    
    public static function deleteSub($commentId) 
    {
        
        $query = new QueryToDB();
        $sql = "SELECT * FROM comments WHERE parent_id = ".$commentId;
        $result = $query->queryToDB($sql);
        
        while($child = mysqli_fetch_array($result)) 
        {
            CommentsModel::deleteSub($child["id"]);
        }
        
        $sql = "DELETE FROM rating  WHERE comment_id = ".$commentId;
        $query->queryToDB($sql);
        
        $sql = "DELETE FROM comments  WHERE id = ".$commentId;
        
        return $query->queryToDB($sql);
    }
    
    public static function setUpRating($data) 
    {
        
        $status = '';  
        $up = 0;
        $down = 0;
        $query = new QueryToDB();

        $sql = "SELECT * FROM rating WHERE user_id = " . $_SESSION['users_id'] . 
               " AND comment_id = " . $data['id'] ;
        $result = $query->queryToDB($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();            

            if ($data['rating'] == 'up') {

                if ($row['up'] == 0) {
                    $sql="UPDATE rating SET up='1', down='0' WHERE comment_id='" . 
                         $data['id'] . "' AND  user_id='" . $_SESSION['users_id']. "'";
                    $status =  ['up' => 1, 'down' => -1];                
                } elseif ($row['up'] == 1) {                    
                    $status =  ['up' => 0, 'down' => 0]; 
                } 
            }

            if ($data['rating'] == 'down') {
                if ($row['down'] == 0) {
                    $sql="UPDATE rating SET up='0', down='1' WHERE comment_id='" . 
                         $data['id'] . "' AND  user_id='" . $_SESSION['users_id']. "'";
                    $status =  ['up' => -1, 'down' => 1];
                } elseif ($row['down'] == 1) {                    
                    $status =  ['up' => 0, 'down' => 0];  
                }   
            }
            $query->queryToDB($sql);
        } else {

            if ($data['rating'] == 'up') {
                $field = 'up';    
                $status =  ['up' => 1, 'down' => ''];   
            } elseif ($data['rating'] == 'down') {
                $field = 'down';  
                $status =  ['up' => '', 'down' => 1];   
            }

            $setSql = $sql="INSERT INTO rating (user_id, comment_id, $field)
            VALUES ('" . $_SESSION['users_id'] . "','"   . $data['id'] . "','1')"; 

            $query->queryToDB($setSql);
        }
    
        return $status;
    }
    
    public static function selectRating ($commentId) 
    {
        
        $query = new QueryToDB();       
        $sql="SELECT SUM(up = '1') AS up, SUM(down = '1') AS down FROM rating WHERE comment_id = $commentId";
        $result = $query->queryToDB($sql);
        
        return $result;
    }
    
    
}
