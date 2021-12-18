<?php 
    include_once('header.php');
    (isset($_SESSION['name']))? header("location: home"):null;
    
    if(isset($_POST['sub123']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = safe($_POST['email']);
        $pswd = safe($_POST['pswd']);
        
        if(empty($email)){
            $errEmail = "Please write your email address";
        }else{
            $crrEmail = $conn->real_escape_string($email);
        }

        if(empty($pswd)){
            $errPass = "Please write your password";
        }else{
            $crrPass = $conn->real_escape_string($pswd);
        }

        if(isset($crrEmail) && isset($crrPass)){
            $crrPass = md5($crrPass);
            $check_email = $conn->query("SELECT * FROM `users` WHERE `email` = '$crrEmail' AND `pass` = '$crrPass'");
            $check_uname = $conn->query("SELECT * FROM `users` WHERE `uname` = '$crrEmail' AND `pass` = '$crrPass'");
            if ($check_email->num_rows == 0 && $check_uname->num_rows == 0) {
                $msg = "<div class='alert alert-danger alert-dismissible'><button class='btn-close' data-bs-dismiss='alert'></button>Username or password is wrong</div>";
            }else{
                $msg = "<div class='alert alert-success alert-dismissible'><button class='btn-close' data-bs-dismiss='alert'></button>Login Successfull</div>";
                if($check_email->num_rows == 1){
                    $udata = $check_email->fetch_object();
                    $crrFname = $udata->name;
                    $crrUname = $udata->uname;
                    $crrEmail = $udata->email;
                }elseif($check_uname->num_rows == 1){
                    $udata = $check_uname->fetch_object();
                    $crrFname = $udata->name;
                    $crrUname = $udata->uname;
                    $crrEmail = $udata->email;
                }
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
            <h2 class="mb-3">Login Form</h2>
            <?= $msg ?? null; ?>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="mb-4 needs-validation" novalidate>
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control <?= (isset($errEmail))? 'is-invalid':null; ?> <?= (isset($crrEmail))? 'is-valid':null; ?>" id="email" placeholder="Enter email or username" name="email"  value="<?= $email ?? null; ?>">
                    <label for="email">Email or Username</label>
                    <div class="valid-feedback">Valid email address or username</div>
                    <div class="invalid-feedback"><?= $errEmail ?? null; ?></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control <?= (isset($errPass))? 'is-invalid':null; ?> <?= (isset($crrPass))? 'is-valid':null; ?>" id="pwd" placeholder="Enter password" name="pswd"  value="<?= $pswd ?? null; ?>">
                    <label for="pwd" class="form-label">Password:</label>
                    <div class="valid-feedback">Valid password</div>
                    <div class="invalid-feedback"><?= $errPass ?? null; ?></div>
                </div>
                <button type="submit" class="btn btn-primary" name="sub123">Login</button>
            </form>
            Don't have account? <a href="./signup">Sign up</a> Here !
            </div>
        </div>
    </div>
<?php include_once('footer.php'); ?>