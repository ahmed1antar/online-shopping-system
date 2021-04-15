<?php
    $pageTitle = 'Profile';
    $background = 1;
    $done = 0;
    include 'init.php';
    $Nitem = $_GET['nameOrder'];
    $Pitem = $_GET['priceOrder'];
     
        
        ?>
    
        <?php
            if(isset($_GET['fullnameOrder']))
            {
                if(isset($_GET['phonenumberOrder']))
                {
                    if(isset($_GET['addressOrder']))
                    {
                        $fnameOrder    = filter_var($_GET['fullnameOrder'],FILTER_SANITIZE_STRING);
                        $phoneOrder    = filter_var($_GET['phonenumberOrder'],FILTER_SANITIZE_NUMBER_INT);
                        $addressOrder  = $_GET['addressOrder'];
                        $nameOrder     = filter_var($_GET['nameOrder'],FILTER_SANITIZE_STRING);
                        $priceOrder    = filter_var($_GET['priceOrder'],FILTER_SANITIZE_NUMBER_INT);
                        $stmt = $connect->prepare("INSERT into orders set FullName=?,PhoneNumber=?,Address=?,NameItem=?,Price=?,Date=now()");
                        $stmt->execute(array($fnameOrder,$phoneOrder,$addressOrder,$nameOrder,$priceOrder));
                        $done = 1;
                    }
                }
            }
        ?>
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                </div>
                <div class="col-md-5 border-right">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>">
                            <div class="p-3 py-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-right">Order</h4>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12"><label class="labels">Full Name</label><input type="text" name="fullnameOrder" class="form-control" placeholder="FullName" required></div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12"><label class="labels">PhoneNumber</label><input type="text" name="phonenumberOrder" class="form-control" placeholder="enter phone number" required></div>
                                    <div class="col-md-12"><label class="labels">Address</label><input type="text" name="addressOrder" class="form-control" placeholder="enter address" required></div>
                                    
                                    <div class="col-md-12"><label class="labels">Name Order</label><input type="text" class="form-control" placeholder="<?php echo $Nitem ?>" disabled></div>
                                    <div class="col-md-12"><label class="labels">Price</label><input type="text" class="form-control" placeholder="<?php echo $Pitem ?>" value="<?php echo $Pitem ?>" disabled></div>
                                    
                                    <div class="col-md-12"><input type="text" name="nameOrder" class="form-control" placeholder="<?php echo $Nitem ?>" value="<?php echo $Nitem ?>" hidden></div>
                                    <div class="col-md-12"><input type="text" name="priceOrder" class="form-control" placeholder="<?php echo $Pitem ?>" value="<?php echo $Pitem ?>" hidden></div>
                                </div>
                                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Order Now</button></div>
                            </div>
                        </form>
                    </div>
                <div class="col-md-4">
                    <?php
                        if($done == 1)
                        {
                            echo '<div class="p-3 py-5">';
                                echo '<i class="fa fa-check-circle" style="color:green"></i> Done!';
                            echo '</div>';
                        }
                        else
                        {
                            echo '<div class="p-3 py-5">';
                            echo '</div>';
                        }
                    ?>
                    
                </div>
            </div>
        </div>

<?php   
    include $tpl . 'footer.php';
?>