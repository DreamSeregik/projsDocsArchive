<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$core->connect(HOST, USER, PASS, DB);
$id = $core->ToInt($_POST['stage_id']);
$query = $core->Query('SELECT id, name FROM stages WHERE id = '.$id.'');

if (mysqli_num_rows($query) != 0) {
	$arr = array();

    while ($r = mysqli_fetch_array($query))
   {      
         for ($i = 0; $i < count($r); $i++)
         {
            array_push($arr, $r[$i]);
         }
     
   }
   echo json_encode($arr);
} else echo 1;
