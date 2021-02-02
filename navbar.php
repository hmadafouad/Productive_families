<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">PFA</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link" href="homepage.php">Home</a>
      </li>
     
      </li>
      <li class="nav-item">
        <a class="nav-link" href="items.php">Items</a>
      </li>
      <?php 
        if (empty(isset($_SESSION['username']))){ 
      echo '<li class="nav-item">';
        echo '<a class="nav-link" href="login.php">Login</a>';
      echo '</li>';
}
      
        if (isset($_SESSION['username'])){ 
      
      echo '<li class="nav-item dropdown">';
        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
         echo $_SESSION['username'] ;
       echo '</a>';
        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
          echo '<a class="dropdown-item" href="profile.php">My Profile</a>';
          echo '<a class="dropdown-item" href="my_items.php">My Items</a>';
          echo '<a class="dropdown-item" href="logout.php">Logout</a>';
        echo '</div>';
      echo '</li>';
      } ?>
    
    </ul>
  </div>
</nav>