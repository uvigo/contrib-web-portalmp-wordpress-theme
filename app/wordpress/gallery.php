<?php

namespace UVigoThemeWPApp;

/**
 * Gallery sizes
 */
add_action('after_setup_theme', function () {
    add_image_size('gallery-image', 400, 400, true);
    add_image_size('gallery-image-slide', 1280, 720, true);
}, 40);

/**
 * Change the Gallery shortcode original output.
 *
 */
add_filter('post_gallery', function ($output, $attr, $instance) {

    $post = get_post();

    $atts = shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => 'figure',
        'icontag'    => 'div',
        'captiontag' => 'figcaption',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => '',
        'link'       => ''
    ), $attr, 'gallery');

    $id = intval($atts['id']);

    if (! empty($atts['include'])) {
        $_attachments = get_posts(array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif (! empty($atts['exclude'])) {
        $attachments = get_children(array('post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));
    } else {
        $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));
    }

    if (empty($attachments)) {
        return '';
    }

    if (is_feed()) {
        $output = "\n";
        foreach ($attachments as $att_id => $attachment) {
            $output .= wp_get_attachment_link($att_id, $atts['size'], true) . "\n";
        }
        return $output;
    }

    $itemtag = tag_escape($atts['itemtag']);
    $captiontag = tag_escape($atts['captiontag']);
    $icontag = tag_escape($atts['icontag']);
    $valid_tags = wp_kses_allowed_html('post');
    if (! isset($valid_tags[ $itemtag ])) {
        $itemtag = 'dl';
    }
    if (! isset($valid_tags[ $captiontag ])) {
        $captiontag = 'dd';
    }
    if (! isset($valid_tags[ $icontag ])) {
        $icontag = 'dt';
    }

    $columns = intval($atts['columns']);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = '';

    // En función das columnas da imaxe seleccionamos un ou outro tamaño de imaxe
    if ($columns > 1) {
        $atts['size'] = 'gallery-image';
    } else {
        $atts['size'] = 'gallery-image-slide';
    }

    $size_class = sanitize_html_class($atts['size']);
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

    /**
     * Filters the default gallery shortcode CSS styles.
     *
     * @since 2.5.0
     *
     * @param string $gallery_style Default CSS styles and opening HTML div container
     *                              for the gallery shortcode output.
     */
    $output = apply_filters('gallery_style', $gallery_style . $gallery_div);

    $i = 0;
    foreach ($attachments as $id => $attachment) {
        if ($columns == 1) {
            $attr = (trim($attachment->post_excerpt)) ? array('aria-describedby' => "$selector-$id") : '';

            $image_output = wp_get_attachment_link($id, $atts['size'], false, false, false, $attr);
            // $image_output = wp_get_attachment_image($id, $atts['size'], false, $attr);

            // if (! empty($atts['link']) && 'file' === $atts['link']) {
            //     $image_output = wp_get_attachment_link($id, $atts['size'], false, false, false, $attr);
            // } elseif (! empty($atts['link']) && 'none' === $atts['link']) {
            //     $image_output = wp_get_attachment_image($id, $atts['size'], false, $attr);
            // } else {
            //     $image_output = wp_get_attachment_link($id, $atts['size'], true, false, false, $attr);
            // }
            $image_meta  = wp_get_attachment_metadata($id);

            $orientation = '';
            if (isset($image_meta['height'], $image_meta['width'])) {
                $orientation = ($image_meta['height'] > $image_meta['width']) ? 'portrait' : 'landscape';
            }
            $output .= "<{$itemtag} class='gallery-item'>";
            $output .= "<{$icontag} class='gallery-icon {$orientation}'>";
            if ($columns == 1) {
                $output .= '<div class="gallery-item-open"><span class="sr-only">' . __('Open', 'uvigothemewp') . '</span></div>';
            }
            $output .= "
                    $image_output
                </{$icontag}>";

            if ($columns == 1) {
                $output .= '<div class="gallery-item-slider-controls-position">';
                $output .= '<a class="gallery-item-download" href="' . wp_get_attachment_url($id) . '" download>' . __('Download', 'uvigothemewp') . '</a>';
                $output .= '</div>';
            }

            if ($captiontag && trim($attachment->post_excerpt)) {
                $output .= "
                    <{$captiontag} class='wp-caption-text gallery-item-info' id='$selector-$id'>
                    <p class='gallery-item-caption'>" . $attachment->post_excerpt . "</p>
                    <p class='gallery-item-title'>" . $attachment->post_title . "</p>
                    " . apply_filters('the_content', $attachment->post_content) . "
                    </{$captiontag}>";
            }
            $output .= "</{$itemtag}>";
        } else {
            $attr = (trim($attachment->post_excerpt)) ? array('aria-describedby' => "$selector-$id") : '';
            if (! empty($atts['link']) && 'file' === $atts['link']) {
                $image_output = wp_get_attachment_link($id, $atts['size'], false, false, false, $attr);
            } elseif (! empty($atts['link']) && 'none' === $atts['link']) {
                $image_output = wp_get_attachment_image($id, $atts['size'], false, $attr);
            } else {
                $image_output = wp_get_attachment_link($id, $atts['size'], true, false, false, $attr);
            }
            $image_meta  = wp_get_attachment_metadata($id);

            $orientation = '';
            if (isset($image_meta['height'], $image_meta['width'])) {
                $orientation = ($image_meta['height'] > $image_meta['width']) ? 'portrait' : 'landscape';
            }
            $output .= "<{$itemtag} class='gallery-item'>";
            $output .= "<{$icontag} class='gallery-icon {$orientation}'>";
            if ($columns == 1) {
                $output .= '<div class="gallery-item-open"><span class="sr-only">' . __('Open', 'uvigothemewp') . '</span></div>';
            }
            $output .= "
                    $image_output
                </{$icontag}>";

            if ($columns == 1) {
                $output .= '<div class="gallery-item-slider-controls-position">';
                $output .= '</div>';
            }

            if ($captiontag && trim($attachment->post_excerpt)) {
                $output .= "
                    <{$captiontag} class='wp-caption-text gallery-item-info' id='$selector-$id'>
                    <p class='gallery-item-title'>" . $attachment->post_title . "</p>
                    " . apply_filters('the_content', $attachment->post_content) . "
                    <p class='gallery-item-caption'>" . $attachment->post_excerpt . "</p>
                    </{$captiontag}>";
            }
            $output .= "</{$itemtag}>";
        }
    }

    if ($columns == 1) {
        $output .= '<div class="gallery-item-slider-controls">';
        $output .= '<div class="gallery-item-slider-counter"><span></span></div>';
        $output .= '<div class="gallery-item-slider-arrows"></div>';
        // $output .= '<button class="gallery-item-download">' . __('Download', 'uvigothemewp') . '</button>';
        $output .= '</div>';
    }

    $output .= "
		</div>\n";

    if ($columns == 1) {
        // Build modal gallery
        $selector = $selector . '-modal';

        $output .= '<div class="modal modal-gallery fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="' . $selector . '-' . $id . '" aria-hidden="true">';
        $output .= '<button type="button" class="close" data-dismiss="modal" aria-label="' . __('Close', 'uvigothemewp') . '">';
        $output .= '<span class="sr-only" aria-hidden="true">' . __('Close', 'uvigothemewp') . '</span>';
        $output .= '</button>';
        $output .= '<div class="modal-dialog modal-lg modal-dialog-centered" role="document">';
        $output .= '<div class="modal-content">';

        $output .= "<div id='$selector' class='gallery gallery-modal'>";
        $i = 0;
        foreach ($attachments as $id => $attachment) {
            $attr = ( trim($attachment->post_excerpt) ) ? array('aria-describedby' => "$selector-$id") : '';

            $image_output = wp_get_attachment_image($id, $atts['size'], false, $attr);
            $image_meta  = wp_get_attachment_metadata($id);

            $orientation = '';
            if (isset($image_meta['height'], $image_meta['width'])) {
                $orientation = ($image_meta['height'] > $image_meta['width']) ? 'portrait' : 'landscape';
            }
            $output .= "<{$itemtag} class='gallery-item'>";
            $output .= "
                <{$icontag} class='gallery-icon {$orientation}'>
                    $image_output
                </{$icontag}>";

            $output .= '<div class="gallery-item-slider-controls-position">';
            $output .= '<a class="gallery-item-download" href="' . wp_get_attachment_url($id) . '" download>' . __('Download', 'uvigothemewp') . '</a>';
            $output .= '</div>';

            if ($captiontag && trim($attachment->post_excerpt)) {
                $output .= "
                    <{$captiontag} class='wp-caption-text gallery-item-info' id='$selector-$id'>
                    <p class='gallery-item-caption'>" . $attachment->post_excerpt . "</p>
                    <p class='gallery-item-title'>" . $attachment->post_title . "</p>
                    " . apply_filters('the_content', $attachment->post_content) . "
                    </{$captiontag}>";
            }
            $output .= "</{$itemtag}>";
        }
        $output .= '<div class="gallery-item-slider-controls">';
        $output .= '<div class="gallery-item-slider-counter"><span></span></div>';
        $output .= '<div class="gallery-item-slider-arrows"></div>';
        $output .= '</div>';

        $output .= "</div>\n";

        $output .= "</div>\n";
        $output .= "</div>\n";
        $output .= "</div>\n";
    }

    return $output;
}, 10, 3);
