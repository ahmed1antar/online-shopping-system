<?php
    ob_start();

    session_start();
    $background=1;

    $pageTitle = 'Categories';

    if(isset($_SESSION['username']))
    {
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do'] :'Manage';
        // Manage page 
        if($do == 'Manage')
        {
            $sort = "desc";
            $sort_array = array('ASC','DESC');
            if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array))
            {
                $sort = $_GET['sort'];
            }
            $stmt3 = $connect->prepare("select * from categories order by Ordering $sort");
            $stmt3->execute();
            $cats = $stmt3->fetchAll();
            ?>
            <h1 class="text-center ahmed">Manage Categories</h1>
            <div class="container categories">
                <div class=col-sm-12>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-edit"></i> Manage Categories
                            <div class="ordering pull-right">
                            Ordering:
                            <a class="<?php if($sort == 'ASC'){echo '.active';} ?>" href="?sort=ASC">ASC</a>
                            <a class="<?php if($sort == 'DESC'){echo '.active';} ?>" href="?sort=DESC">DESC</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                                foreach($cats as $value)
                                {
                                    echo '<div class="cat">';
                                        echo '<div class="hidden-button">';
                                            echo "<a href='?do=Edit&catid=" . $value['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit faa'></i>Edit</a>" ;
                                            echo "<a href='?do=Delete&catid=" . $value['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close faa'></i>Delete</a>" ;
                                        echo '</div>';
                                        echo "<h3 class='slide'>" . $value['Name'] . "</h3>";
                                            echo "<div class='full-view'>";
                                                echo "<p>"; if($value['Description']==''){echo 'this category has no description';} else{echo $value['Description'];} echo "</P>";
                                                if($value['Visibility']==1){
                                                    echo '<span class="visibility"><i class="fa fa-eye"></i>Hidden</span>';
                                                } 
                                                if($value['Allow_Comment']==1){
                                                    echo '<span class="allow-comment"><i class="fa fa-close"></i>Comment Disabled</span>';
                                                }
                                                if($value['Allow_Ads']==1){
                                                    echo '<span class="advertises"><i class="fa fa-close"></i>Ads Disabled</span>';
                                                }
                                            echo "</div>";
                                        echo '</div>';
                                    echo "<hr>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <a href="?do=Add" class="Add-category btn btn-primary btn-lg row"><i class="fa fa-plus"></i> Add Category</a>
            </div>
            <?php
        }
        // add category 
        elseif($do == 'Add')
        { ?>
            <h1 class="text-center ahmed">Add Category</h1>
                <div class = "container">
                <form class="form-horizontal" action="?do=Insert" method="POST">
                    <!-- start Name Field  -->
                <div class="form-group form-group-lg row">
                    <label for="inputname" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-4">
                    <input type="text" name="name" class="form-control" id="inputname" autocomplete="off" required placeholder="Category Name">
                    </div>
                </div>
                <!-- end Name Field  -->
                <!-- start Describtion Field  -->
                <div class="form-group form-group-lg row">
                    <label for="inputDescribtion" class="col-sm-2 control-label">Describtion</label>
                    <div class="col-sm-10 col-md-4">
                    <input type="text" name="describtion" class="form-control" id="inputDescribtion" required placeholder="Describe Category">
                    </div>
                </div>
                <!-- end Describtion Field  -->
                <!-- start Ordering Field  -->
                <div class="form-group form-group-lg row">
                    <label for="inputOrder" class="col-sm-2 control-label">Ordering</label>
                    <div class="col-sm-10 col-md-4">
                    <input type="text" name="ordering" class="form-control" id="inputOrder" required placeholder="Number To Arrange The Categories">
                    </div>
                </div>
                <!-- end Ordering Field  -->
                <!-- start Visible Field  -->
                <div hidden class="form-group form-group-lg row">
                    <label for="inputVisible" class="col-sm-2 col-form-label">Visible</label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input type="radio" name="visibility" value="1" checked id="inputVisibilityYes">
                            <label for="inputVisibilityYes">Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="visibility" value="0" checked id="inputVisibilityNo">
                            <label for="inputVisibilityNo">No</label>
                        </div>
                    </div>
                </div>
                <!-- end Visible Field  -->
                <!-- start Allow Commenting Field  -->
                <div hidden class="form-group form-group-lg row">
                    <label for="inputComment" class="col-sm-2 col-form-label">Allow Commenting</label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input type="radio" name="commenting" value="1" checked id="inputCommentYes">
                            <label for="inputCommentYes">Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="commenting" value="0" checked id="inputCommentNo">
                            <label for="inputCommentNo">No</label>
                        </div>
                    </div>
                </div>
                <!-- end Allow Commenting Field  -->
                <!-- start Allow Ads Field  -->
                <div hidden class="form-group form-group-lg row">
                    <label for="inputAds" class="col-sm-2 col-form-label">Allow Ads</label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input type="radio" name="ads" value="1" checked id="inputAdsYes">
                            <label for="inputAdsYes">Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="ads" value="0" checked id="inputAdsNo">
                            <label for="inputAdsNo">No</label>
                        </div>
                    </div>
                </div>
                <!-- end Allow Ads Field  -->
                <!-- start Add Category Field  -->
                <div class="form-group form-group-lg row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10 col-md-4">
                        <button type="submit" class="btn btn-primary btn-lg">Add Category</button>
                    </div>
                </div>
                <!-- end Add Category Field  -->
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

                $name      = $_POST['name'];
                /* for check pass */
                $desc      = $_POST['describtion'];
                $order     = $_POST['ordering'];
                $visible   = $_POST['visibility'];
                $comment   = $_POST['commenting'];
                $ads       = $_POST['ads'];
                
                /* check if there is not error */
                
                /* check user if exist */
                $check = checkItem("Name","categories",$name);
                if($check == 1)
                {
                    $msg = '<div class="alert alert-danger">sorry category exist</div>';
                    handleError($msg,'back');
                }
                else
                {
                    /* insert the database with this info */
                    $handle = $connect->prepare("insert into categories set Name = ?, Description = ?, Ordering = ?, Visibility = ?,Allow_Comment = ?,Allow_Ads = ?");
                    // $handle->bindParam(5,"now()",PDO::PARAM_INT);
                    $handle->execute(array($name,$desc,$order,$visible,$comment,$ads));

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
        // edit category 
        elseif($do == 'Edit')
        {
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

            $sql = "select * from categories where ID = ?";
            $handle = $connect->prepare($sql);
            $handle->execute(array($catid));
            $cat =$handle->fetch();
            $count = $handle->rowCount();
            if($count > 0)
            {
                ?>
                    <h1 class="text-center ahmed">Edit Category</h1>
                    <div class = "container">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                        <input type="hidden" name="catid" value="<?php echo $catid; ?>">
                    <!-- start Name Field  -->
                    <div class="form-group form-group-lg row">
                        <label for="inputname" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-4">
                        <input type="text" name="name" value="<?php echo $cat['Name'] ;?>" class="form-control" id="inputname" autocomplete="off" required placeholder="Category Name">
                        </div>
                    </div>
                    <!-- start Name Field  -->
                    <!-- start Describtion Field  -->
                    <div class="form-group form-group-lg row">
                        <label for="inputDescribtion" class="col-sm-2 control-label">Describtion</label>
                        <div class="col-sm-10 col-md-4">
                        <input type="text" name="describtion" class="form-control" id="inputDescribtion" required placeholder="Describe Category" value="<?php echo $cat['Description'] ;?>">
                        </div>
                    </div>
                    <!-- end Describtion Field  -->
                    <!-- start Ordering Field  -->
                    <div class="form-group form-group-lg row">
                        <label for="inputOrder" class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-4">
                        <input type="text" name="ordering" class="form-control" id="inputOrder" required placeholder="Number To Arrange The Categories" value="<?php echo $cat['Ordering'] ;?>">
                        </div>
                    </div>
                    <!-- end Ordering Field  -->
                    <!-- start Visible Field  -->
                    <div hidden class="form-group form-group-lg row">
                        <label for="inputVisible" class="col-sm-2 col-form-label">Visible</label>
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input type="radio" name="visibility" value="0"  id="inputVisibilityYes" <?php if($cat['Visibility'] == 0){echo 'checked';} ?>>
                                <label for="inputVisibilityYes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="visibility" value="1"  id="inputVisibilityNo" <?php if($cat['Visibility'] == 1){echo 'checked';} ?>>
                                <label for="inputVisibilityNo">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end Visible Field  -->
                    <!-- start Allow Commenting Field  -->
                    <div hidden class="form-group form-group-lg row">
                        <label for="inputComment" class="col-sm-2 col-form-label">Allow Commenting</label>
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input type="radio" name="commenting" value="0"  id="inputCommentYes" <?php if($cat['Allow_Comment'] == 0){echo 'checked';} ?>>
                                <label for="inputCommentYes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="commenting" value="1"  id="inputCommentNo" <?php if($cat['Allow_Comment'] == 1){echo 'checked';} ?>>
                                <label for="inputCommentNo">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end Allow Commenting Field  -->
                    <!-- start Allow Ads Field  -->
                    <div hidden class="form-group form-group-lg row">
                        <label for="inputAds" class="col-sm-2 col-form-label">Allow Ads</label>
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input type="radio" name="ads" value="0"  id="inputAdsYes" <?php if($cat['Allow_Ads'] == 0){echo 'checked';} ?>>
                                <label for="inputAdsYes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="ads" value="1"  id="inputAdsNo" <?php if($cat['Allow_Ads'] == 1){echo 'checked';} ?>>
                                <label for="inputAdsNo">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end Allow Ads Field  -->
                    <!-- start Save Update Field  -->
                    <div class="form-group form-group-lg row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10 col-md-4">
                        <button type="submit" class="btn btn-primary btn-lg">Save Update</button>
                        </div>
                    </div>
                    <!-- end Save Update Field  -->
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
        // Update category 
        elseif($do == 'Update')
        {
            echo '<h1 class="text-center ahmed">Update Member</h1>';
            echo '<div class="container">';
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id       = $_POST['catid'];
                $name     = $_POST['name'];
                $desc     = $_POST['describtion'];
                $order    = $_POST['ordering'];
                $visible  = $_POST['visibility'];
                $comment  = $_POST['commenting'];
                $ads      = $_POST['ads'];
                
                /* update the database with this info */
                $handle = $connect->prepare("update categories set Name = ?, Description = ?, Ordering  = ?, Visibility  = ?,Allow_Comment = ?,Allow_Ads = ? where ID = ?");
                $handle->execute(array($name,$desc,$order,$visible,$comment,$ads,$id));

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
        // Delete category 
        elseif($do == 'Delete')
        {
            /* page for delete member */
            echo '<h1 class="text-center ahmed">Deleted Member</h1>';
            echo '<div class="container">';
    
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
            $check = checkItem('ID','categories',$catid);
            if($check > 0)
            {
                $handle = $connect->prepare("delete from categories where ID = ?");
                $handle->execute(array($catid));
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