<?php
    ob_start();

    /* Items page */

    session_start();
    $pageTitle = 'Items Page';
    $background=1;

    if(isset($_SESSION['username']))
    {
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do'] :'Manage';
        if($do == 'Manage')
        {
            /* manage member page */


            /* select all user except admins */
            $sql = "SELECT
                        items.*,categories.Name AS category_name,
                        users.Username
                        FROM 
                            items 
                        INNER JOIN
                            categories 
                        ON 
                            categories.ID = items.Cat_ID 
                        INNER JOIN 
                            users 
                        ON 
                            users.UserID = items.Member_ID";
            $handle = $connect->prepare($sql);
            $handle->execute();
            /* fetch data */
            $items = $handle->fetchAll();


            ?>
                <h1 class="text-center ahmed">Manage Items</h1>
                <div class = "container">
                    <div class="table-responsive">
                        <table class="main-table manage-image-item text-center table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>Image</td>
                                <td>Category</td>
                                <td>Name</td>
                                <td>Brand</td>
                                <td>Description</td>
                                <td>Price</td>
                                <td>Adding Date</td>
                                <td>Author</td>
                                <td>Control</td>
                            </tr>
                            <?php
                                foreach($items as $value)
                                {
                                    echo '<tr>';
                                        echo '<td>' . $value['item_ID'] . '</td>';
                                        echo '<td>';
                                        echo '<div class="haa">';
                                        echo "<img src='layout/images/item-images/" . $value['Image'] . "'>";
                                        echo '</div>';
                                        echo '</td>';
                                        echo '<td>' . $value['category_name'] . '</td>';
                                        echo '<td>' . $value['Name'] . '</td>';
                                        echo '<td>' . $value['Brand'] . '</td>';
                                        echo '<td>' . $value['Description'] . '</td>';
                                        echo '<td>' . $value['Price'] . '</td>';
                                        echo '<td>' . $value['Add_Date'] . '</td>';
                                        echo '<td>' . $value['Username'] . '</td>';
                                        echo "<td>  <a href='?do=Edit&itemid=" . $value['item_ID'] . "'class='btn btn-success'><i class='fa fa-edit faa'></i>Edit</a>
                                                    <a href='?do=Delete&itemid=" . $value['item_ID'] . "'class='btn btn-danger confirm'><i class='fa fa-close faa'></i>Delete</a>";
                                                    if($value['Approve']==1)
                                                    {
                                                       echo "<a href='?do=Approve&itemid=" . $value['item_ID'] . "'class='btn btn-info activate'><i class='fa fa-check faa'></i>Approve</a>";
                                                    }
                                                echo "</td>";
                                    echo '<tr>';

                                }
                            ?>
                           
                        </table>
                    </div>
                    <a class="btn btn-primary btn-lg" href="items.php?do=Add"><i class="fa fa-plus"></i> add new Item</a>
                </div>
            <?php
        }
        elseif($do == 'Add')
        {
            ?>
                <h1 class="text-center ahmed">Add Item</h1>
                    <div class = "container">
                        <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                            <!-- start Name field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="text" name="name" class="form-control" id="inputname" required placeholder="Item Name">
                                </div>
                            </div>
                            <!-- end Name field  -->
                            <!-- start Brands field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Brands</label>
                                <div class="col-sm-10 col-md-4">
                                    <select name="brand" id="">
                                        <option value="0" disabled>...</option>
                                        <?php
                                            $stmt = $connect->prepare("select * from brands");
                                            $stmt->execute();
                                            $brs = $stmt->fetchAll();
                                            foreach($brs as $value)
                                            {
                                                echo "<option value='" . $value['Name'] . "' >" . $value['Name'] . "</option>";
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- end Brands field  -->
                            <!-- start Description field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="text" name="description" class="form-control" id="inputname" required placeholder="Description Name">
                                </div>
                            </div>
                            <!-- end Description field  -->
                            <!-- start Price field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="text" name="price" class="form-control" id="inputname" required placeholder="Price Name">
                                </div>
                            </div>
                            <!-- end Price field  -->
                            <!-- start country field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Country</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="text" name="country" class="form-control" id="inputname" required placeholder="Country Of Made">
                                </div>
                            </div>
                            <!-- end country field  -->
                            <!-- start Categories field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Categories</label>
                                <div class="col-sm-10 col-md-4">
                                    <select name="category" id="">
                                        <option value="0" disabled>...</option>
                                        <?php
                                            $stmt = $connect->prepare("select * from categories");
                                            $stmt->execute();
                                            $cats = $stmt->fetchAll();
                                            foreach($cats as $value)
                                            {
                                                echo "<option value='" . $value['ID'] . "' >" . $value['Name'] . "</option>";
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- end Categories field  -->
                            <!-- start member field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Member</label>
                                <div class="col-sm-10 col-md-4">
                                    <select name="member" id="">
                                        <option value="0" disabled>...</option>
                                        <?php
                                            $stmt = $connect->prepare("select * from users where GroupID = 1");
                                            $stmt->execute();
                                            $users = $stmt->fetchAll();
                                            foreach($users as $value)
                                            {
                                                echo "<option value='" . $value['UserID'] . "' >" . $value['Username'] . "</option>";
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- end member field  -->
                            <!-- start image field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputImg" class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="file" name="image" id="inputImg" required>
                                </div>
                            </div>
                            <!-- end image field  -->
                            <!-- start btn field  -->
                            
                            <div class="form-group form-group-lg row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10 col-md-4">
                                    <button type="submit" class="btn btn-primary btn-lg">Add Item</button>
                                </div>
                            </div>
                            <!-- end btn field  -->
                        </form>
                    </div>
            <?php

        }
        elseif($do == 'Insert')
        {
            /* design Insert page */
            
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                echo '<h1 class="text-center ahmed">Insert Items</h1>';
                echo '<div class="container">';
                /* get image */
                $imgName  = $_FILES['image']['name'];
                $imgType  = $_FILES['image']['type'];
                $imgTmp   = $_FILES['image']['tmp_name'];
                $imgError = $_FILES['image']['error'];
                $imgSize  = $_FILES['image']['size'];

                $imgAllowedExtension = array("jpeg","jpg","png","gif");

                $imgExtension = strtolower(end(explode('.',$imgName)));
                /* get info */
                $name        = $_POST['name'];
                $brand       = $_POST['brand'];
                $desc        = $_POST['description'];
                $price       = $_POST['price'];
                $country     = $_POST['country'];
                
                $member      = $_POST['member'];
                $category    = $_POST['category'];
                
                /* validate the form */ 
                $formError = array();
                if(empty($name))
                {
                    $formError[] = 'name cant be empty';
                }
                if(empty($desc))
                {
                    $formError[] = 'description cant be empty';
                }
                if(empty($price))
                {
                    $formError[] = 'price cant be empty';
                }
                if(empty($country))
                {
                    $formError[] = 'country cant be empty';
                }
                
                if($member == 0)
                {
                    $formError[] = 'member cant be empty';
                }
                if($category == 0)
                {
                    $formError[] = 'category cant be empty';
                }
                if(!empty($imgName) && !in_array($imgExtension,$imgAllowedExtension))
                {
                    $formError[] = 'this extension is not <strong>Allowed</strong>';
                }
                if(empty($imgName))
                {
                    $formError[] = 'image <strong>Required</strong>';
                }
                if($imgSize > 4000000)
                {
                    $formError[] = 'Image has big size must be less Than <strong>4M</strong>';
                }

                foreach($formError as $error)
                {
                    $msg = '<div class="alert alert-danger">' .$error . '</div>';
                    handleError($msg,'back');
                }

                /* check if there is not error */
                if(empty($formError))
                {
                    
                    $img = rand(0,1000000) . '_' . $imgName;
                    move_uploaded_file($imgTmp,'layout\images\item-images\\' . $img);
                    /* insert the database with this info */
                    $handle = $connect->prepare("insert into items set Name = ?,Brand=?, Description = ?, Price = ?, Country_Made = ?,Cat_ID = ?,Member_ID = ?,Image = ?,Add_Date = now()");
                    $handle->execute(array($name,$brand,$desc,$price,$country,$category,$member,$img));

                    $msg = "<div class='alert alert-success'>" . $handle->rowCount() . 'record inserted</div>';
                    handleError($msg,'back');
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
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
            $sql = "select * from items where item_ID=?";
            $handle = $connect->prepare($sql);
            $handle->execute(array($itemid));
            $item =$handle->fetch();
            $count = $handle->rowCount();
            if($count > 0)
            {
                ?>
                    <h1 class="text-center ahmed">Edit Item</h1>
                    <div class = "container">
                        <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
                            <!-- start Name field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="text" name="name" class="form-control" id="inputname" required placeholder="Item Name" value="<?php echo $item['Name'] ?>">
                                </div>
                            </div>
                            <!-- end Name field  -->
                            <!-- start Brands field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Brands</label>
                                <div class="col-sm-10 col-md-4">
                                    <select name="brand" id="">
                                        <option value="0" disabled>...</option>
                                        <?php
                                            $stmt = $connect->prepare("select * from brands");
                                            $stmt->execute();
                                            $brs = $stmt->fetchAll();
                                            foreach($brs as $value)
                                            {
                                                echo "<option value='" . $value['Name'] . "' >" . $value['Name'] . "</option>";
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- end Brands field  -->
                            <!-- start Description field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="text" name="description" class="form-control" id="inputname" required placeholder="Description Name" value="<?php echo $item['Description'] ?>">
                                </div>
                            </div>
                            <!-- end Description field  -->
                            <!-- start Price field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="text" name="price" class="form-control" id="inputname" required placeholder="Price Name" value="<?php echo $item['Price'] ?>">
                                </div>
                            </div>
                            <!-- end Price field  -->
                            <!-- start country field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Country</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="text" name="country" class="form-control" id="inputname" required placeholder="Country Of Made" value="<?php echo $item['Country_Made'] ?>">
                                </div>
                            </div>
                            <!-- end country field  -->
                            <!-- start Categories field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Categories</label>
                                <div class="col-sm-10 col-md-4">
                                    <select name="category" id="">
                                        <option value="0" disabled>...</option>
                                        <?php
                                            $stmt = $connect->prepare("select * from categories");
                                            $stmt->execute();
                                            $cats = $stmt->fetchAll();
                                            foreach($cats as $value)
                                            {
                                                echo "<option value='" . $value['ID'] . "'";
                                                if($item['Cat_ID']==$value['ID']){echo 'selected';}
                                                echo ">" . $value['Name'] . "</option>";
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- end Categories field  -->
                            <!-- start member field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputname" class="col-sm-2 control-label">Member</label>
                                <div class="col-sm-10 col-md-4">
                                    <select name="member" id="">
                                        <option value="0" disabled>...</option>
                                        <?php
                                            $stmt = $connect->prepare("select * from users");
                                            $stmt->execute();
                                            $users = $stmt->fetchAll();
                                            foreach($users as $value)
                                            {
                                                echo "<option value='" . $value['UserID'] . "'";
                                                if($item['Member_ID']==$value['UserID']){echo 'selected';} 
                                                echo ">" . $value['Username'] . "</option>";
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- end member field  -->
                            <!-- start image field  -->
                            <div class="form-group form-group-lg row">
                                <label for="inputImg" class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="file" name="image" id="inputImg" required>
                                </div>
                            </div>
                            <!-- end image field  -->
                            <!-- start btn field  -->
                            
                            <div class="form-group form-group-lg row">
                            <div class="col-sm-2"></div>
                                <div class="col-sm-10 col-md-4">
                                    <button type="submit" class="btn btn-primary btn-lg">Save Item</button>
                                </div>
                            </div>
                            <!-- end btn field  -->
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
            echo '<h1 class="text-center ahmed">Update Item</h1>';
            echo '<div class="container">';
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                /* get image */
                $imgName  = $_FILES['image']['name'];
                $imgType  = $_FILES['image']['type'];
                $imgTmp   = $_FILES['image']['tmp_name'];
                $imgError = $_FILES['image']['error'];
                $imgSize  = $_FILES['image']['size'];

                $imgAllowedExtension = array("jpeg","jpg","png","gif");

                $imgExtension = strtolower(end(explode('.',$imgName)));
                /* get info */
                $id       = $_POST['itemid'];
                $name     = $_POST['name'];
                $brand    = $_POST['brand'];
                $desc     = $_POST['description'];
                $price    = $_POST['price'];
                $country  = $_POST['country'];
                $member   = $_POST['member'];
                $category = $_POST['category'];
                
                $formError = array();
                if(empty($name))
                {
                    $formError[] = 'name cant be empty';
                }
                if(empty($desc))
                {
                    $formError[] = 'description cant be empty';
                }
                if(empty($price))
                {
                    $formError[] = 'price cant be empty';
                }
                if(empty($country))
                {
                    $formError[] = 'country cant be empty';
                }
                if($member == 0)
                {
                    $formError[] = 'member cant be empty';
                }
                if($category == 0)
                {
                    $formError[] = 'category cant be empty';
                }
                if(!empty($imgName) && !in_array($imgExtension,$imgAllowedExtension))
                {
                    $formError[] = 'this extension is not <strong>Allowed</strong>';
                }
                if(empty($imgName))
                {
                    $formError[] = 'image <strong>Required</strong>';
                }
                if($imgSize > 4000000)
                {
                    $formError[] = 'Image has big size must be less Than <strong>4M</strong>';
                }

                foreach($formError as $error)
                {
                    echo '<div class="alert alert-danger">' .$error . '</div>';
                }

                /* check if there is not error */
                if(empty($formError))
                {
                    $img = rand(0,1000000) . '_' . $imgName;
                    move_uploaded_file($imgTmp,'layout\images\item-images\\' . $img);
                /* update the database with this info */
                $handle = $connect->prepare("UPDATE items 
                                             set 
                                                Name = ?,Brand=? ,Description = ?, Price = ?,Country_Made = ?,Member_ID=?,Cat_ID=?,Image=? 
                                             where 
                                                item_ID = ?");
                $handle->execute(array($name,$brand,$desc,$price,$country,$member,$category,$img,$id));

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
            echo '<h1 class="text-center ahmed">Deleted Item</h1>';
            echo '<div class="container">';
    
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
            
            $count = checkItem('item_ID','items',$itemid);
            if($count > 0)
            {
                $handle = $connect->prepare("delete from items where item_ID = ?");
                $handle->execute(array($itemid));
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
        elseif($do == 'Approve')
        {
            /* Approve page */
            echo '<h1 class="text-center ahmed">Approve Item</h1>';
            echo '<div class="container">';
    
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
            $count = checkItem('item_ID','items',$itemid);
            if($count > 0)
            {
                $handle = $connect->prepare("update items set Approve = 1 where item_ID = ?");
                $handle->execute(array($itemid));
                $msg = "<div class='alert alert-success'>" . $handle->rowCount() . 'record Activated</div>';
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