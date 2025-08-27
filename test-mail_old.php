<?PHP
/*$header = "From: alert@mvm-digital.com\r\n";
$header.= "MIME-Version: 1.0\r\n";
$header.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$header.= "X-Priority: 1\r\n";

$sender = 'alert@mvm-digital.com';
$recipient = 'alex.lioy@gmail.com';

$subject = "php mail test";
$message = "php test message";
$headers = 'From:' . $sender;

if (mail($recipient, $subject, $message, $headers))
{
    echo "Message accepted";
}
else
{
    echo "Error: Message not accepted";
}*/


   $params = Array ( 
                           'personalizations' => Array ( 
                                     Array ( 
                                        'to' => Array ( 
                                             Array ( 'email' =>'alex.lioy@gmail.com', 'name'=>'Alex' ) 
                                            ) 
                                        ) 
                               ), 
                           'from' => Array ( 
                               'email' => 'alert@mvm-digital.com',
                               'name' => 'mvm'
                               ) ,
                           'replay_to' => Array ( 
                               'email' => 'noreplay@mvm-digital.com'
                               ) ,       
                           'subject' => 'test',
                           'content' => Array ( 
                               Array ( 
                                   'type' => 'text/plain', 'value' => 'mail di prova'
                                   ) 
                               ) 
                           );


$url = 'https://api.sendgrid.com/';
				$request =  $url.'v3/mail/send';
                                $authorization = "Authorization: Bearer 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";
                                
				// Generate curl request
				$ch = curl_init($request);
				// Tell PHP not to use SSLv3 (instead opting for TLS)
				curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
				// Tell curl to use HTTP POST
				curl_setopt ($ch, CURLOPT_POST, true);
				// Tell curl that this is the body of the POST
                                $payload = json_encode($params);
                                curl_setopt ($ch, CURLOPT_POSTFIELDS, $payload);
				// Tell curl not to return headers, but do return the response
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                //auth
                                curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                                
				// obtain response
				//$response = curl_exec($ch);
                                echo print_r($response,1);                            

                                curl_close($ch);


?>
