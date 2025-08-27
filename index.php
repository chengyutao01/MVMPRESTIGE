<?php
require_once("boot.ini.php");
$err="";
if (isset($_GET["err"])) {
	$err=$_GET["err"];
}
 ?>
<html lang="it">
  <head>
    <title>MVM</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <?php
       include(getenv('ROOT_DIR') . "_head.php");
      $current_page = "index";
    ?>
  </head>
  <body>
    <div class="row m-0">
      <header class="px-4 py-2 logo-index w-100">
        <a href="<?=getenv('SITE_URL')?>">
          <img src="<?=getenv('SITE_URL')?>assets/images/logo.png" alt="logo MVM">
        </a>
      </header>
      <div class="bg-image col-12 p-0">
        <div class="text-right p-3 p-lg-4">
          <div class="top-account">
            <?php include(getenv('ROOT_DIR') . "/_top.php") ?>
          </div>

          <div class="login-index mx-auto">
            <p class="font-LC h4 px-3 text-left mt-2 text-plonk">ACCEDI</p>
            <form class="form-dati my-3" action="login.php" method="post" role="form">
                <?php
                    if ($err == "noauth") {
                         ?>
                         <div class="alert alert-danger" role="alert">
                            Access denied. Retry.
                         </div>
                         <?php
                    }
                ?>
                <div class="form-group ">
                     <div class="col-12">
                        <input type="text" id="email" name="username" class="form-control" placeholder="username" >
                      </div>
                  </div>
                  <div class="form-group mb-3 mb-md-1">
                     <div class="col-12">
                        <input type="password" id="pwd" name="password" class="form-control" placeholder="password" <?php if (isset($_SESSION["ShipmentData"])) echo "value='".htmlentities($_SESSION["ShipmentData"]["surname"],ENT_QUOTES,"UTF-8")."'"; ?> >
                         <small>
                           <a class="text-info d-md-block d-lg-inline" href="#">Password smarrita?</a>
                         </small>
                      </div>
                  </div>
                  <div class="form-group ">
                      <!--<label class="col-sm-3 control-label">&nbsp;</label>-->
                      <div class="col-12 pt-sm-3">
                        <button type="submit" class="btn btn-primary font-PT w-100">ACCEDI</button>
                       </div>
                  </div>
               </form>
           </div>
				 </div>
        </div>
        <footer class="bg-black text-light">
          <?php require_once(dirname(__FILE__)."/_footer.php") ?>
        </footer>
    </div>
    <?php echo getenv('DB_SCHEMA');
          echo getenv('DB_USER');
          echo getenv('DB_PASSWORD');
          ?>
  </body>
</html>
