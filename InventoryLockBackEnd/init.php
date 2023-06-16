<?php

include 'config.php';

function my_autoload ($pClassName) {
    $pClassName = str_replace('\\', DIRECTORY_SEPARATOR, $pClassName);
    include(__DIR__ . "/" . $pClassName . ".php");
  }
  spl_autoload_register("my_autoload");

mb_internal_encoding('UTF-8');

// session_start();