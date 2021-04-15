<?php
    ob_start();

    session_start();
    $background=1;

    $pageTitle = 'Brand';

    if(isset($_SESSION['username']))
    {
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do'] :'Manage';
        // Manage Brand 
        if($do == 'Manage')
        {
            $sort = "desc";
            $sort_array = array('ASC','DESC');
            if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array))
            {
                $sort = $_GET['sort'];
            }
            
            $stmt3 = $connect->prepare("select * from brands");
            $stmt3->execute();
            $brs = $stmt3->fetchAll();
            
            ?>
            <h1 class="text-center ahmed">Manage Brands</h1>
            <div class="container categories">
                <div class=col-sm-12>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-edit"></i> Manage Brands
                            <div class="ordering pull-right">
                            Ordering:
                            <a class="<?php if($sort == 'ASC'){echo '.active';} ?>" href="?sort=ASC">ASC</a>
                            <a class="<?php if($sort == 'DESC'){echo '.active';} ?>" href="?sort=DESC">DESC</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                                foreach($brs as $value)
                                {
                                    echo '<div class="cat">';
                                        echo '<div class="hidden-button">';
                                            echo "<a href='?do=Edit&brsid=" . $value['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit faa'></i>Edit</a>" ;
                                            echo "<a href='?do=Delete&brsid=" . $value['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close faa'></i>Delete</a>" ;
                                        echo '</div>';
                                        echo "<h3 class='slide'>" . $value['Name'] . "</h3>";
                                        echo '</div>';
                                    echo "<hr>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <a href="?do=Add" class="Add-category btn btn-primary btn-lg row"><i class="fa fa-plus"></i> Add Brand</a>
            </div>
            <?php
        }
        // Add Brand 
        elseif($do == 'Add')
        { ?>
            <h1 class="text-center ahmed">Add Brand</h1>
                <div class = "container">
                    <form class="form-horizontal" action="?do=Insert" method="POST">
                        <div class="form-group form-group-lg row">
                            <label for="inputname" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-4">
                            <input type="text" name="name" class="form-control" id="inputname" autocomplete="off" required placeholder="Brand Name">
                            <br>
                            <button type="submit" class="btn btn-primary btn-lg">Add Brand</button>
                            </div>
                        </div>
                    </form>
                </div>
        <?php }
        elseif($do == 'Insert')
        {
            /* design Insert page */
            
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                echo '<h1 class="text-center ahmed">Insert Category</h1>';
                echo '<div class="container">';

                $name = $_POST['name'];
                
                /* check if there is not error */
                
                /* check user if exist */
                $check = checkItem("Name","brands",$name);
                if($check == 1)
                {
                    $msg = '<div class="alert alert-danger">sorry category exist</div>';
                    handleError($msg,'back');
                }
                else
                {
                    /* insert the database with this info */
                    $handle = $connect->prepare("insert into brands set Name = ?, Date=now()");
                    // $handle->bindParam(5,"now()",PDO::PARAM_INT);
                    $handle->execute(array($name));

                    $msg = "<div class='alert alert-success'>" . $handle->rowCount() . 'record inserted</div>';
                    handleError($msg,'back');
                }
                
                
            }
            else
            {
                $msg = '<div class="alert alert-danger">Sorry cant access directly </div>';
                handleError($msg,"back");
            }
            echo "</div>";
        }
        // edit brand 
        elseif($do == 'Edit')
        {
            $brsid = isset($_GET['brsid']) && is_numeric($_GET['brsid']) ? intval($_GET['brsid']) : 0;

            $sql = "select * from brands where ID = ?";
            $handle = $connect->prepare($sql);
            $handle->execute(array($brsid));
            $brs =$handle->fetch();
            $count = $handle->rowCount();
            if($count > 0)
            {
                ?>
                    <h1 class="text-center ahmed">Edit Brand</h1>
                    <div class = "container">
                        <form class="form-horizontal" action="?do=Update" method="POST">
                            <input type="hidden" name="brsid" value="<?php echo $brsid; ?>">
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10 col-md-4">
                                <input type="text" name="name" value="<?php echo $brs['Name'] ;?>" class="form-control" id="inputname" autocomplete="off" required placeholder="Brand Name">
                                <br>
                                <button type="submit" class="btn btn-primary btn-lg">Save Edit</button>
                                </div>
                            </div>
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
        // Update Brand 
        elseif($do == 'Update')
        {
            echo '<h1 class="text-center ahmed">Update Member</h1>';
            echo '<div class="container">';
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id       = $_POST['brsid'];
                $name     = $_POST['name'];
                
                
                /* update the database with this info */
                $handle = $connect->prepare("update brands set Name = ?, Date = now() where ID=?");
                $handle->execute(array($name,$id));

                $msg = "<div class='alert alert-success'>" . $handle->rowCount() . 'record updated</div>';
                handleError($msg,'back'); 
            }
            else
            {
                $msg = "can't acces";
                handleError($msg);
            }
            echo "</div>";

        }
        // Delete Brand 
        elseif($do == 'Delete')
        {
            /* page for delete member */
            echo '<h1 class="text-center ahmed">Deleted Member</h1>';
            echo '<div class="container">';
    
            $brsid = isset($_GET['brsid']) && is_numeric($_GET['brsid']) ? intval($_GET['brsid']) : 0;
            $check = checkItem('ID','brands',$brsid);
            if($check > 0)
            {
                $handle = $connect->prepare("delete from brands where ID = ?");
                $handle->execute(array($brsid));
                $msg = "<div class='alert alert-success'>" . $handle->rowCount() . 'record Deleted</div>';
                handleError($msg,'back');
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
    ob_end_flush();
?>