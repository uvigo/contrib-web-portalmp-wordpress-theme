<?php

namespace UVigoThemeWPApp;

use WP_Widget;

class UVigoGroupEventWidget extends WP_Widget
{

    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'widget-group-event',
            'description' => esc_html__('Widget for GroupEvent', 'uvigothemewp'),
        );
        parent::__construct('uvigo_groupevent_widget', esc_html__('Group event', 'uvigothemewp'), $widget_ops);
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

        // /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

        $classname = ! empty($instance['classname']) ? $instance['classname'] : '';

        echo do_shortcode('[uvigo_event_group classname="' . $classname . '"]');

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
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'uvigothemewp'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
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

        return $instance;
    }
}

/**
 * Widget "uvigo_menu_widget"
 */
add_action('widgets_init', function () {
    register_widget('UVigoThemeWPApp\UVigoGroupEventWidget');
});
