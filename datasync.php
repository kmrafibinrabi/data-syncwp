<?php

/*
 * Plugin Name:       Data SyncWP
 * Plugin URI:        https://wordpress.org/plugins/data-syncwp/
 * Description:       Maintain your data easily with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            K M Rafi Bin Rabi
 * Author URI:        https://kmrafibinrabi.github.io/portfolio
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       data-syncwp
 * Domain Path:       /languages
 */


// Function to create the database table on plugin activation
function data_syncwp_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'keywords';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        heading varchar(255) NOT NULL,
        keywords longtext NOT NULL,
        post varchar(255) DEFAULT NULL,
        date DATE,
        time TIME,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'data_syncwp_create_table' );

// Function to display the form in the admin area
function data_syncwp_display_form() {
    ?>
    <div class="wrap">
        <h2>Save Keywords, Headings, Date, Time, and Upload CSV</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <label for="heading">Heading:</label><br>
            <input type="text" id="heading" name="heading"><br><br>
            <label for="keywords">Keywords (comma-separated):</label><br>
            <textarea id="keywords" name="keywords" rows="4" cols="50" placeholder="Enter keywords manually"></textarea><br><br>
            <label for="csv_file">Upload CSV:</label><br>
            <input type="file" id="csv_file" name="csv_file"><br>
            <span style="font-size: 0.8em;">Note: You can upload a CSV file containing keywords.</span><br><br>
            <label for="post">Post:</label><br>
            <input type="text" id="post" name="post"><br><br>
            <label for="date">Date:</label><br>
            <input type="date" id="date" name="date" value="<?php echo esc_attr( date('Y-m-d') ); ?>"><br><br>
            <label for="time">Time:</label><br>
            <input type="time" id="time" name="time" value="<?php echo esc_attr( date('H:i') ); ?>"><br><br>
            <input type="submit" name="submit_keywords" value="Send Request" class="button-primary">
        </form>
    </div>
    <?php
}

// Function to handle form submission
function data_syncwp_handle_form() {
    if ( isset( $_POST['submit_keywords'] ) ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'keywords';

        $heading = isset( $_POST['heading'] ) ? sanitize_text_field( $_POST['heading'] ) : '';
        $keywords_input = isset( $_POST['keywords'] ) ? sanitize_text_field( $_POST['keywords'] ) : '';
        $post = isset( $_POST['post'] ) ? sanitize_text_field( $_POST['post'] ) : '';
        $date = isset( $_POST['date'] ) ? sanitize_text_field( $_POST['date'] ) : date('Y-m-d');
        $time = isset( $_POST['time'] ) ? sanitize_text_field( $_POST['time'] ) : date('H:i');
        $csv_keywords = array();

        // Handle CSV file upload
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['csv_file']['tmp_name'];
            if (($handle = fopen($file, 'r')) !== false) {
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    // Add each keyword from CSV to an array
                    $csv_keywords = array_merge($csv_keywords, $data);
                }
                fclose($handle);
            }
        }

        // Combine keywords from CSV and textarea input
        $keywords_array = array_merge($csv_keywords, explode(',', $keywords_input));

        // Combine keywords into a single string
        $all_keywords = implode(', ', $keywords_array);

        // Insert heading, all keywords, post, date, and time into the database
        $wpdb->insert(
            $table_name,
            array(
                'heading' => $heading,
                'keywords' => $all_keywords,
                'post' => $post,
                'date' => $date,
                'time' => $time
            )
        );

        // Optionally, you can add a success message or redirect the user
        echo '<div class="updated"><p>Heading, all keywords, post, date, and time saved successfully!</p></div>';
    }
}

// Hook the form display and form submission handling functions
add_action( 'admin_menu', 'data_syncwp_add_menu' );
function data_syncwp_add_menu() {
    add_menu_page(
        'Data SyncWP',
        'Data SyncWP',
        'manage_options',
        'data-syncwp',
        'data_syncwp_display_form'
    );
}
add_action( 'admin_init', 'data_syncwp_handle_form' );

// Function to display data in the admin panel
function data_syncwp_display_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'keywords';

    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $wpdb->delete($table_name, array('id' => $id));
        echo '<script>alert("Data deleted successfully.");</script>';
        echo '<script>window.location.href = "' . esc_url( admin_url('admin.php?page=data-syncwp-data') ) . '";</script>';
        exit;
    }

    $data = $wpdb->get_results("SELECT * FROM $table_name");

    if ($data) {
        echo '<div class="wrap">';
        echo '<h2>Data SyncWP Data</h2>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>ID</th><th>Heading</th><th>Keywords</th><th>Post</th><th>Date</th><th>Time</th><th>Action</th></tr></thead>';
        echo '<tbody>';
        foreach ($data as $row) {
            echo '<tr>';
            echo '<td>' . $row->id . '</td>';
            echo '<td>' . $row->heading . '</td>';
            echo '<td>' . $row->keywords . '</td>';
            echo '<td>' . $row->post . '</td>';
            echo '<td>' . $row->date . '</td>';
            echo '<td>' . $row->time . '</td>';
            echo '<td><a href="' . esc_url( add_query_arg( array('action' => 'delete', 'id' => $row->id) ) ) . '">Delete</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<div class="wrap"><p>No data found.</p></div>';
    }
}

// Hook the function to display data into the admin panel
add_action('admin_menu', 'data_syncwp_add_data_page');
function data_syncwp_add_data_page() {
    add_submenu_page(
        'data-syncwp',
        'Data SyncWP Data',
        'View Data',
        'manage_options',
        'data-syncwp-data',
        'data_syncwp_display_data'
    );
}

// Function to create API endpoint
function data_syncwp_register_api_endpoint() {
    register_rest_route( 'data-syncwp/v1', '/data/', array(
        'methods' => 'GET',
        'callback' => 'data_syncwp_get_data',
    ) );
}
add_action( 'rest_api_init', 'data_syncwp_register_api_endpoint' );

// Callback function to fetch and send data
function data_syncwp_get_data( $request ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'keywords';

    $data = $wpdb->get_results( "SELECT * FROM $table_name" );

    $json_data = json_encode( $data );

    return rest_ensure_response( $json_data );
}
