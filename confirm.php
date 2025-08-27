<?php
require_once('boot.ini.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$id = $_GET['id'];
$name = $_GET['name'];
$type = $_GET['type'];
switch ($type){
    case 'Network':
        $link='scripts/destroy-network.php';
        break;
    case 'User':
        $link='scripts/destroy-user.php';
        break;
    case 'Advert':
        $link='scripts/destroy-advert.php';
        break;    
    case 'Server':
        $link='scripts/destroy-server.php';
        break;   
        
}

?>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">                
                <h4 class="modal-title text-danger"><?=l('general.ConfirmDeletion1')?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <?=l('general.'.$type)?> #<?=$id?> (<?=$name?>)<br>
              <?=l('general.ConfirmDeletion2')?>
            </div>
            <div class="modal-footer">
                <a href="<?=$link?>?id=<?=$id?>" type="button" class="btn btn-primary">
                    <?=l('general.YesDelete')?>
                </a>
                <button type="button" class="btn btn-default btn-danger" data-dismiss="modal"><?=l('general.No')?></button>
            </div>
        </div>
    </div>
