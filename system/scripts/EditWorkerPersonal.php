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
$id = $core->ToInt($_POST["id"]);


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
$date_end_tmp = explode(".", trim($_POST["date_end"]));
$date_start = $date_start_tmp[2] . "-" . $date_start_tmp[1] . "-" . $date_start_tmp[0];
$date_end = $date_end_tmp[2] . "-" . $date_end_tmp[1] . "-" . $date_end_tmp[0];

if (empty($_POST["p_stages"])) {
    echo "Пожалуйста выберите хотя бы один П-раздел";
    return;
}

if (empty($_POST["r_stages"])) {
    echo "Пожалуйста выберите хотя бы один Р-раздел";
    return;
}


$core->connect(HOST, USER, PASS, DB);

$core->Query('UPDATE project SET code = "' . $shifr . '", dog_code = "' . $dog_code . '", building_type = "' . $obj_type . '", lead_eng = "' . $gip . '", date_start = "' . $date_start . '", date_end = "' . $date_end . '", total_coast = "' . $coast . '", paid = "' . $obj_status . '", buyer = "' . $zakazchik . '" WHERE id = ' . $id . '');
$p_diffs_query = $core->Query('SELECT s_id FROM p_stage WHERE p_id = ' . $id . '');
$r_diffs_query = $core->Query('SELECT s_id FROM r_stage WHERE p_id = ' . $id . '');

while ($r = mysqli_fetch_array($p_diffs_query)) {
    $p_diffs = array_diff($r, $_POST["p_stages"]);

    if (!empty($p_diffs)) {
        for ($i = 0; $i < count($p_diffs); $i++) {
            $core->Query('DELETE FROM p_stage WHERE p_id = ' . $id . ' AND s_id = ' . $p_diffs[$i] . '');
        }
    }
}

for ($i = 0; $i < count($_POST["p_stages"]); $i++) { 
        if (mysqli_num_rows($core->Query('SELECT id FROM p_stage WHERE s_id = ' . $_POST["p_stages"][$i] . ' AND p_id = '.$id.'')) == 0)
            $core->Query('INSERT INTO p_stage(p_id, s_id, razrab, prov, stat) VALUES(' . $id . ', '.$_POST["p_stages"][$i].', "-", "-", 0)');
        else
            continue;
}

while ($r = mysqli_fetch_array($r_diffs_query)) {
    $r_diffs = array_diff($r, $_POST["r_stages"]);

    if (!empty($r_diffs)) {
        for ($i = 0; $i < count($r_diffs); $i++) {
            $core->Query('DELETE FROM r_stage WHERE p_id = ' . $id . ' AND s_id = ' . $r_diffs[$i] . '');
        }
    }
}

for ($i = 0; $i < count($_POST["r_stages"]); $i++) { 
    if (mysqli_num_rows($core->Query('SELECT id FROM r_stage WHERE s_id = ' . $_POST["r_stages"][$i] . ' AND p_id = '.$id.'')) == 0)
        $core->Query('INSERT INTO r_stage(p_id, s_id, razrab, prov, stat) VALUES(' . $id . ', '.$_POST["r_stages"][$i].', "-", "-", 0)');
    else
        continue;
}