<?php
/*
 * Plugin Name: Mano darbai
 * Plugin URI:
 * Description: Mano planuojami darbai
 * Version: 1
 * Author URI:
 * Author: Vaidas Surblys
 * License: VS1
 */
//Iseiti jeigu prisijungiama is kazkur kitu ne per Worpressa
defined('ABSPATH') or die('No script kiddies please!');

@require_once(dirname(__FILE__) . '/db/setup-db.php'); //sukuria lentele
@require_once(dirname(__FILE__) . '/widgets/widget.php'); //susijungia su widgetu


add_action('admin_menu', 'my_plugin_menu');


function my_plugin_menu()
{

    add_menu_page('To do admin panel', 'To do panel', 'manage_options', plugin_dir_path(__FILE__) . '/admin/main.php', null, 'dashicons-editor-ul');
}

function pluginprefix_install()
{
    add_option('todo_widget_title', 'To do widget title');
    //priskiriame pavadinima ir duodame pradine reiksme
}

register_activation_hook(__FILE__, 'pluginprefix_install');
register_activation_hook(__FILE__, 'vaidas_todo_install_table');
add_action('init', 'process_post');

function process_post()
{
    global $new_ttitle;
    global $wpdb;
    $table_name = $wpdb->prefix . 'vaidas_todo';


    if (isset($_POST['new-to-do'])) {
        $wpdb->insert(
            $table_name,
            array('Name' => $_POST['new-to-do']),
            array('%s')
        );
    }


    if (isset($_POST['todo-widget-title'])) {
        update_option('todo_widget_title', $_POST['todo-widget-title']);

    }

    if (isset($_POST['todo-item-list'])) {


        $wpdb->query("UPDATE $table_name SET `Done` = 0;");
        if (isset($_POST['DoneBox'])) {
            foreach ($_POST['DoneBox'] as $entryid) {
                $wpdb->update(
                    $table_name,
                    array('Done' => 1),
                    array('id' => $entryid),
                    array('%d'),
                    array('%d')
                );
            }
        }
    } else if (isset($_POST['Delete-to-do'])) {

        $wpdb->delete(
            $table_name,
            array(
                'id' => $_POST['id']
            ), array(
                '%d'
            )
        );
    }

}

?>