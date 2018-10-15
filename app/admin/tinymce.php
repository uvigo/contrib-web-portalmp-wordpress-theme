<?php

namespace UVigoThemeWPApp;

/**
 * TinyMce Formats
 */

// Callback function to insert 'styleselect' into the $buttons array
add_filter('mce_buttons_2', function ($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}, 10);

// Attach callback to 'tiny_mce_before_init'
add_filter('tiny_mce_before_init', function ($init_array) {
    // Define the style_formats array
    $style_formats = array(
        // Each array child is a format with it's own settings
        array(
            'title' => 'Lista piquitos',
            'selector' => 'ul',
            'classes' => 'list-peak',
            'wrapper' => true,
        ),
        array(
            'title' => 'Lista columnada',
            'selector' => 'ul',
            'classes' => 'list-columns',
            'wrapper' => true,
        ),
        array(
            'title' => 'Antetítulo listaxes',
            'selector' => 'p',
            'classes' => 'header-list',
            'wrapper' => true,
        ),
        array(
            'title' => 'Imaxe redonda',
            'selector' => 'img',
            'classes' => 'rounded-image',
            'wrapper' => false,
        ),
        array(
            'title' => 'Romper aliñamentos',
            'selector' => 'h2, h3, h4',
            'classes' => 'clearfloat',
            'wrapper' => false,
        ),
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode($style_formats);
    $init_array['style_formats_autohide'] = json_encode(true);

    return $init_array;
}, 10);
