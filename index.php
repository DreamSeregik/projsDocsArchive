<?php
 require_once($_SERVER['DOCUMENT_ROOT'] . '/system/core/core.php');
 $core->connect(HOST, USER, PASS, DB);
 $core->load_maket(makets . '/main_page.html');
 $core->exec_script(scripts . '/jq.js', 'js');
 $core->exec_script(scripts . '/script.js', 'js');
 $core->exec_script(scripts . '/dtp.js', 'js');
?>