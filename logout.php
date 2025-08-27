<?php
require_once("boot.ini.php");
$session->invalidate(0);
header('Location:' . getenv('SITE_URL')."index.php");











