<?php
require_once('boot.ini.php');
use classes\Models\Advert;
use classes\Models\Meteo;
use classes\Models\Clock;
use classes\Models\User;
use classes\Models\Network;

if (isset($_GET['id_advert'])){
  $id = $_GET['id_advert'];  
  
  
  $image = Advert::where('id_advert', $id)->first();
        $endpoint = $image->end_point ?? '';
      if (isset($_GET['alt'])){
         $endpoint = $image->end_point_alt;
      }/*
  if ($image->type == 0){
      $endpoint = $image->end_point ?? '';
      if (isset($_GET['alt'])){
         $endpoint = $image->end_point_alt;
      }
  }
  elseif  ($image->type == 1){
     $image = Clock::where('id_network', $image->id_network)->first(); 
     $endpoint = $image->end_point ?? '';
  }
  elseif  ($image->type == 2){
     $image = Meteo::where('id_network', $image->id_network)->first(); 
     $endpoint = $image->end_point ?? '';
  }*/
  
}
elseif (isset($_GET['id_meteo'])){
  $id = $_GET['id_meteo'];  
  $image = Meteo::where('id_meteo', $id)->first();
  $endpoint = $image->end_point;
}
elseif (isset($_GET['id_clock'])){
  $id = $_GET['id_clock'];  
  $image = Clock::where('id_clock', $id)->first();
  $endpoint = $image->end_point;
}
elseif (isset($_GET['id_avatar'])){
    $id = $_GET['id_avatar'];  
    $image = User::where('id_user', $id)->first();
    $image->mime_type = 'image/jpeg';
    $endpoint = $image->avatar_end_point;
    //echo getenv('UPLOAD_DIR').$endpoint;
    //exit; 
}
elseif (isset($_GET['id_network'])){
    $id = $_GET['id_network'];  
    $image = Network::where('id_network', $id)->first();
    $image->mime_type = 'image/jpeg';
    $endpoint = $image->default_image_end_point;
    //echo getenv('UPLOAD_DIR').$endpoint;
    //exit; 
}




if ($image)  {
	
	
	// controlla proprietario
	
	if (false) {
		die;
	}

	
	$type = $image->mime_type;
	$str="";
	$str = file_get_contents(getenv('UPLOAD_DIR').$endpoint);
}
else {
    exit;
}
header('Content-Type:'.$type);
echo $str;