<?php
require_once('boot.ini.php');
use classes\Mail;




$mail_test = new Mail('mvm','alert@mvm-digital.com','test','mail di prova da sendgrid','');


$mail_test->SetSendMethod("sendgrid_v3");


$res = $mail_test->Send("alex.lioy@gmail.com","alex.lioy@gmail.com");
echo print_r($res,1);

