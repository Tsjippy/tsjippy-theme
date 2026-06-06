<?php

namespace TSJIPPYTHEME;

use Exception;

define(__NAMESPACE__ . '\THEME', 'tsjippy-theme');
define(__NAMESPACE__ . '\THEME_PATH', str_replace('\\', '/', __DIR__));

// composer
require 'lib/vendor/autoload.php';

$files = glob(__DIR__  . '/php/*.php');
foreach ($files as $file) {
    require_once($file);
}
