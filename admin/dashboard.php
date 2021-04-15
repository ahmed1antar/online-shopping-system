<?php
    ob_start(); /* output buffering */
    session_start();
    $background=1;
    $pageTitle = "Skin_Care";

    if(isset($_SESSION['username']))
    {
        include 'init.php';
        /* start dashboard page */

        $numUsers = 6;

        $theUsers = getLatest("*","users","UserID",$numUsers);
    
        ?>

        <div class="container home-stats">
            <h1 class="text-center ahmed">Dashboard</h1>
            <div class="row">
                <!-- start member section  -->
                <div class="col-md-3">
                    <div class="stat st-members text-center">
                        Total Member
                        <span><a href="members.php"> <?php echo $count = countItems("UserID","users");?> </a></span>
                    </div>
                </div>
                <!-- start member section  -->
                <!-- start pending member section  -->
                <div class="col-md-3">
                    <div class="stat st-pending text-center">
                        Total Brand
                        <span><a href="brand.php?do=Manage">
                            <?php echo countItems('Name','brands') ?>
                        </a></span>
                    </div>
                </div>
                <!-- end pending member section  -->
                <!-- start items section  -->
                <div class="col-md-3">
                    <div class="stat st-items text-center">
                        Total Items
                        <span><a href="items.php">
                            <?php echo countItems('item_ID','items'); ?>
                        </a></span>
                    </div>
                </div>
                <!-- end items section  -->
                <!-- start orders section  -->
                <div class="col-md-3">
                    <div class="stat st-pending text-center">
                        Orders
                        <span><a href="orders.php?do=Manage">
                            <?php echo countItems('ID','orders') ?>
                        </a></span>
                    </div>
                </div>
                <!-- end orders section  -->
                
                
            </div>
        </div>

        <?php


        /* end dashboard page */
        include $tpl . 'footer.php';
    }

    else
    {
        header('Location : index.php');
        exit();
    }

    ob_end_flush();