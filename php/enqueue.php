<?php

namespace TSJIPPYTHEME;

add_action('wp_enqueue_scripts', function () {
    $baseUrl    = get_stylesheet_directory_uri();

    wp_enqueue_style('sim_theme_style', "$baseUrl/css/main.min.css", array(), wp_get_theme()->get('Version'));
});

/**
 * Enqueue styles and scripts for the Customizer.
 */
add_action('customize_controls_enqueue_scripts', function () {
    wp_enqueue_script(
        'tsjippy-theme-customizer-control',
        get_stylesheet_directory_uri() . '/js/customizer.min.js',
        array('customize-controls'),
        '20180924',
        true
    );
});
