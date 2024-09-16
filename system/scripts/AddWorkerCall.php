<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$call_in = "";
$tarif = "";
$date_time = "";
$duration = "";
$ab_id = $core->ToInt(trim($_POST["ab_id"]));

if (!empty(trim($_POST["call_in"])))
{
    if ($_POST["call_in"] != -1)
    {
        $call_in = trim($_POST["call_in"]);                         
    }
    else
    {
        echo "Пожалуйста укажите город в который звонил абонент";  
        return;
    }
}
else
{
    echo "Пожалуйста укажите город в который звонил абонент";
    return;
}
    
if (!empty(trim($_POST["tarif"])))
{
    $tarif = trim($_POST["tarif"]);
}
else
{
    echo "Пожалуйста укажите тариф";
    return;
}


if (!empty(trim($_POST["date_time"])))
{
    $arr = explode(' ', trim($_POST["date_time"]));
    $date = explode('.', $arr[0]);
    $date_time = $date[2].'-'.$date[1].'-'.$date[0].' '.$arr[1];
}
else
{
    echo "Пожалуйста укажите дату и время совершения разговора";
    return;
}

if (!empty(trim($_POST["duration"])))
{
    $duration = $core->ToFloat(trim($_POST["duration"]));    
}
else
{
    echo "Пожалуйста укажите длительность разговора";
    return;
}

$core->connect(HOST, USER, PASS, DB);

$core->Query('INSERT INTO calls(ab_id, call_in, date, dur) VALUES('.$ab_id.', '.$call_in.', "'.$date_time.'", '.$duration.')');
?>