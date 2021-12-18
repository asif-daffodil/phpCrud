<?php 
    include_once('header.php');
    (isset($_SESSION['name']))? header("location: home"):null;
    if(isset($_POST['sub123']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $fname = safe($_POST['fname']);
        $uname = safe($_POST['uname']);
        $email = safe($_POST['email']);
        $pswd = safe($_POST['pswd']);
        $pswd2 = safe($_POST['pswd2']);
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
            $check_uname = $conn->query("SELECT * FROM `users` WHERE `uname` = '$uname' ");
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
            $check_email = $conn->query("SELECT * FROM `users` WHERE `email` = '$email'");
            if($check_email->num_rows > 0){
                $errEmail = "Email address already exicts";
            }else{
                $crrEmail = $email;
            }
        }

        if(empty($pswd)){
            $errPass = "Please write your password";
        }elseif(strlen($pswd) < 6){
            $errPass = "Please write an strong password";
        }else{
            $crrPass = $conn->real_escape_string($pswd);
        }

        if(empty($pswd2)){
            $errConPass = "Please write your confirm password";
        }elseif($crrPass != $pswd2){
            $errConPass = "Password didnot matched";
        }else{
            $crrConPass = $conn->real_escape_string($pswd2);
        }

        if(isset($crrFname) && isset($crrUname) && isset($crrEmail) && isset($crrConPass)){
            $crrConPass = md5($crrConPass);
            $insert = $conn->query("INSERT INTO `users` (`name`, `uname`, `email`, `pass`) VALUES ('$crrFname', '$crrUname','$crrEmail','$crrConPass')");
            if (!$insert) {
                $msg = "<div class='alert alert-danger alert-dismissible'><button class='btn-close' data-bs-dismiss='alert'></button>Something went wrong</div>";
            }else{
                $msg = "<div class='alert alert-success alert-dismissible'><button class='btn-close' data-bs-dismiss='alert'></button>Registration Successfull</div>";
                $_SESSION['name'] = $crrFname;
                $_SESSION['uname'] = $crrUname;
                $_SESSION['email'] = $crrEmail;
                echo "<script>setInterval(function(){location.href = 'home'}, 2000)</script>";
            }
        }
    }
?>
    <!-- <?= (isset($_POST['sub123']))? 'needs-validation':null; ?> -->
    <div class="container">
        <div class="row d-flex mt-5">
            <div class="col-md-6 m-auto border p-5 rounded shadow">
            <h2 class="mb-3">Sign-up Form</h2>
            <?= $msg ?? null; ?>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="mb-4 needs-validation" novalidate>
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control <?= (isset($errFname))? 'is-invalid':null; ?> <?= (isset($crrFname))? 'is-valid':null; ?>" id="fname" placeholder="Full Name" name="fname" value="<?= $fname ?? null; ?>">
                    <label for="fname" class="form-label">Full Name:</label>
                    <div class="valid-feedback">Valid Name</div>
                    <div class="invalid-feedback"><?= $errFname ?? null; ?></div>
                </div>
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control <?= (isset($errUname))? 'is-invalid':null; ?> <?= (isset($crrUname))? 'is-valid':null; ?>" id="uname" placeholder="User Name" name="uname"  value="<?= $uname ?? null; ?>">
                    <label for="uname" class="form-label">User Name:</label>
                    <div class="valid-feedback">Valid user-name.</div>
                    <div class="invalid-feedback"><?= $errUname ?? null; ?></div>
                </div>
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control <?= (isset($errEmail))? 'is-invalid':null; ?> <?= (isset($crrEmail))? 'is-valid':null; ?>" id="email" placeholder="Enter email" name="email"  value="<?= $email ?? null; ?>">
                    <label for="email">Email</label>
                    <div class="valid-feedback">Valid email address</div>
                    <div class="invalid-feedback"><?= $errEmail ?? null; ?></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control <?= (isset($errPass))? 'is-invalid':null; ?> <?= (isset($crrPass))? 'is-valid':null; ?>" id="pwd" placeholder="Enter password" name="pswd"  value="<?= $pswd ?? null; ?>">
                    <label for="pwd" class="form-label">Password:</label>
                    <div class="valid-feedback">Valid password</div>
                    <div class="invalid-feedback"><?= $errPass ?? null; ?></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control <?= (isset($errConPass))? 'is-invalid':null; ?> <?= (isset($crrConPass))? 'is-valid':null; ?>" id="pwd2" placeholder="Confirm Password" name="pswd2"  value="<?= $pswd2 ?? null; ?>">
                    <label for="pwd2" class="form-label">Confirm Password:</label>
                    <div class="valid-feedback">Valid confirm password</div>
                    <div class="invalid-feedback"><?= $errConPass ?? null; ?></div>
                </div>
                <button type="submit" class="btn btn-primary" name="sub123">Submit</button>
            </form>
            Already have account? <a href="./login">Log in</a> Here !
            </div>
        </div>
    </div>
<?php include_once('footer.php'); ?>