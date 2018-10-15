<?php

namespace UVigoThemeWPApp;

use WP_Customize_Control;
use WP_Customize_Image_Control;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        },
    ]);

    // Redes Sociais
    $default_settings = [
        'default'   => '',
        'transport' => 'refresh',
    ];
    $wp_customize->add_section('uvigothemewp_social_networks', array(
        'title' => __('Social networks', 'uvigothemewp'),
        'priority' => 80,
    ));
    $wp_customize->add_setting('uvigothemewp_facebook_setting', $default_settings);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'uvigothemewp_facebook_control', array(
        'label'    => __('Facebook', 'uvigothemewp'),
        'section'  => 'uvigothemewp_social_networks',
        'settings' => 'uvigothemewp_facebook_setting',
    )));

    $wp_customize->add_setting('uvigothemewp_twitter_setting', $default_settings);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'uvigothemewp_twitter_control', array(
        'label'    => __('Twitter', 'uvigothemewp'),
        'section'  => 'uvigothemewp_social_networks',
        'settings' => 'uvigothemewp_twitter_setting',
    )));

    $wp_customize->add_setting('uvigothemewp_instagram_setting', $default_settings);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'uvigothemewp_instagram_control', array(
        'label'    => __('Instagram', 'uvigothemewp'),
        'section'  => 'uvigothemewp_social_networks',
        'settings' => 'uvigothemewp_instagram_setting',
    )));

    $wp_customize->add_setting('uvigothemewp_youtube_setting', $default_settings);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'uvigothemewp_youtube_control', array(
        'label'    => __('Youtube', 'uvigothemewp'),
        'section'  => 'uvigothemewp_social_networks',
        'settings' => 'uvigothemewp_youtube_setting',
    )));

    $wp_customize->add_setting('uvigothemewp_linkedin_setting', $default_settings);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'uvigothemewp_linkedin_control', array(
        'label'    => __('Linkedin', 'uvigothemewp'),
        'section'  => 'uvigothemewp_social_networks',
        'settings' => 'uvigothemewp_linkedin_setting',
    )));

    $wp_customize->add_setting('uvigothemewp_appleu_setting', $default_settings);

    //custom-mobile-logo
    $wp_customize->add_setting('custom-mobile-logo', $default_settings);
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'custom-mobile-logo-control',
        array(
            'label'    => __('Logo mobile', 'uvigothemewp'),
            'section'  => 'title_tagline',
            'settings' => 'custom-mobile-logo',
            'priority' => 9,
        )
    ));

    //teachers
    if (post_type_exists('uvigo-teacher')) {
        $wp_customize->add_setting('uvigothemewp_sfp_teachers_setting', $default_settings);
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'uvigothemewp_sfp_teachers_control', array(
            'label'    => __('Page Root Teachers', 'uvigothemewp'),
            'section'  => 'static_front_page',
            'settings' => 'uvigothemewp_sfp_teachers_setting',
            'type'     => 'dropdown-pages',
        )));
    }
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('uvigothemewp/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});
