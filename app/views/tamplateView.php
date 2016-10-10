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
        <div class="nav">
            <div class="container">
                
                <div class="title-comments">
                    Comments:
                </div>
                <div class="username">
                    <?= isset($_SESSION['username']) ? $_SESSION['username'] : '' ?>
                </div>
                
                <?php if (isset($_SESSION['username'])) :?>
                    <a href="/auth/sing-out<?= isset($contentId) ? '?contentId=' .$contentId : '' ?>" class="btn btn-default btn-xs" role="button">Sing Out</a>
                <?php else: ?>
                    <a href="/auth/login-form<?= isset($contentId) ? '?contentId=' .$contentId : '' ?>" class="btn btn-default btn-xs" role="button">Sing In</a>
                    <a href="/auth/sing-on<?= isset($contentId) ? '?contentId=' .$contentId : '' ?>" class="btn btn-success btn-xs" role="button">Sing Up</a>               
                <?php endif; ?>

            </div>
        </div>
        <div class="container" >  
        
        <?php isset($contentView) ? require_once ROOT. '/../app/views/' . $contentView : ''; ?>
            
       </div>        
    </body>
</html>
