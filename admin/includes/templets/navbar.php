<nav class="navbar navbar-expand-lg navbar-light bg-my">
  <a class="navbar-brand" href="#">BareBeauty</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="app-nav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php"><?php echo $lang['HOME_ADMIN'];?> </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php"><?php echo $lang['Categories'];?> </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="brand.php"><?php echo $lang['Brand'];?> </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="items.php"><?php echo $lang['Items'];?> </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="members.php"><?php echo $lang['Members'];?> </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="orders.php"><?php echo $lang['Orders'];?> </a>
      </li>
      
      
      
      </ul>
      
      <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Profile
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../index.php" target="_blank">Visit Shop</a>
          <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'];?>">Edit Profile</a>
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="logoutadmin.php">Logout</a>
        </div>
      </li>
      
    </ul>
    
  </div>
</nav>