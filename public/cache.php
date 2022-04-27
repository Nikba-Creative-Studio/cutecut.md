<?php
/*
=====================================================
 Copyright (c) 2020 NIKBA.COM
=====================================================
 File: cache.php
=====================================================
*/

#Define Root Dir
$root = (!isset($_SERVER["DOCUMENT_ROOT"])) ? $_SERVER["DOCUMENT_ROOT"] = substr($_SERVER['SCRIPT_FILENAME'] , 0 , -strlen($_SERVER['PHP_SELF'])."/" ) : $_SERVER["DOCUMENT_ROOT"]."/";
@define('ROOT', $root);

@array_map('unlink', glob(ROOT."var/cache/static/*.*"));
echo "Cache Removed";
?>