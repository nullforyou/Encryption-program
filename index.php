<?php
chdir(dirname(__file__));
defined ("__ROOT__") or define('__ROOT__', dirname(__file__));
include_once "./log/log.php";
include_once "./db/db_handle.php";
include_once "./code/codeingfile.php";

$path = str_replace("\\", DIRECTORY_SEPARATOR, dirname(__dir__) . "\jiami_code");
$tree = new CodeingFile(DbHandle::getInstance());
$tree->codeToFile($path);
