<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php setTitle(); ?></title>
        <link rel="stylesheet" href="<?php echo $css;?>bootstrap.css">
        <link rel="stylesheet" href="<?php echo $css;?>hover.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $css;?>jquery-ui.css">
        <link rel="stylesheet" href="<?php echo $css;?>jquery.selectBoxIt.css">
        <link rel="stylesheet" href="<?php echo $css;?>frontend.css">
    </head>
    <body <?php if($background == 0){echo 'class="bg-login"';} ?> >

    <!-- <body> -->
    <!-- START session  -->
    <?php 
      if(session_start() == 0)
      {
        session_start();
      }
    ?>
      
    <!-- END session  -->
    <!-- START NAVBAR  -->
    <nav class="navbar navbar-expand-lg navbar-light bg-my">
        <a class="navbar-brand" href="#">BareBeauty</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="app-nav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            
            <?php
                $categories = getCat();
                foreach($categories as $value)
                {
                    echo 
                    "<li class='nav-item'>
                    <a class='nav-link' href='categories.php?pageid=" . $value['ID'] . "&pagename=" . str_replace(' ','-',$value['Name']) . "'>" . $value['Name'] . "</a>
                    </li>"; 
                }?>
            
          </ul>
          
          <ul class="navbar-nav ml-auto">
          <li>
            <?PHP
            
              if(isset($_SESSION['Email']))
              {
                  $stmt = $connect->prepare("SELECT Username from users where Email = ?");
                  $stmt->execute(array($_SESSION['Email']));
                  $row = $stmt->fetch();
                  $_SESSION['Username'] = $row['Username'];
                  echo 'welcome' . ' ' . $_SESSION['Username'] . " ";
                  echo "<a href='order.php'>order</a>";
                  echo " " . "<a href='logout.php'>LogOut</a>";
              }
              else{
                  ?>
                    <a href="login.php">
                      
                      <span class="pull-right text-dark ">Sign In<i class="fa fa-user-circle faa"></i></span>
                    </a>
            <?php
              }?>
          </li>
          
        </ul>
        
      </div>
    </nav>
<!-- END NAVBAR  -->    
    