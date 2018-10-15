<?php

namespace UVigoThemeWPApp;

/***
 * Add to all widgets a classname property and used it on render.
 */

/**
 * Add option widget classname on form
 */
add_action('in_widget_form', function ($widget, $return, $instance) {
    $instance = wp_parse_args(
        (array)$instance,
        array('uvigo_widget_classname' => '')
    );
    ?>
    <p>
        <label for="<?php echo $widget->get_field_id('uvigo_widget_classname'); ?>">
            <?php _e('Widget Classname: ', 'uvigothemewp'); ?>
        </label>
        <input class="widefat"
            id="<?php echo $widget->get_field_id('uvigo_widget_classname'); ?>"
            name="<?php echo $widget->get_field_name('uvigo_widget_classname'); ?>"
            type="text"
            value="<?php echo $instance['uvigo_widget_classname']; ?>">
    </p>
    <?php
    $instance = wp_parse_args(
        (array)$instance,
        array('uvigo_widget_boxtype' => 'default')
    );
    echo '<p>';
    echo '<label for="' . $widget->get_field_id('uvigo_widget_boxtype') . '">';
    echo __('Box type:', 'uvigothemewp');
    echo ' </label>';
    echo '<select class="widefat" ';
    echo 'name="' . $widget->get_field_name('uvigo_widget_boxtype') . '" ';
    echo 'id="' . $widget->get_field_id('uvigo_widget_boxtype') . '" ';
    echo '>';
    echo '<option value="default">' . __('Default', 'uvigothemewp') . '</option>';
    echo '<option value="widgetbox-gray" ' . ($instance['uvigo_widget_boxtype'] == 'widgetbox-gray' ? 'selected="selected"' : '' ) . '>' . __('Gray block', 'uvigothemewp') . '</option>';
    echo '<option value="widgetbox-secondary" ' . ($instance['uvigo_widget_boxtype'] == 'widgetbox-secondary' ? 'selected="selected"' : '' ) . '>' . __('Blue block', 'uvigothemewp') . '</option>';
    echo '<option value="widgetbox-primary" ' . ($instance['uvigo_widget_boxtype'] == 'widgetbox-primary' ? 'selected="selected"' : '' ) . '>' . __('Dark Blue block', 'uvigothemewp') . '</option>';
    echo '</select>';
    echo '</p>';
}, 5, 3);

/**
 * Save form widget classname
 */
add_filter('widget_update_callback', function ($instance, $new_instance, $old_instance) {
    if (array_key_exists('uvigo_widget_classname', $new_instance)) {
        $instance['uvigo_widget_classname'] = $new_instance['uvigo_widget_classname'];
    }
    if (array_key_exists('uvigo_widget_boxtype', $new_instance)) {
        $instance['uvigo_widget_boxtype'] = $new_instance['uvigo_widget_boxtype'];
    }
    return $instance;
}, 5, 3);

/**
 * Add widget classname
 */
add_filter('dynamic_sidebar_params', function ($params) {
    global $wp_registered_widgets;

    $widget_id = $params[0]['widget_id'];
    $widget_obj = $wp_registered_widgets[$widget_id];
    $widget_opt = get_option($widget_obj['callback'][0]->option_name);
    $widget_num = $widget_obj['params'][0]['number'];

    if (isset($widget_opt[$widget_num]['uvigo_widget_classname'])) {
        $classname = $widget_opt[$widget_num]['uvigo_widget_classname'];
        $params[0]['before_widget'] = str_replace(
            'class="',
            'class="' .  $classname . ' ',
            $params[0]['before_widget']
        );
    }

    if (isset($widget_opt[$widget_num]['uvigo_widget_boxtype'])) {
        $classname = $widget_opt[$widget_num]['uvigo_widget_boxtype'];
        $params[0]['before_widget'] = str_replace(
            'class="',
            'class="widgetbox ' .  $classname . ' ',
            $params[0]['before_widget']
        );
    }

    return $params;
}, 10, 3);
