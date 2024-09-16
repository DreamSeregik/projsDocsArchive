<?php

class Core
{
   private $config_path = '/system/core/conf.php';
   private $con = null;


   public function __construct()
   {
      //шаблон конфига для автосоздания
      $conf_tmpl = '<?php' . PHP_EOL .
         'error_reporting(E_ERROR | E_PARSE);' . PHP_EOL .
         '//Блок переопределений' . PHP_EOL .
         'define("root_dir", $_SERVER["DOCUMENT_ROOT"]."/dz1");' . PHP_EOL .
         'define("makets",   root_dir . "/dz1/system/makets");' . PHP_EOL .
         'define("handlers", root_dir . "/dz1/system/handlers");' . PHP_EOL .
         'define("scripts",  root_dir . "/dz1/system/scripts");' . PHP_EOL .
         'define("pages",    root_dir . "/dz1/system/pages");' . PHP_EOL .
         '//настройки для подключения к БД' . PHP_EOL .
         'define("HOST", "localhost");' . PHP_EOL .
         'define("USER", "root");' . PHP_EOL .
         'define("PASS", "TUT PASS K ROOTOO");' . PHP_EOL .
         'define("DB", "TUT BAZA");';

      if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $this->config_path))
         file_put_contents($_SERVER['DOCUMENT_ROOT'] . $this->config_path, $conf_tmpl);
      require_once($_SERVER['DOCUMENT_ROOT'] . $this->config_path);
   }

   public function connect($h, $u, $p, $db)
   {
      $this->con = mysqli_connect($h, $u, $p, $db);

      if (mysqli_connect_errno() !== 0)
         die('<span style = "color: red; font-weight: 600; font-size: 15px;">Не удалось соедениться с БД, проверьте настройки</span><br>' . 'ERROR[' . mysqli_connect_errno() . '] ' . mysqli_connect_error());
   }

   public function Query($q)
   {
      if ($this->con !== null)
         return mysqli_query($this->con, $q);

      if (mysqli_errno($this->con) !== 0) {
         echo ('Не удалось выполнить запрос<br>' . 'ERROR[' . mysqli_errno($this->con) . '] ' . mysqli_error($this->con));
      } else {
         echo 'вначале подключитесь к БД';
      }
   }

   public function load_maket($maket, $line_from = null, $line_to = null)
   {
      if (file_exists($maket)) {
         $res = file($maket);
         if ($line_from !== null && $line_to === null) {
            $line_from = intval($line_from);

            if ($line_from > 0) {
               if ($line_from <= count($res)) {
                  for ($i = $line_from - 1; $i < count($res); $i++)
                     echo $res[$i];
               } else {
                  echo 'в этом нет смысла! Заданный начальный индекс больше кол-ва строк в файле';
                  exit;
               }
            } else {
               echo 'начальный индекс должен быть больше 0';
               exit;
            }
         } elseif ($line_to !== null && $line_from === null) {
            $line_to = intval($line_to);

            if ($line_to > 0) {
               if ($line_to <= count($res)) {
                  for ($i = 0; $i < $line_to; $i++)
                     echo $res[$i];
               } else {
                  echo 'в этом нет смысла! Заданный конечный индекс больше кол-ва строк в файле';
                  exit;
               }
            } else {
               echo 'конечный индекс должен быть больше 0';
               exit;
            }
         } elseif ($line_from !== null && $line_to !== null) {

            $line_from = intval($line_from);
            $line_to = intval($line_to);

            if ($line_from > 0 && $line_to > 0) {

               if ($line_from > $line_to) {
                  echo 'в этом нет смысла! начальный индекс больше конечного';
                  exit;
               } else {
                  for ($i = $line_from - 1; $i < $line_to; $i++)
                     echo $res[$i];
               }
            } else {
               echo 'начальный и конечный индексы должны быть больше 0';
               exit;
            }
         } elseif ($line_from === null && $line_to === null)
            for ($i = 0; $i < count($res); $i++)
               echo $res[$i];
      } else {
         echo 'не могу открыть файл (' . $maket . ')';
         exit;
      }
   }

   public function exec_script($script = null, $type = null, $line_from = null, $line_to = null)
   {

      if (file_exists($script)) {
         $res = file($script);
         if ($type == 'js') {  //JS
            if ($line_from !== null && $line_to === null) {
               $line_from = intval($line_from);

               if ($line_from > 0) {
                  if ($line_from <= count($res)) {
                     echo '<script type = "text/javascript">';
                     for ($i = $line_from - 1; $i < count($res); $i++)
                        echo $res[$i];
                     echo '</script>';
                  } else {
                     echo 'в этом нет смысла! Заданный начальный индекс больше кол-ва строк в файле';
                     exit;
                  }
               } else {
                  echo 'начальный индекс должен быть больше 0';
                  exit;
               }
            } elseif ($line_to !== null && $line_from === null) {
               $line_to = intval($line_to);

               if ($line_to > 0) {
                  if ($line_to <= count($res)) {
                     echo '<script type = "text/javascript">';
                     for ($i = 0; $i < $line_to; $i++)
                        echo $res[$i];
                     echo '</script>';
                  } else {
                     echo 'в этом нет смысла! Заданный конечный индекс больше кол-ва строк в файле';
                     exit;
                  }
               } else {
                  echo 'конечный индекс должен быть больше 0';
                  exit;
               }
            } elseif ($line_from !== null && $line_to !== null) {

               $line_from = intval($line_from);
               $line_to = intval($line_to);

               if ($line_from > 0 && $line_to > 0) {

                  if ($line_from > $line_to) {
                     echo 'в этом нет смысла! начальный индекс больше конечного';
                     exit;
                  } else {
                     echo '<script type = "text/javascript">';
                     for ($i = $line_from - 1; $i < $line_to; $i++)
                        echo $res[$i];
                     echo '</script>';
                  }
               } else {
                  echo 'начальный и конечный индексы должны быть больше 0';
                  exit;
               }
            } elseif ($line_from === null && $line_to === null) {
               echo '<script type = "text/javascript">';
               for ($i = 0; $i < count($res); $i++)
                  echo $res[$i];
               echo '</script>';
            }
         } elseif ($type == 'php') { // PHP
            if ($line_from === null && $line_to === null) {
               require_once($script);
            } else {
               echo 'при выполнении php скрипта не нужно указывать начальную и конечную строки';
               exit;
            }
         } else {
            echo 'указанный вами тип скрипта не поддерживается или вы не указали тип вовсе';
            exit;
         }
      }
   }

   public function Handle($handler, $watermark = null, $watermarkStr = 0)
   {
      if (file_exists($handler)) {
         $res = file($handler);
         if ($watermark !== null) {
            if ($watermarkStr >= 0) {
               if ($watermarkStr <= count($res)) {
                  if (trim(str_replace('//', '', $res[$watermarkStr])) != trim($watermark)) {
                     echo 'Извените, не могу запустить ваш обработчик';
                     exit;
                  } else
                     require_once($handler);
               } else {
                  echo 'Индекс строки не должен превышать кол-во строк в файле';
                  exit;
               }
            } else {
               echo 'Индекс строки для поиска должен быть больше либо равен 0';
            }
         }
      } else
         echo 'Извените, не могу запустить ваш обработчик';
   }

   public function ToInt($val)
   {
      return intval($val);
   }

   public function ToFloat($val)
   {
      return floatval(str_replace(',', '.', $val));
   }

   public function ToClrStr($val)
   {
      return trim(strip_tags($val));
   }

   public function ToPhone($val)
   {

      // if (substr($val, 0, 2) == '+7') {
      //    if (strlen($val) < 12) {
      //       echo 'в номере должно быть 13 цифр (включачая +7)';
      //       exit;
      //    }
      //    $val = substr($val, 0, 13);
      //    $val = str_replace('+7', '8', substr($val, 0, 2)) . substr($val, 2);
      //    $val = trim(intval($val));

      //    if (strlen($val) !== 0)
      //       return $val;
      //    else {
      //       echo 'Неверный формат номера';
      //       exit;
      //    }
      // } else if (substr($val, 0, 1) == '8') {
      //    if (strlen($val) < 11) {
      //       echo 'в номере должно быть 11 цифр (включачая 8)';
      //       exit;
      //    }

      //    $val = substr($val, 0, 11);
      //    $val = trim(intval($val));

      //    if (strlen($val) !== 0)
      //       return $val;
      //    else {
      //       echo 'Неверный формат номера';
      //       exit;
      //    }
      // } else {
      //    echo 'Неверный формат номера';
      //    exit;
      // }

      return $val;
   }

   public function ToEmail($val)
   {
      if (strpos($val, '@') == false || strpos($val, '.') == false) {
         echo 'В адресе остутствую обязательные символы "@" или ".", пожалуйста введите их';
         exit;
      } else
         $exp = explode('@', $val);
      if (strlen($exp[0]) == 0 || strlen(substr($exp[1], 0, strpos($exp[1], '.'))) == 0) {
         echo 'часть адреса до символа @ и после него не должна быть пустой';
         exit;
      } else {
         return $val;
      }
   }

   public function GetInitials($val) {
      $res = trim($val);
      $res = explode(" ", $res);
      if (count($res) == 3)
         $res = $res[0]." ".mb_strcut($res[1], 0, 2).". ".mb_strcut($res[2], 0, 2).".";
      else
         $res = $res[0]." ".mb_strcut($res[1], 0, 2).". ".mb_strcut($res[2], 0, 2);
      return $res;    
   }
}

$core = new Core();
