<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$core->connect(HOST, USER, PASS, DB);
$id = $core->ToInt($_POST['project_id']);

$core->Query('DELETE FROM project WHERE id = '.$id.'');
$core->Query('DELETE FROM p_stage WHERE p_id = '.$id.'');
$core->Query('DELETE FROM r_stage WHERE p_id = '.$id.'');

echo 0;
