<?php 
    include_once('header.php');
    (!isset($_SESSION['name']))? header("location: login"):null;
    $uname = $_SESSION['uname'];
    if (isset($_POST['sub123']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $opass = safe($_POST['opass']);
        $npass = safe($_POST['npass']);
        $cnpass = safe($_POST['cnpass']);

        if (empty($opass)) {
            $errOpass = "Please write your old password";
        }else{
            $suser = $conn->query("SELECT * FROM `users` WHERE `uname` = '$uname'");
            $suserObj = $suser->fetch_object();
            if (md5($opass) != $suserObj->pass) {
                $errOpass = "Invalid old password";
            }else{
                $crrOpass = $conn->real_escape_string('$opass');
            }
        }

        if (empty($npass)) {
            $errNpass = "Please write your new password";
        }elseif (strlen($npass) < 6) {
            $errNpass = "Please write a strong password";
        }else{
            $crrNpass = $conn->real_escape_string($npass);
        }

        if (empty($cnpass)) {
            $errCnpass = "Please confirm the new password";
        }elseif ($npass != $cnpass) {
            $errCnpass = "Password didnot matched";
        }else{
            $crrCnpass = $conn->real_escape_string($cnpass);
        }

        if(isset($crrOpass) && isset($crrNpass) && isset($crrCnpass)){
            $crrCnpass = md5($crrCnpass);
            $cpassQuery = $conn->query("UPDATE `users` SET `pass` = '$crrCnpass' WHERE `uname` = '$uname'");
            if(!$cpassQuery){
                $msg = "<div class='alert alert-danger alert-dismissible'><button class='btn-close' data-bs-dismiss='alert'></button>Something went wrong</div>";
            }else{
                $msg = "<div class='alert alert-success alert-dismissible'><button class='btn-close' data-bs-dismiss='alert'></button>Password changed</div>";
            }
        }
    }
?>
    <div class="container">
      <div class="row p-5">
          <div class="col-md-6 m-auto px-3 py-4 border rounded shadow">
                <h2 class="mb-4">Change Password</h2>
                <?= $msg ?? null; ?>
                <form action="" method="post" novalidate>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?= (isset($errOpass))? 'is-invalid':null; ?> <?= (isset($crrOpass))? 'is-valid':null; ?>" placeholder="Old Password" name="opass" value="<?= $opass ?? null; ?>">
                        <label for="">Old Password</label>
                        <div class="invalid-feedback"><?= $errOpass ?? null; ?></div>
                        <div class="valid-feedback"></div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?= (isset($errNpass))? 'is-invalid':null; ?> <?= (isset($crrNpass))? 'is-valid':null; ?>" placeholder="New Password" name="npass" value="<?= $npass ?? null; ?>">
                        <label for="">New Password</label>
                        <div class="invalid-feedback"><?= $errNpass ?? null; ?></div>
                        <div class="valid-feedback"></div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?= (isset($errCnpass))? 'is-invalid':null; ?> <?= (isset($crrCnpass))? 'is-valid':null; ?>" placeholder="Confirm New Password" name="cnpass" value="<?= $cnpass ?? null; ?>">
                        <label for="">Confirm New Password</label>
                        <div class="invalid-feedback"><?= $errCnpass ?? null; ?></div>
                        <div class="valid-feedback"></div>
                    </div>
                    <div class="form-form-check-inline mb-3">
                        <input type="checkbox" class="form-form-check-input" id="spass">
                        <label for="" class="form-form-check-label">Show Password</label>
                    </div>
                    <input type="submit" value="Change Password" class="btn btn-primary" name="sub123">
                </form>
          </div>
      </div>
    </div>
    <script>
        let inputs = document.querySelectorAll("input[type='password']");
        document.querySelector("#spass").addEventListener('click', function(){
            if(this.checked == true){
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].type = "text";
                }
            }else{
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].type = "password";
                }
            }
        })
    </script>
<?php include_once('footer.php'); ?>
    
