<div class="row-fluid">                    
    <div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4" >
         <div class="login-panel panel panel-default">
            <div class="panel-heading"> 
                <h3> Sing In </h3>
            </div>
            <div class="panel-body">                
                <form action="/auth/sing-in" method="post" id="login"  >
                    <?= isset($error['errorLogin'])? "<span class='error_f'> " . $error['errorLogin']. "</span>": '';?>
                    <div class="form-group">                         
                        <label for="username">Username:</label>
                        <input type="text" name="username" class="form-control" id="username" required placeholder="Enter username">
                        <?= isset($error['username'])? "<span class='error_f'> " . $error['username']. "</span>": '';?>
                    </div>            
                    <div class="form-group">
                       <label for="pwd">Password:</label>
                       <input type="password" name="password" class="form-control" required id="pwd" placeholder="Enter password">
                       <?= isset($error['password'])? "<span class='error_f'> " . $error['password']. "</span>": '';?>
                       <input type="hidden"  name="contentId" value="<?= isset($contentId) ? $contentId : '' ?>">
                    </div>   
                    <a href="/<?= isset($contentId) ? '?contentId=' . $contentId : '' ?>" class="btn  btn-xs"><span class="glyphicon glyphicon-menu-left">
                        </span><span class="glyphicon glyphicon-menu-left"></span> Back
                    </a>  
                    <button type="submit" class="btn btn-primary btn-xs">Sing In</button>                  
                </form>
            </div>
        </div>   
    </div>
</div>
