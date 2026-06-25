<?php

namespace TSJIPPYTHEME;

use Exception;

define(__NAMESPACE__ . '\THEME', 'tsjippy-theme');
define(__NAMESPACE__ . '\THEME_PATH', str_replace('\\', '/', __DIR__));

// composer
require 'lib/vendor/autoload.php';

$files = glob(__DIR__."/php/*.php", \GLOB_BRACE);
foreach ($files as $file) {
    require_once($file);
}

/**
 * Transforms an url to a path
 * @param     string        $url             The url to be transformed
 *
 * @return    string                        The path
 */
function urlToPath($url)
{
    if (gettype($url) != 'string') {
        return '';
    }

    if (file_exists($url)) {
        return $url;
    }

    $siteUrl    = str_replace(['https://', 'http://'], '', SITEURL);
    $url        = str_replace(['https://', 'http://'], '', urldecode($url));
    $url        = explode('?', $url)[0];

    return str_replace(trailingslashit($siteUrl), str_replace('\\', '/', ABSPATH), $url);
}