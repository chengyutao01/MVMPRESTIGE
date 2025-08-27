<?php
require_once 'vendor/autoload.php';
require_once __DIR__ . '/database.php'; //inizializza Eloquent


$SERVER_URL = 'http://95.110.229.203/';
/* sessioni */
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
$monthlySession = new NativeSessionStorage(
    array(
        'cookie_lifetime' => 3600*24*7
    )
);

$session = new Session($monthlySession);
$session->start();

/* gestione delle variabili di ambiente */
use Dotenv\Dotenv;
$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

if (getenv('DEBUG_MODE') == 1){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

}

/* database Redis */
use Predis\Client as RedisClient;
$redisAvailable = false;

/*if ( getenv('REDIS_AVAILABLE') ) {
    $redisAvailable = true;
    try{
        $redis = new RedisClient();
        $redis->select(1);
    } catch (\Predis\Connection\ConnectionException $e){
      $redisAvailable = false;
      //TODO trace the problem on the db
      //ok
    }
}*/

/* gestione unicode */
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');


/* gestione delle traduzioni */
use classes\Lang;
$locale = $session->get('user.language', 'fr');
$lang = new Lang(__DIR__ .'/lang',$locale, 'fr');
function l($string, $options = []){
    return Lang::trans($string, $options);
}


/* validazione acesso utente */
function validate($scope, $value, $session){
    
    switch ($scope) {
        case 'project':            
            if ($value != $session->get('user.id_project', -1) && $session->get('user.id_project', 999) > 0){
                header('location:'. getenv('SITE_URL') . "forbidden.php?userProject=".$session->get('user.id_project', -1));
                exit;  
            }
            break;
        case 'network':
            if ($session->get('user.role') == 3 && !in_array($value, $session->get('user.networks_grant'))){
                header('location:'. getenv('SITE_URL') . 'forbidden.php?networksAllowed='.implode(',',$session->get('user.networks_grant')));
                exit;    
            }          
            break;
        default:
            header('location:'. getenv('SITE_URL') . 'forbidden.php');
            exit;   
            break;
    }
    
    
}

/* gestione output del buffer e degli errori */
ob_start();


/* Inizializzazione variabili */
$SITE_NAME = 'MVM Prestige';


// Pagination
$itemsPerPage = 20;
$page = 1;
$maxPages = 6;
$nPages=1;

