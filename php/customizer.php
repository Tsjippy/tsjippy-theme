<?php

namespace TSJIPPYTHEME;

if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Label_Control extends \WP_Customize_Control
    {
        /**
         * Render the control's content.
         *
         * @since 3.4.0
         */
        public function render_content()
        {
            ?>
            <label class="customize-control-select">
                <span class="customize-control-title">
                    <?php echo esc_html($this->label); ?>
                </span>
            </label>

            <?php
            $descriptionId   = '_customize-description-' . $this->id;
            if (! empty($this->description)){
                ?>
                <span id="<?php echo esc_attr($descriptionId); ?>" class="description customize-control-description">
                    <?php echo esc_attr($this->description); ?>
                </span>
                <?php 
            }
        }
    }
}

// Add home page customizer options
if (! function_exists('tsjippyCustomizeRegister')) {
    add_action('customize_register', __NAMESPACE__ . '\tsjippyCustomizeRegister', 30);

    /**
     * Add our base options to the Customizer.
     *
     * @param \WP_Customize_Manager $wpCustomize Theme Customizer object.
     */
    function tsjippyCustomizeRegister($wpCustomize)
    {
        // Add a homepage panel
        $wpCustomize->add_panel(
            'tsjippy_frontpage_panel',
            array(
                'title' => __('Home page', '%TEXTDOMAIN%'),
                'priority'     => 20,
            )
        );

        topNavigation($wpCustomize);

        frontpageHeader($wpCustomize);
    }
}

/**
 * Top navigation settings
 */
function topNavigation($wpCustomize)
{
    $wpCustomize->add_section(
        'tsjippy_layout_top_navigation',
        array(
            'title' => __('Top Navigation', '%TEXTDOMAIN%'),
            'priority' => 29,
            'panel' => 'generate_layout_panel',
        )
    );

    $wpCustomize->add_setting(
        'top_nav_alignment_setting',
        array(
            'default' => 'right'
        )
    );

    $wpCustomize->add_control(
        'top_nav_alignment_setting',
        array(
            'type'    => 'select',
            'label'   => __('Top Navigation Alignment', '%TEXTDOMAIN%'),
            'section' => 'tsjippy_layout_top_navigation',
            'choices' => array(
                'left'   => __('Left', '%TEXTDOMAIN%'),
                'center' => __('Center', '%TEXTDOMAIN%'),
                'right'  => __('Right', '%TEXTDOMAIN%'),
            ),
            'settings' => 'top_nav_alignment_setting',
            'priority' => 20,
        )
    );
}

/**
 * The options for the frontpage header
 */
function frontpageHeader($wpCustomize)
{
    $wpCustomize->add_section(
        'tsjippy_header',
        array(
            'title' => __('Header image and buttons', '%TEXTDOMAIN%'),
            'priority' => 10,
            'panel' => 'tsjippy_frontpage_panel',
        )
    );

    $wpCustomize->add_setting(
        "header_image_height",
        [
            'default'   => 600
        ]
    );

    $wpCustomize->add_control(
        "header_image_height",
        [
            'type'            => 'number',
            'label'         => __('The height of the images in pixels', '%TEXTDOMAIN%'),
            'section'       => 'tsjippy_header',
            'settings'      => "header_image_height",
            'priority'      => 6
        ]
    );

    $wpCustomize->add_setting(
        'header_image',
    );

    $headerImageOptions = [
        'label'             => __('Frontpage Header Image', '%TEXTDOMAIN%'),
        'section'           => 'tsjippy_header',
        'settings'          => 'header_image',
        'priority'          => 5,
    ];

    if (extension_loaded('gd')) {
        $headerImageOptions['width']        = 1024;
        $headerImageOptions['flex_width']   = true;
        $headerImageOptions['flex_height']  = true;
        $height                             = get_theme_mod("header_image_height", false);
        if ($height) {
            $headerImageOptions['height']   = $height;
        }

        $wpCustomize->add_control(
            new \WP_Customize_Cropped_Image_Control(
                $wpCustomize,
                'header_image',
                $headerImageOptions
            )
        );
    } else {
        $wpCustomize->add_control(
            new \WP_Customize_Image_Control(
                $wpCustomize,
                'header_image',
                $headerImageOptions
            )
        );
    }

    $wpCustomize->add_setting(
        'first_button_page'
    );

    $wpCustomize->add_control(
        'first_button_page',
        [
            'label'             => __('First button page', '%TEXTDOMAIN%'),
            'section'           => 'tsjippy_header',
            'settings'          => 'first_button_page',
            'priority'          => 10,
            'type'                => 'dropdown-pages'
        ]
    );

    $wpCustomize->add_setting(
        'first_button_text',
        [
            'default'            => get_the_title(get_theme_mod('first_button_page')),
            'sanitize_callback'    => 'sanitize_text_field',
        ]
    );

    $wpCustomize->add_control(
        'first_button_text',
        [
            'label'             => __('First button text', '%TEXTDOMAIN%'),
            'section'           => 'tsjippy_header',
            'settings'          => 'first_button_text',
            'priority'          => 11
        ]
    );

    $wpCustomize->add_setting(
        'second_button_page',
    );

    $wpCustomize->add_control(
        'second_button_page',
        [
            'label'             => __('Second button page', '%TEXTDOMAIN%'),
            'section'           => 'tsjippy_header',
            'settings'          => 'second_button_page',
            'priority'          => 15,
            'type'                => 'dropdown-pages'
        ]
    );

    $wpCustomize->add_setting(
        'second_button_text',
        [
            'default'            => get_the_title(get_theme_mod('second_button_page')),
            'sanitize_callback'    => 'sanitize_text_field',
        ]
    );

    $wpCustomize->add_control(
        'second_button_text',
        [
            'label'             => __('Second button text', '%TEXTDOMAIN%'),
            'section'           => 'tsjippy_header',
            'settings'          => 'second_button_text',
            'priority'          => 16

        ]
    );
}
