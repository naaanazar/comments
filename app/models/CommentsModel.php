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
            
            if ($row['up'] == 0 && $data['rating'] == 'up') {
                $up = 1;
                $status =  '1';                
            } elseif ($row['up'] == 1 && $data['rating'] == 'up') {
                $status =  '0';    
            } elseif ($row['down'] == 0 && $data['rating'] == 'down') {
                $down = 1;  
                $status =  '-1';
            } elseif ($row['down'] == 1 && $data['rating'] == 'down') {
                $status =  '0';    
            }   
            
            $sql="UPDATE rating SET up='" . $up. "', down='" . $down. "' WHERE comment_id='" . 
                $data['id'] . "' AND  user_id='" . $_SESSION['users_id']. "'";
                
            $query->queryToDB($sql);
        } else {
            
            if ($data['rating'] == 'up') {
                $field = 'up';       
            } elseif ($data['rating'] == 'down') {
                $field = 'down';       
            }
            
            $setSql = $sql="INSERT INTO rating (user_id, comment_id, $field)
            VALUES ('" . $_SESSION['users_id'] . "','"   . $data['id'] . "','1')"; 
            
            $query->queryToDB($setSql);
            
            $status =  '1';            
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
