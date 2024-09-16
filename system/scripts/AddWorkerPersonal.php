<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');

$shifr = "";
$gip = "";
$zakazchik = "";
$coast = "";
$dog_code = "";
$obj_type = 0;
$obj_status = 0;
$date_start = null;
$date_end = null;


if (trim($_POST["shifr"]) == "") {
    echo "Пожалуйста укажите шифр объекта";
    return;
} elseif (strlen(trim($_POST["shifr"])) > 6) {
    echo "Длина шифра объекта не должна превышать 6 символов";
    return;
} else {
    $shifr = trim($_POST["shifr"]);
}

if (trim($_POST["gip"]) == "") {
    echo "Пожалуйста укажите ГИП объекта";
    return;
} else {
    $gip = trim($_POST["gip"]);
}

if (trim($_POST["zakazchik"]) == "") {
    echo "Пожалуйста укажите заказчика объекта";
    return;
} else {
    $zakazchik = trim($_POST["zakazchik"]);
}

if (trim($_POST["coast"]) == "") {
    echo "Пожалуйста укажите стоимость объекта";
    return;
} else {
    $coast = trim($_POST["coast"]);
}

if (trim($_POST["dog_code"]) == "") {
    echo "Пожалуйста укажите код договора";
    return;
} elseif (strlen(trim($_POST["dog_code"])) > 8) {
    echo "Длина шифра объекта не должна превышать 8 символов";
    return;
} else {
    $dog_code = trim($_POST["dog_code"]);
}

if (trim($_POST["obj_type"]) == 0) {
    echo "Пожалуйста укажите тип объекта";
    return;
} else {
    $obj_type = trim($_POST["obj_type"]);
}

if (trim($_POST["obj_status"]) == 0) {
    echo "Пожалуйста укажите статус объекта";
    return;
} else {
    $obj_status = trim($_POST["obj_status"]);
}
$date_start_tmp = explode(".", trim($_POST["date_start"]));
$date_end_tmp = explode("." ,trim($_POST["date_end"]));
$date_start = $date_start_tmp[2]."-".$date_start_tmp[1]."-".$date_start_tmp[0];
$date_end = $date_end_tmp[2]."-".$date_end_tmp[1]."-".$date_end_tmp[0];

if (empty($_POST["p_stages"])){
    echo "Пожалуйста выберите хотя бы один П-раздел";
    return;
}

if (empty($_POST["r_stages"])){
    echo "Пожалуйста выберите хотя бы один Р-раздел";
    return;
}


$core->connect(HOST, USER, PASS, DB);

$core->Query('INSERT INTO project(code, dog_code, building_type, lead_eng, date_start, date_end, total_coast, paid, buyer) VALUES("' . $shifr . '", "' . $dog_code . '", ' . $obj_type . ', "'.$gip.'", "'.$date_start.'", "'.$date_end.'", '.$coast.', '.$obj_status.', "'.$zakazchik.'")');
$query = $core->Query('SELECT MAX(id) FROM project');
$added_id = mysqli_fetch_row($query);

for ($i = 0; $i < count($_POST["p_stages"]); $i++) { 
    $core->Query('INSERT INTO p_stage(p_id, s_id, razrab, prov, stat) VALUES(' . $added_id[0] . ', '.$_POST["p_stages"][$i].', "-", "-", 0)');
}

for ($i = 0; $i < count($_POST["r_stages"]); $i++) { 
    $core->Query('INSERT INTO r_stage(p_id, s_id, razrab, prov, stat) VALUES(' . $added_id[0] . ', '.$_POST["r_stages"][$i].', "-", "-", 0)');
}




