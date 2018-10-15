<?php

namespace UVigoThemeWPApp;

const TAXONOMY_UVIGO_SLIDER_GROUP_NAME = 'uvigo-slider-group';
const SLIDER_POST_TYPE = 'uvigo-slide';

/**
 * Register uvigo-slider-group taxonomy
 *
 * @since 1.0.0
 */
add_action('init', function () {
    if (!taxonomy_exists(TAXONOMY_UVIGO_SLIDER_GROUP_NAME)) {
        $labels = array(
            'name'              => _x('Types Sliders', 'taxonomy general name', 'uvigothemewp'),
            'singular_name'     => _x('Type slider', 'taxonomy singular name', 'uvigothemewp'),
            'search_items'      => __('Search Type slider', 'uvigothemewp'),
            'all_items'         => __('All Type slider', 'uvigothemewp'),
            'parent_item'       => __('Parent Type slider', 'uvigothemewp'),
            'parent_item_colon' => __('Parent Type slider:', 'uvigothemewp'),
            'edit_item'         => __('Edit Type slider', 'uvigothemewp'),
            'update_item'       => __('Update Type slider', 'uvigothemewp'),
            'add_new_item'      => __('Add New Type slider', 'uvigothemewp'),
            'new_item_name'     => __('New Type slider Name', 'uvigothemewp'),
            'menu_name'         => __('Type slider', 'uvigothemewp'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_menu'      => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => false,
            'query_var'         => 'taxonomy-slider-group',
            'rewrite'           => array('slug' => 'slider-group'),
        );

        $ob = register_taxonomy(
            TAXONOMY_UVIGO_SLIDER_GROUP_NAME,
            array(
                SLIDER_POST_TYPE,
            ),
            $args
        );
    }
}, 10);

/**
 * Register the custom post type Slider
 *
 * @since    1.0.0
 */
add_action('init', function () {
    $labels = array(
        'name'               => _x('Sliders', 'post type general name', 'uvigothemewp'),
        'singular_name'      => _x('Slider', 'post type singular name', 'uvigothemewp'),
        'menu_name'          => _x('Sliders', 'admin menu', 'uvigothemewp'),
        'name_admin_bar'     => _x('Sliders', 'add new on admin bar', 'uvigothemewp'),
        'add_new'            => _x('Add new', 'slider', 'uvigothemewp'),
        'add_new_item'       => __('Add new slider', 'uvigothemewp'),
        'new_item'           => __('New slider', 'uvigothemewp'),
        'edit_item'          => __('Edit slider', 'uvigothemewp'),
        'view_item'          => __('View slider', 'uvigothemewp'),
        'all_items'          => __('All sliders', 'uvigothemewp'),
        'search_items'       => __('Search sliders', 'uvigothemewp'),
        'parent_item_colon'  => __('Parent slider:', 'uvigothemewp'),
        'not_found'          => __('Sliders not found.', 'uvigothemewp'),
        'not_found_in_trash' => __('Sliders not found in trash.', 'uvigothemewp'),
    );

    $args = array(
        'labels'              => $labels,
        'description'         => __('Sliders.', 'uvigothemewp'),
        'public'              => true,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => false,
        'rewrite'             => array('slug' => 'slider'),
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-images-alt2',
        'supports'            => array('title', 'editor', 'excerpt', 'page-attributes', 'custom-fields', 'thumbnail', 'author'),
        'taxonomies'          => array(TAXONOMY_UVIGO_SLIDER_GROUP_NAME),
        'exclude_from_search' => true,
    );

    register_post_type(SLIDER_POST_TYPE, $args);
}, 10);

/**
 * Add slider Image Size
 */
add_action('after_setup_theme', function () {
    add_image_size('slider-image', 1440, 540, true);
}, 30);
