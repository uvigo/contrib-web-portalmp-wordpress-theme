<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

// echo 'LOAD functions.php ...';
// echo '<br>';
// echo is_child_theme() ? get_template_directory_uri().'/dist' : get_theme_file_uri().'/dist';
// echo '<br>';
// echo is_child_theme() ? get_template_directory().'/dist/assets.json' : get_theme_file_path().'/dist/assets.json';
// echo '<br>';

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'uvigothemewp');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7 or greater.', 'c'), __('Invalid PHP version', 'uvigothemewp'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.9.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.9.0 or greater.', 'uvigothemewp'), __('Invalid WordPress version', 'uvigothemewp'));
}

/**
 * Write to log function
 */
if (!function_exists('write_log')) {
    function write_log($log)
    {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'uvigothemewp'),
            __('Autoloader not found.', 'uvigothemewp')
        );
    }
    if (!is_child_theme()) {
        require_once $composer;
    }
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "./app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'uvigothemewp'), $file), 'File not found');
    }
}, [
    'helpers',
    'setup',
    'filters',
    'admin/admin',
    'admin/settings',
    'admin/customizer',
    'admin/sidebars',
    'admin/slider',
    'admin/tinymce',
    'admin/widgets-classname',
    'shortcodes/shortcodes',
    'widgets/widget-groupevent',
    'widgets/widget-news',
    'widgets/widget-menu',
    'widgets/widget-social',
    'wordpress/gallery',
    'wordpress/menu-walker',
    'update',
]);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require __DIR__.'/config/assets.php',
            'theme' => require __DIR__.'/config/theme.php',
            'view' => require __DIR__.'/config/view.php',
        ]);
    }, true);
