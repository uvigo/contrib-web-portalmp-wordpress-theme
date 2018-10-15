<?php

namespace UVigoThemeWPApp;

use Walker_Nav_Menu;

class UVigoMenuWalker extends Walker_Nav_Menu
{
    /**
     * Starts the list before the elements are added.
    *
    * Adds classes to the unordered list sub-menus.
    *
    * @param string $output Passed by reference. Used to append additional content.
    * @param int    $depth  Depth of menu item. Used for padding.
    * @param array  $args   An array of arguments. @see wp_nav_menu()
    */
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        // Depth-dependent classes.
        $indent = ($depth > 0  ? str_repeat("\t", $depth) : ''); // code indent
        $display_depth = ($depth + 1); // because it counts the first submenu as 0

        // Depth-dependent classes.
        $indent = ($depth > 0  ? str_repeat("\t", $depth) : ''); // code indent
        $display_depth = ($depth + 1); // because it counts the first submenu as 0
        $classes = array(
            ( $depth > 0  ? 'children' : '' ),
            // ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            // ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            // 'menu-depth-' . $display_depth
        );
        $class_names = ' class="' . implode(' ', $classes) . '"';

        // Build HTML for output.
        // $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
        $output .= "\n{$indent}<ul$class_names>\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::end_lvl()
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat( $t, $depth );
        $output .= "$indent</ul>{$n}";
    }

    /**
     * Start the element output.
    *
    * Adds main/sub-classes to the list items and links.
    *
    * @param string $output Passed by reference. Used to append additional content.
    * @param object $item   Menu item data object.
    * @param int    $depth  Depth of menu item. Used for padding.
    * @param array  $args   An array of arguments. @see wp_nav_menu()
    * @param int    $id     Current item ID.
    */
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $wp_query;

        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        if ($depth == 0) {
            $output .= $indent . '<li class="menunav"><div class="menu-header">';
            $output .= $item->title;
            $output .= $indent . '</div>';
        } else {
            // Depth-dependent classes.
            // $depth_classes = array(
            //     ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            //     ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            //     ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            //     'menu-item-depth-' . $depth
            // );
            // $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
            $depth_class_names = '';

            // Passed classes.
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

            // UVigoThemeWPApp::errorLog($classes);
            // if (!in_array('current-menu-ancestor', $classes)) {
            //     return '';
            // }

            // Build HTML.
            // $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
            $output .= $indent . '<li class="' . $depth_class_names . ' ' . $class_names . '">';

            // Link attributes.
            $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
            $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target) .'"' : '';
            $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) .'"' : '';
            $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url) .'"' : '';
            $attributes .= ' class="menu-link ' . ($depth > 0 ? 'sub-menu-link' : 'main-menu-link') . '"';

            // Build HTML output and pass through the proper filter.
            $item_output = '<div class="menu-item-link">';
            // UVigoThemeWPApp::errorLog($args->walker->has_children);
            if ($args->walker->has_children) {
                $item_output .= '<span class="menu-icon-more"><span class="sr-only">' . __('Open', 'uvigothemewp') . '</span></span>';
            } else {
                $item_output .= '<span class="menu-icon-link"></span>';
            }
            $item_output .= $args->before;
            $item_output .= "<a{$attributes}>";
            $item_output .= $args->link_before;
            $item_output .= $item->title;
            $item_output .= $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
            $item_output .= '</div>';

            // $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            //     $args->before,
            //     $attributes,
            //     $args->link_before,
            //     apply_filters( 'the_title', $item->title, $item->ID ),
            //     $args->link_after,
            //     $args->after
            // );
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }

    /**
     * Ends the element output, if needed.
     *
     * @since 3.0.0
     *
     * @see Walker::end_el()
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Page data object. Not used.
     * @param int      $depth  Depth of page. Not Used.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() )
    {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $output .= "</li>{$n}";
    }
}
