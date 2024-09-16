<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$q = $core->ToClrStr(trim($_POST["query"]));

$core->connect(HOST, USER, PASS, DB);

if (!empty($q))
    $query = $core->Query('SELECT id, code, paid FROM project WHERE code LIKE "%'.$q.'%"');
else
    $query = $core->Query('SELECT id, code, paid FROM project');

if (mysqli_num_rows($query) != 0) {
	echo '<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "text-align: left; background: rgb(238,238,238);">';
	
    while ($r = mysqli_fetch_array($query)){
      $r[2] = $core->ToClrStr($r[2]);
      if ($r[2] == TRUE) {
        $STATUS = "<span class = 'stat' style = 'color: green; padding-left: 10px; padding-right: 10px; font-weight: 700'> Оплачен. В работе </span>";
      }
      else
      {
        $STATUS = "<span class = 'stat' style = 'color: rgb(255, 72, 0); padding-left: 10px; padding-right: 10px; font-weight: 700'> На рассмотрении </span>";
      }
		printf('<tr><td style = "width: 1px; padding-left: 5px; border-bottom: 2px solid black;"> <div class="worker" onclick = "ClickOnWorker($(this)); GetWorkerData('.$r[0].'); GetWorkerCalls('.$r[0].'); GetWorkerFio('.$r[0].')" style = "border: none">%s <span>%s</span> </div></td></tr>', $core->ToClrStr($r[1]), $STATUS);	 		
    }
  
  echo '</table>';

} else echo 1;
