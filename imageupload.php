<?php 
    include_once('header.php'); 
    (!isset($_SESSION['name']))? header("location: login"):null;
    $uname = $_SESSION['uname'];
    $getPreImgQuery = $conn->query("SELECT * FROM `users` WHERE `uname` = '$uname'");
    $getPreImgObj = $getPreImgQuery->fetch_object();
    if(isset($_POST['sub123']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
       $fName = $_FILES['img']['name'];
       $tmpName = $_FILES['img']['tmp_name'];
       if(empty($fName)){
            $errFile = "Please upload a image";
       }elseif(filesize($tmpName) > 604400){
            $errFile = "please choose an small file";
       }elseif (!getimagesize($tmpName)) {
            $errFile = "Invalid image";
       }elseif(getimagesize($tmpName)[0] > 4000 && getimagesize($tmpName)[1] > 4000){
            $errFile = "Please choose an small image";
       }else{
            $newFileName = uniqid().rand().date('hmsmdY').$fName;
            $destination = "./images/".$newFileName;
            if ($getPreImgObj->img != '') {
               $id = $getPreImgObj->id;
               $DelPreImgDb = $conn->query("UPDATE `users` SET `img` = '' WHERE `users`.`id` = $id");
               if (!$DelPreImgDb) {
                 $errFile = "Previous image database problem";
               }else{
                   unlink($getPreImgObj->img);
                   move_uploaded_file($tmpName, $destination);
                   $updateImg = $conn->query("UPDATE `users` SET `img` = '$destination' WHERE id = $id");
                   if($updateImg){
                    $getPreImgQuery = $conn->query("SELECT * FROM `users` WHERE `uname` = '$uname'");
                    $getPreImgObj = $getPreImgQuery->fetch_object();
                        $success = "Image uploaded successfully";
                        echo "<script>setInterval(function(){location.href=".$_SERVER['PHP_SELF']."},500)</script>";
                   }
               }
            }else{
                $id = $getPreImgObj->id;
                move_uploaded_file($tmpName, $destination);
                $conn->query("UPDATE `users` SET `img` = '$destination' WHERE id = $id");
                $success = "Image uploaded successfully";
                echo "<script>setInterval(function(){location.href=".$_SERVER['PHP_SELF']."},500)</script>";
            }
       }
    }
?>
    <div class="container">
      <div class="row p-5 d-flex">
          <div class="col-md-6 m-auto p-5">
              <div class="border rounded shadow w-100 text-center px-3 py-5">
                  <img src="<?= ($getPreImgObj->img == '' )? './images/pp.png':$getPreImgObj->img; ?>" alt="" class="img-thumbnail d-block m-auto" id="output" style="object-fit: cover;" width="160" height="160">
                  <div class="text-muted my-3"><?= ($getPreImgObj->img == '' )? 'No image uploaded yet':'Upload New Image'; ?></div>
                  <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" novalidate>
                    <div class="mb-3">    
                      <input type="file" class="form-control in <?= (isset($errFile))? 'is-invalid':null; ?> <?= (isset($success))? 'is-valid':null; ?>" onchange="loadFile(event)" name="img" >
                      <div class="invalid-feedback"><?= $errFile ?? null; ?></div>
                      <div class="valid-feedback"><?= $success ?? null; ?></div>
                    </div>
                      <input type="submit" class="btn btn-primary" value="Upload Image" name="sub123">
                  </form>
              </div>
          </div>
      </div>
    </div>
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
            }
        };
</script>
<?php include_once('footer.php'); ?>
    
