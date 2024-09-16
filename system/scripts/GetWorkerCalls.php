<?php
// P STAGES
require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$core->connect(HOST, USER, PASS, DB);
$id = $core->ToInt($_POST['project_id']);
$query = $core->Query('SELECT s.name, ps.razrab, ps.prov, ps.stat, s.id, ps.id FROM stages s INNER JOIN p_stage ps ON s.id = ps.s_id WHERE ps.p_id = '.$id.'');

if (mysqli_num_rows($query) != 0)
{
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

