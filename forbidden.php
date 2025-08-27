<?php 
require_once('boot.ini.php');
require_once(getenv('ROOT_DIR') .'auth.php');


?>
<html lang="it">
  <head>
     <title><?=l('general.Forbidden')?>-<?=$SITE_NAME?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <?php   include(getenv('ROOT_DIR') . "_head.php");?>
  </head>
  <body class="container-fluid">
    <div class="row">

           <?php include(getenv('ROOT_DIR') . "_menu.php") ?>

      <div id="site-wrapper" class="col-12 col-md-9 col-xl-10 p-0">

             <?php include(getenv('ROOT_DIR') . "_top.php") ?>

          
        <main class="mx-3 mx-lg-4 mb-5">
          <h1 class="font-CL text-danger mb-lg-4"><?=l('general.Forbidden')?></h1>
         
          <?=l('general.ForbiddenMessage')?>
        </main>
          
          
        <footer class="bg-black text-light">
           <?php include(getenv('ROOT_DIR') . "_footer.php") ?>
        </footer>
      </div>
    </div>

    <script src="<?=getenv('SITE_URL')?>assets/js/bootstrap.min.js"></script>
  </body>
</html>