<?php
    $pageTitle = 'Sign UP';
    $background=0;
    $checkpass=0;
    if(isset($_SESSION['Email']))
    {
        header('Location: index.php');
    }
    include 'init.php';

    
    // check user comming with post method 
    if ($_SERVER['REQUEST_METHOD']=='POST') 
    {
        $formError = array();
        if($_POST['log']==2)
        {
            if(isset($_POST['fname']))
            {
                $filter_fname = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
                $user = $filter_fname;
            }
            else
            {
                $formError[] = "fill first name";
            }
            if(isset($_POST['lname']))
            {
                $filter_lname = filter_var($_POST['lname'],FILTER_SANITIZE_STRING);
            }
            else
            {
                $formError[] = "fill last name";
            }
            $fullname = $filter_fname . ' ' . $filter_lname;
            if(isset($_POST['password1']) && isset($_POST['password2']))
            {
                $pass1 = sha1($_POST['password1']);
                $pass2 = sha1($_POST['password2']);
                if($pass1 !== $pass2)
                {
                    $formError[] = "password must be match & contain [a,A] $ number $ special character";
                }
            }
            if(isset($_POST['email']))
            {
                $filter_email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                if(filter_var($filter_email,FILTER_VALIDATE_EMAIL) == true)
                {
                    $check = checkItem("Email","users",$filter_email);
                    if($check>0)
                    {
                        $formError[] = "Email is exist";
                    }
                    else
                    {
                        $stmt = $connect->prepare("INSERT INTO users SET Username=?,password=?,Email=?,FullName=?,FirstName=?,LastName=?,RegStatus=?,Date=?");
                        $stmt->execute(array($user,$pass1,$filter_email,$fullname,$filter_fname,$filter_lname,1,"now()"));
                        $sql = "SELECT Username,Email,password from users where Email=? AND password=?";
                        $handle = $connect->prepare($sql);
                        $handle->execute(array($filter_email,$pass1));
                        $count = $handle->rowCount();
                        if($count>0)
                        {
                            $_SESSION['Email'] = $filter_email;
                            
                            header('Location: index.php');
                            exit();
                        }
                    }
                }
                else
                {
                    $formError[] = "must be real email";
                }
            }
        }
    }
?>

    <div class="container container1">
        <div class="d-flex justify-content-center h-100 login-margin login-margin1">
            <!-- start sign up form  -->
            
            <!-- Sign Up Form  -->
            <div class="card card1 sign-r">
                <div class="card-header card-header1">
                    <h3>Sign Up</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <input type="hidden" name="log" value="2">
                        <!-- start first name field  -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend input-group-prepend1">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input class="in1" type="text" class="form-control" name="fname" placeholder="First Name" required>
                        </div>
                        <!-- end first name field  -->
                        <!-- start last name field  -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend input-group-prepend1">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input class="in1" type="text" class="form-control" name="lname" placeholder="Last Name" required>
                        </div>
                        <!-- end last name field  -->
                        <!-- start password1 field  -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend input-group-prepend1">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input class="in1" type="password" class="form-control" name="password1" placeholder="password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{6,}$" title="password must have letter [a,A] and number and special character" required>
                        </div>
                        <!-- end password1 field  -->
                        <!-- start password2 field  -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend input-group-prepend1">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input class="in1" type="password" class="form-control" name="password2" placeholder="Confirm password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{6,}$" title="password must have letter [a,A] and number and special character" required>
                        </div>
                        <!-- end password2 field  -->
                        <!-- start email field  -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend input-group-prepend1">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input class="in1" type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <!-- end email field  -->
                        <div class="form-group">
                            <input  type="submit" value="Sign" class="btn float-right login_btn login_btn1 in1">
                        </div>
                        <div style="color:red" class="row align-items-center">
                            <?php
                                if(!empty($formError))
                                {
                                    foreach($formError as $error)
                                    {
                                        echo  "* " . $error . '<br>';
                                    }
                                }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end sign up form  -->
    </div>
    

    
    
<?php include $tpl . 'footer.php'; ?>