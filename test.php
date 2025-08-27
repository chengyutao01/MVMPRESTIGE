<?php 
require_once('boot.ini.php');
use classes\Models\Advert;
use classes\Models\Network;
$file = getenv('ROOT_DIR').'people.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= "John Smith\n";
// Write the contents back to the file
file_put_contents($file, $current);

exit;

 $adverts = Advert::where('id_advert', '>', 0)->whereIdNetwork(2)->get();
 $network = Network::find(2);

 $arr = $network->arrPeriodsWhereDateAreFull('2019-01-01', '2019-12-31',2);
if ($arr){
    print_r($arr);
}
else echo 'ok';


exit;
        

 
 
 $arrayDate =[];
 $arrayUniqueDate;
 
 foreach ($adverts as $a){
     echo "<br>$a->start_time -> $a->end_time";
     $start = DateTime::createFromFormat('Y-m-d H:i:s', $a->start_time);
     $end = DateTime::createFromFormat('Y-m-d H:i:s', $a->end_time);
     echo " / ". $start->getTimestamp() . " -> ". $end->getTimestamp();
     
         $arrayDate[] = ['time' => $start->getTimestamp(), 'action'=>'start']; 
         $arrayDate[] = ['time' => $end->getTimestamp(), 'action'=>'end'];  
         
         $arrayUniqueDate[$start->getTimestamp()] = 0;
         $arrayUniqueDate[$end->getTimestamp()] = 0;
     
 }
 
 array_multisort( array_column($arrayDate, "time"), SORT_ASC, $arrayDate );
 //ksort($arrayDate, SORT_NUMERIC);
 
 $total = 0;
 foreach ($arrayDate as $d){
     if ($d['action'] == 'start'){
         $total++;
         $arrayUniqueDate[$d['time']] = $total;
         
     }
     else {
         $total--;
         $arrayUniqueDate[$d['time']] = $total;
     }
 }
    ksort($arrayUniqueDate);
?>
<pre>
 <?=print_r($arrayDate,1);?>
</pre>
<pre>
 <?=print_r($arrayUniqueDate,1);?>
</pre>
<?php 
$value = max($arrayUniqueDate);
$periods = [];
if ($value > 1){
    $keysOfTheMax = array_keys($arrayUniqueDate, $value);
    
    $keysOfUniqueDate = array_keys($arrayUniqueDate);
    
    foreach ($keysOfTheMax as $k){
       $periods[$k] = $keysOfUniqueDate[array_search($k,$keysOfUniqueDate)+1];
    }
    //$key2 =  $keys[array_search($key,$keys)+1];
}
//echo "$key ; $key2";

print_r($periods);



