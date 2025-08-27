<?php
use Illuminate\Database\Capsule\Manager as Capsule;  

$capsule = new Capsule; 

$capsule->addConnection(array(
    'driver'    => 'mysql',
    'host'      => 'mvmprestvkps.mysql.db',
    'database'  => 'mvmprestvkps',
    'username'  => 'mvmprestvkps',
    'password'  => 'uOAjrvmthUg69',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => ''
));

$capsule->setAsGlobal();
$capsule->bootEloquent();

