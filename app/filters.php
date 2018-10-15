<?php

namespace UVigoThemeWPApp;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__ . '\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    // echo '<br>template_include: ' . $template;
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        // echo "uvigothemewp/template/{$class}/data <br>";
        return apply_filters("uvigothemewp/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory() . '/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Tell WordPress how to find the compiled path of comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );
    return template_path(locate_template(["views/{$comments_template}", $comments_template]) ? : $comments_template);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a class="excerpt_more" href="' . get_permalink() . '">' . __('Continued', 'uvigothemewp') . '</a>';
});

/**
 * Change word lengths to the excerpt
 */
add_filter('excerpt_length', function () {
    return 25;
}, 999);

/**
 * Change the Archive Title
 */
add_filter('get_the_archive_title', function ($title) {
    if (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }

    return $title;
});

/**
 * Pagination markup changes
 */
add_filter('navigation_markup_template', function ($template, $class) {
    $template = '
    <nav class="navigation %1$s" role="navigation">
        <h2 class="screen-reader-text">%2$s</h2>
        %3$s
    </nav>';

    return $template;
}, 10, 2);

/**
 * Replace search form
 */
add_filter('get_search_form', function () {
    $form = '';
    echo template('partials.searchform');
    return $form;
});

/**
 * Add css classname to all menu items
 */
add_filter('nav_menu_css_class', function ($classes, $item) {
    $classes[] = 'nav-item';

    if (is_tax('research') && $item->object_id === get_option('ciuvigo_researchlines_page')) {
        $classes[] = 'current-menu-item';
    } elseif (is_singular('uvigo-inv-group') && $item->object_id === get_option('ciuvigo_researchgroups_page')) {
        $classes[] = 'current-menu-item';
    } elseif (is_singular('uvigo-inv-staff') && $item->object_id === get_option('ciuvigo_researchstaff_page')) {
        $classes[] = 'current-menu-item';
    }

    return $classes;
}, 10, 2);

/**
 * Add css classname to all menu link items
 */
add_filter('nav_menu_link_attributes', function ($atts, $item, $args, $depth) {
    $atts['class'] = (array_key_exists('class', $atts)) ? $atts['class'] . ' nav-link' : 'nav-link';
    return $atts;
}, 10, 4);

/**
 * Remove not only current branch in menu
 */
function submenu_get_children_ids($id, $items)
{
    $ids = wp_filter_object_list($items, array('menu_item_parent' => $id), 'and', 'ID');

    foreach ($ids as $id) {
        $ids = array_merge($ids, submenu_get_children_ids($id, $items));
    }

    return $ids;
}

add_filter('wp_nav_menu_objects', function ($sorted_menu_items, $args) {
    if ($args->theme_location == 'primary_navigation' && $args->container_id == 'sidebar-menu') {
        $parent_menu_item_id = 0;
        foreach ($sorted_menu_items as $key => $menu_item) {
            if ($menu_item->post_parent == 0 && $menu_item->current_item_ancestor) {
                $parent_menu_item_id = $menu_item->ID;
                break;
            }
        }

        if (is_tax('research')
            || is_singular('uvigo-inv-group')
            || is_singular('uvigo-inv-staff')) {
            $parent_menu_item_id = 93;
        }

        if (is_singular('uvigo-teacher')) {
            $teachers_page = get_theme_mod('uvigothemewp_sfp_teachers_setting');
            if (isset($teachers_page)) {
                $teachers_menu_item = find_by_object_id($sorted_menu_items, $teachers_page);
                if ($teachers_menu_item) {
                    $parent_menu_item_id = $teachers_menu_item->ID;
                }
            }
        }

        if (is_singular(['uvigo-subject'])) {

            function find_by_object_id($items, $object_id)
            {
                $items = wp_filter_object_list($items, array('object_id' => $object_id), 'and');
                if (!empty($items)) {
                    return array_values($items)[0];
                }
                return null;
            }

            //titulacion
            $subjects_root_page_id = apply_filters('uvigo_teaching_certification_subjects_root_page', null, get_the_ID());
            if ($subjects_root_page_id) {
                $ancestors = get_post_ancestors($subjects_root_page_id);

                // Ancestros
                foreach ($ancestors as $k => $ancestor_id) {
                    $menu_ancestor = find_by_object_id($sorted_menu_items, $ancestor_id);
                    if ($menu_ancestor) {
                        $menu_ancestor->current_item_ancestor = 1;
                        $menu_ancestor->classes[] = 'current-menu-ancestor';
                        $menu_ancestor->classes[] = 'current_page_ancestor';
                    }
                }

                // Root of Menu
                $root_id = array_pop($ancestors);
                $root_menu_item = find_by_object_id($sorted_menu_items, $root_id);
                if ($root_menu_item) {
                    $parent_menu_item_id = $root_menu_item->ID;
                }

                // Parent os Subjects
                $parent_id = array_shift($ancestors);
                $parent_menu_item = find_by_object_id($sorted_menu_items, $parent_id);
                if ($parent_menu_item) {
                    $parent_menu_item->current_item_parent = 1;
                    $parent_menu_item->classes[] = 'current-menu-parent';
                    $parent_menu_item->classes[] = 'current_page_parent';
                }

                // Current
                $subjects_menu_item = find_by_object_id($sorted_menu_items, $subjects_root_page_id);
                if ($subjects_menu_item) {
                    $subjects_menu_item->current = 1;
                    $subjects_menu_item->classes[] = 'current-menu-item';
                    $subjects_menu_item->classes[] = 'current_page_item';
                }
            }
        }

        if ($parent_menu_item_id) {
            $children = submenu_get_children_ids($parent_menu_item_id, $sorted_menu_items);
            array_unshift($children, $parent_menu_item_id);
            foreach ($sorted_menu_items as $key => $item) {
                if (!in_array($item->ID, $children)) {
                    unset($sorted_menu_items[$key]);
                }
            }
            error_log("sorted_menu_items : " . print_r($sorted_menu_items, true));
        } else {
            $sorted_menu_items = [];
        }
    }

    return $sorted_menu_items;
}, 10, 2);

/**
 * Trick for header menu principal
 */
add_filter('wp_nav_menu_items', function ($items, $args) {

    if ($args->theme_location == 'primary_navigation' && $args->container_id == 'primary-navigation') {
        $items = '<li class="fill-menu" aria-hiden="true">&nbsp;</li>' . $items;
    }

    return $items;
}, 10, 2);


/**
 * Display sidebar filter
 */
add_filter('uvigothemewp/display_sidebar', function ($display) {
    static $display;

    $base_template_page = basename(get_page_template());

    isset($display) || $display = in_array(true, [
        // The sidebar will be displayed if any of the following return true
        is_single(),
        (is_page() && $base_template_page != 'template-fullwidth.blade.php'),
        is_tax('research'),
        is_tax('uvigo-groupevent'),
        is_archive(),
        is_home(),
        //   is_404(),
    ]);
    return $display;
});

/**
 * Change 'post' article
 */
add_filter('post_type_single_title', function ($title, $post_type) {
    if ($post_type == 'post') {
        $title = _x('News', 'post_type_archive_title', 'uvigothemewp');
    }

    return $title;
}, 10, 2);

/**
 * Disable wpauto in Contact Form 7
 */
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Add a new element to Contact Form 7: similar to range but with numbers in steps
 */
if (class_exists('WPCF7')) {
    add_action('wpcf7_init', function () {
        wpcf7_add_form_tag(
            array('steps', 'steps*'),
            function ($tag) {
                if (empty($tag->name)) {
                    return '';
                }

                $validation_error = wpcf7_get_validation_error($tag->name);

                $class = wpcf7_form_controls_class($tag->type);

                $class .= ' wpcf7-validates-as-number';

                if ($validation_error) {
                    $class .= ' wpcf7-not-valid';
                }

                $atts = array();

                $atts['class'] = $tag->get_class_option($class);
                $atts['id'] = $tag->get_id_option();
                $atts['tabindex'] = $tag->get_option('tabindex', 'signed_int', true);
                $atts['min'] = $tag->get_option('min', 'signed_int', true);
                $atts['max'] = $tag->get_option('max', 'signed_int', true);
                $atts['step'] = $tag->get_option('step', 'int', true);

                if ($tag->has_option('readonly')) {
                    $atts['readonly'] = 'readonly';
                }

                if ($tag->is_required()) {
                    $atts['aria-required'] = 'true';
                }

                $atts['aria-invalid'] = $validation_error ? 'true' : 'false';

                $value = (string)reset($tag->values);

                if ($tag->has_option('placeholder') || $tag->has_option('watermark')) {
                    $atts['placeholder'] = $value;
                    $value = '';
                }

                $value = $tag->get_default_option($value);

                $value = wpcf7_get_hangover($tag->name, $value);

                $atts['value'] = $value;

                if (wpcf7_support_html5()) {
                    $atts['type'] = $tag->basetype;
                } else {
                    $atts['type'] = 'text';
                }
                $atts['type'] = 'range';

                $atts['name'] = $tag->name;

                $steps_items = '<div class="form-control-range-steps">';
                for ($i = $atts['min']; $i <= $atts['max']; $i++) {
                    $steps_items .= '<span>' . $i . '</span>';
                }
                $steps_items .= '</div>';

                $atts = wpcf7_format_atts($atts);

                $html = sprintf(
                    '<span class="wpcf7-form-control-wrap %1$s"><input %2$s/>%3$s%4$s</span>',
                    sanitize_html_class($tag->name),
                    $atts,
                    $steps_items,
                    $validation_error
                );

                return $html;
            },
            array('name-attr' => true)
        );
    });

    // Add validations to new contact form 7 element, the same as numbers.
    add_filter('wpcf7_validate_steps', 'wpcf7_number_validation_filter', 10, 2);
    add_filter('wpcf7_validate_steps*', 'wpcf7_number_validation_filter', 10, 2);
}



/**
 * -------
 *
 */
add_filter('comment_form_fields', function ($comment_fields) {
    $fields = [];

    foreach ($comment_fields as $key => $value) {
        if ($key !== 'cookies') {
            $fields[$key] = $value;
        }
    }

    $consent = '<p class="form-check">';
    $consent .= '<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">';
    $consent .= '<label class="form-check-label" for="defaultCheck1">Default checkbox</label>';
    $consent .= '</p>';

    // $consent = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" />';
    // $consent .= '<label for="wp-comment-cookies-consent">' . __( 'Save my name, email, and website in this browser for the next time I comment.' ) . '</label></p>';

    $fields['consent'] = $consent;

    return $fields;
}, 10, 1);

/**
 * Change Home Query
 */
add_action('pre_get_posts', function ($query) {
    if ($query->is_home() && $query->is_main_query()) {
        $query->set('post_type', ['post', 'uvigo-event']);
    }
}, 10);

/**
 * Redirección para os Grupos de Eventos.
 */
add_action('template_redirect', function () {
    if (is_tax('uvigo-groupevent') && !is_user_logged_in()) {
        $term = get_queried_object();
        wp_redirect(home_url($term->description));
        die;
    }
});
