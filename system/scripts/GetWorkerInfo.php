<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$core->connect(HOST, USER, PASS, DB);
$id = $core->ToInt($_POST['proj_id']);
$query = $core->Query('SELECT code, lead_eng, buyer, total_coast, dog_code, building_type, date_start, date_end, paid FROM project WHERE id = '.$id.'');

if (mysqli_num_rows($query) != 0)
{
   $arr = array();
   while ($r = mysqli_fetch_array($query))
   {
      $tmp1 = explode("-", $r[6]);
      $tmp2 = explode("-", $r[7]);

      $r[6] = $tmp1[2].'.'.$tmp1[1].'.'.$tmp1[0];
      $r[7] = $tmp2[2].'.'.$tmp2[1].'.'.$tmp2[0];
      for ($i = 0; $i < count($r); $i++)
      {
         array_push($arr, $r[$i]);
      }
   }
   echo json_encode($arr);
} else echo 1;

