<?php include_once('header.php'); ?>
    <div class="container">
        <?php if(!isset($_SESSION['name'])){ ?>
            <div class="row">
                <div class="col-md-12 display-1 text-center p-5">
                    Please Login to see the website
                </div>
            </div>
        <?php }else{ ?>
            <div class="row">
                <div class="col-md-12 display-1 text-center p-5">
                    Welcome <?= $_SESSION['name']; ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php include_once('footer.php'); ?>
    
