<div class="row-fluid">
    <div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4" >
        <div class="login-panel panel panel-default">
            <div class="panel-heading"> 
                <h3> Sing Up </h3>
            </div>
            <div class="panel-body">
                <form action="/auth/insert-registration-data" method="post" id="reg"  >
                    <div class="form-group">                         
                        <label for="username">Username:</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter username">
                        <?= isset($error['username'])? "<span class='error_f'> " . $error['username']. "</span>": '';?>
                    </div>
                    <div class="form-group">                       
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
                        <?= isset($error['password'])? "<span class='error_f'> " . $error['password']. "</span>": '';?>
                    </div>
                    <div class="form-group">
                       <label for="pwd">Password:</label>
                       <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
                    </div>
                    <div class="form-group">                        
                       <label for="pwd">Confirm password:</label>
                       <input type="password" name="confirmPassword" class="form-control" id="pwd" placeholder="Confirm password">
                       <?= isset($error['confirm'])? "<span class='error_f'> " . $error['confirm']. "</span>": '';?>
                    </div>            
                    <button type="submit" class="btn btn-primary">Sing On</button>
                </form>
            </div>    
        </div>        
    </div>   
</div>