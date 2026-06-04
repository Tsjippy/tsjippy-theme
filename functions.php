<?php

namespace TSJIPPYTHEME;

use Exception;

define(__NAMESPACE__ . '\THEME', 'tsjippy-theme');
define(__NAMESPACE__ . '\THEME_PATH', str_replace('\\', '/', __DIR__));

// We cannot use the sim theme
if (is_plugin_inactive('tsjippy-shared-functionality/tsjippy-shared-functionality.php') && is_plugin_inactive('sim-plugin/sim-plugin.php')) {
    $themes = wp_get_themes();
    unset($themes['Tsjippy theme']);

    switch_theme(array_values($themes)[0]['theme_root']);
    error_log("To use the tsjippy-theme you need to install the tsjippy-shared-functionality plugin");
    //throw new Exception("To use the tsjippy-theme you need to install the tsjippy-shared-functionality");
}

// composer
require 'lib/vendor/autoload.php';

$files = glob(__DIR__  . '/php/*.php');
foreach ($files as $file) {
    require_once($file);
}
