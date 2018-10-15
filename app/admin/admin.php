<?php

namespace UVigoThemeWPApp;

/**
 * Theme Admin assets
 */
add_action('admin_enqueue_scripts', function ($pagehook) {
    wp_enqueue_script('uvigothemewp/admin.js', asset_path('scripts/admin.js'), ['jquery'], null, true);
    wp_enqueue_style('uvigothemewp/admin.css', asset_path('styles/admin.css'), false, null);
    // do nothing if we are not on the target pages
    if (('edit.php' == $pagehook)) {
        wp_enqueue_script('uvigothemewp/quickfields.js', asset_path('scripts/quickfields.js'), ['jquery'], null, true);
    }
});

/**
 * Order on Admin View of Slider post Type
 */
add_action('pre_get_posts', function ($query) {
    if (is_admin() && $query->is_main_query() && $query->get('post_type') === SLIDER_POST_TYPE) {
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    }
}, 10);
