<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$stage_name = "";
$id = $core->ToInt($_POST["id"]);

if (!empty(trim($_POST["stage_name"])))
{
    if (strlen(trim($_POST["stage_name"])) >= 1)
      $stage_name = trim($_POST["stage_name"]);
    else
    {
        echo "Пожалуйста введите название раздела";
        return;
    }
}
          
$core->connect(HOST, USER, PASS, DB);
$core->Query('UPDATE stages SET name = "'.$stage_name.'" WHERE id = '.$id.'');
?>