<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$razrab = "";
$prov = "";
$stat = "";
$id = $core->ToInt(trim($_POST["id"]));
$param = $core->ToInt($_POST['p']);

if (!empty(trim($_POST["razrab"])))
{
    $razrab = trim($_POST["razrab"]);                         
}
else
{
    echo "Пожалуйста укажите разработчика"; 
    return;
}
    
if (!empty(trim($_POST["prov"])))
{
    
    $prov = trim($_POST["prov"]);                         
}
else
{
    echo "Пожалуйста укажите проверяющего"; 
    return;
}

$stat = trim($_POST["stat"]);


$core->connect(HOST, USER, PASS, DB);
if ($param == 0)
    $core->Query('UPDATE p_stage SET razrab = "'.$razrab.'", prov = "'.$prov.'", stat = '.$stat.' WHERE id = '.$id.'');
else
    $core->Query('UPDATE r_stage SET razrab = "'.$razrab.'", prov = "'.$prov.'", stat = '.$stat.' WHERE id = '.$id.''); 