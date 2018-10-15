<?php

namespace UVigoThemeWPApp;

/**
 * Add settings page to menu
 */
add_action('admin_menu', function () {
    add_theme_page('Custom Sidebars', __('Custom sidebars', 'uvigothemewp'), 'manage_options', 'custom_sidebars_settings_page', __NAMESPACE__ . '\\custom_sidebars_page');
});

/**
 * Functions to add settings page
 */
add_action('admin_init', function () {
    register_setting('custom_sidebars_settings', 'custom_sidebars_settings', __NAMESPACE__ . '\\callback_custom_sidebars_settings_validate');
    add_settings_section('custom_sidebars_settings_section', __('Sidebars items', 'uvigothemewp'), __NAMESPACE__ . '\\callback_custom_sidebars_settings_section_text', 'custom_sidebars_settings_page');
    add_settings_field('center_field_list', __('Sidebar name', 'uvigothemewp'), __NAMESPACE__ . '\\callback_custom_sidebars_settings_field_list', 'custom_sidebars_settings_page', 'custom_sidebars_settings_section');
});

/**
 * Render custom_sidebars_page
 *
 * @return void
 */
function custom_sidebars_page()
{
?>
    <div id="sidebar-management__container" class="">
        <h1><?php echo __('Sidebars management', 'uvigothemewp'); ?></h1>
        <?php echo __('Manage custom new sidebar items.', 'uvigothemewp'); ?>
        <form action="options.php" method="post">
            <?php settings_fields('custom_sidebars_settings'); ?>
            <?php do_settings_sections('custom_sidebars_settings_page'); ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"></th>
                        <td>
                            <input name="Submit" type="submit" class="button button-primary button-large" value="<?php esc_attr_e('Save Changes'); ?>" />
                            <span class="text-right-button">É necesario que pulses este botón para gardar os cambios.</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<?php
}

/**
 * Get List of CustomSidebars
 * @return array key = id / value = sidebar name.
 */
add_filter('uvigo_list_custom_sidebars', function ($sidebars) {
    $options = get_option('custom_sidebars_settings');
    $id = 'list_custom_sidebars';
    $list = array();
    if (isset($options[$id]) && is_array($options[$id])) {
        $list = $options[$id];
    }
    $uvigo_list_custom_sidebars = array();
    foreach ($list as $sidebar) {
        $key = 'sidebar-' . sanitize_key($sidebar);
        $counter = 1;
        while (array_key_exists($key, $uvigo_list_custom_sidebars)) {
            $key .= '-' . $counter;
            $counter ++;
        }
        $uvigo_list_custom_sidebars[$key] = $sidebar;
    }

    return array_merge($sidebars, $uvigo_list_custom_sidebars);
});

/**
 * Render Fields
 *
 * @return void
 */
function callback_custom_sidebars_settings_field_list()
{
    $options = get_option('custom_sidebars_settings');
    $id = 'list_custom_sidebars';
    // print_r($options);
?>
    <div id="sidebar-management" class="sidebar-management">
        <input class="all-options" type="text" placeholder="<?php _e('Insert new custom sidebar name', 'uvigothemewp'); ?>" id="new_sidebar_name" />
        <input class="button button-small add-sidebar" type="button" id="add_sidebar" value="<?php _e('Add custom sidebar', 'uvigothemewp'); ?>" />
        <div class="sidebar-management__list">
            <?php
            if (isset($options[$id]) && is_array($options[$id])) {
                $i = 0;
            ?>
            <ul>
            <?php
                foreach ($options[$id] as $sidebar) {
                    $i++;
            ?>
                <li>
                    <?php echo esc_html($sidebar); ?>
                    <a href="#" class="sidebar_del" title="<?php _e('Delete sidebar', 'uvigothemewp') ?>"><span class="dashicons-before dashicons-no"></span></a>
                    <input type="hidden" name="custom_sidebars_settings[<?php echo $id; ?>][<?php echo $i; ?>]" value="<?php echo esc_attr($sidebar); ?>">
                </li>
            <?php
                }
            ?>
            </ul>
            <?php
            } else {
            ?>
                <p>Non hai Custom Sidebars creadas.</p>
            <?php
            }
            ?>
        </div>
        <input id="custom_sidebars_number" type="hidden" name="custom_sidebars_settings[<?php echo $id; ?>_number]" value="<?php echo ((isset($options[$id]) && is_array($options[$id])) ? $i : 0); ?>">
    </div>
<?php
}

/**
 * Title secctión Center settings page
 *
 * @return void
 */
function callback_custom_sidebars_settings_section_text()
{
    echo '<p>' . __('User can add and remove custom sidebars.', 'uvigothemewp') . '</p>';
}

/**
 * Validate Fields
 *
 * @param [array] $input : fields
 * @return array
 */
function callback_custom_sidebars_settings_validate($input)
{
    return $input;
}
