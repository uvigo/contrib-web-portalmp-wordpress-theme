<?php

namespace UVigoThemeWPApp;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme activated
 */
add_action('after_switch_theme', function ($old_name, $old_theme = false) {
    // update_option( 'medium_size_w', 800 );
    // update_option( 'medium_size_h', 400 );
    // Change date and time formats
    update_option('date_format', 'd/m/Y');
    update_option('time_format', 'H:i');

    // Change permalink category and tag base slug
    update_option('category_base', 'categorias');
    update_option('tag_base', 'etiquetas');
    flush_rewrite_rules(false); // recreate rewrite rules.
}, 10, 2);

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    // echo asset_path('styles/main.css');
    wp_enqueue_style('google/fonts/roboto', 'https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i', false, null);
    wp_enqueue_style('google/fonts/baskerville', 'https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i,700', false, null);
    wp_enqueue_style('uvigothemewp/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('uvigothemewp/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'uvigothemewp')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(445, 250, true);
    // additional image sizes
    // add_image_size('category-thumb', 300, 9999);
    add_image_size('featured-thumbnail-2x', 1500, 844, true);
    add_image_size('featured-thumbnail', 800, 450, true);

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/tinymce.css'));
}, 20);

/**
 * Theme Logo
 */
add_action('after_setup_theme', function () {
    add_theme_support('custom-logo', array(
        'width' => 960,
        'height' => 120,
        'flex-width' => true,
        'flex-height' => true,
    ));
});

/**
 * Init actions
 */
add_action('init', function () {
    add_post_type_support('page', 'excerpt');
}, 10);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'uvigothemewp'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Header', 'uvigothemewp'),
        'id'            => 'sidebar-header'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'uvigothemewp'),
        'id'            => 'sidebar-footer',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="sr-only">',
        'after_title'   => '</h3>'
    ] + $config);
    register_sidebar([
        'name'          => __('Sponsor', 'uvigothemewp'),
        'id'            => 'sidebar-sponsor',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="sr-only">',
        'after_title'   => '</h3>'
    ] + $config);

    register_sidebar([
        'name'          => __('Home Sidebar', 'uvigothemewp'),
        'id'            => 'sidebar-home'
    ] + $config);

    // Filter to add Custom Sidebars
    $uvigo_list_custom_sidebars = apply_filters('uvigo_list_custom_sidebars', []);

    if (isset($uvigo_list_custom_sidebars) && sizeof($uvigo_list_custom_sidebars) > 0) {
        foreach ($uvigo_list_custom_sidebars as $id => $sidebar_name) {
            register_sidebar([
                'name'        => $sidebar_name,
                'id'          => $id,
                'description' => esc_html__('Custom sidebar created by user.', 'uvigothemewp'),
            ] + $config);
        }
    }
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Theme Language
 */
add_action('after_setup_theme', function () {
    load_theme_textdomain('uvigothemewp', get_template_directory() . '/languages');
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    // echo 'after_setup_theme<br>';
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        // echo 'adf';
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
}, 10);

/**
 * Soberwp Models
 */
add_filter('sober/models/path', function () {
    if (is_child_theme()) {
        return get_template_directory() . '/app/models';
    } else {
        return get_theme_file_path() . '/app/models';
    }
});

/**
 * Soberwp Controller
 */
add_filter('sober/controller/path', function () {
    if (is_child_theme()) {
        return get_template_directory() . '/app/controllers';
    } else {
        return get_theme_file_path() . '/app/controllers';
    }
    // return get_theme_file_path() . '/app/controllers';
});

/**
 * Add 'superscript' and 'subscript' buttons to Editor
 */
add_filter('mce_buttons_2', function ($buttons) {
    return [ 'superscript', 'subscript' ] + $buttons;
});
