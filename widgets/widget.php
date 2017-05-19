<?php
/**
 * Created by PhpStorm.
 * User: Dev minion
 * Date: 5/9/2017
 * Time: 7:10 PM
 */
// Creating the widget

class vaidas_todo_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'vaidas_todo',
            __('To-do-listas', 'wpb_widget_domain'), //widget title ir text_domain
            array('description' => __('Mano darbu listai', 'wpb_widget_domain'),)
        );
    }


    public function widget($args, $instance) //arguments and values from database //ka idesime cia bus atvaizduo ta
    {

        global $wpdb;
        global $wp;
        $title = get_option('todo_widget_title');


// pasiimti visus To do irasus is db

        $table_name = $wpdb->prefix . 'vaidas_todo';
        $sql = "SELECT * FROM $table_name";
        $results = $wpdb->get_results($sql, ARRAY_A);
        $current_url = home_url(add_query_arg(array(), $wp->request));

        ?>

        <div>
            <div><h1><?php echo $title; ?></h1></div>

            <form method="post" class="search-form" action="<?php echo $current_url; ?>">

                <input type="search" class="search-field" placeholder="Item name" value="" name="new-to-do">
                <button type="submit" class="search-submit">Add item</button>
            </form>

            <form method="post" action="<?php echo $current_url; ?>" >
                <input type="hidden" name="todo-item-list" value="" >
                <?php

                // ideti for each visiem to do irasams is db
                foreach ($results as $entry):
                    ?>


                    <input type="checkbox"
                           name="DoneBox[]"
                           value="<?php echo $entry['id']; ?>"
                           onchange="this.form.submit()"
                        <?php if ($entry['Done']) echo 'checked'; ?>
                    >

                    <label><?php echo $entry['Name']; ?></label>


                    <?php
                    // uzbaigti for each duombazes irasams
                endforeach;
                ?>
            </form>
        </div>


        <?php

    }


}

// Register and load the widget
function vaidas_todo_load_widget()
{
    register_widget('vaidas_todo_widget');
}


add_action('widgets_init', 'vaidas_todo_load_widget');








