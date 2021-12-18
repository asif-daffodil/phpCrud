<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="./home">SMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Add Student</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Student List</a>
        </li>
        <?php if(!isset($_SESSION['name'])){ ?>
        <li class="nav-item">
          <a class="nav-link" href="./login">Log in</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./signup">Sign up</a>
        </li>
        <?php }else{ ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><?= $_SESSION['name']; ?></a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="profile">Edit Profile</a></li>
                <li><a class="dropdown-item" href="imageupload">Upload Image</a></li>
                <li><a class="dropdown-item" href="changepass">Change Password</a></li>
                <li><hr class="dropdown-divider"></hr></li>
                <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
            </ul>
        </li>
        <?php } ?>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="text" placeholder="Search">
        <button class="btn btn-primary" type="button">Search</button>
      </form>
    </div>
  </div>
</nav>