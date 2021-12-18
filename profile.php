<?php 
    include_once('header.php');
    (!isset($_SESSION['name']))? header("location: login"):null;
    $pUname = $_SESSION['uname'];
    $getPreDetailsQuery = $conn->query("SELECT * FROM `users` WHERE `uname` = '$pUname'");
    $predata = $getPreDetailsQuery->fetch_object();
    if(isset($_POST['sub123']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $fname = safe($_POST['fname']);
        $uname = safe($_POST['uname']);
        $email = safe($_POST['email']);
        if(empty($fname)){
            $errFname = "Please write your full name";
        }elseif(!preg_match('/^[A-Za-z. ]*$/', $fname)){
            $errFname = "Invalid name";
        }else{
            $crrFname = $conn->real_escape_string($fname);
        }
        
        if(empty($uname)){
            $errUname = "Please write your user name";
        }else{
            $uname = $conn->real_escape_string($uname); 
            $check_uname = $conn->query("SELECT * FROM `users` WHERE `uname` = '$uname' AND `uname` != '$predata->uname' ");
            if($check_uname->num_rows > 0){
                $errUname = "User name already exicts"; 
            }else{
                $crrUname = $uname; 
            }
        }

        if(empty($email)){
            $errEmail = "Please write your email address";
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errEmail = "Invalid email address";
        }else{
            $email = $conn->real_escape_string($email);
            $check_email = $conn->query("SELECT * FROM `users` WHERE `email` = '$email' AND `email` != '$predata->email'");
            if($check_email->num_rows > 0){
                $errEmail = "Email address already exicts";
            }else{
                $crrEmail = $email;
            }
        }
        if(isset($crrFname) && isset($crrUname) && isset($crrEmail)){
            $update = $conn->query("UPDATE `users` SET `name` = '$crrFname', `email` = '$crrEmail', `uname` = '$crrUname' WHERE id = $predata->id; ");
            if (!$update) {
                $msg = "<div class='alert alert-danger alert-dismissible'><button class='btn-close' data-bs-dismiss='alert'></button>Something went wrong</div>";
            }else{
                if($predata->name == $crrFname && $predata->email == $crrEmail && $predata->uname == $crrUname){
                    $msg = "<div class='alert alert-danger alert-dismissible'><button class='btn-close' data-bs-dismiss='alert'></button>Nothing to update</div>";
                }else{
                    $msg = "<div class='alert alert-success alert-dismissible'><button class='btn-close' data-bs-dismiss='alert'></button>Profile Updated Successfull</div>";
                    $_SESSION['name'] = $crrFname;
                    $_SESSION['uname'] = $crrUname;
                    $_SESSION['email'] = $crrEmail;
                    echo "<script>setInterval(function(){location.href = 'profile'}, 2000)</script>";
                }
            }
        }
    }
?>
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-6 m-auto p-5">
                <div class="border rounded shadow w-100 h-100 py-5 px-3">
                    <h2 class="mb-3">Update Profile</h2>
                    <?= $msg ?? null; ?>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" novalidate>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control <?= (isset($errFname))? 'is-invalid':null; ?> <?= (isset($crrFname))? 'is-valid':null; ?>" placeholder="Name" name="fname" value="<?= $fname ?? $_SESSION['name']; ?>">
                            <label for="">Name</label>
                            <div class="valid-feedback">Valid Name</div>
                            <div class="invalid-feedback"><?= $errFname ?? null; ?></div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control <?= (isset($errEmail))? 'is-invalid':null; ?> <?= (isset($crrEmail))? 'is-valid':null; ?>" placeholder="Email" name="email" value="<?= $email ?? $_SESSION['email']; ?>">
                            <label for="">Email</label>
                            <div class="valid-feedback">Valid Email Address</div>
                            <div class="invalid-feedback"><?= $errEmail ?? null; ?></div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control  <?= (isset($errUname))? 'is-invalid':null; ?> <?= (isset($crrUname))? 'is-valid':null; ?>" placeholder="User Name" name="uname" value="<?= $uname ?? $_SESSION['uname']; ?>">
                            <label for="">User Name</label>
                            <div class="valid-feedback">Valid User Name</div>
                            <div class="invalid-feedback"><?= $errUname ?? null; ?></div>
                        </div>
                        <input type="submit" value="Update Profile" name="sub123" class="btn btn-primary btn-sm">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include_once('footer.php'); ?>
    
