<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $vaidas_todo_db_version;
$vaidas_todo_db_version = '1.0';

function vaidas_todo_install_table() {
    global $wpdb;
    global $vaidas_todo_db_version;
    $table_name      = $wpdb->prefix . 'vaidas_todo';
    $charset_collate = $wpdb->get_charset_collate();
    $sql             = "CREATE TABLE $table_name (
   `id` INT NOT NULL AUTO_INCREMENT ,
   `Name` VARCHAR(255) DEFAULT NULL ,
   `Done` BOOLEAN NULL DEFAULT NULL ,
   PRIMARY KEY (`id`)) $charset_collate;
   ";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    add_option( 'vaidas_todo_db_version', $vaidas_todo_db_version );

}
