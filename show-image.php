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
      }
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


if ($image->mime_type == 'video/mp4'){
$file = getenv('UPLOAD_DIR').$endpoint;

                    $fp = @fopen($file, 'rb');
                    $size = @filesize($file); // File size
                    $length = $size;           // Content length
                    $start = 0;               // Start byte
                    $end = $size - 1;       // End byte
                    //ob_get_clean();

                    header('Content-type: video/mp4');
                    header("Cache-Control: max-age=2592000, public");
                    header("Expires: " . gmdate('D, d M Y H:i:s', time() + 2592000) . ' GMT');
                    header("Last-Modified: " . gmdate('D, d M Y H:i:s', @filemtime($file)) . ' GMT');
                    header("Accept-Ranges: bytes 0-$end");
                    // header("Accept-Ranges: bytes");
                    if (isset($_SERVER['HTTP_RANGE'])) {
                        $c_start = $start;
                        $c_end = $end;
                        list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
                        if (strpos($range, ',') !== false) {
                            header('HTTP/1.1 416 Requested Range Not Satisfiable');
                            header("Content-Range: bytes $start-$end/$size");
                            exit;
                        }
                        if ($range == '-') {
                            $c_start = $size - substr($range, 1);
                        } else {
                            $range = explode('-', $range);
                            $c_start = $range[0];
                            $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
                        }
                        $c_end = ($c_end > $end) ? $end : $c_end;
                        if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
                            header('HTTP/1.1 416 Requested Range Not Satisfiable');
                            header("Content-Range: bytes $start-$end/$size");
                            exit;
                        }
                        $start = $c_start;
                        $end = $c_end;
                        $length = $end - $start + 1;
                        fseek($fp, $start);
                        header('HTTP/1.1 206 Partial Content');
                        header("Content-Range: bytes $start-$end/$size");
                        header("Content-Length: " . $length);
                    } else {
                        header("Content-Length: " . $length);
                        header("Accept-Ranges: bytes");
                    }
                   // ob_start();
                    $buffer = 1024 * 8;
                    while (!feof($fp) && ($p = ftell($fp)) <= $end) {
                        if ($p + $buffer > $end) {
                            $buffer = $end - $p + 1;
                        }
                        set_time_limit(0);
                        $data = @stream_get_contents($fp, $buffer);

                        echo $data;
                        //echo fread($fp, $buffer);
                       // ob_flush();
                        //flush();
                    }
                    fclose($fp);
                    exit();

}
else {

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
    exit;
}