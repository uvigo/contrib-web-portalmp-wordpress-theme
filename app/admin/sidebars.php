<?php

namespace UVigoThemeWPApp;

/**
 * Add field to Page Attributes for store page sidebar used
 */
add_action('page_attributes_misc_attributes', function ($post) {
    if ('page' === $post->post_type) {
        $uvigo_page_template_sidebar = get_post_meta($post->ID, 'uvigo_page_template_sidebar', true);
        if (empty($uvigo_page_template_sidebar)) {
            $uvigo_page_template_sidebar = 'none';
        }
?>
    <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="uvigo_page_template_sidebar"><?php _e('Aditional sidebar', 'uvigothemewp'); ?></label></p>
    <select name="uvigo_page_template_sidebar" id="uvigo_page_template_sidebar">
        <option value="none" <?php selected($uvigo_page_template_sidebar, 'none'); ?>><?php _e('None'); ?></option>
        <?php
        $uvigo_list_custom_sidebars = apply_filters('uvigo_list_custom_sidebars', []);
        if (isset($uvigo_list_custom_sidebars) && sizeof($uvigo_list_custom_sidebars) > 0) {
            foreach ($uvigo_list_custom_sidebars as $sidebar_id => $sidebar_name) {
                echo '<option value="' . $sidebar_id . '" ' . selected($uvigo_page_template_sidebar, $sidebar_id) . ' >' . $sidebar_name . '</option>';
            }
        }
        ?>
    </select>
<?php
    }
});

add_action('quick_edit_custom_box', function ($column_name, $post_type, $val) {
    if ('page' === $post_type && 'sidebar' === $column_name) {
?>
    <fieldset>
        <div class="inline-edit-col">
            <div class="inline-edit-group wp-clearfix">
                <label class="inline-edit-status alignleft">
                    <span class="title"><?php _e('Sidebar', 'uvigothemewp'); ?></span>
                    <select name="uvigo_page_template_sidebar">
                        <option value="none"><?php _e('None'); ?></option>
                        <?php
                        $uvigo_list_custom_sidebars = apply_filters('uvigo_list_custom_sidebars', []);
                        if (isset($uvigo_list_custom_sidebars) && sizeof($uvigo_list_custom_sidebars) > 0) {
                            foreach ($uvigo_list_custom_sidebars as $sidebar_id => $sidebar_name) {
                                echo '<option value="' . $sidebar_id . '">' . $sidebar_name . '</option>';
                            }
                        }
                        ?>
                    </select>
                </label>
            </div>
        </div>
    </fieldset>
<?php
    }
}, 10, 3);

add_action('bulk_edit_custom_box', function ($column_name, $post_type) {
    if ('page' === $post_type && 'sidebar' === $column_name) {
    ?>
    <fieldset class="inline-edit-col-right" style="margin-top: 0;">
        <div class="inline-edit-col">
            <div class="inline-edit-group wp-clearfix">
                <label class="inline-edit-status alignleft">
                    <span class="title"><?php _e('Sidebar', 'uvigothemewp'); ?></span>
                    <select name="uvigo_page_template_sidebar_bulk_edit">
                        <option value="-1"><?php _e('&mdash; No Change &mdash;'); ?></option>
                        <option value="none"><?php _e('None'); ?></option>
                        <?php
                        $uvigo_list_custom_sidebars = apply_filters('uvigo_list_custom_sidebars', []);
                        if (isset($uvigo_list_custom_sidebars) && sizeof($uvigo_list_custom_sidebars) > 0) {
                            foreach ($uvigo_list_custom_sidebars as $sidebar_id => $sidebar_name) {
                                echo '<option value="' . $sidebar_id . '">' . $sidebar_name . '</option>';
                            }
                        }
                        ?>
                    </select>
                </label>
            </div>
        </div>
    </fieldset>
<?php
    }
}, 10, 2);


/**
 * Save page sidebar used
 */
add_action('save_post', function ($post_id) {

    // check user capabilities
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (array_key_exists('uvigo_page_template_sidebar', $_POST)) {
        update_post_meta(
            $post_id,
            'uvigo_page_template_sidebar',
            $_POST['uvigo_page_template_sidebar']
        );
    }
});

add_action('wp_ajax_save_bulk_edit_sidebar', function () {
    if (array_key_exists('uvigo_page_template_sidebar_bulk_edit', $_POST)) {
        $post_ids = ( ! empty($_POST['post_ids'])) ? $_POST['post_ids'] : array();
        $sidebar_id = $_POST['uvigo_page_template_sidebar_bulk_edit'];
        if (! empty($post_ids) && is_array($post_ids) && ! empty($sidebar_id) && $sidebar_id !== '-1') {
            foreach ($post_ids as $post_id) {
                // check user capabilities
                if (!current_user_can('edit_post', $post_id)) {
                    continue;
                }
                update_post_meta(
                    $post_id,
                    'uvigo_page_template_sidebar',
                    $sidebar_id
                );
            }
        }
    }

    die();
});


add_filter('manage_pages_columns', function ($post_columns) {
    $columns = [];
    foreach ($post_columns as $column => $title) {
        if ($column === 'author') {
            $columns['sidebar'] = __('Sidebar', 'uvigothemewp');
        }
        $columns[$column] = $title;
    }

    return $columns;
});

add_action('manage_pages_custom_column', function ($column_name, $post_id) {
    if ($column_name === 'sidebar') {
        $uvigo_page_template_sidebar = get_post_meta($post_id, 'uvigo_page_template_sidebar', true);
        if ('none' === $uvigo_page_template_sidebar) {
            $uvigo_page_template_sidebar = '';
        }
        echo str_replace('sidebar-', '', $uvigo_page_template_sidebar);
    }
}, 10, 2);

