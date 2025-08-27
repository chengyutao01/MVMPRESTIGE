<?php
use classes\Auth;
$bgcolor='';
if (Auth::isRoot($session)){
    $topadmin = 'top-admin"';
}
$user_id = $session->get('user.id');
$avatar_end_point = $session->get('user.avatar_end_point');
?>
<div class="text-right p-3 p-lg-4 <?=$topadmin?>">
  <div class="top-account">
    <a class="icon-top-account" href=#>
        <?php if ($avatar_end_point != '') {?>
        <img src="<?=getenv('SITE_URL')?>show-image.php?id_avatar=<?=$user_id?>" alt="icon account" style="border-radius: 50%" width="38" height="38"">
        <?php } else {?>
        <img src="<?=getenv('SITE_URL')?>assets/images/icons/account.svg" alt="icon account">
        <?php } ?>
    </a>
    <a class="d-none d-md-inline-block text" href=#>
      <span class="pl-2 pr-4"><?=l('general.Hello')?>, <?=$session->get('user.username')?></span>
    </a>
    <a class="icon-top-exit" href="<?=getenv('SITE_URL')?>logout.php">
      <span class="d-none d-md-inline ml-2">logout</span>
      <img src="<?=getenv('SITE_URL')?>assets/images/icons/exit.svg" alt="icon exit account">
    </a>
   </div>
</div>
