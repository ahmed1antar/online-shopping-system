<?php

    session_start();
    $noNavbar = '';
    $pageTitle = 'Login';
    $background=0;

    if(isset($_SESSION['username']))
    {
        header('Location: dashboard.php');
    }
    include 'init.php';
    


    // check user comming with post method 
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $username = $_POST['user'];
        $password = sha1($_POST['pass']);
        $sql = "select UserID,Username,password from users where Username=? AND password=? AND GroupID=1 LIMIT 1";
        $handle = $connect->prepare($sql);
        $handle->execute(array($username,$password));
        $row =$handle->fetch();
        $count = $handle->rowCount();
        if($count>0)
        {
            
            $_SESSION['username'] = $username;
            $_SESSION['ID'] = $row['UserID'];
            header('Location: dashboard.php');
        }
       
    }
?>

    <!-- start login  -->
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="login" method="POST">
        
            <h4 class="text-center text-primary">Admin LOGIN</h4>
            <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
            <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
            <input class="btn btn-primary btn-block" type="submit" value="Login">
        
        </form>
    <!-- end login  -->


<?php include $tpl . 'footer.php';?>
