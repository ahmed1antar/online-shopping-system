<?php
    
    
    $pageTitle = 'Login';
    $background=0;
    if(isset($_SESSION['Email']))
    {
        header('Location: index.php');
    }
    include 'init.php';

    
    // check user comming with post method 
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $formError = array();
        if($_POST['log']==1)
        {
            if(isset($_POST['email']))
            {
                $filterEmail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                if(filter_var($filterEmail,FILTER_VALIDATE_EMAIL) == true)
                {
                    $email = $filterEmail;
                    $pass = sha1($_POST['password']);

                    $sql = "select Username,Email,password from users where Email=? AND password=?";
                    $handle = $connect->prepare($sql);
                    $handle->execute(array($email,$pass));
                    $count = $handle->rowCount();
                    if($count>0)
                    {

                        $_SESSION['Email'] = $email;
                        
                        header('Location: index.php');
                        exit();
                    }
                    else
                    {
                        $formError[] = "Make sure for pass & email";
                    }
                }
                // else
                // {
                //     $formError = "Sorry not support this email";
                // }
            }
            
        } 
    }
?>
    <!-- Login Form  -->
    <div class="container container1">
	    <div class="d-flex justify-content-center h-100 login-margin login-margin1">
            
            <div class="card card1 login-form-f">
                <div class="card-header card-header1">
                    <h3>Sign In</h3>
                    <!-- <div class="d-flex justify-content-end social_icon social_icon1">
                        <span><i class="fab fa-facebook-square"></i></span>
                        <span><i class="fab fa-google-plus-square"></i></span>
                        <span><i class="fab fa-twitter-square"></i></span>
                    </div> -->
                </div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                        <input type="hidden" name="log" value="1">
                        <!-- start email section  -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend input-group-prepend1">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input class="in1" type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <!-- start email section  -->
                        <!-- start passsword section  -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend input-group-prepend1">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input class="in1" type="password" class="form-control" name="password" placeholder="password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{6,}$" title="password must have letter [a,A] and number and special character" required>
                        </div>
                        <!-- end passsword section  -->
                        <!-- <div class="row align-items-center remember remember1">
                            <input type="checkbox">Remember Me
                        </div> -->
                        
                        <div class="form-group">
                            <input  type="submit" value="Login" class="btn float-right login_btn login_btn1 in1">
                        </div>
                        <div style="color: red;" class="row align-items-center">
                            <?php
                                if(!empty($formError))
                                {
                                    foreach($formError as $error)
                                    {
                                        echo "* " . $error . "<br>";
                                    }
                                }
                            ?>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links links1">
                        Don't have an account?<a href="register.php">Sign Up</a>
                    </div>
                    <!-- <div class="d-flex justify-content-center">
                        <a href="#">Forgot your password?</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
            
    
    
<?php include $tpl . 'footer.php'; ?>