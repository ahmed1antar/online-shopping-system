<?php
    /* manage member */
    /* add , edit , remove*/

    session_start();

    $pageTitle = 'Orders';
    $background=1;

    if(isset($_SESSION['username']))
    {
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if($do == 'Manage')
        {
            /* manage member page */

            

            /* select all user except admins */
            $handle = $connect->prepare("SELECT * from orders");
            $handle->execute();
            /* fetch data */
            $row = $handle->fetchAll();


        ?>
            <h1 class="text-center ahmed">Order</h1>
            <div class = "container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>Client</td>
                            <td>Phone Number</td>
                            <td>Address</td>
                            <td>Name Of Item</td>
                            <td>Price</td>
                            <td>Date</td>
                            <td>Control</td>
                        </tr>
                        <?php
                            foreach($row as $value)
                            {
                                echo '<tr>';
                                    echo '<td>' . $value['FullName'] . '</td>';
                                    echo '<td>' . $value['PhoneNumber'] . '</td>';
                                    echo '<td>' . $value['Address'] . '</td>';
                                    echo '<td>' . $value['NameItem'] . '</td>';
                                    echo '<td>' . $value['Price'] . '</td>';
                                    echo '<td>' . $value['Date'] . '</td>';
                                    echo "<td>
                                                <a href='?do=Delete&comid=" . $value['ID'] . "'class='btn btn-danger confirm'><i class='fa fa-close faa'></i>Delete</a>";
                                                if($value['status']==1)
                                                {
                                                   echo "<a href='?do=Delivered&comid=" . $value['ID'] . "'class='btn btn-success activate'><i class='fa fa-check faa'></i>Delivered</a>";
                                                }
                                                if($value['status']==0)
                                                {
                                                   echo "<a href='?do=Delivered&comid=" . $value['ID'] . "'class='btn btn-info activate'><i class='fa fa-spinner faa'></i>Waiting</a>";
                                                }
                                                
                                        echo "</td>";
                                echo '<tr>';

                            }
                        ?>
                        
                    </table>
                </div>
            </div>
        <?php
        }
        
        elseif($do == 'Delete')
        {
            /* page for delete member */
            echo '<h1 class="text-center ahmed">Deleted Order</h1>';
            echo '<div class="container">';
    
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
            $count = checkItem('ID','orders',$comid);
            if($count > 0)
            {
                $handle = $connect->prepare("delete from orders where ID = ?");
                $handle->execute(array($comid));
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
        elseif($do == 'Delivered')
        {
            /* activate page */
            echo '<h1 class="text-center ahmed">Delivered order</h1>';
            echo '<div class="container">';
    
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
            
            $count = checkItem('ID','orders',$comid);
            if($count > 0)
            {
                $handle = $connect->prepare("update orders set status = 1 where ID = ?");
                $handle->execute(array($comid));
                $msg = "<div class='alert alert-success'>" . $handle->rowCount() . 'Order Delivered</div>';
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
?>