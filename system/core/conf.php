<?php
error_reporting(E_ERROR | E_PARSE);
//Блок переопределений
define("root_dir", $_SERVER["DOCUMENT_ROOT"]);
define("makets",   root_dir. "/system/makets");
define("handlers", root_dir. "/system/handlers");
define("scripts", root_dir. "/system/scripts");
define("pages", root_dir. "/system/pages");

//настройки для подключения к БД
define("HOST", "localhost");
define("USER", "root");
define("PASS", "");
define("DB", "projects");
