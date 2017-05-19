<?php
/**
 * Created by PhpStorm.
 * User: Dev minion
 * Date: 5/9/2017
 * Time: 7:10 PM
 */


global $wpdb;
$title = get_option('todo_widget_title');


// pasiimti visus To do irasus is db

$table_name = $wpdb->prefix . 'vaidas_todo';
$sql = "SELECT * FROM $table_name";
$results = $wpdb->get_results($sql, ARRAY_A);
$admin_page_url =admin_url('/admin.php?page='.$_GET['page']);
?>

<div>
    <div><h1><?php echo $title; ?></h1></div>
    <form method="post" action="<?php echo $admin_page_url; ?>">
        <input type="text" name="todo-widget-title" value="<?php echo $title; ?>">
        <input type="submit" value="Save"/>
    </form>

    <?php

    // ideti for each visiem to do irasams is db
    foreach ($results as $entry):
        ?>

        <form method="post" action="<?php echo $admin_page_url; ?>">
            <input type="submit" value="Delete" name="Delete-to-do">
            <input type="checkbox" disabled <?php if ($entry['Done']) echo 'checked'; ?>>
            <input type="hidden" name="id" value="<?php echo $entry['id']; ?>"/>
            <label><?php echo $entry['Name']; ?></label>
        </form>

        <?php
        // uzbaigti for each duombazes irasams
    endforeach;
    ?>
</div>
