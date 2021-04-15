<?php
    /* manage member */
    /* add , edit , remove*/

    session_start();

    $pageTitle = 'Members';
    $background=1;

    if(isset($_SESSION['username']))
    {
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if($do == 'Manage')
        {
            /* manage member page */

            $query = '';
            if(isset($_GET['active']) && $_GET['active']=='Pending')
            {
                $query = 'AND RegStatus = 0';
            }

            /* select all user except admins */
            $sql = "select * from users WHERE GroupID != 1 $query";
            $handle = $connect->prepare($sql);
            $handle->execute();
            /* fetch data */
            $row = $handle->fetchAll();


        ?>
            <h1 class="text-center ahmed">Manage Member</h1>
            <div class = "container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Username</td>
                            <td>Email</td>
                            <td>Full Name</td>
                            <td>Registerd Date</td>
                            <td>Control</td>
                        </tr>
                        <?php
                            foreach($row as $value)
                            {
                                echo '<tr>';
                                    echo '<td>' . $value['UserID'] . '</td>';
                                    echo '<td>' . $value['Username'] . '</td>';
                                    echo '<td>' . $value['Email'] . '</td>';
                                    echo '<td>' . $value['FullName'] . '</td>';
                                    echo '<td>' . $value['Date'] . '</td>';
                                    echo "<td>  <a href='?do=Edit&userid=" . $value['UserID'] . "'class='btn btn-success'><i class='fa fa-edit faa'></i>Edit</a>
                                                <a href='?do=Delete&userid=" . $value['UserID'] . "'class='btn btn-danger confirm'><i class='fa fa-close faa'></i>Delete</a>";
                                                if($value['RegStatus']==1)
                                                {
                                                   echo "<a href='?do=Activate&userid=" . $value['UserID'] . "'class='btn btn-info activate'><i class='fa fa-check faa'></i>Make Admin</a>";
                                                }
                                        echo "</td>";
                                echo '<tr>';

                            }
                        ?>
                        
                    </table>
                </div>
                <a class="btn btn-primary btn-lg" href="members.php?do=Add"><i class="fa fa-plus"></i> add new member</a>
            </div>
        <?php
        }
        elseif($do == 'Add')
        { /* add member page */
        ?>
            <h1 class="text-center ahmed">Add Member</h1>
                <div class = "container">
                <form class="form-horizontal" action="?do=Insert" method="POST">
                    <!-- start username field  -->
                <div class="form-group form-group-lg">
                    <label for="inputUsername" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-4">
                    <input type="text" name="username" class="form-control" id="inputUsername" autocomplete="off" required>
                    </div>
                </div>
                <!-- end username field  -->
                <!-- start Password field  -->
                <div class="form-group form-group-lg">
                    <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-4">
                    <input type="password" name="password" class="form-control" id="inputPassword" required>
                    </div>
                </div>
                <!-- end Password field  -->
                <!-- start Email field  -->
                <div class="form-group form-group-lg">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-4">
                    <input type="email" name="email" class="form-control" id="inputEmail" required>
                    </div>
                </div>
                <!-- end Email field  -->
                <!-- start Full Name field  -->
                <div class="form-group form-group-lg">
                    <label for="inputFullname" class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-4">
                    <input type="text" name="full" class="form-control" id="inputFullname">
                    </div>
                </div>
                <!-- end Full Name field  -->
                <!-- start Add Member field  -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-10 col-md-4">
                    <button type="submit" class="btn btn-primary btn-lg">Add Member</button>
                    </div>
                </div>
                <!-- end Add Member field  -->
                </form>
                </div>
        <?php
        }
        elseif($do == "Insert")
        {
            /* design Insert page */
            
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                echo '<h1 class="text-center ahmed">Insert Member</h1>';
                echo '<div class="container">';

                $user = $_POST['username'];
                /* for check pass */
                $pass = $_POST['password'];
                $email = $_POST['email'];
                $name = $_POST['full'];
                /* to secure pass */
                $hashPass = sha1($_POST['password']);
                /* validate the form */ 
                $formError = array();
                if(empty($user))
                {
                    $formError[] = 'Username cant be empty';
                }
                if(empty($hashPass))
                {
                    $formError[] = 'Password cant be empty';
                }
                if(empty($email))
                {
                    $formError[] = 'Email cant be empty';
                }
                if(empty($name))
                {
                    $formError[] = 'FullName cant be empty';
                }

                foreach($formError as $error)
                {
                    $msg = '<div class="alert alert-danger">' .$error . '</div>';
                    handleError($msg,'back');
                }

                /* check if there is not error */
                if(empty($formError))
                {
                    /* check user if exist */
                    $check = checkItem("Username","users",$user);
                    if($check == 1)
                    {
                        $msg = '<div class="alert alert-danger">sorry user exist</div>';
                        handleError($msg,'back');
                    }
                    else
                    {
                        /* insert the database with this info */
                        $handle = $connect->prepare("insert into users set Username = ?, password = ?, Email = ?, FullName = ?,RegStatus = ?,Date = now()");
                        // $handle->bindParam(5,"now()",PDO::PARAM_INT);
                        $handle->execute(array($user,$hashPass,$email,$name,0));

                        $msg = "<div class='alert alert-success'>" . $handle->rowCount() . 'record inserted</div>';
                        handleError($msg,'back');
                    }
                    
                }
            }
            else
            {
                $msg = '<div class="alert alert-danger">Sorry cant access directly </div>';
                handleError($msg);
            }
            echo "</div>";
            
        }
        elseif($do == 'Edit')
        {
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            $sql = "select * from users where UserID=? LIMIT 1";
            $handle = $connect->prepare($sql);
            $handle->execute(array($userid));
            $row =$handle->fetch();
            $count = $handle->rowCount();
            if($count > 0)
            {
                
            
            ?>
                <h1 class="text-center ahmed">Edit Member</h1>
                <div class = "container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                <!-- start username field  -->
                <div class="form-group form-group-lg">
                    <label for="inputUsername" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-4">
                    <input type="text" name="username" class="form-control" id="inputUsername" autocomplete="off" required>
                    </div>
                </div>
                <!-- start username field  -->
                <!-- start Password field  -->
                <div class="form-group form-group-lg">
                    <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-4">
                    <input type="hidden" name="oldpassword" value="<?php echo $row['password'];?>">
                    <input type="password" name="newpassword" class="form-control" id="inputPassword">
                    </div>
                </div>
                <!-- end Password field  -->
                <!-- start Email field  -->
                <div class="form-group form-group-lg">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-4">
                    <input type="email" name="email" class="form-control" id="inputEmail" required>
                    </div>
                </div>
                <!-- end Email field  -->
                <!-- start Full Name field  -->
                <div class="form-group form-group-lg">
                    <label for="inputFullname" class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-4">
                    <input type="text" name="full" class="form-control" id="inputFullname">
                    </div>
                </div>
                <!-- end Full Name field  -->
                <!-- start Save field  -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-10 col-md-4">
                    <button type="submit" class="btn btn-primary btn-lg">Save</button>
                    </div>
                </div>
                <!-- end Save field  -->
                </form>
                </div>
                <?php 
            }
            else
            {
                echo "<div class='container'>";
                $msg = "<div class='alert alert-danger'>there is no id</div>";
                handleError($msg); 
                echo "</div>";
            }
        }
        elseif($do == 'Update')
        {
            echo '<h1 class="text-center ahmed">Update Member</h1>';
            echo '<div class="container">';
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['userid'];
                $user = $_POST['username'];
                $email = $_POST['email'];
                $name = $_POST['full'];
                

                $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
                /* validate the form */ 
                $formError = array();
                if(empty($user))
                {
                    $formError[] = 'Username cant fullname be empty';
                }
                if(empty($user))
                {
                    $formError[] = 'Password cant fullname be empty';
                }
                if(empty($email))
                {
                    $formError[] = 'Email cant fullname be empty';
                }
                if(empty($name))
                {
                    $formError[] = 'FullName cant fullname be emptyc';
                }

                foreach($formError as $error)
                {
                    echo '<div class="alert alert-danger">' .$error . '</div>';
                }

                /* check if there is not error */
                if(empty($formError))
                {
                /* update the database with this info */
                $handle = $connect->prepare("update users set Username = ?, Email = ?, FullName = ?, password = ? where UserID = ?");
                $handle->execute(array($user,$email,$name,$pass,$id));

                $msg = "<div class='alert alert-success'>" . $handle->rowCount() . 'record updated</div>';
                handleError($msg,'back'); 
                }
            }
            else
            {
                $msg = "can't acces";
                handleError($msg);
            }
            echo "</div>";

        }
        elseif($do == 'Delete')
        {
            /* page for delete member */
            echo '<h1 class="text-center ahmed">Deleted Member</h1>';
            echo '<div class="container">';
    
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            $sql = "select * from users where UserID=? LIMIT 1";
            $handle = $connect->prepare($sql);
            $handle->execute(array($userid));
            $count = $handle->rowCount();
            if($count > 0)
            {
                $handle = $connect->prepare("delete from users where UserID = ?");
                $handle->execute(array($userid));
                $msg = "<div class='alert alert-success'>" . $handle->rowCount() . 'record Deleted</div>';
                handleError($msg);
            }
            else
            {
                $msg = 'this id is not exist';
                handleError($msg);
            }
            echo "</div>";
        }
        elseif($do == 'Activate')
        {
            /* activate page */
            echo '<h1 class="text-center ahmed">Activate Member</h1>';
            echo '<div class="container">';
    
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            $sql = "select * from users where UserID=? LIMIT 1";
            $handle = $connect->prepare($sql);
            $handle->execute(array($userid));
            $count = $handle->rowCount();
            if($count > 0)
            {
                $handle = $connect->prepare("update users set GroupID = 1 where UserID = ?");
                $handle->execute(array($userid));
                $msg = "<div class='alert alert-success'>" . $handle->rowCount() . 'record Activated</div>';
                handleError($msg);
            }
            else
            {
                $msg = 'this id is not exist';
                handleError($msg);
            }
            echo "</div>";
        }

        include $tpl . 'footer.php';
    }

    else
    {
        header('Location: index.php');
        exit();
    }
?>