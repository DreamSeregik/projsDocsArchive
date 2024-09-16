<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$stage_name = "";


if (!empty(trim($_POST["stage_name"])))
{
    if (strlen(trim($_POST["stage_name"])) > 1)
      $stage_name = trim($_POST["stage_name"]);
    else
    {
        echo "Пожалуйста укажите название раздела";
        return;
    }
}
else
{
    echo "Пожалуйста укажите название раздела";
    return;
}
          
$core->connect(HOST, USER, PASS, DB);
$core->Query('INSERT INTO stages(name) VALUES("'.$stage_name.'")');
