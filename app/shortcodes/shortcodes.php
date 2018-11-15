<?php

namespace UVigoThemeWPApp;

use WP_Query;

/**
 * Shortcode "uvsliders"
 *
 * @param  array $atts The attributes from the shortcode
 *
 * @return mixed $output Output of the buffer
 */
add_shortcode('uvslider', function ($atts) {
    global $post; // A variable debe ter o elemento cando é un single e cando está dentro do loop

    $defaults_atts = array(
        'maxitems' => 5,
        'group' => '',   // slug da taxonomia uvig-slider-group
        'autoplay' => 1, // Indica se o slider pasa automáticmente
    );

    $args = shortcode_atts($defaults_atts, $atts, 'uvslider');

    $query_args = array(
        'posts_per_page' => $args['maxitems'],
        'post_status'    => 'publish',
        'post_type'      => SLIDER_POST_TYPE,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );

    if ($args['group'] != '') {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => TAXONOMY_UVIGO_SLIDER_GROUP_NAME,
                'field'    => 'slug',
                'terms'    =>  explode(',', $args['group']),
            )
        );
    }

    $last_important_sliders_query = new WP_Query($query_args);

    sage('blade')->share('uvslider_query', $last_important_sliders_query);
    sage('blade')->share('uvslider_autoplay', intval($args['autoplay']));
    $template = locate_template('shortcodes/uvslider');
    $output = template($template);

    /* Restore original Post Data */
    wp_reset_postdata();

    return $output;
});

/**
 * Shortcode "uvsocialnetworks"
 *
 * @param  array $atts The attributes from the shortcode
 *
 * @return mixed $output Output of the buffer
 */
add_shortcode('uvsocialnetworks', function ($atts) {

    $defaults_atts = array(
        'classname' => '',
        'facebook' => get_theme_mod('uvigothemewp_facebook_setting'),
        'twitter' => get_theme_mod('uvigothemewp_twitter_setting'),
        'youtube' => get_theme_mod('uvigothemewp_youtube_setting'),
        'linkedin' => get_theme_mod('uvigothemewp_linkedin_setting'),
        'instagram' => get_theme_mod('uvigothemewp_instagram_setting')
    );

    $args = shortcode_atts($defaults_atts, $atts, 'uvsocialnetworks');

    sage('blade')->share('uvsocialnetworks_classname', $args['classname']);
    sage('blade')->share('uvsocialnetworks_facebook', $args['facebook']);
    sage('blade')->share('uvsocialnetworks_twitter', $args['twitter']);
    sage('blade')->share('uvsocialnetworks_youtube', $args['youtube']);
    sage('blade')->share('uvsocialnetworks_linkedin', $args['linkedin']);
    sage('blade')->share('uvsocialnetworks_instagram', $args['instagram']);

    $template =  locate_template('shortcodes/uvsocialnetworks');
    $output = template($template);

    return $output;
});

/**
 * Shortcode "uvigo_featured"
 *
 * @param  array $atts The attributes from the shortcode
 * @return mixed $output Output of the buffer
 */
add_shortcode('uvigo_featured', function ($atts) {

    $defaults_atts = array(
        'classname' => '',
    );

    $args = shortcode_atts($defaults_atts, $atts, 'uvigo_featured');

    $items = [];
    // sage('blade')->share('featured_items', $uvigo_featured);

    // Buscamos as novas e os eventos
    $query_args = ['post_type' => ['post', 'uvigo-event']];
    $uvigo_featured = new WP_Query($query_args);
    if ($uvigo_featured->have_posts()) {
        while ($uvigo_featured->have_posts()) {
            $uvigo_featured->the_post();
            $template = locate_template('shortcodes/featured-items');
            $output = template($template);

            $items[] = [
                'type' => get_post_type(),
                'date' => get_the_date('Y-m-d h:i'),
                'html' => $output,
            ];
        }
    }

    // Buscamos as ofertas de emprego
    $query_args = [
        'post_type'      => ['uvigo-offer'],
        'posts_per_page' => 3,
        'meta_key'       => 'uvigo_offers_offer_start_date',
        'orderby'        => 'meta_value',
        'order'          => 'DESC',
    ];
    $uvigo_featured = new WP_Query($query_args);
    if ($uvigo_featured->have_posts()) {
        $offers_date = get_the_date('Y-m-d h:i', $uvigo_featured->posts[0]);
        sage('blade')->share('featured_items', $uvigo_featured);
        $template = locate_template('shortcodes/featured-offer');
        $output = template($template);

        $items[] = [
            'type' => get_post_type(),
            'date' => $offers_date,
            'html' => $output,
        ];
    }

    sage('blade')->share('featured_list', $items);
    $template = locate_template('shortcodes/featured');
    $output = template($template);

    return $output;
});

add_shortcode('uvigo_event_group', function ($atts) {

    $defaults_atts = [
        'classname' => '',
        'group'     => '',
    ];

    $args = shortcode_atts($defaults_atts, $atts, 'uvigo_event_group');

    $items = [];

    // Recollemos os grupos de eventos se existe o plugin
    if (class_exists('Uvigo_News')) {
        // Recollemos os termos da taxonomía que hai no plugin de Novas e Eventos
        $group_events = get_terms(['taxonomy' => \Uvigo_News_Admin::UV_GROUPEVENT_TAXONOMY]);
        if ($group_events) {
            foreach ($group_events as $taxonomy) {
                // A consulta recolle os eventos posteriores a onte (así recollemos os de hoxe)
                // do termo indicado na taxonomía e ordenados por data ascendente,
                // quedándonos co primeiro que será o seguinte evento
                $query_args = [
                    'post_type'    => ['uvigo-event'],
                    'meta_key'     => 'uvigo_news_event_date',
                    'meta_value'   => date('Y-m-d H:i:s'),
                    'meta_compare' => '>',
                    // 'date_query' => [
                    //     'after' => '-1 day',
                    // ],
                    'tax_query' => [
                        'taxonomy'         => \Uvigo_News_Admin::UV_GROUPEVENT_TAXONOMY,
                        'field'            => 'term_id',
                        'terms'            => $taxonomy->term_id,
                        'include_children' => false,
                    ],
                    'order'          => 'ASC',
                    'orderby'        => 'meta_value',
                    'posts_per_page' => 1,
                ];
                $uvigo_featured = new WP_Query($query_args);
                if ($uvigo_featured->have_posts()) {
                    sage('blade')->share('taxonomy', $taxonomy);
                    sage('blade')->share('featured_items', $uvigo_featured);
                    $template = locate_template('shortcodes/groupevents');
                    $output = template($template);
                }
            }
        }
    }

    return $output;
});

/**
 * Shortcode "infosticker"
 *
 * @param  array $atts The attributes from the shortcode
 *
 * @return mixed $output Output of the buffer
 */
add_shortcode('infosticker', function ($atts, $content = null) {

    $defaults_atts = array(
        'classname' => '',
        'icontype' => 'uvigo-iconfont', // uvigo-iconfont | elegant-icon-font
        'icon' => '',
        'quantity' => '',
    );

    $args = shortcode_atts($defaults_atts, $atts, 'infosticker');

    ob_start();
    ?>
        <div class="infosticker">
        <?php if (! empty($args['icon'])) : ?>
            <div class="infosticker__icon <?php echo $args['icontype']; ?>">
            <?php
            switch ($args['icontype']) {
                case 'uvigo-iconfont':
                    ?>
                    <i class="uvigo-iconfont uvigo-iconfont-<?php echo $args['icon']; ?>" aria-hidden="true"></i>
                    <?php
                    break;
                case 'elegant-icon-font':
                    ?>
                    <span class="<?php echo $args['icon']; ?>" aria-hidden="true"></span>
                    <?php
                    break;
                default:
                    echo $args['icon'];
                    break;
            }
            ?>
            </div>
        <?php endif; ?>
            <div class="infosticker__quantity"><?php echo $args['quantity']; ?></div>
            <div class="infosticker__content"><?php echo $content; ?></div>
        </div>
    <?php

    return ob_get_clean();
});
