<?php
    $pageTitle = 'Home Page';
    $background = 1;
    include 'init.php';
?>
    <!-- start sliding image  -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="layout/images/home-images/image01.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="layout/images/home-images/image02.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="layout/images/home-images/image03.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="layout/images/home-images/image04.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- end sliding image  -->
    <!-- start body page  -->
        <?php
            $stmt = $connect->prepare("SELECT Name from brands");
            $stmt->execute();
            $row = $stmt->fetchAll();
            

            foreach($row as $brs)
            {
                echo '<div class="container">';
                echo '<br>  <p class="text-center c-category-cover__title ">' . $brs['Name'] . '</p>';
                echo '<hr>';
                echo '<div class="row">';
                $stmt = $connect->prepare("SELECT Name,Brand,Description,Price,Image from items");
                $stmt->execute();
                $row = $stmt->fetchAll();

                foreach($row as $item)
                {
                    if($brs['Name'] == $item['Brand'])
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
                        echo '<input type="hidden" method="GET" value="?price=' . $item['Price'] . '&nameitem=' . $item['Name'] . '">';
                        echo '<a href="order.php?priceOrder=' . $item['Price'] . '&nameOrder=' . $item['Name'] . '" class="btn btn-sm btn-primary float-right order order-button">Order Now</a>';
                        echo '<div class="price-wrap h5">';
                            echo '<span class="price-new">$' . $item['Price'];
                        echo '</div>';
                        echo '</div> ';
                        echo '</figure>';
                        echo '</div>';
                    }
                    
                    
                    
                }
                echo '</div>';
                echo '</div>'; 
            } 
        ?>
    <!-- end body page  -->
    


    <!-- start footer page  -->
    
    <!--container.//-->

    <br><br><br>
    <article class="bg-secondary mb-3">  
    <div class="card-body text-center">
        <h4 class="text-white">Contact </h4>
    </div>
    <p class="h5 text-white"><i class="fa fa-user-o faa"></i> Author By : Ahmed Mahmoud Antar</p>   
    <br>
    <p class="h5 text-white"><i class="fa fa-phone faa"></i> Mobile : 01144307519</p>   
    <br>
    <p class="h5 text-white"><i class="fa fa-envelope faa"></i> Email : ahmed.m.antar@gmail.com</p>   
    <br>
    
    </article>
    <!-- end footer page  -->
    
<?php include $tpl . 'footer.php';?>

