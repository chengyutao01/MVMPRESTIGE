<?php
require_once('boot.ini.php');
$session->clear();// serve per azzerare tutto quando uno sullo stesso pc entra con utenti diversi
use classes\Models\User;
use classes\Auth as Auth;


$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = $_POST['password'];

$user = User::where('username', $username)->get();
//print_r($user);
if ( !Auth::Authenticate($user, $password) ){
    header('location: index.php?err=noauth');
    exit;
}
$session->set('user.username',$user[0]->username);
$session->set('user.id',$user[0]->id_user);
$session->set('user.id_project',$user[0]->id_project);
$session->set('user.role',$user[0]->role);
$session->set('user.avatar_end_point',$user[0]->avatar_end_point);
if ($user[0]->networks_grant && $user[0]->networks_grant != ''){
    $session->set('user.networks_grant',explode(',',$user[0]->networks_grant));
}
else {
    $session->set('user.networks_grant',[]);
}
$idsLanguages = ['1' => 'fr', '2'=> 'it', '3'=> 'en'];
$session->set('user.language',$idsLanguages[$user[0]->id_language], 'it');

header('location: '. getenv('SITE_URL') . 'modules/networks/networks.php');
exit;

