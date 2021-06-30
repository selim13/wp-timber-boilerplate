<?php

namespace Local;

/**
 * Alters admin pages.
 *
 * @package Local
 */
class Admin
{
    public static function wp_init()
    {
        add_action('admin_menu', [self::class, 'admin_menu']);
        add_action('admin_bar_menu', [self::class, 'admin_bar_menu'], 999);

        // Allow editors to edit menus
        $role_object = get_role('editor');
        $role_object->add_cap('edit_theme_options');
    }

    /**
     * Hides menu items for non-admins
     */
    public static function admin_menu()
    {
        if (current_user_can('administrator')) {
            return;
        }

        remove_menu_page('index.php'); // Консоль
        remove_menu_page('edit-comments.php'); // Комментарии
        remove_menu_page('edit.php'); // Посты
        remove_submenu_page('themes.php', 'themes.php'); // hide the theme selection submenu
        remove_submenu_page('themes.php', 'widgets.php'); // hide the widgets submenu
        remove_menu_page('tools.php'); // Tools

        // Hide theme customize submenu
        global $submenu;
        if (isset($submenu['themes.php'])) {
            foreach ($submenu['themes.php'] as $index => $menu_item) {
                if (in_array('Customize', $menu_item)
                    || in_array('Customizer', $menu_item)
                    || in_array('customize', $menu_item)) {
                    unset($submenu['themes.php'][$index]);
                }
            }
        }
    }

    /**
     * Hides customize submenu and comments
     * from the menu bar for non-admins.
     *
     * @param $wp_admin_bar
     */
    public static function admin_bar_menu($wp_admin_bar)
    {
        if (current_user_can('administrator')) {
            return;
        }

        $wp_admin_bar->remove_node('customize');
        $wp_admin_bar->remove_node('comments');
    }
}