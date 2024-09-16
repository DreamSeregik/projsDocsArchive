<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$core->connect(HOST, USER, PASS, DB);
$id = $core->ToInt($_POST['call_id']);

$core->Query('DELETE FROM calls WHERE id = '.$id.'');


echo 0;
?>