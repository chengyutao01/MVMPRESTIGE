<?php use classes\Auth; ?>
    <div class="col-12 col-md-3 col-xl-2 bg-light p-0 nav-left ">
        <header class="bg-light col-md-3 col-xl-2 p-0 h-100">

            <div class="p-4 d-none d-md-block">
              <a href="<?=getenv('SITE_URL')?>">
                <img src="<?=getenv('SITE_URL')?>assets/images/logo.png" alt="logo MVM">
              </a>
            </div>
            <nav class="navbar navbar-expand-md navbar-light d-inline-block d-md-block">
                <!--button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuTop" aria-controls="menuTop" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button-->
                <button class="navbar-toggler" type="button" onclick="event.preventDefault(); $('#menuTop').toggle(); $('.shadow').toggle();">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="menuTop">
                    <ul class="nav flex-column navbar-nav">

                      <li class="nav-item d-block d-md-none mt-3">
                        <a class="text" href=#>
                          <?=l('general.Hello')?>, <?=$session->get('user.username')?>
                        </a>
                      </li>
                      <li class="nav-item"><hr class="d-block d-md-none"></li>

                      <?php if (Auth::isRoot($session)){?>
                      <li class="nav-item">
                        <a class="nav-link<?php if ($current_link == "projects"){echo " active";} ?>" href="<?=getenv('SITE_URL')?>modules/projects/projects.php"><?=l('projects.Projects')?></a>
                      </li>
                    <?php }?>
                    <?php if (Auth::isAdminAtLeast($session)){?>
                      <li class="nav-item">
                        <a class="nav-link<?php if ($current_link == "users"){echo " active";} ?>" href="<?=getenv('SITE_URL')?>modules/users/users.php"><?=l('users.Users')?></a>
                      </li>
                    <?php }?>
                       <?php if (!Auth::isRoot($session)){?>
                      <li class="nav-item">
                        <a class="nav-link<?php if ($current_link == "networks"){echo " active";} ?>" href="<?=getenv('SITE_URL')?>modules/networks/networks.php"><?=l('networks.Networks')?></a>
                      </li>
                   <?php }?>
                    <?php if (Auth::isAdmin($session)){?>
                      <li class="nav-item">
                        <a class="nav-link<?php if ($current_link == "planning"){echo " active";} ?>" href="<?=getenv('SITE_URL')?>modules/planning/index.php"><?=l('planning.Planning')?></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link<?php if ($current_link == "config"){echo " active";} ?>" href="<?=getenv('SITE_URL')?>modules/projects/config.php"><?=l('general.Config')?></a>
                      </li>                      
                    <?php }?>


                      
                    </ul>
                    
                    
                </div>
            </nav>

            <div class="px-sm-3 py-3 d-inline-block d-md-none">
              <a href="<?=getenv('SITE_URL')?>">
                <img src="<?=getenv('SITE_URL')?>assets/images/logo.png" alt="logo MVM" style="max-height:34px;">
              </a>
            </div>

   </header>
</div>
<div class="shadow collapse" onclick="event.preventDefault(); $('#menuTop').toggle(); $('.shadow').toggle();"></div>
