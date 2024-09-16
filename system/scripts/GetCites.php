<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$core->connect(HOST, USER, PASS, DB);
$query = $core->Query('SELECT id, name FROM stages');

if (mysqli_num_rows($query) != 0) {
	$arr = array(array());
   $j = 0;
   while ($r = mysqli_fetch_array($query))
   {      
         for ($i = 0; $i < count($r); $i++)
         {
            $arr[$j][] = $r[$i];
         }
         $j = $j + 1;    
      
   }
   echo json_encode($arr);
} else echo 1;
