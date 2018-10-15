<?php

namespace UVigoThemeWPApp;

use WP_Widget;

class UVigoNewsWidget extends WP_Widget
{

    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'widget-news',
            'description' => esc_html__('List latest news', 'uvigothemewp'),
            'customize_selective_refresh' => true,
        );
        parent::__construct('uvigo_news_widget', esc_html__('News widget', 'uvigothemewp'), $widget_ops);
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        if (! isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }

        $title = (! empty($instance['title'])) ? $instance['title'] : '';

        $number = (! empty($instance['number'])) ? absint($instance['number']) : 5;
        if (! $number) {
            $number = 5;
        }
        $show_image = isset($instance['show_image']) ? $instance['show_image'] : false;

        $show_excerpt = isset($instance['show_excerpt']) ? $instance['show_excerpt'] : false;

        $classname = ! empty($instance['classname']) ? $instance['classname'] : '';

        $r = new \WP_Query(apply_filters('widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        ), $instance));

        if (! $r->have_posts()) {
            return;
        }
        ?>
        <?php echo $args['before_widget']; ?>
        <?php
        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        if ($show_image) {
            $classname .= ' has-thumbnail';
        }
        if ($show_excerpt) {
            $classname .= ' has-excerpt';
        }
        ?>
        <div class="post-items <?php echo $classname; ?>">
            <?php foreach ($r->posts as $recent_post) : ?>
                <?php
                $post_title = get_the_title($recent_post->ID);
                $title      = (! empty($post_title)) ? $post_title : __('(no title)');
                ?>
                <article class="post-item">
                    <?php if ($show_image) : ?>
                        <div class="post-thumbnail"><a href="<?php the_permalink($recent_post->ID); ?>"><?php echo get_the_post_thumbnail($recent_post->ID, 'large'); ?></a></div>
                    <?php endif; ?>
                    <div class="post-date"><?php echo get_the_date('', $recent_post->ID); ?></div>
                    <div class="post-title"><a class="post-link" href="<?php the_permalink($recent_post->ID); ?>"><?php echo $title ; ?></a></div>
                    <?php if ($show_excerpt) : ?>
                    <div class="post-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form($instance)
    {
        $title        = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number       = isset($instance['number']) ? absint($instance['number']) : 5;
        $show_image   = isset($instance['show_image']) ? (bool) $instance['show_image'] : false;
        $show_excerpt = isset($instance['show_excerpt']) ? (bool) $instance['show_excerpt'] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
        </p>
        <p>
            <input class="checkbox" type="checkbox"<?php checked($show_image); ?> id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>" />
            <label for="<?php echo $this->get_field_id('show_image'); ?>"><?php _e('Display thumbnail?', 'uvigothemewp'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox"<?php checked($show_excerpt); ?> id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>" />
            <label for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _e('Display excerpt?', 'uvigothemewp'); ?></label>
        </p>
        <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_image'] = isset($new_instance['show_image']) ? (bool) $new_instance['show_image'] : false;
        $instance['show_excerpt'] = isset($new_instance['show_excerpt']) ? (bool) $new_instance['show_excerpt'] : false;

        return $instance;
    }
}

/**
 * Widget "uvigo_menu_widget"
 */
add_action('widgets_init', function () {
    register_widget('UVigoThemeWPApp\UVigoNewsWidget');
});
