<?php

namespace UVigoThemeWPApp\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public static function errorLog($log)
    {
        if (is_array($log) || is_object($log)) {
            error_log(print_r($log, true));
        } else {
            error_log($log);
        }
    }

    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'uvigothemewp');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return __('Search Results for', 'uvigothemewp') . ' <em class="search-text">' . get_search_query() . '</em>';
        }
        if (is_404()) {
            return __('Not Found', 'uvigothemewp');
        }
        return get_the_title();
    }

    public static function languagesMenuSwitcher($name_style = 'code')
    {
        if (class_exists('SitePress')) {
            $languages = apply_filters('wpml_active_languages', null, array(
                'skip_missing' => 0,
            ));

            if (! empty($languages) && count($languages) > 1) {
                echo '<div class="language-switcher">';
                echo '<ul>';

                foreach ($languages as $language) {
                    if (! $language['active']) {
                        echo '<li class="language-link' . ( $language['active'] ? ' language-active' : '' ) . '">';
                        echo '<a href="' . $language['url'] . '" title="' . $language['native_name'] . '" hreflang="' . $language['default_locale'] . '">';
                        if ($name_style == 'code') {
                            echo $language['language_code'];
                        } else {
                            echo $language['native_name'];
                        }
                        echo '</a></li>';
                    }
                }

                echo '</ul>';
                echo '</div>';
            }
        }
    }

    public static function breadcrumb()
    {
        if (is_404()) {
            return;
        }

        global $post;

        $post_id = 0;
        $ancestors = array();

        if ($post) {
            if (is_singular('post')) {
                $post_id = $post->ID;
                $actual_title = '';
                $ancestors[] = get_page(get_option('page_for_posts'));
            } elseif (is_singular('uvigo-event')) {
                $post_id = $post->ID;
                $actual_title = '';
                $groupevent_names = wp_get_post_terms($post_id, \Uvigo_News_Admin::UV_GROUPEVENT_TAXONOMY);
                if ($groupevent_names) {
                    $ancestors[] = [
                        'title' => $groupevent_names[0]->name,
                        'link'  => get_term_link($groupevent_names[0]),
                    ];
                }
                $ancestors[] = get_page(get_option('page_for_posts'));
            } elseif (is_singular('uvigo-offer')) {
                $post_id = $post->ID;
                $actual_title = self::theTerms($post_id, 'uvigo-tax-offer');
                $ancestors[] = [
                    'title' => get_post_type_object('uvigo-offer')->label,
                    'link'  => get_post_type_archive_link('uvigo-offer')
                ];
            } elseif (is_singular('uvigo-practice')) {
                $post_id = $post->ID;
                $actual_title = self::theTerms($post_id, 'uvigo-tax-practice');
                $ancestors[] = [
                    'title' => get_post_type_object('uvigo-practice')->label,
                    'link'  => get_post_type_archive_link('uvigo-practice')
                ];
            } elseif (is_singular(['uvigo-teacher'])) {
                $teachers_page = get_theme_mod('uvigothemewp_sfp_teachers_setting');
                if ($teachers_page) {
                    $post_id = $post->ID;
                    $actual_title = $post->post_title;
                    $ancestors[] = $teachers_page;
                }
            } elseif (is_singular(['uvigo-subject'])) {
                $subjects_root_page_id = apply_filters('uvigo_teaching_certification_subjects_root_page', null, $post->ID);
                if ($subjects_root_page_id) {
                    $post_id = $post->ID;
                    $actual_title = $post->post_title;
                    $ancestors = get_post_ancestors($subjects_root_page_id);
                    array_unshift($ancestors, get_post($subjects_root_page_id));
                }
            } elseif (is_page()) {
                $post_id = $post->ID;
                $actual_title = $post->post_title;
                $ancestors = get_post_ancestors($post_id);
            }
        } else {
            if (is_tax('research')) {
                $term = get_queried_object();
                $post_id = get_option('ciuvigo_researchlines_page');
                $actual_title = $term->name;
                $ancestors = get_post_ancestors($post_id);
                array_unshift($ancestors, get_page(223));
            }
        }

        $output = '';
        if ($post_id) {
            $output .= '<nav class="breadcrumb-nav" aria-label="breadcrumb">';
            $output .= '<ol class="breadcrumb">';
            if (! empty($ancestors)) {
                $ancestors = array_reverse($ancestors);
                foreach ($ancestors as $ancestor) {
                    $link = '';
                    $title = '';
                    if (is_a($ancestor, 'WP_Post') || is_numeric($ancestor)) {
                        $link = get_permalink($ancestor);
                        $title = get_the_title($ancestor);
                    } else {
                        $link = $ancestor['link'];
                        $title = $ancestor['title'];
                    }
                    $output .= '<li class="breadcrumb-item"><a href="' . esc_url($link) . '">' . $title . '</a></li>';
                }
            }
            if ($actual_title) {
                $output .= '<li class="breadcrumb-item active" aria-current="page">' . $actual_title . '</li>';
            }
            $output .= '</ol>';
            $output .= '</nav>';
        }

         // filter to change de breadcrumb.
        $output = apply_filters('uvigothemewp/breadcrumb', $output, $post);

        echo $output;
    }

    /**
     * Generate Breadcrum navigator
     *
     * @param [Array] $ancestors_map Title / URL
     * @param [String] $actual_title
     * @return void
     */
    public static function theBreadcrumb($ancestors_map, $actual_title)
    {
        $output = '';
        $output .= '<nav class="breadcrumb-nav" aria-label="breadcrumb">';
        $output .= '<ol class="breadcrumb">';
        if (! empty($ancestors_map)) {
            $ancestors_map = array_reverse($ancestors_map);

            foreach ($ancestors_map as $title => $url) {
                $output .= '<li class="breadcrumb-item"><a href="' . $url . '">' . $title . '</a></li>';
            }
        }
        if ($actual_title) {
            $output .= '<li class="breadcrumb-item active" aria-current="page">' . $actual_title . '</li>';
        }
        $output .= '</ol>';
        $output .= '</nav>';
        return $output;
    }

    public static function mediaHasSize($attachment_id, $size)
    {
        $image_attributes = wp_get_attachment_image_src($attachment_id, $size);

        if ($image_attributes) {
            return $image_attributes[3];
        }

        return false;
    }

    /** Recuperación del logo de movil. */
    public static function theCustomMobileLogo()
    {
        echo App::getCustomMobileLogo();
    }

    public static function getCustomMobileLogo($blog_id = 0)
    {
        $html = '';
        $switched_blog = false;
        $empty_mobile_logo = true;

        if (is_multisite() && ! empty($blog_id) && (int) $blog_id !== get_current_blog_id()) {
            switch_to_blog($blog_id);
            $switched_blog = true;
        }

        $custom_logo_url = get_theme_mod('custom-mobile-logo');

        // We have a logo. Logo is go.
        if ($custom_logo_url) {
            $empty_mobile_logo = false;
            $html = sprintf(
                '<a href="%1$s" class="custom-logo-link mobile" rel="home" itemprop="url">
                <img src="%2$s" class="custom-logo mobile" alt="%3$s" itemprop="logo">
                </a>',
                esc_url(home_url('/')),
                esc_url($custom_logo_url),
                get_bloginfo('name', 'display')
            );
        }

        if ($switched_blog) {
            restore_current_blog();
        }

        // Return same logo as defulat 'custom_logo'
        if ($empty_mobile_logo) {
            $html = get_custom_logo();
        }

        return $html;
    }

    public static function getThumbnailAndCaption($size = 'large')
    {
        $post_id = get_post_thumbnail_id();
        $caption = wp_get_attachment_caption($post_id);
        $html = '';

        if ($caption) {
            $html = '<figure class="wp-caption">';
            $html .= get_the_post_thumbnail(null, $size);
            $html .= '<figcaption class="wp-caption-text">' . $caption . '</figcaption>';
            $html .= '</figure>';
        } else {
            $html = get_the_post_thumbnail(null, $size);
        }

        return $html;
    }

    public static function getPostTypeTitle($post_type = '', $type = '')
    {
        $title = '';

        if ($post_type) {
            $post_type_obj = get_post_type_object($post_type);

            if ($type === 'archive') {
                $title = apply_filters('post_type_archive_title', $post_type_obj->labels->name, $post_type);
            } else {
                $title = apply_filters('post_type_single_title', $post_type_obj->labels->singular_name, $post_type);
            }
        }

        return $title;
    }

    public static function getTerms($taxonomies)
    {
        $terms = [];
        foreach ($taxonomies as $tax) {
            $tax_terms = get_the_terms(null, $tax);
            if ($tax_terms && ! is_wp_error($tax_terms)) {
                $terms = array_merge($terms, $tax_terms);
            }
        }
        // print_r($terms);

        return $terms;
    }

    public static function theTerms($id, $taxonomy, $before = '', $sep = '', $after = '')
    {
        $terms = get_the_terms($id, $taxonomy);
        $names = array();
        foreach ($terms as $term) {
            $names[] = $term->name;
        }

        return $before . join($sep, $names) . $after;
    }

    public static function getSidebarUsed()
    {
        if (is_home()) {
            dynamic_sidebar('sidebar-home');
        } elseif (is_singular('post', 'uvigo-event')) {
            dynamic_sidebar('sidebar-home');
        } elseif (is_tax('uvigo-groupevent')) {
            dynamic_sidebar('sidebar-home');
        } else {
            $uvigo_page_template_sidebar = get_post_meta(get_the_ID(), 'uvigo_page_template_sidebar', true);
            if ($uvigo_page_template_sidebar && 'none' !== $uvigo_page_template_sidebar) {
                if (is_active_sidebar($uvigo_page_template_sidebar)) {
                    dynamic_sidebar($uvigo_page_template_sidebar);
                }
            }
        }

        $sidebar_index = apply_filters('uvigothemewp_sidebar_used', '');
        if ($sidebar_index) {
            dynamic_sidebar($sidebar_index);
        }
    }

    public static function getThumbnailBackground($size, $attr = '')
    {
        global $_wp_additional_image_sizes;

        if (has_image_size($size) && isset($_wp_additional_image_sizes[$size])) {
            $width  = $_wp_additional_image_sizes[$size]['width'];
            $height = $_wp_additional_image_sizes[$size]['height'];
            $class  = 'wp-post-image ';
            if (is_array($attr) && isset($attr['class'])) {
                $class .= $attr['class'];
            }
            echo '<div class="unresize-thumbnail" style="background-image: url(\'' . get_the_post_thumbnail_url(null, $size) . '\');">';
            echo '<img src="' . \UVigoThemeWPApp\asset_path("images/empty-${width}x${height}.png") . '" class="' . $class . '" width="' . $width . '" height="' . $height . '" alt="' . esc_attr(get_the_title()) . '">';
            echo '</div>';
        } else {
            echo get_the_post_thumbnail(null, $size, $attr);
        }
    }

    public static function hasEmbed($post_id = false)
    {
        if (!$post_id) {
            $post_id = get_the_ID();
        } else {
            $post_id = absint($post_id);
        }

        if (!$post_id) {
            return false;
        }

        $post_meta = get_post_custom_keys($post_id);

        foreach ($post_meta as $meta) {
            if ('_oembed' != substr(trim($meta), 0, 7)) {
                continue;
            }
            return true;
        }

        return false;
    }

    public static function hasFeaturedVideo($post_id = false)
    {
        if (!$post_id) {
            $post_id = get_the_ID();
        } else {
            $post_id = absint($post_id);
        }

        if (!$post_id) {
            return false;
        }

        $post_meta = get_post_custom_keys($post_id);

        foreach ($post_meta as $meta) {
            if ('uvigo_featured_video_url' != trim($meta)) {
                continue;
            } elseif (empty(get_post_meta($post_id, 'uvigo_featured_video_url', true))) {
                continue;
            }
            return true;
        }

        return false;
    }

    public static function renderFeaturedVideo($post_id = false)
    {
        if (!$post_id) {
            $post_id = get_the_ID();
        } else {
            $post_id = absint($post_id);
        }

        if (!$post_id) {
            return false;
        }

        $url_embed = get_post_meta($post_id, 'uvigo_featured_video_url', true);

        global $wp_embed;
        $embed_code = $wp_embed->run_shortcode('[embed width="500"]' . $url_embed . '[/embed]');

        // $embed_code = wp_oembed_get($url_embed, ['width' => 500]);
        // $embed_code = do_shortcode('[embed width="500"]' . $url_embed . '[/embed]');

        return $embed_code;
    }

    public static function getTermImage($post_id = false, $taxonomy = '')
    {
        $url_image = false;

        if (!$post_id) {
            $post_id = get_the_ID();
        } else {
            $post_id = absint($post_id);
        }

        if (!$post_id) {
            return false;
        }

        $terms_id = wp_get_post_terms($post_id, $taxonomy, array( 'fields' => 'ids' ));

        if (!empty($terms_id)) {
            $post_id = $taxonomy . '_' . $terms_id[0];
            $url_image = get_field('uvigo_groupevent_icon', $post_id);
        }

        return $url_image;
    }
}
