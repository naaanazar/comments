<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">              
        <link  href="/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" >      
        <link href="/css/main.css" rel="stylesheet" type="text/css">       
        <script src="/js/lib/jquery/jquery.min.js"></script>
        <script src="/js/common.js"></script>       
        <script src="/js/lib/bootstrap/bootstrap.min.js"></script> 
    </head>
    <body>
        <div >
            <h3>Comments</h3>   
        </div>
        
        <?php isset($contentView) ? require_once ROOT. '/../app/views/' . $contentView : ''; ?>
        
    </body>
</html>
