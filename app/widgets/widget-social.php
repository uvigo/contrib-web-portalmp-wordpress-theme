<?php

namespace UVigoThemeWPApp;

use WP_Widget;

class UVSocialNetworks extends WP_Widget
{

    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'widget_uv_social_networks',
            'description' => esc_html__('Define social networks on your site.', 'uvigothemewp'),
        );
        parent::__construct('uv_social_networks', esc_html__('Social Networks', 'uvigothemewp'), $widget_ops);
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $classname = ! empty($instance['classname']) ? $instance['classname'] : '';

        // outputs the content of the widget based on shortcode
        echo do_shortcode('[uvsocialnetworks classname="' . $classname . '"]');

        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form($instance)
    {
        // outputs the options form on admin
        $title = ! empty($instance['title']) ? $instance['title'] : '';
        $classname = ! empty($instance['classname']) ? $instance['classname'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'uvigothemewp'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('classname')); ?>"><?php esc_attr_e('Classname:', 'uvigothemewp'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('classname')); ?>" name="<?php echo esc_attr($this->get_field_name('classname')); ?>" type="text" value="<?php echo esc_attr($classname); ?>">
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
        // processes widget options to be saved
        $instance = array();
        $instance['title'] = (! empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['classname'] = (! empty($new_instance['classname'])) ? sanitize_text_field($new_instance['classname']) : '';

        return $instance;
    }
}

/**
 * Widget "uv_social_networks"
 */
add_action('widgets_init', function () {
    register_widget('UVigoThemeWPApp\UVSocialNetworks');
});
