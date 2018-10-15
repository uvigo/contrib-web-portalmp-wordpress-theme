<?php

namespace UVigoThemeWPApp;

use WP_Widget;

class UVigoMenuWidget extends WP_Widget
{

    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'widget-sidebar-menu',
            'description' => esc_html__('Secondary menu for sidebar column.', 'uvigothemewp'),
        );
        parent::__construct('uvigo_menu_widget', esc_html__('Sidebar menu', 'uvigothemewp'), $widget_ops);
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

        // // print_r($args);

        // if ($title) {
        //     echo $args['before_title'] . $title . $args['after_title'];
        // }

        echo '<div class="sidebar-menu-toggle open2">';
        echo '<span class="text-open">';
        if ($title) {
            echo $title;
        } else {
            echo __('Navigation', 'uvigothemewp');
        }
        echo '</span>';
        echo '<span class="text-close">' . __('Close', 'uvigothemewp') . '</span>';
        echo '</div>';

        $classname = ! empty($instance['classname']) ? $instance['classname'] : '';

        // outputs the content of the widget based on shortcode
        if (has_nav_menu('primary_navigation')) {
            wp_nav_menu([
                'theme_location'  => 'primary_navigation',
                'container_id'    => 'sidebar-menu',
                'container_class' => 'sidebar-menu',
                // 'menu_class'      => 'sidebar-menu',
                'walker'          => new UVigoMenuWalker(),
            ]);
        }

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
    register_widget('UVigoThemeWPApp\UVigoMenuWidget');
});
