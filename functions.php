<?php
namespace SIMTHEME;

use Exception;

define(__NAMESPACE__ .'\THEME', 'sim-theme');
define(__NAMESPACE__ .'\THEME_PATH', str_replace('\\', '/', __DIR__));

// We cannot use the sim theme
if(is_plugin_inactive('tsjippy-shared-functionality/tsjippy-shared-functionality.php') && is_plugin_inactive('sim-plugin/sim-plugin.php')){
    $themes = wp_get_themes();
    unset($themes['SIM theme']);

    switch_theme(array_values($themes)[0]['theme_root']);
    error_log("To use the sim-theme you need to install the tsjippy-shared-functionality plugin");
    //throw new Exception("To use the sim-theme you need to install the tsjippy-shared-functionality");
}

// composer
require 'lib/vendor/autoload.php';

$files = glob(__DIR__  . '/php/*.php');
foreach ($files as $file) {
    require_once($file);
}

//wp_enqueue_script('sim_theme_main_script', "$baseUrl/js/main.min.js", array(), wp_get_theme()->get('Version'), true);