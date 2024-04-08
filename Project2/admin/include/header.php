<?php 
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page filename
?>

<nav class="navbar navbar-expand-lg bg-info">
  <div class="container">
    <a class="navbar-brand text-light" href="main.php"><h3>Pacific</h3></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php if($current_page == 'main.php') echo 'text-light active'; ?>" href="main.php"><h4>Home</h4></a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($current_page == 'report.php') echo 'text-light active'; ?>" href="report.php"><h4>Report</h4></a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($current_page == 'create-user.php') echo 'text-light active'; ?>" href="create-user.php"><h4>Create</h4></a>
        </li>
        <li class="nav-item d-sm-none d-md-none">
          <a href="#"><div class="nav-link justify-content-end"><h4>Logout</h4></div></a>
        </li>
      </ul>
    </div>
    <a href="#" class="nav-link justify-content-end d-none d-lg-block text-white"><h4>Logout</h4></a>
  </div>
</nav>
