<?php $background = 1; include 'init.php'; ?>

    <!-- start description part  -->
    <div class="container" style="margin-top:50px;">
        <div class="row">
            <div class="col-lg-8 col-md-8 hidden1-xs hidden1-sm">
                <div class="c-category-cover__title">
                    <?php echo str_replace('-',' ',$_GET['pagename']); ?>
                </div>
                <div>
                    <?php
                        $stmt = $connect->prepare("SELECT Description from categories where ID=?");
                        $stmt->execute(array($_GET['pageid']));
                        $row = $stmt->fetch();
                        echo $row['Description'];
                     ?>                    
                </div>
            </div>
            <!-- <div class="col-lg-4 col-md-4 hidden1-xs hidden1-sm">
                <img class="makeup-bg" src="layout/images/makeup-images/image01.jpg" alt="">
            </div> -->
        </div>
    </div>
    <!-- end description part  -->
    
    <!-- start show items  -->

    <div class="container">
        <br><p class="text-center c-category-cover__title"><?php echo str_replace('-',' ',$_GET['pagename']); ?></p>
        <hr>
        <?php
            $stmt = $connect->prepare("SELECT * from items");
            $stmt->execute();
            $row = $stmt->fetchAll();
            echo '<div class="row">';
            foreach($row as $item)
            {
                if($_GET['pageid'] == $item['Cat_ID'])
                {

                
                    echo '<div class="col-md-4">';
                        echo '<figure class="card card-product">';
                            echo '<div class="img-wrap">';
                            echo "<img class=\"makeup-bg\" src='admin/layout/images/item-images/" . $item['Image'] . "'>";
                            echo '</div>';
                            echo '<figcaption class="info-wrap">';
                                echo '<h4 class="title faa">' . $item['Name'] . '</h4>';
                                echo '<p class="desc faa">' . $item['Description'] . '</p>';
                            echo '</figcaption>';
                            echo '<div class="bottom-wrap faa">';
                                echo '<a href="order.php?priceOrder=' . $item['Price'] . '&nameOrder=' . $item['Name'] . '" class="btn btn-sm btn-primary float-right order-button">Order Now</a>';
                                echo '<div class="price-wrap h5">';
                                    echo '<span class="price-new">$' . $item['Price'];
                                echo '</div>';
                            echo '</div>';
                        echo '</figure>';
                    echo '</div>';
                }
                
            }
            echo '</div>';?>  
    </div>
            
        
    <!-- end show items  -->

<?php include $tpl . 'footer.php'; ?>
